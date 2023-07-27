<?php
    /**
     * @Filename: class-nh_profile.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\CLASSES\Nh_User;
    use WP_Post;


    /**
     * Description...
     *
     * @class Nh_Profile
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Profile extends Nh_Module
    {
        public array $meta_data = [
            'widget_list',
            'preferred_opportunities_cat_list',
            'preferred_articles_cat_list',
        ];
        public array $taxonomy = [
            'industry'
        ];

        public function __construct()
        {
            parent::__construct('profile');
        }

        /**
         * Description...
         *
         * @param \WP_Post $post
         * @param array    $meta_data
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return \NH\APP\CLASSES\Nh_Post
         */
        public function convert(WP_Post $post, array $meta_data = []): Nh_Post
        {
            return parent::convert($post, $this->meta_data);
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
            $this->hooks->add_filter('show_admin_bar', $this, 'hide_admin_bar');
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return bool
         */
        public function hide_admin_bar(): bool
        {
            global $user_ID;
            if (!is_user_logged_in() || (Nh_User::get_user_role($user_ID) === Nh_User::INVESTOR || Nh_User::get_user_role($user_ID) === Nh_User::OWNER)) {
                return FALSE;
            }
            return TRUE;
        }
    }
