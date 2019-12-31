<?php

namespace RecruitingApp;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Dotenv\Dotenv;

class Bootstrap
{
    public static function loadEnv()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../config/.env');
    }
    
    public static function getEntityManager()
    {
        $paths = [__DIR__ . '/Model'];

        $isDevMode = true;

        $dbParams = [
            'driver' => getenv('driver'),
            'user' => getenv('user'),
            'password' => getenv('password'),
            'dbname' => getenv('dbname'),
            'port' => getenv('port'),
            'host' => getenv('host')
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        return EntityManager::create($dbParams, $config);
    }

    public static function run()
    {
        self::loadEnv();
    }
}