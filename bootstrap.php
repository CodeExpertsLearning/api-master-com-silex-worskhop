<?php
require 'vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

define('UPLOAD_FOLDER', __DIR__ . '/public/assets/img/uploads/');

$isDevMode = false;

$paths = array(__DIR__ . '/src/Model');

$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'api_master_2',
    'host'     => '127.0.0.1'
);

$config = Setup::createConfiguration($isDevMode);

$driver = new AnnotationDriver(new AnnotationReader(), $paths);

$config->setMetadataDriverImpl($driver);

AnnotationRegistry::registerFile(
    __DIR__ . '/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
);

AnnotationRegistry::registerAutoloadNamespace(
	'JMS\Serializer\Annotation',
	__DIR__ . "/vendor/jms/serializer/src"
);

$entityManager = EntityManager::create($dbParams, $config);
