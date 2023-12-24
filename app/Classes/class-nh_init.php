<?php
    /**
     * @Filename: class-nh_init.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */

    namespace NH\APP\CLASSES;

    use Exception;
    use NINJAHUB\APP\CLASSES\Ninjahub_Init;
    use stdClass;

    /**
     * Description...
     *
     * @class Nh_Init
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Init extends Ninjahub_Init
    {
        /**
         * @var array
         */
        public static array $obj = [];
        /**
         * @var null
         */
        protected static $instance = NULL;
        /**
         * @var \string[][][]
         */
        protected array $class_name = [];

        public function __construct()
        {
            parent::__construct();
            $this->class_name['core']  = [];
            $this->class_name['admin']  = [];
            $this->class_name['public'] = [
                'Auth'    => [
                    'type'      => 'class',
                    'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                    'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_auth.php'
                ],
                'Blog'    => [
                    'type'      => 'class',
                    'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                    'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_blog.php'
                ],
                'Profile' => [
                    'type'      => 'class',
                    'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                    'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_profile.php'
                ]
            ];
        }

        /**
         * @return mixed|null
         */
        public static function get_instance()
        {
            $class = __CLASS__;
            if (!self::$instance instanceof $class) {
                self::$instance = new $class;
            }

            return self::$instance;
        }

        /**
         * @param $type
         * @param $class
         *
         * @return mixed|\stdClass
         */
        public static function get_obj($type, $class)
        {
            return array_key_exists($class, self::$obj[$type]) ? self::$obj[$type][$class] : new stdClass();
        }

        /**
         * @param $type
         *
         * @throws \Exception
         */
        public function run($type): void
        {
            echo '[FIRST]';

            if (array_key_exists($type, $this->class_name)) {
                foreach ($this->class_name[$type] as $class => $value) {
                    try {
                        if (!file_exists($value['path'])) {
                            throw new Exception("Your class path is invalid.");
                        }

                        require_once $value['path'];

                        if ('abstract' === $value['type'] || 'helper' === $value['type'] || 'widget' === $value['type']) {
                            continue;
                        }

                        $class_name = $value['namespace'] . "\Nh_" . $class;
                        $class_name .= $type === 'admin' ? "_Admin" : "";

                        if (!class_exists("$class_name")) {
                            throw new Exception("Your class is not exists.");
                        }

                        self::$obj[$class] = new $class_name();

                    } catch (Exception $e) {
                        echo "<code>" . $e->getMessage() . "</code>";
                    }
                }
            }
        }
    }
