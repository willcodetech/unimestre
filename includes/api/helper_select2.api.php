<?php // HelperSelect2 Api file

  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_itens":
          $list = HelperSelect2::list($_GET);
          ApiHelper::json_return($list);
          break;

        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;

  }