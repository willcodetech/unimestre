<?php
  //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
  ApiHelper::set_headers();
  ApiHelper::null_empty_fields();

  try {
    if ( !isset($_REQUEST['api']) || empty($_REQUEST['api']) )
      throw new ApiException(TranslationHelper::get_text(["code" => "api_error_api_empty"]));

    /**/
    if ( !isset($_REQUEST['action']) || empty($_REQUEST['action']) )
      throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_empty"]));
    
    if ( !in_array($_REQUEST['api'], ApiHelper::get_api_list()) )
      throw new ApiException(TranslationHelper::get_text(["code" => "api_error_api_empty"]));

    //ApiHelper::is_allowed($_REQUEST['api'], $_REQUEST['action'], @$_REQUEST['auth_token']);

    $request_headers = getallheaders();    
    ApiHelper::is_allowed($_REQUEST['api'], $_REQUEST['action'], @$request_headers['Auth-Token']);

    include_once("{$_REQUEST['api']}.api.php");

  } catch ( AuthException $error ){
    ApiHelper::create_error_return($error, @$_REQUEST['api'], 401); // unauthorized

  }catch ( PermissionException $error ){
    ApiHelper::create_error_return($error, @$_REQUEST['api'], 403); // forbidden

  }catch ( FormException $error ){
    ApiHelper::create_error_return($error, @$_REQUEST['api'], 400); // bad request / invalid data

  }catch ( Exception $error ){
    ApiHelper::create_error_return($error, @$_REQUEST['api'], 500); // interal or generic error

  }
