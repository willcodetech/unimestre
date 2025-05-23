<?php // PermissionGroupPermission Api file

  $current_user_id = $_SESSION['auth']['user_id'];
  $PermissionGroupPermission = new PermissionGroupPermission();
  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_form":
          $mode = ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "create" );
          ApiHelper::json_return(PermissionGroupPermission::get_form($mode));
          break;

        case "list":
          Auth::has_permission("permission_group_permission_list");
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($PermissionGroupPermission->list($_REQUEST));          
          break;
        
        case "list_datatable":
          Auth::has_permission("permission_group_permission_list");
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($PermissionGroupPermission->get_datatable_list($PermissionGroupPermission->list($_REQUEST)));          
          break;

        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;

    case "POST":
      switch ( $_REQUEST['action'] ){
        case "create":
          Auth::has_permission("permission_group_permission_create");
          Helper::validate_form(PermissionGroupPermission::get_form("create"), $_REQUEST, $bypass_required = ["id",]);
          
          $PermissionGroupPermission->to_object($_POST);

          $new_data = $PermissionGroupPermission->create();
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
          Auth::has_permission("permission_group_permission_edit");
          
          Helper::validate_form(PermissionGroupPermission::get_form(), $_POST, $bypass_required = []);
         
          $permission_group_permission = $PermissionGroupPermission->list(["id" => $_POST['id']]);
          if ( !$PermissionGroupPermission )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
          
          $new_data = $PermissionGroupPermission->edit($_POST);
          $message = TranslationHelper::get_text(["code" => "crud_edited", "replace_values" => ["id" => $new_data]]);
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
          Auth::has_permission("permission_group_permission_delete");
          if ( !isset($_POST['id']) || empty($_POST['id']) )
            throw new FormException(TranslationHelper::get_text(["code" => "api_error_empty_id"]));

          $permission_group_permission = $PermissionGroupPermission->list(["id" => $_POST['id']]);
          if ( !$PermissionGroupPermission )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
                      
          $PermissionGroupPermission->to_object($_POST);
          $new_data = $PermissionGroupPermission->delete($_POST['id']);
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