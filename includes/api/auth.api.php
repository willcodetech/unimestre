<?php // Auth Api file

  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "POST":
      switch ( $_POST['action'] ){
        case "login":            
          if ( !isset($_POST['login']) || empty($_POST['login']) )
            throw new Exception(TranslationHelper::get_text(["code" => "auth_error_empty_login"]));

          if ( !isset($_POST['password']) || empty($_POST['password']) )
            throw new Exception(TranslationHelper::get_text(["code" => "auth_error_empty_password"]));

          $auth = Auth::login($_POST['login'], $_POST['password']);
          if ( !$auth )            
            throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_invalid_user"]));

          if ( Auth::is_equipment() && !Parameter::get("enable_interface_equipment_login") )
            throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_equipment_login_not_allowed"]));

          ApiHelper::json_return($auth);       
          break;
        
        case "logout":
          $auth = Auth::logout();
          ApiHelper::json_return($auth);
          break;

        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;

    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_auth_info":
          ApiHelper::json_return(Auth::get_auth_info());
          break;

        case "check_session":
          $return = Auth::is_logged() ;
          if ( !$return ){
            $return['redirect_url'] = "/login/";
          }
          
          if ( !isset($_GET['return_values']) || $_GET['return_values'] != true )
            $return = [];

          ApiHelper::json_return($return);
          break;
        
        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;
  }