<?php

module_load_include('php', 'itonics_nabin_teacher', 'src/Controllers/ItonicsNabinTeacherEntityBaseController');
module_load_include('php', 'itonics_nabin_teacher', 'src/Controllers/ItonicsNabinTeacherContainer');
module_load_include('php', 'itonics_nabin_teacher', 'src/Controllers/ItonicsNabinStateController');
module_load_include('php', 'itonics_nabin_teacher', 'src/Controllers/ItonicsNabinDistrictController');
module_load_include('php', 'itonics_nabin_teacher', 'src/Entities/ItonicsNabinTeacher');
module_load_include('php', 'itonics_nabin_teacher', 'src/Entities/ItonicsNabinState');
module_load_include('php', 'itonics_nabin_teacher', 'src/Entities/ItonicsNabinDistrict');

/*
 * @note: This is a container class for testing and tinkering around with.
 * Please skip this if referencing something related to drupal 7
 * */
class TeacherServiceContainer
{
    private $moduleIdentifier = 'nabin_itonics_teacher';

    protected static $instances = [];

    public function __construct() {
        var_dump("here");
    }

    public static function get($service) {
        if (!isset(self::$instances[$service])) {
            self::$instances[$service] = self::resolve($service);
        }

        return self::$instances[$service];
    }

//    public static function resolve($service) {
//        switch ($service) {
//            case 'controller':
//                module_load_include('php', self::$moduleIdentifier, 'src/Controllers/TeacherController');
//                return new TeacherController();
//            case 'model':
//                module_load_include('php', self::$moduleIdentifier, 'src/Entities/Teacher');
//                return new Teacher();
//            case 'view':
//                module_load_include('php', self::$moduleIdentifier, 'src/Views/TeacherView');
//                return new TeacherView();
//            default:
//                throw new Exception('Unknown service: '. $service);
//        }
//    }

    public static function route($method) {
        $controller = self::get('controller');
        return call_user_func([$controller, $method]);
    }
}
