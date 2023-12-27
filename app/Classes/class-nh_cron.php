<?php
    /**
     * @Filename: class-nh_cron.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 29/6/2023
     */

    namespace NH\APP\CLASSES;

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Cron
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author  - Mustafa Shaaban
     */
    class Nh_Cron
    {
        const NOTIFICATIONS_LIMIT = 20;
        private Nh_Hooks $hooks;

        public function __construct()
        {
            $this->hooks = new Nh_Hooks();
            $this->hooks->add_filter('cron_schedules', $this, 'nh_schedules');
            $this->hooks->add_action(Nh::_DOMAIN_NAME . '_check_notifications', $this, 'check_notifications');
            $this->hooks->add_action('init', $this, 'init_schedules');
            $this->hooks->run();
        }

        public function nh_schedules($schedules)
        {
            $schedules['daily'] = [
                'interval' => 86400,
                'display'  => esc_html__('NH Check Every 24 hours'),
            ];
            return $schedules;
        }


        /**
         * Check user notifications and automatically remove the exceeded limit notifications
         * @throws \Exception
         */
        public function check_notifications(): void
        {
            global $wpdb;

            $results = $wpdb->get_results("
                        SELECT
                            u.ID,
                            u.user_login,
                            COUNT(p.ID) AS post_count
                        FROM
                            " . $wpdb->prefix . "users u
                        LEFT JOIN
                            " . $wpdb->prefix . "posts p ON u.ID = p.post_author
                        WHERE
                            p.post_type = 'notification'
                            AND p.post_status = 'publish'
                        GROUP BY
                            u.ID, u.user_login
                        ORDER BY
                            post_count DESC
                    ");

            foreach ($results as $user) {
                if ($user->post_count > self::NOTIFICATIONS_LIMIT) {
                    $IDs = $wpdb->get_results("
                        SELECT
                            p.ID
                        FROM
                            " . $wpdb->prefix . "posts p
                        WHERE
                            p.post_type = 'notification'
                            AND p.post_status = 'publish'
                            AND p.post_author = '" . $user->ID . "'
                        ORDER BY
                            p.ID DESC
                        LIMIT 18446744073709551615
                        OFFSET " . self::NOTIFICATIONS_LIMIT . "
                    ");

                    foreach ($IDs as $obj) {
                        wp_delete_post($obj->ID, TRUE);
                    }
                }
            }
        }

        public function init_schedules(): void
        {
            if (!wp_next_scheduled(Nh::_DOMAIN_NAME . '_check_notifications')) {
                wp_schedule_event(time(), 'daily', Nh::_DOMAIN_NAME . '_check_notifications'); //1644876600
            }
        }

    }
