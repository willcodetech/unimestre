<?php // System Api file

  switch ( $_SERVER['REQUEST_METHOD'] ){
    
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_all_texts":
          $list = TranslationHelper::minify($_SESSION['texts']);
          ApiHelper::json_return($list);
          break;
        
        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;
  }