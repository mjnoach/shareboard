<?php

/*
 Fill out the DATABASE section with valid values and rename this file to 'config.php'
*/

// ========================================
//  DATABASE
// ========================================
define("PDO_DSN_PREFIX", "mysql");
define("DB_HOST", "");
define("DB_PORT", "3306");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASS", "");

// ========================================
//  SERVER
// ========================================
define("ROOT_URL", "http://".$_SERVER['SERVER_NAME']);
define("SERVER_TLD", substr(strrchr($_SERVER['SERVER_NAME'], '.'), 1));
