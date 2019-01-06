<?php
session_start();
require "../config.php";
require "../app/Router.php";

require "../app/classes/Messages.php";

// ----------------------------------------
//  Controllers
// ----------------------------------------
require "../app/controllers/Controller.php";
require "../app/controllers/HomeController.php";
require "../app/controllers/UsersController.php";
require "../app/controllers/SharesController.php";

// ----------------------------------------
//  Models
// ----------------------------------------
require "../app/models/Model.php";
require "../app/models/UsersModel.php";
require "../app/models/SharesModel.php";

$router = new Router($_SERVER["REQUEST_URI"]);
$router->route();