<?php // Curriculum Api file

  $current_user_id = $_SESSION['auth']['user_id'];
  $Curriculum = new Curriculum();
  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_form":
          $mode = ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "create" );
          ApiHelper::json_return(Curriculum::get_form($mode));
          break;

        case "list":
          Auth::has_permission(["curriculum_list"], $throw_exception = true );
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

            
          ApiHelper::json_return($Curriculum->list($_REQUEST));          
          break;


        case "get_curriculum_info":        
          if ( !isset($_GET['id']) || empty($_GET['id']) )
            throw new FormException(TranslationHelper::get_text(["code" => "api_error_empty_id"]));
          
          $_REQUEST["limit"] = 1;

          if ( !Auth::is_admin()){
            $_REQUEST['user_id'] = @Auth::get_auth_info()['user_id']; // set current user id to prevent listing another user data
          }

          $curriculum_data = $Curriculum->list_details($_REQUEST);

          if ( $curriculum_data ){
            foreach ( $curriculum_data as $key => $data ){
              if ( !empty($data['courses']) ){
                $courses_list = json_decode($data['courses'], true);
                $counter = 1;
                foreach ( $courses_list as $key_course => $course ){
                  foreach ( $course as $course_field => $info ){
                    $curriculum_data[$key]["courses[$key_course][$course_field]"] = $info;
                  }
                  $counter++;
                }
              }
              if ( !empty($data['experiences']) ){
                $experiences_list = json_decode($data['experiences'], true);
                $counter = 1;
                foreach ( $experiences_list as $key_experience => $experience ){
                  foreach ( $experience as $experience_field => $info ){
                    $curriculum_data[$key]["experiences[$key_experience][$experience_field]"] = $info;
                  }
                  $counter++;
                }
              }
            }
          }
          ApiHelper::json_return($curriculum_data);    
          break;
        
        case "list_datatable":
          Auth::has_permission("curriculum_list", $throw_exception = true );
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($Curriculum->get_datatable_list($Curriculum->list($_REQUEST)));          
          break;

        case "html_table":
          Auth::has_permission(["curriculum_list"], $throw_exception = true );
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          $filters = $_REQUEST;
          $filters = ApiHelper::unset_empty_keys($_REQUEST);
          $list = $Curriculum->list_details($filters);
          $table = DataTable::create($Curriculum->to_datatable($list));

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
          Auth::has_permission(["curriculum_create"], $throw_exception = true );
          Helper::validate_form(Curriculum::get_form("create"), $_REQUEST, $bypass_required = ["id",]);
          
          $new_data = $_POST;
          $new_data['courses'] = json_encode($_POST['courses'], true);
          $new_data['experiences'] = json_encode($_POST['experiences'], true);
          $new_data['user_id'] = $current_user_id;
          $new_data['cpf'] = Helper::only_numbers($_POST['cpf']);
          $Curriculum->to_object($new_data);

          $new_data = $Curriculum->create();
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
          Auth::has_permission(["curriculum_edit"], $throw_exception = true );
          
          Helper::validate_form(Curriculum::get_form(), $_POST, $bypass_required = []);
         
          $curriculum = $Curriculum->list(["id" => $_POST['id']]);
          if ( !$Curriculum )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
        
          $new_data = $_POST;
          $new_data['courses'] = json_encode($_POST['courses'], true);
          $new_data['experiences'] = json_encode($_POST['experiences'], true);
          $new_data['cpf'] = Helper::only_numbers($_POST['cpf']);
          $new_data = $Curriculum->edit($new_data);
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
          Auth::has_permission(["curriculum_delete"], $throw_exception = true );
          if ( !isset($_POST['id']) || empty($_POST['id']) )
            throw new FormException(TranslationHelper::get_text(["code" => "api_error_empty_id"]));

          $curriculum = $Curriculum->list(["id" => $_POST['id']]);
          if ( !$Curriculum )
            throw new NotFoundException(TranslationHelper::get_text(["code" => "record_not_found", "replace_values" => [ "id" => $_POST['id']]]));
                      
          $Curriculum->to_object($_POST);
          $new_data = $Curriculum->delete($_POST['id']);
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