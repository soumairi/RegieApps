<?php



// Start Session
    session_start();

// Include Config

require('config.php');

require('classes/Bootstrap.php');
require('classes/Controller.php');
require('classes/Messages.php');
require('classes/Model.php');
require('classes/Pagination.php');
require('classes/convertir.php');
require('assets/pdf/fpdf.php');


require('controllers/home.php');
require('controllers/recettes.php');
require('controllers/users.php');


require('models/home.php');
require('models/recette.php');
require('models/user.php');




    $bootstrap = new Bootstrap($_GET);
    $controller = $bootstrap->createController();
    if ($controller) {
        $controller->executeAction();
    }
