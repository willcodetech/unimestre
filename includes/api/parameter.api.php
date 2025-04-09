<?php // Parameter Api file

  $current_user_id = $_SESSION['auth']['user_id'];
  $Parameter = new Parameter();
  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_form":
          $mode = ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "create" );
          ApiHelper::json_return(Parameter::get_form($mode));
          break;

        case "list":
          Auth::has_permission("parameter_list", $throw_exception = true );
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($Parameter->list($_REQUEST));          
          break;
        
        case "list_datatable":
          Auth::has_permission("parameter_list", $throw_exception = true );
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($Parameter->get_datatable_list($Parameter->list($_REQUEST)));          
          break;

        case "html_table":
          Auth::has_permission("parameter_list", $throw_exception = true );
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          $filters = $_REQUEST;
          $filters = ApiHelper::unset_empty_keys($_REQUEST);
          $list = $Sale->list_details($filters);
          $table = DataTable::create($Sale->to_datatable($list));

          ApiHelper::json_return(["html" => $table, "filters" => $filters, ]);          
          break;
        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;

    case "POST":
      switch ( $_REQUEST['action'] ){
        case "create":
          Auth::has_permission("parameter_create", $throw_exception = true );
          Helper::validate_form(Parameter::get_form("create"), $_REQUEST, $bypass_required = ["id",]);
          
          $Parameter->to_object($_POST);

          $new_data = $Parameter->create();
          $message = TranslationHelper::get_text(["code" => "crud_created", "replace_values" => ["id" => $new_data]]);
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $new_data,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "edit":
          Auth::has_permission("parameter_edit", $throw_exception = true );
          
          Helper::validate_form(Parameter::get_form(), $_POST, $bypass_required = []);
         
          $parameter = $Parameter->list(["id" => $_POST['id']]);
          if ( !$Parameter )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
          
          $new_data = $Parameter->edit($_POST);
          $message = TranslationHelper::get_text(["code" => "crud_edited", "replace_values" => ["id" => $_POST['id']]]);
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "POST" => $_POST,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "delete":
          Auth::has_permission("parameter_delete", $throw_exception = true );
          if ( !isset($_POST['id']) || empty($_POST['id']) )
            throw new FormException(TranslationHelper::get_text(["code" => "api_error_empty_id"]));

          $parameter = $Parameter->list(["id" => $_POST['id']]);
          if ( !$Parameter )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
                      
          $Parameter->to_object($_POST);
          $new_data = $Parameter->delete($_POST['id']);
          $message = TranslationHelper::get_text(["code" => "crud_deleted", "replace_values" => ["id" => $new_data]]);
          $return = [
            "type" => "ok",
            "message" => $message,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message ],
            "id" => $_POST['id'],
          ];
          ApiHelper::json_return($return);
          break;
  

        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;
      
  }