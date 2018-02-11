<?php 

namespace Inc;

final class Init {

    public static function get_services () {
        return [
            Base\Cron::class,
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Data\Read::class,
            Data\InsertUser::class,
            Data\UploadFile::class

        ];

    }

    

    public static function register_services () {
        foreach (self::get_services() as $class ) {
            $service = self::instantiate($class);
            if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
        }

    }

    protected static function instantiate ($class) {
        $service = new $class();
        return $service;

    }
}