<?php

/*******************************
          DEPENDENCIES
*******************************/

require_once 'vendor/autoload.php';

require_once 'kernel/Kernel.php';


/*******************************
              RUN
*******************************/

Kernel::init();


$app = \Slim\Slim::getInstance();
$app->run();

