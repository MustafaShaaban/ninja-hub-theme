<?php
    /**
     * @Filename: class-nh_user.php
     * @Description: This file contains the definition of the Nh_User class.
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */


    namespace NH\APP\CLASSES;

    use NH\APP\HELPERS\Nh_Cryptor;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\HELPERS\Nh_Mail;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\Nh;
    use WP_Error;
    use WP_User;

    /**
     * Description...
     *
     * @class Nh_User
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_User
    {
        /**
         * Default Meta
         */
        const USER_DEFAULTS = [
            // User Profile ID
            'profile_id'                    => 0,
            // Profile Picture URL
            'avatar_id'                     => 0,
            // If verified by email
            'email_verification_status'     => 0,
            // If verified by phone
            'phone_verification_status'     => 0,
            // If account verified at all
            'account_verification_status'   => 0,
            // If account authenticated at all
            'account_authentication_status' => 0,
            // Default user language
            'site_language'                 => 'en'
        ];
        /**
         * USER ROLES
         */
        const ADMIN      = 'administrator';
        const CMS        = 'cmsmanager';
        const OWNER      = 'owner';
        const INVESTOR   = 'investor';
        const SEO        = 'seomanager';
        const WEBMASTER  = 'webmaster';
        const REVIEWER   = 'reviewer';
        const TRANSLATOR = 'translator';
        /**
         * Verification Types
         */
        const VERIFICATION_TYPES = [
            'email'    => 'email',
            'mobile'   => 'mobile',
            'whatsapp' => 'whatsapp',
        ];
        /**
         * NH USER INSTANCE
         *
         * @var object|null
         */
        private static ?object $instance = NULL;
        /**
         * The User ID
         *
         * @since 1.0.0
         * @var int
         */
        public int $ID = 0;
        /**
         * The User Username
         *
         * @since 1.0.0
         * @var string
         */
        public string $username = '';
        /**
         * The User Password
         *
         * @since 1.0.0
         * @var string
         */
        public string $password = '';
        /**
         * The User Email
         *
         * @since 1.0.0
         * @var string
         */
        public string $email = '';
        /**
         * The User First name
         *
         * @since 1.0.0
         * @var string
         */
        public string $first_name = '';
        /**
         * The User Last name
         *
         * @since 1.0.0
         * @var string
         */
        public string $last_name = '';
        /**
         * The User Nickname
         *
         * @since 1.0.0
         * @var string
         */
        public string $nickname = '';
        /**
         * The User Displayed name
         *
         * @since 1.0.0
         * @var string
         */
        public string $display_name = '';
        /**
         * The User Avatar url
         *
         * @since 1.0.0
         * @var array|null|string
         */
        public string|array|null $avatar;
        /**
         * The User single role as
         *
         * @since 1.0.0
         * @var string
         */
        public string $role = '';
        /**
         * The User Status (Active or Not)
         *
         * @since 1.0.0
         * @var int
         */
        public int $status = 0;
        /**
         * The User Registered date
         *
         * @since 1.0.0
         * @var string
         */
        public string $registered = '0000-00-00 00:00:00';
        /**
         * The User Activation key
         *
         * @since 1.0.0
         * @var string
         */
        public string $activation_key = '';

        /**
         * @var \NH\APP\MODELS\FRONT\MODULES\Nh_Profile
         */
        public Nh_Profile $profile;

        /**
         * The User Meta data
         *
         * @since 1.0.0
         * @var array|string[]
         */
        public array $user_meta = [
            'first_name',
            'last_name',
            'nickname',
            'phone_number',
            'reset_password_key',
            'verification_type',
            'verification_key',
            'verification_expire_date',
            'authentication_key',
            'authentication_expire_date',
        ];

        /**
         * Constructs a new instance of the Nh_User class.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function __construct()
        {
            global $pagenow;

            // Reformat class metadata
            foreach ($this->user_meta as $k => $meta) {
                $this->user_meta[$meta] = '';
                unset($this->user_meta[$k]);
            }

            // Add filter to override user avatar in users table
            if (is_admin() && ('users.php' == $pagenow || 'profile.php' == $pagenow)) {
                $hooks = new Nh_Hooks();
                $hooks->add_filter('get_avatar_data', $this, 'override_user_table_avatar', 1, 2);
                $hooks->run();
            }
        }

        /**
         * Magic method to retrieve the value of a property.
         *
         * @param string $name The name of the property.
         *
         * @return mixed The value of the property if it exists, or FALSE otherwise.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function __get($name)
        {
            return property_exists($this, $name) ? $this->{$name} : FALSE;
        }

        /**
         * Magic method to set the value of a property.
         *
         * @param string $name The name of the property.
         * @param mixed  $value The value to set.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function __set($name, $value)
        {
            $this->{$name} = sanitize_text_field($value);
        }

        /**
         * Retrieves the instance of the Nh_User class.
         *
         * @return Nh_User The instance of the Nh_User class.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public static function get_instance(): Nh_User
        {
            $class = __CLASS__;
            if (!self::$instance instanceof $class) {
                self::$instance = new $class;
            }

            return self::$instance;
        }

        /**
         * Checks if a user has a specific role.
         *
         * @param string $role_name The name of the role to check.
         * @param int    $id The ID of the user. Defaults to 0, which indicates the current user.
         *
         * @return bool True if the user has the role, False otherwise.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public static function is_role(string $role_name, int $id = 0): bool
        {
            return in_array($role_name, self::get_user_role($id, FALSE));
        }

        /**
         * Retrieves the role(s) of a user.
         *
         * @param int  $id The ID of the user. Defaults to 0, which indicates the current user.
         * @param bool $single Whether to return a single role or an array of roles.
         *
         * @return string|array The role(s) of the user.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public static function get_user_role(int $id = 0, bool $single = TRUE): string|array
        {
            global $user_ID;
            $ID   = ($id !== 0 && is_numeric($id)) ? $id : $user_ID;
            $role = [];
            if (!empty($ID) && is_numeric($ID)) {
                $user_meta = get_userdata($ID);
                return $role = ($single) ? $user_meta->roles[0] : $user_meta->roles;
            }
            return $role;
        }

        /**
         * Retrieves the current user as a Nh_User object.
         *
         * @return Nh_User The current user.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public static function get_current_user(): Nh_User
        {
            global $current_user;
            return self::get_user($current_user);
        }

        /**
         * Inserts a new user into the database.
         *
         * @return Nh_User|int|WP_Error The inserted user object or an error object.
         * @throws \Exception
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function insert(): Nh_User|int|WP_Error
        {
            $error = new WP_Error(); // Create a new WordPress error object.

            if (username_exists($this->username)) { // Check if the username already exists.
                $error->add('username_exists', __('Sorry, this phone number already exists!', 'ninja'), [
                    'status'  => FALSE,
                    'details' => [ 'username' => $this->username ]
                ]); // Add an error message to the error object.
                return $error; // Return the error object.
            }

            if (email_exists($this->email)) { // Check if the email already exists.
                $error->add('email_exists', __('Sorry, that email already exists!', 'ninja'), [
                    'status'  => FALSE,
                    'details' => [ 'email' => $this->email ]
                ]); // Add an error message to the error object.
                return $error; // Return the error object.
            }

            $user_id = wp_insert_user([
                'user_login'   => $this->username,
                'user_pass'    => $this->password,
                'user_email'   => $this->email,
                'first_name'   => $this->first_name,
                'last_name'    => $this->last_name,
                'display_name' => $this->display_name,
                'role'         => $this->role
            ]); // Insert a new user into the system and get the user ID.

            if (is_wp_error($user_id)) { // Check if there was an error during user insertion.
                return $user_id; // Return the error object.
            }

            $this->ID = $user_id; // Set the user ID for the current object.

            $avatar = $this->set_avatar(); // Set the avatar for the user.

            if ($avatar->has_errors()) { // Check if there were errors setting the avatar.
                return $avatar; // Return the error object.
            }

            $user_meta = array_merge($this->user_meta, self::USER_DEFAULTS); // Merge the user meta data with default values.

            foreach ($user_meta as $key => $value) { // Loop through each user meta data.
                $value = property_exists($this, $key) ? $this->{$key} : $value; // Get the value from the current object property or use the default value.
                add_user_meta($this->ID, $key, $value); // Add user meta data for the current user.
            }

            $profile         = new Nh_Profile(); // Create a new Nh_Profile object.
            $profile->title  = $this->display_name; // Set the profile title.
            $profile->author = $this->ID; // Set the profile author.
            $profile->insert(); // Insert the profile into the system.

            update_user_meta($this->ID, 'profile_id', $profile->ID); // Update user meta data with the profile ID.

            $this->setup_verification('verification'); // Set up user verification.

            $cred = [
                'user_login'    => $this->username,
                'user_password' => $this->password
            ]; // Set the credentials for signing in.

            $login = wp_signon($cred); // Sign in the user.

            if (is_wp_error($login)) { // Check if there was an error during sign in.
                $error->add('invalid_register_signOn', __($login->get_error_message(), 'ninja'), [
                    'status'  => FALSE,
                    'details' => [
                        'user_login' => $this->username,
                        'password'   => $this->password
                    ]
                ]); // Add an error message to the error object.
                return $error; // Return the error object.
            }

            do_action(Nh::_DOMAIN_NAME . "_after_create_user", $this); // Trigger an action after user creation.

            return $this; // Return the current user object.
        }

        /**
         * Updates the user's information.
         *
         * @return \NH\APP\CLASSES\Nh_User|\WP_Error The updated user object or an error object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function update(): Nh_User|WP_Error
        {
            global $current_user;

            $error = new WP_Error(); // Create a new WordPress error object.

            if (strtolower($current_user->data->user_login) !== strtolower($this->username)) {
                // Check if the current user's username is different from the username being updated.

                if (username_exists($this->username)) { // Check if the new username already exists.
                    $error->add('username_exists', __('Sorry, this phone number already exists!', 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'username' => $this->username ]
                    ]); // Add an error message to the error object.
                    return $error; // Return the error object.
                }

                global $wpdb;

                // Update the user's username in the WordPress database using $wpdb.
                $wpdb->update($wpdb->users, [ 'user_login' => $this->username ], [ 'user_login' => $current_user->data->user_login ]);
            }

            $user_id = wp_update_user([
                'ID'           => $this->ID,
                'user_email'   => $this->email,
                'first_name'   => ucfirst(strtolower($this->first_name)),
                'last_name'    => ucfirst(strtolower($this->last_name)),
                'display_name' => ucfirst(strtolower($this->first_name)) . ' ' . ucfirst(strtolower($this->last_name)),
                'role'         => $this->role
            ]); // Update the user's information using wp_update_user function.

            if (is_wp_error($user_id)) { // Check if there was an error during user update.
                return $user_id; // Return the error object.
            }

            if (is_array($this->avatar) && !empty($this->avatar)) {
                // Check if the avatar property is an array and not empty.

                $avatar = $this->set_avatar(); // Set the avatar for the user.

                if ($avatar->has_errors()) { // Check if there were errors setting the avatar.
                    return $avatar;
                }
            }

            $this->profile->title = $this->display_name; // Update the profile title.
            $this->profile->update(); // Update the profile information.

            foreach ($this->user_meta as $key => $value) {
                update_user_meta($this->ID, $key, $value); // Update the user meta data.
            }

            return $this; // Return the current user object.
        }

        /**
         * Uploading user profile picture and setting it as metadata.
         *
         * @return \WP_Error The error object if an error occurs during avatar upload, otherwise returns an empty error object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        private function set_avatar(): WP_Error
        {
            $error = new WP_Error(); // Create a new WordPress error object.

            if (is_array($this->avatar) && !empty($this->avatar)) {
                // Check if the avatar property is an array and not empty.

                $mimes = [
                    'jpe'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg'  => 'image/jpeg',
                    'png'  => 'image/png'
                ]; // Define an array of allowed mime types.

                $overrides = [
                    'mimes'     => $mimes,
                    'test_form' => FALSE
                ]; // Set the overrides for the file upload.

                // Upload the avatar file using wp_handle_upload function.
                $upload = wp_handle_upload($this->avatar, $overrides);

                if (isset($upload['error'])) {
                    $error->add('invalid_image', __($upload['error'], 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'file' => $this->avatar ]
                    ]); // Add an error message to the error object if an error occurs during upload.
                    return $error;
                }

                $image_url  = $upload['url']; // Get the URL of the uploaded image.
                $upload_dir = wp_upload_dir(); // Get the upload directory information.
                $image_data = file_get_contents($image_url); // Get the image data.
                $filename   = basename($image_url); // Get the filename from the image URL.

                if (wp_mkdir_p($upload_dir['path'])) {
                    $file = $upload_dir['path'] . '/' . $filename;
                } else {
                    $file = $upload_dir['basedir'] . '/' . $filename;
                } // Set the file path based on the upload directory.

                // Save the image data to the file.
                file_put_contents($file, $image_data);

                $wp_filetype = wp_check_filetype($filename, NULL); // Get the file type.
                $attachment  = [
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title'     => sanitize_file_name($filename),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ]; // Set the attachment details.

                // Insert the attachment into the database.
                $attachment_id = wp_insert_attachment($attachment, $file);

                if (is_wp_error($attachment_id)) {
                    return $attachment_id; // Return the error object if there was an error during attachment insertion.
                }

                // Generate and update the attachment metadata.
                $attach_data = wp_generate_attachment_metadata($attachment_id, $file);
                wp_update_attachment_metadata($attachment_id, $attach_data);

                // Set the user meta data for 'avatar_id' with the attachment ID.
                $this->set_user_meta('avatar_id', $attachment_id);

                // Get the URL of the avatar using the attachment ID.
                $this->avatar = wp_get_attachment_image_url($attachment_id, 'thumbnail');

            } else {
                // Set a default avatar if no avatar is provided.
                $this->avatar = Nh_Hooks::PATHS['public']['img'] . '/default-profile.png';
            }

            return $error; // Return the error object.
        }

        /**
         * Sets the user meta data.
         *
         * @param string       $name The name of the user meta data.
         * @param string|array $value The value of the user meta data.
         * @param bool         $update Whether to update the user meta data in the database.
         *
         * @return bool Returns true if the user meta data is successfully set, otherwise false.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function set_user_meta(string $name, string|array $value, bool $update = FALSE): bool
        {
            // Check if the user meta key exists in the user meta array.
            if (array_key_exists($name, $this->user_meta)) {
                $this->user_meta[$name] = $value;

                // Update the user meta data in the database if $update is true.
                if ($update) {
                    update_user_meta($this->ID, $name, $value);
                }

                return TRUE;
            }

            return FALSE;
        }

        /**
         * Initiates the forgot password process for a user.
         *
         * @param string $user_email_phone The email or phone of the user.
         *
         * @throws \Exception
         * @return \NH\APP\CLASSES\Nh_User|\WP_Error|$this The current user object, an error object, or $this.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function forgot_password(string $user_email_phone): Nh_User|WP_Error
        {
            // Get the user by email.
            $user = get_user_by('email', $user_email_phone);

            if (!$user) {
                // If user not found by email, get the user by login.
                $user = get_user_by('login', $user_email_phone);
            }

            if ($user) {
                // Generate the forgot password data for the user.
                $generate_forgot_data = $this->generate_forgot_password_data($user);

                // Get the verification type from user meta data.
                $verification_type = get_user_meta($user->ID, 'verification_type', TRUE);

                if ($verification_type === Nh_User::VERIFICATION_TYPES['mobile']) {
                    // If the verification type is mobile, send the phone OTP code.
                    $this->send_phone_otp_code(Nh_User::VERIFICATION_TYPES['mobile'], $user->user_login);
                } elseif ($verification_type === Nh_User::VERIFICATION_TYPES['whatsapp']) {
                    // If the verification type is WhatsApp, send the WhatsApp OTP code.
                    $this->send_whatsapp_otp_code(Nh_User::VERIFICATION_TYPES['whatsapp'], $user->user_login);
                } else {
                    // Send the forgot password email.
                    $email = Nh_Mail::init()
                                     ->to($user->user_email)
                                     ->subject('Forgot Password')
                                     ->template('forgot-password/body', [
                                         'data' => [
                                             'user'      => $user,
                                             'url_query' => $generate_forgot_data['reset_link']
                                         ]
                                     ])
                                     ->send();
                }

            }
            return $this; // Return the current user object.
        }

        /**
         * Generates forgot password data for a user.
         *
         * @param object $user The user object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @return array The generated forgot password data.
         */
        public function generate_forgot_password_data($user): array
        {
            $reset_key = wp_generate_password(20, FALSE);
            // Generate a reset key.

            $reset_data = [
                'user_id'         => $user->ID,
                'reset_key'       => $reset_key,
                'expiration_time' => time() + (1 * 3600)
                // 1 hour
            ]; // Set the reset data.

            $encrypted_data = Nh_Cryptor::Encrypt(serialize($reset_data));
            // Encrypt the reset data.

            $reset_link = add_query_arg([
                'user' => $user,
                'key'  => $encrypted_data
            ], site_url('my-account/reset-password'));
            // Generate the reset link.

            update_user_meta($user->ID, 'reset_password_key', $reset_data);
            // Update the user meta data with the reset data.

            return [
                'reset_data' => $reset_data,
                'reset_link' => $reset_link
            ]; // Return the generated forgot password data.
        }

        /**
         * Changes the user's password.
         *
         * @return bool|\WP_Error Returns true if the password is changed successfully, otherwise returns an error object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function change_password(): bool|WP_Error
        {
            $error         = new WP_Error(); // Create a new WordPress error object.
            $form_data     = $_POST['data']; // Get the form data.
            $user_password = sanitize_text_field($form_data['user_password']); // Sanitize the user password.
            $key           = sanitize_text_field($form_data['user_key']); // Sanitize the reset key.

            if (!is_wp_error(self::check_reset_code($key))) {
                // Check if the reset code is valid.
                $decrypt_data = Nh_Cryptor::Decrypt($key);
                // Decrypt the reset key.

                if ($decrypt_data) {

                    $reset_data = unserialize($decrypt_data);
                    // Unserialize the decrypted reset data.

                    // Change user password
                    wp_set_password($user_password, $reset_data['user_id']);
                    // Change the user's password.

                    // Remove reset key
                    update_user_meta($reset_data['user_id'], 'reset_password_key', '');
                    // Remove the reset password key from user meta data.

                    return TRUE; // Return true indicating successful password change.

                } else {
                    $error->add('failed_decryption', __("Your reset key is invalid!.", 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'key' => $key ]
                    ]); // Add an error message to the error object if decryption fails.
                    return $error; // Return the error object.
                }
            } else {
                $error->add('invalid_key', __("Your reset key is invalid!.", 'ninja'), [
                    'status'  => FALSE,
                    'details' => [ 'key' => $key ]
                ]); // Add an error message to the error object if the reset key is invalid.
                return $error; // Return the error object.
            }
        }


        /**
         * Check the reset code validity
         *
         * @param $key The reset code
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return bool|\WP_Error Returns true if the reset code is valid, otherwise returns a WP_Error object
         */
        public static function check_reset_code($key): bool|WP_Error
        {
            $error        = new WP_Error(); // Create a new WP_Error object
            $decrypt_data = Nh_Cryptor::Decrypt($key); // Decrypt the reset code

            if ($decrypt_data && is_serialized($decrypt_data)) {
                $reset_data = unserialize($decrypt_data); // Unserialize the decrypted data
                $user       = self::get_user_by('ID', (int)$reset_data['user_id']); // Get the user associated with the reset code

                if (!is_wp_error($user)) {
                    if (is_array($user->user_meta['reset_password_key']) && !empty($user->user_meta['reset_password_key'])) {
                        if ($reset_data['reset_key'] === $user->user_meta['reset_password_key']['reset_key']) {
                            $current_timestamp = time(); // Get the current Unix timestamp

                            if ($reset_data['expiration_time'] >= $current_timestamp) {
                                return TRUE; // The reset code is valid
                            } else {
                                // The reset key has expired
                                $error->add('expire_date', __("Your reset key is expired.", 'ninja'), [
                                    'status'  => FALSE,
                                    'details' => [ 'time' => $reset_data['expiration_time'] ]
                                ]);
                                return $error; // Return the WP_Error object
                            }
                        } else {
                            // The reset key is invalid
                            $error->add('invalid_key', __("Your reset key is invalid!.", 'ninja'), [
                                'status'  => FALSE,
                                'details' => [ 'key' => $reset_data['reset_key'] ]
                            ]);
                            return $error; // Return the WP_Error object
                        }
                    } else {
                        // The reset key is empty or invalid
                        $error->add('empty_key', __("Your reset key is invalid!.", 'ninja'), [
                            'status'  => FALSE,
                            'details' => [ 'key' => $reset_data['reset_key'] ]
                        ]);
                        return $error; // Return the WP_Error object
                    }
                } else {
                    // The user associated with the reset key is invalid
                    $error->add('invalid_user', __("Your reset key is invalid!.", 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'user' => $reset_data['user_id'] ]
                    ]);
                    return $error; // Return the WP_Error object
                }
            } else {
                // The reset key could not be decrypted
                $error->add('failed_decryption', __("Your reset key is invalid!.", 'ninja'), [
                    'status'  => FALSE,
                    'details' => [ 'key' => $key ]
                ]);
                return $error; // Return the WP_Error object
            }
        }

        /**
         * Check the OTP code validity
         *
         * @param array  $data The data containing the OTP code and type
         * @param string $type The type of OTP code (authentication or verification)
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return bool|\WP_Error Returns true if the OTP code is valid, otherwise returns a WP_Error object
         */
        public static function check_otp_code(array $data, string $type): bool|WP_Error
        {
            $error             = new WP_Error(); // Create a new WP_Error object
            $current_timestamp = time(); // Get the current Unix timestamp
            $expire_date       = $type === 'authentication' ? $data['authentication_expire_date'] : $data['verification_expire_date'];

            if ($expire_date >= $current_timestamp) {
                if ($data['incoming_code'] === $data['current_code']) {
                    return TRUE; // The OTP code is valid
                } else {
                    // The OTP code is invalid
                    $error->add('invalid_key', __("Your reset key is invalid!.", 'ninja'), [
                        'status' => FALSE
                    ]);
                    return $error; // Return the WP_Error object
                }
            } else {
                // The OTP code has expired
                $error->add('expire_date', __("Your reset key is expired.", 'ninja'), [
                    'status' => FALSE
                ]);
                return $error; // Return the WP_Error object
            }
        }

        /**
         * Get user as a Nh User object
         *
         * @param \WP_User $user The WP_User object
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return \NH\APP\CLASSES\Nh_User The Nh User object
         */
        public static function get_user(WP_User $user): Nh_User
        {
            $class          = __CLASS__;
            self::$instance = new $class();

            return self::$instance->convert($user);
        }

        /**
         * Get user by a specific field and value
         *
         * @param string $field The field to search by (e.g., 'ID', 'login', 'email')
         * @param string $value The value to search for
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return \NH\APP\CLASSES\Nh_User|\WP_Error The Nh User object if found, otherwise returns a WP_Error object
         */
        public static function get_user_by(string $field, string $value): Nh_User|WP_Error
        {
            $error = new WP_Error(); // Create a new WP_Error object
            $user  = get_user_by($field, $value); // Get the user by the specified field and value

            if ($user) {
                return self::get_user($user); // Get the Nh User object
            } else {
                // The user does not exist
                $error->add('invalid_user', __("This user does not exist!.", 'ninja'), [
                    'status'  => FALSE,
                    'details' => [
                        'user'  => $value,
                        'field' => $field
                    ]
                ]);
                return $error; // Return the WP_Error object
            }
        }

        /**
         * Convert the default WP user object to a Nh User object
         *
         * @param \WP_User $user The WP_User object to convert
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return \NH\APP\CLASSES\Nh_User The converted Nh User object
         */
        private function convert(WP_User $user): Nh_User
        {
            $class    = __CLASS__;
            $new_user = new $class(); // Create a new Nh User object

            $new_user->ID             = $user->ID;
            $new_user->username       = $user->data->user_login;
            $new_user->password       = $user->data->user_pass;
            $new_user->email          = $user->data->user_email;
            $new_user->first_name     = $this->first_name;
            $new_user->last_name      = $this->last_name;
            $new_user->nickname       = $this->nickname;
            $new_user->display_name   = $user->data->display_name;
            $new_user->role           = $user->roles[0];
            $new_user->status         = $user->data->user_status;
            $new_user->registered     = $user->data->user_registered;
            $new_user->activation_key = $user->data->user_activation_key;

            $new_user->user_meta = array_merge($new_user->user_meta, self::USER_DEFAULTS);

            foreach ($new_user->user_meta as $key => $meta) {
                $new_user->user_meta[$key] = get_user_meta($user->ID, $key, TRUE);
            }

            $new_user->first_name = $new_user->user_meta['first_name'];
            $new_user->last_name  = $new_user->user_meta['last_name'];
            $new_user->nickname   = $new_user->user_meta['nickname'];
            $new_user->avatar     = $new_user->get_avatar();

            if (class_exists('\NH\APP\MODELS\FRONT\MODULES\Nh_Profile')) {
                $profile_obj       = new Nh_Profile();
                $new_user->profile = $profile_obj;
                $profile           = $profile_obj->get_by_id((int)$new_user->user_meta['profile_id']);
                if (!is_wp_error($profile)) {
                    $new_user->profile = $profile_obj->get_by_id((int)$new_user->user_meta['profile_id']);
                }
            }

            return $new_user;
        }

        /**
         * Assign WP_User properties to Nh_User
         *
         * @param \WP_User $user The WP_User object to assign properties from
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        private function assign(WP_User $user): void
        {
            $this->ID             = $user->ID;
            $this->username       = $user->data->user_login;
            $this->password       = $user->data->user_pass;
            $this->email          = $user->data->user_email;
            $this->display_name   = $user->data->display_name;
            $this->role           = $user->roles[0];
            $this->status         = $user->data->user_status;
            $this->registered     = $user->data->user_registered;
            $this->activation_key = $user->data->user_activation_key;

            $this->user_meta = array_merge($this->user_meta, self::USER_DEFAULTS);

            foreach ($this->user_meta as $key => $meta) {
                $this->user_meta[$key] = get_user_meta($user->ID, $key, TRUE);
            }

            $this->first_name = $this->user_meta['first_name'];
            $this->last_name  = $this->user_meta['last_name'];
            $this->nickname   = $this->user_meta['nickname'];
            $this->avatar     = $this->get_avatar();
        }

        /**
         * Override the user table avatar
         *
         * @param $avatar The avatar image
         * @param $id The user ID
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function override_user_table_avatar($avatar, $id)
        {
            $user          = self::get_user_by('ID', $id); // Get the user by ID
            $avatar['url'] = $user->avatar; // Override the avatar URL

            return $avatar;
        }

        /**
         * Perform login
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @return \WP_Error|\static Returns a WP_Error object if the login is invalid, otherwise returns $this
         * @throws \Exception
         */
        protected function login(): Nh_User|WP_Error
        {
            $error         = new WP_Error(); // Create a new WP_Error object
            $form_data     = $_POST['data']; // Get the form data from the POST request
            $user_login    = sanitize_text_field($form_data['user_login']); // Sanitize the user login field
            $user_password = sanitize_text_field($form_data['user_password']); // Sanitize the user password field

            $user = get_user_by('login', $user_login); // Get the user by login

            if (empty($user)) {
                $user = get_user_by('email', $user_login); // Get the user by email
                if (empty($user)) {
                    // The login credentials are invalid
                    $error->add('invalid_username', __("Your login credentials are invalid.", 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'username' => $user_login ]
                    ]);
                    return $error; // Return the WP_Error object
                }
            }

            if (!empty($user)) {
                $this->assign($user); // Assign properties from WP_User to Nh_User

                $check_pwd = wp_check_password($user_password, $this->password, $this->ID); // Check if the password is valid

                if (!$check_pwd) {
                    // The login credentials are invalid
                    $error->add('invalid_password', __("Your login credentials are invalid.", 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'password' => $user_password ]
                    ]);
                    return $error; // Return the WP_Error object
                }

                $cred = [
                    'user_login'    => $user_login,
                    'user_password' => $user_password
                ];

                if (!empty($form_data['rememberme'])) {
                    $cred['remember'] = $form_data['rememberme'];
                }

                $login = wp_signon($cred); // Sign in the user

                if (is_wp_error($login)) {
                    // The sign-on process failed
                    $error->add('invalid_signOn', __($login->get_error_message(), 'ninja'), [
                        'status'  => FALSE,
                        'details' => [
                            'user_login' => $user_login,
                            'password'   => $user_login
                        ]
                    ]);
                    return $error; // Return the WP_Error object
                }

                if (!$this->is_confirm()) {
                    // The account is not confirmed, send verification code
                    $this->setup_verification('verification');
                    $error->add('account_verification', __("Your account is pending! Please check your E-mail/Mobile/WhatsApp to activate your account.", 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'email' => $this->user_meta['account_verification_status'] ]
                    ]);
                    return $error; // Return the WP_Error object
                }

                $front_dashboard = [
                    self::OWNER,
                    self::INVESTOR
                ];

                if (in_array($this->role, $front_dashboard)) {
                    $this->setup_verification('authentication');
                }

                $profile_id = get_user_meta($login->ID, 'profile_id', TRUE);
                if (!$profile_id) {
                    // The account is disabled or blocked
                    $error->add('invalid_profile', __("This account is temporarily disabled or blocked. Please contact us.", 'ninja'), [
                        'status' => FALSE
                    ]);
                    return $error; // Return the WP_Error object
                }
                $profile_obj = new Nh_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                if (!isset($profile->taxonomy['industry']) || empty($profile->taxonomy['industry'])) {
                    // The profile must have at least one industry
                    $error->add('empty_industry', __("You have to use at least 1 industry.", 'ninja'), [
                        'status'  => FALSE,
                        'details' => [ 'industry' => $profile->taxonomy['industry'] ]
                    ]);
                    return $error; // Return the WP_Error object
                }
            }

            return $this;
        }


        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        public static function logout()
        {

        }

        /**
         * Sets up the verification process based on the given type.
         *
         * @param string $type The type of verification process.
         *
         * @throws \Exception
         * @return \WP_Error|bool The WP_Error object or a boolean value indicating the success of the verification setup.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function setup_verification(string $type): WP_Error|bool
        {
            $error = new WP_Error(); // Create a new WordPress error object.

            if ($this->user_meta['verification_type'] === self::VERIFICATION_TYPES['mobile']) {
                // If the verification type is mobile, send the phone OTP code.
                $verification = $this->send_phone_otp_code($type);

                if (is_wp_error($verification)) {
                    // If sending the phone OTP code resulted in an error, add the error to the error object and return it.
                    $error->add('mobile_error', __($verification->get_error_message(), 'ninja'), [
                        'status'  => FALSE,
                        'details' => [
                            'e' => '',
                        ]
                    ]);
                    return $error;
                }
            } elseif ($this->user_meta['verification_type'] === self::VERIFICATION_TYPES['whatsapp']) {
                // If the verification type is WhatsApp, send the WhatsApp OTP code.
                $verification = $this->send_whatsapp_otp_code($type);

                if (is_wp_error($verification)) {
                    // If sending the WhatsApp OTP code resulted in an error, add the error to the error object and return it.
                    $error->add('whatsapp_error', __($verification->get_error_message(), 'ninja'), [
                        'status'  => FALSE,
                        'details' => [
                            'e' => '',
                        ]
                    ]);
                    return $error;
                }
            } else {
                // For other verification types, send the email OTP code.
                $verification = $this->send_email_otp_code($type);

                if (!$verification) {
                    // If sending the email OTP code failed, add the error to the error object and return it.
                    $error->add('email_error', __("The verification code didn't send!", 'ninja'), [
                        'status'  => FALSE,
                        'details' => [
                            'email_error' => 'email error',
                        ]
                    ]);
                    return $error;
                }
            }

            return $verification; // Return the verification result.
        }

        /**
         * Sends the phone OTP code.
         *
         * @param string $type The type of OTP code.
         * @param string $to The receiver number.
         *
         * @return \WP_Error|bool The WP_Error object or a boolean value indicating the success of sending the OTP code.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @throws \Exception
         */
        public function send_phone_otp_code(string $type, string $to = ''): WP_Error|bool
        {
            $error        = new WP_Error(); // Create a new WordPress error object.
            $randomNumber = mt_rand(1000, 9999); // Generate a random OTP code.
            $to           = empty($to) ? $this->username : $to;

            if ($type === 'authentication') {
                // If the type is authentication, send the authentication code via phone.
                $send = $this->send_by_twilio([
                    'to'   => '+' . $to,
                    'from' => '+19894738633',
                    'body' => sprintf(__('Your authentication code for NH is %s', 'ninja'), $randomNumber)
                ]);

                if (!is_wp_error($send)) {
                    // If sending the code was successful, update the user meta data.
                    $this->set_user_meta('account_authentication_status', 0, TRUE);
                    $this->set_user_meta('authentication_key', $randomNumber, TRUE);
                    $this->set_user_meta('authentication_expire_date', time() + (5 * 60), TRUE);
                }
            } else {
                // If the type is verification, send the verification code via phone.
                $send = $this->send_by_twilio([
                    'to'   => '+' . $to,
                    'from' => '+19894738633',
                    'body' => sprintf(__('Your verification code for NH is %s', 'ninja'), $randomNumber)
                ]);

                if (!is_wp_error($send)) {
                    // If sending the code was successful, update the user meta data.
                    $this->set_user_meta('account_verification_status', 0, TRUE);
                    $this->set_user_meta('verification_key', $randomNumber, TRUE);
                    $this->set_user_meta('verification_expire_date', time() + (5 * 60), TRUE);
                }
            }

            return $send; // Return the result of sending the OTP code.
        }

        /**
         * Sends the WhatsApp OTP code.
         *
         * @param string $type The type of OTP code.
         * @param string $to The receiver number.
         *
         * @return \stdClass|\WP_Error The stdClass object or WP_Error object indicating the success of sending the OTP code.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @throws \Exception
         */
        public function send_whatsapp_otp_code(string $type, string $to = ''): \stdClass|\WP_Error
        {
            $error        = new WP_Error(); // Create a new WordPress error object.
            $randomNumber = mt_rand(1000, 9999); // Generate a random OTP code.
            $to           = empty($to) ? $this->username : $to;

            if ($type === 'authentication') {
                // If the type is authentication, send the authentication code via WhatsApp.
                $send = $this->send_by_twilio([
                    'to'   => 'whatsapp:+' . $to,
                    'from' => 'whatsapp:+19894738633',
                    'body' => sprintf(__('Your authentication code for NH is %s', 'ninja'), $randomNumber)
                ]);

                if (!is_wp_error($send)) {
                    // If sending the code was successful, update the user meta data.
                    $this->set_user_meta('account_authentication_status', 0, TRUE);
                    $this->set_user_meta('authentication_key', $randomNumber, TRUE);
                    $this->set_user_meta('authentication_expire_date', time() + (5 * 60), TRUE);
                }
            } else {
                // If the type is verification, send the verification code via WhatsApp.
                $send = $this->send_by_twilio([
                    'to'   => 'whatsapp:+' . $to,
                    'from' => 'whatsapp:+19894738633',
                    'body' => sprintf(__('Your verification code for NH is %s', 'ninja'), $randomNumber)
                ]);

                if (!is_wp_error($send)) {
                    // If sending the code was successful, update the user meta data.
                    $this->set_user_meta('account_verification_status', 0, TRUE);
                    $this->set_user_meta('verification_key', $randomNumber, TRUE);
                    $this->set_user_meta('verification_expire_date', time() + (5 * 60), TRUE);
                }
            }

            return $send; // Return the result of sending the OTP code.
        }

        /**
         * Sends the message using Twilio.
         *
         * @param array $data The data required to send the message.
         *
         * @return \stdClass|\WP_Error The stdClass object or WP_Error object indicating the success of sending the message.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @throws \Exception
         */
        private function send_by_twilio(array $data): \stdClass|\WP_Error
        {
            $error      = new WP_Error(); // Create a new WordPress error object.
            $account_ID = 'AC6fd8e3d3e4b54dcfbb681ebd0fec3cec';
            $username   = 'AC6fd8e3d3e4b54dcfbb681ebd0fec3cec';
            $password   = '859d2d5288fd109930458ae91f2b342f';
            $to         = $data['to'];
            $from       = $data['from'];
            $body       = $data['body'];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.twilio.com/2010-04-01/Accounts/$account_ID/Messages.json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, "$username" . ':' . "$password");

            $data = [
                'To'   => $to,
                'From' => $from,
                'Body' => $body
            ];

            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                // If there was a cURL error, add the error to the error object and return it.
                $error->add('sending_error', __("Response Error!", 'ninja'), [
                    'status'  => FALSE,
                    'details' => [
                        'details' => 'Error:' . curl_error($ch)
                    ]
                ]);
                return $error;
            }

            curl_close($ch);

            $response = json_decode($result);

            if ($response->status === 400) {
                // If the response status is 400, add the error to the error object and return it.
                $error->add('sending_error', __("Response Error!", 'ninja'), [
                    'status'  => FALSE,
                    'details' => [
                        'details' => $response
                    ]
                ]);
                return $error;
            }

            return $response; // Return the response object.
        }

        /**
         * Sends the email OTP code.
         *
         * @param string $type The type of OTP code.
         *
         * @return bool The boolean value indicating the success of sending the OTP code.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @throws \Exception
         */
        public function send_email_otp_code(string $type): bool
        {
            $randomNumber = mt_rand(1000, 9999); // Generate a random OTP code.

            if ($type === 'authentication') {
                // If the type is authentication, update the user meta data and send the authentication email.
                $this->set_user_meta('account_authentication_status', 0, TRUE);
                $this->set_user_meta('authentication_key', $randomNumber, TRUE);
                $this->set_user_meta('authentication_expire_date', time() + (5 * 60), TRUE);

                $email = Nh_Mail::init()
                                 ->to($this->email)
                                 ->subject('Welcome to Nh - Please Authenticate Your Email')
                                 ->template('account-authentication/body', [
                                     'data' => [
                                         'user'   => $this,
                                         'digits' => $randomNumber
                                     ]
                                 ])
                                 ->send();
            } else {
                // If the type is verification, update the user meta data and send the verification email.
                $this->set_user_meta('account_verification_status', 0, TRUE);
                $this->set_user_meta('verification_key', $randomNumber, TRUE);
                $this->set_user_meta('verification_expire_date', time() + (5 * 60), TRUE);

                $email = Nh_Mail::init()
                                 ->to($this->email)
                                 ->subject('Welcome to Nh - Please Verify Your Email')
                                 ->template('account-verification/body', [
                                     'data' => [
                                         'user'   => $this,
                                         'digits' => $randomNumber
                                     ]
                                 ])
                                 ->send();
            }

            return $email; // Return the result of sending the email.
        }

        /**
         * Returns the avatar URL for the user.
         *
         * @return string The URL of the avatar image.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        private function get_avatar(): string
        {
            $url = wp_get_attachment_image_url($this->user_meta['avatar_id'], 'thumbnail');
            return empty($url) ? Nh_Hooks::PATHS['public']['img'] . '/default-profile.webp' : $url;
        }

        /**
         * Checks if the user is confirmed.
         *
         * @return bool The boolean value indicating if the user is confirmed.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        private function is_confirm(): bool
        {
            if (empty($this->user_meta['account_verification_status']) || !boolval($this->user_meta['account_verification_status'])) {
                // If the account verification status is empty or false, the user is not confirmed.
                return FALSE;
            }

            return TRUE; // Otherwise, the user is confirmed.
        }

    }
