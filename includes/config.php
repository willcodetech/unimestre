<?php

  // base dir path (where source files are stored)
  define("BASE_DIR", dirname(__FILE__, 2) . "/");
  $include_path_list = [
    BASE_DIR . "includes",
    BASE_DIR . "includes/classes",
    BASE_DIR . "includes/api",
  ]; 

  define("STORAGE_DIR", BASE_DIR . "storage/");
  define("API_DIR_PATH", BASE_DIR . "includes/api" );
  // creating base dir configurations 
  $include_path_string = implode(PATH_SEPARATOR, $include_path_list);
  set_include_path($include_path_string);


  define("TEMPLATES_DIR", BASE_DIR . "includes/html/templates/");
  
  // error log file lcation 
  define("ERROR_LOG", BASE_DIR . "logs/error.log");  
  ini_set("error_log", ERROR_LOG);

  define("VIEWS_DIR", BASE_DIR . "/includes/html/views/" );
  
  // composer autoload
  include_once(BASE_DIR ."includes/vendor/autoload.php");

  // autoload classes
  spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
  });

  // used as parameter for user password creation, changing this will invalidate all users passwords
  define('PW_SALT', 'soh*eu*sei!');

  // used as parameter for api token creation, changing this will invalidate all api tokens
  define('API_TOKEN_SALT', 'T0k3n*4p1!');

  define('VERIFY_TOKEN_SALT', 'V3RiFyH4S1!');
  define('VERIFY_TOKEN_EXPIRATION_HOURS', '+48 hours');
  define('HELPER_SELECT2_TOKEN', 'aHblPppZ4tb0UNX2tC6Q4leBNiryyafXSWgf14Wfg');
  define('SUDO_TOKEN', 'bb26d9e9607500de55249fa7e0660955');

  // database connection settings
  $_config['db'] = [ 
    "SERVER" => "MYSQL", // server type 
    "DB" => "", // database name
    "HOST" => "localhost", // database host (dsn or ip)
    "PORT" => 1366,
    "USER" => "", // database user ( create, update, delete and insert permissions required )
    "PASSWORD" => "", // database password 
    "CHARSET" => "utf8mb4",
  ];
  define("DB_CONFIG", $_config['db']);
  define("DEFAULT_LANGUAGE", "pt_br");

  /*
  */
  $_config['mail'] = [
    "SMTP_USER" => "",
    "SMTP_PASSWORD" => "",
    "SMTP_HOST" => "",
    "SMTP_PORT" => "587",
    "SMTP_MAIL_FROM_ADDRESS" => "", // mail address used as sender
    "SMTP_MAIL_FROM_NAME" => Parameter::get("mail_sender_name"), //"WillCode - Portal", // name of sender
    "SMTP_OPTIONS" =>  [
      'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      ],
    ],
  ];
  define("MAIL_CONFIG", $_config['mail']);
  session_start();

  //$_SESSION['texts'] = TranslationHelper::get_all_texts(["language_code" => DEFAULT_LANGUAGE]);

  /*
    Default includes and other requirements
  */
  include_once("CustomExceptions.php");
  //$_crud_instance = Crud::get_instance();
  //Helper::show_php_errors();