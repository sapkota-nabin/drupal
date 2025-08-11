<?php

class TeacherServiceContainer
{
    private $moduleIdentifier = 'nabin_itonics_teacher';

    protected static $instances = [];
    
    public static function get($service) {
        if (!isset(self::$instances[$service])) {
            self::$instances[$service] = self::resolve($service);
        }

        return self::$instances[$service];
    }

    public static function resolve($service) {
        switch ($service) {
            case 'controller':
                module_load_include('php', self::$moduleIdentifier, 'src/Controllers/TeacherController');
                return new TeacherController();
            case 'model':
                module_load_include('php', self::$moduleIdentifier, 'src/Entities/Teacher');
                return new Teacher();
            case 'view':
                module_load_include('php', self::$moduleIdentifier, 'src/Views/TeacherView');
                return new TeacherView();
            default:
                throw new Exception('Unknown service: '. $service);
        }
    }

    public static function route($method) {
        $controller = self::get('controller');
        return call_user_func([$controller, $method]);
    }
}
