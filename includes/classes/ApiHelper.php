<?php

  Class ApiHelper {

    const API_DEBUG_KEY = "701eb98b8a3a4abf8ac4acbec7f76f4a"; // token used to enable debug when returning api
    const API_LIST = ["user", "auth", "language", "permission", "user_permission", "body", "company", "company_tracking_code", "tracking_code", "gui", "backup_handler", "system"];
    public static function get_public_actions(){
      return [ 
        "auth" => ["login"],
        "backup_handler" => ["create", "list"],
        "user" => [ "get_form", "get_register", "register_user", "reset_password",  "request_password_change", "create_simplified"],
        "investment_plan" => ["get_plan_details", "list_goals"], 
        "move" => [ "get_form" ],
        "dolar" => [ "create", "open", "open_90"]
      ];
    }

    public static function get_debug_info($_api_debug_key = null){
      if ( !$_api_debug_key || ( $_api_debug_key != self::API_DEBUG_KEY ) )
				return [ "debug" => "Invalid debug token" ];

      return [
        "debug" => [
          "request_method" => @$_SERVER['REQUEST_METHOD'],
          "remote_ip" => @$_SERVER['REMOTE_ADDR'],
          "script_executed" => @$_SERVER['SCRIPT_FILENAME'],
          "server_name" => @$_SERVER['SERVER_NAME'],
          "post" => @$_POST,
          "get" => @$_GET,
          "session" => @$_SESSION,
        ],
      ];

    }

    public static function create_error_return($error, $api, $status_code = 500){
      if ( !headers_sent() ) {              
        header('Content-Type: application/json');
      }
  
      $return = [
        "error_type" => get_class($error),
        "error_code" => $error->getCode() ? $error->getCode() : "",
        "error_message" => $error->getMessage() ? $error->getMessage() : "",
        "api" => $api,
        //"popup" => ["title" => get_class($error), "text" =>  $error->getMessage() ? $error->getMessage() : "", "type" => "error", "icon" => "error" ],
        "popup" => ["title" => 'Algo não saiu como esperado :(', "text" =>  $error->getMessage() ? $error->getMessage() : "", "type" => "error", "icon" => "error" ],
        "headers" => getallheaders(),
      ];
  
      switch ( $return["error_type"] ){
        case "FormException": 
          $return['field'] = $error->get_field();
          break;

        case "PermissionException": 
          $return['permission_required'] = $error->get_permission_required();
          break;
      }
  
      http_response_code($status_code);
  
      self::json_return($return);
      //echo json_encode($return, true);
    }

    public static function set_headers(){
      self::handle_cors();

      if ( isset($_REQUEST['header']) && !empty($_REQUEST['header']) ){
        switch ( $_REQUEST['header'] ){
          case "html":
            header('Content-Type: text/html; charset=utf-8');
            break;
        }

      }else {
        header('Content-Type: application/json; charset=utf-8');

      }
    }

    public static function handle_cors($allow_all = false){
        // Allow from any origin
      if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
      }
      
      // Access-Control headers are received during OPTIONS requests
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
          
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
          // may also be using PUT, PATCH, HEAD etc
          header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
          header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
      }
      
    }

    public static function json_return($data = []){
      if ( isset($_REQUEST['_api_debug_key']) && !empty($_REQUEST['_api_debug_key']) ){
        $data = array_merge($data, self::get_debug_info($_REQUEST['_api_debug_key']));
      }

      if ( http_response_code() == 200 ){
        if ( isset($data['popup']) && !isset($data['popup']['icon']) ){
          $data['popup']['icon'] = "ok";
        }
      }
      echo json_encode($data, true);
      
    }

    public static function is_allowed($api, $action, $api_token){
      $public_actions = self::get_public_actions();
      if ( isset($public_actions[$api]) ){
        if ( in_array($action, $public_actions[$api]) )
          return true;
      }

      if ( !empty($api_token) ) // force new session when using token 
        Auth::logout();

      // not logged in, try login with api token
      if ( !isset($_SESSION['auth']['authenticated']) || isset($_SESSION['auth']['authenticated']) != true )
        Auth::token_login($api_token);
        
      return true;
    }

    public static function get_api_list(){
      $files = array_diff(scandir(API_DIR_PATH), array('..', '.'));
      $api_list = [];
      if ( $files ){
        foreach ( $files as $key => $file_name ){
          $api_list[] = str_replace(".api.php", "", $file_name);
        }
      }
      return $api_list;
    }

    public static function null_empty_fields(){
      foreach ( $_REQUEST as $key => $data ){
        if ( $data == "" )
          $_REQUEST[$key] = null;
      }
      foreach ( $_POST as $key => $data ){
        if ( $data == "" )
          $_POST[$key] = null;
      }
    }

    public static function unset_empty_keys($data){
      if ( $data ){
        foreach ( $data as $key => $value ){
          if ( empty($value) )
            unset($data[$key]);
        }
      }

      return $data;
    }
  }