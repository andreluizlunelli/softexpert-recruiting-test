<?php

require './vendor/autoload.php';

use RecruitingApp\Bootstrap;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

Bootstrap::loadEnv();

$entityManager = Bootstrap::getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);