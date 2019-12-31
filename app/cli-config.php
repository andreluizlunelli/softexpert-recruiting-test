<?php

require './vendor/autoload.php';

use RecruitingApp\Bootstrap;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$bootstrap = new Bootstrap();

$entityManager = $bootstrap->getContainer('em');

return ConsoleRunner::createHelperSet($entityManager);