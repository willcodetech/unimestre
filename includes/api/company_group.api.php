<?php // CompanyGroup Api file

  $current_user_id = $_SESSION['auth']['user_id'];
  $CompanyGroup = new CompanyGroup();
  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_form":
          $mode = ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "create" );
          ApiHelper::json_return(CompanyGroup::get_form($mode));
          break;

        case "list":
          Auth::has_permission(["company_group_list"], $throw_exception = true );
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($CompanyGroup->list($_REQUEST));          
          break;
        
        case "list_datatable":
          Auth::has_permission("company_group_list", $throw_exception = true );
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($CompanyGroup->get_datatable_list($CompanyGroup->list($_REQUEST)));          
          break;

        case "list_with_company":
          if ( !$_GET['id'] )
            throw new FormException("Parâmetros inválidos, impossível buscar grupo e serviços");

          Auth::has_permission("permission_group_list", $throw_exception = true );
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1;

          
          $return = $CompanyGroup->list($_REQUEST);
          $CompanyGroupCompany = new CompanyGroupCompany();
          $company_list = $CompanyGroupCompany->list(['company_group_id' => $_GET['id']]);        

          $return["checkboxes_array"] = [];
          if ( $company_list ){
            $return["checkboxes_array"][] = [
              "data" => $company_list,
              "field" => "company",
              "value" => "company_id"
            ];
          }
          ApiHelper::json_return($return);          
          break;

        case "html_table":
          Auth::has_permission(["company_group_list"], $throw_exception = true );
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          $filters = $_REQUEST;
          $filters = ApiHelper::unset_empty_keys($_REQUEST);
          $list = $CompanyGroup->list($filters);
          $table = DataTable::create($CompanyGroup->to_datatable($list));

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
          Auth::has_permission(["company_group_create"], $throw_exception = true );
          Helper::validate_form(CompanyGroup::get_form("create"), $_REQUEST, $bypass_required = ["id",]);
          
          $CompanyGroup->to_object($_POST);

          $new_data = $CompanyGroup->create();
          $message = TranslationHelper::get_text(["code" => "crud_created", "replace_values" => ["id" => $new_data]]);
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $new_data,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];

          if ( isset($_POST['company']) && !empty($_POST['company']) ){
            foreach ( $_POST['company'] as $company_id => $data ){
              $CompanyGroupCompany->company_group_id = $new_data;
              $CompanyGroupCompany->company_id = $company_id;
              $CompanyGroupCompany->create();

            }

          }
          ApiHelper::json_return($return);
          break;

        case "edit":
          Auth::has_permission(["company_group_edit"], $throw_exception = true );
          
          Helper::validate_form(CompanyGroup::get_form(), $_POST, $bypass_required = []);
         
          $company_group = $CompanyGroup->list(["id" => $_POST['id']]);
          if ( !$CompanyGroup )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
          
          $new_data = $CompanyGroup->edit($_POST);
          $message = TranslationHelper::get_text(["code" => "crud_edited", "replace_values" => ["id" => $_POST['id']]]);
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "POST" => $_POST,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];

          $CompanyGroupCompany = new CompanyGroupCompany();
          $CompanyGroupCompany->clear_company_group_company($company_group[0]['id']);
          if ( isset($_POST['company']) && !empty($_POST['company']) ){
            foreach ( $_POST['company'] as $company_id => $data ){
              $CompanyGroupCompany->company_group_id = $company_group[0]['id'];
              $CompanyGroupCompany->company_id = $company_id;
              $CompanyGroupCompany->create();

            }

          }
          ApiHelper::json_return($return);
          break;

        case "delete":
          Auth::has_permission(["company_group_delete"], $throw_exception = true );
          if ( !isset($_POST['id']) || empty($_POST['id']) )
            throw new FormException(TranslationHelper::get_text(["code" => "api_error_empty_id"]));

          $company_group = $CompanyGroup->list(["id" => $_POST['id']]);
          if ( !$CompanyGroup )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
                      
          $CompanyGroup->to_object($_POST);
          $new_data = $CompanyGroup->delete($_POST['id']);
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