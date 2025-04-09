<?php // user Api file

  $User = new User();
  $UserPermission = new UserPermission();
  $File = new File();
  $FileMimeType = new FileMimeType();
  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_form":
          $mode = ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "create" );
          ApiHelper::json_return(User::get_form($mode));
          break;

        case "list":          
          Auth::has_permission("user_list", $throw_exception = true );
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($User->list($_REQUEST));          
          break;
      
        case "list_own":

          if ( empty($_GET['id']) || $_GET['id'] != Auth::get_auth_info()['user_id'] )
            throw new AuthException("Ação permitida apenas para o mesmo usuário logado");

          //Auth::has_permission("user_list", $throw_exception = true );
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($User->list($_REQUEST));          
          break;

        case "list_with_permission":
          if ( !$_GET['id'] )
            throw new FormException("Parâmetros invalidos, impossível buscar usuário e permissões");

          Auth::has_permission("user_list", $throw_exception = true );
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          $return = $User->list($_REQUEST);        

          $return["permissions"] = $UserPermission->list(["user_id" => $_REQUEST['id']]);
          ApiHelper::json_return($return);          
          break;

        case "get_register":
          if ( !$_GET['id'] || !$_GET['hash'] )
            throw new FormException("Parâmetros inválidos, impossível buscar pré-cadastro");

          $filters = [
            "id" => $_GET['id'],
            "api_token" => $_GET['hash'],
          ];
          $user = $User->list($filters);
          if ( !$user )
            throw new NotFoundException("Não foi possível encontrar pré-cadastro");

          ApiHelper::json_return($user[0]);
          break;
        
        case "list_datatable":
          Auth::has_permission("user_list", $throw_exception = true );
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($User->get_datatable_list($User->list($_REQUEST)));          
          break;
        
        case "html_table":
          //Auth::has_permission("sale_list");
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          $filters = $_REQUEST;
          $filters = ApiHelper::unset_empty_keys($_REQUEST);
          $list = $User->list($filters);
          $table = DataTable::create($User->to_datatable($list));

          ApiHelper::json_return(["html" => $table, "filters" => $filters,]);          
          break;

        default:
          throw new ApiException("Ação Inválida");
          break;
      }
      break;

    case "POST":
      switch ( $_REQUEST['action'] ){
        case "create_simplified":            
          Helper::validate_form(User::get_form("create_simplified"), $_REQUEST, $bypass_required = ["id"]);
          $User->check_password($_POST['password'], $_POST['password2']);
          $data = $_POST;
          $data['role'] = "user";
          $data['permission_group_id'] = 6; // candidate
          $data['active'] = 1;
          $User->build($data);
          $new_data = $User->create();

          $message = "Usuário criado com sucesso!";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $new_data,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;
        case "create":            
          Auth::has_permission("user_create", $throw_exception = true );
          Helper::validate_form(User::get_form("create"), $_REQUEST, $bypass_required = ["id"]);
          $User->check_password($_POST['password'], $_POST['password2']);
          $User->build($_POST);
          $new_data = $User->create();

          if ( isset($_POST['permission']) && !empty($_POST['permission']) ){
            foreach ( $_POST['permission'] as $permission_id => $data ){
              $UserPermission->user_id = $new_data;
              $UserPermission->permission_id = $permission_id;
              $UserPermission->create();

            }

          }

          if( isset($_FILES)  && !empty($_FILES) ){
            $file_parameters = [ "register_id" => $new_data, "type" => "profile_picture", "object" => "user" ];
            $file_created = $File->create_file($file_parameters);
            if ( $file_created ){
              $User->edit([
                "id" =>$new_data,
                "profile_picture_url" => $file_created[0]['url']
              ]);

              $_SESSION['auth']['user_profile_picture'] = $file_created[0]['url'];
              $User->remove_profile_picture($new_data, $except_id = $file_created[0]['id']);
            }
          }

          $message = "Usuário criado com sucesso!";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $new_data,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "edit":
          Auth::has_permission("user_edit", $throw_exception = true );
          Helper::validate_form(User::get_form("edit"), $_POST, $bypass_required = []);
          $user = $User->list(["id" => $_POST['id']]);
          if ( !$user )
            throw new NotFoundException("Usuário: {$_POST['id']} não encontrado");

          $UserPermission->clear_user_permissions($user[0]['id']);
          if ( isset($_POST['permission']) && !empty($_POST['permission']) ){
            foreach ( $_POST['permission'] as $permission_id => $data ){
              $UserPermission->user_id = $user[0]['id'];
              $UserPermission->permission_id = $permission_id;
              $UserPermission->create();

            }

          }
          
          if( isset($_FILES)  && !empty($_FILES)  && is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['size'] > 0){
            $file_parameters = [ "register_id" => $_POST['id'], "type" => "profile_picture", "object" => "user" ];
            $file_created = $File->create_file($file_parameters);
            if ( $file_created ){
              $User->edit([
                "id" => $_POST['id'],
                "profile_picture_url" => $file_created[0]['url']
              ]);
              $_SESSION['auth']['user_profile_picture'] = $file_created[0]['url'];
              $User->remove_profile_picture($_POST['id'], $except_id = $file_created[0]['id']);
            }
          }

          //$User->to_object($_POST);
          $new_data = $User->edit($_POST);
          $message = "Usuário: {$user[0]['login']} - {$user[0]['name']} editado com sucesso";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "edit_own":
          //Auth::has_permission("user_edit", $throw_exception = true );
          Helper::validate_form(User::get_form("edit_own"), $_POST, $bypass_required = []);
          $user = $User->list(["id" => $_POST['id']]);
          if ( !$user )
            throw new NotFoundException("Usuário: {$_POST['id']} não encontrado");

          if ( Auth::get_auth_info()['user_id'] != $_POST['id'] )
            throw new NotFoundException("Não é permitido alterar a senha de outro usuário");

          if( isset($_FILES)  && !empty($_FILES) && is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['size'] > 0){
            $file_parameters = [ "register_id" => $_POST['id'], "type" => "profile_picture", "object" => "user" ];
            $file_created = $File->create_file($file_parameters);
            if ( $file_created ){
              $User->edit([
                "id" => $_POST['id'],
                "profile_picture_url" => $file_created[0]['url']
              ]);
              $_SESSION['auth']['user_profile_picture'] = $file_created[0]['url'];
              $User->remove_profile_picture($_POST['id'], $except_id = $file_created[0]['id']);
            }
          }
          
          //$User->to_object($_POST);
          $new_data = $User->edit($_POST);
          $message = "Usuário: {$user[0]['login']} - {$user[0]['name']} editado com sucesso";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "register_user":
          $_POST['active'] = 1;
          Helper::validate_form(User::get_form("register"), $_POST, $bypass_required = []);
          $User->check_password($_POST['password'], $_POST['password2']);
          $user = $User->list(["id" => $_POST['id'], "verify_token" => $_POST['verify_token'], "active" => false ]);
          if ( !$user )
            throw new NotFoundException("ID de usuario: {$_POST['id']} no encontrado");

          User::verify_token_is_valid($user[0]['verify_token_expiration']);       
          
          if( isset($_FILES)  && !empty($_FILES)  && is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['size'] > 0){
            $file_parameters = [ "register_id" => $_POST['id'], "type" => "profile_picture", "object" => "user" ];
            $file_created = $File->create_file($file_parameters);
            if ( $file_created ){
              $User->edit([
                "id" => $_POST['id'],
                "profile_picture_url" => $file_created[0]['url']
              ]);
              $_SESSION['auth']['user_profile_picture'] = $file_created[0]['url'];
              $User->remove_profile_picture($_POST['id'], $except_id = $file_created[0]['id']);
            }
          }
          $new_data = $User->confirm_register($_POST);
          $message =  "ID de usuario: {$_POST['login']} - {$_POST['name']} Registrado correctamente";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "popup" => ["title" => "Ok!", "text" =>  $message ],
          ];
          ApiHelper::json_return($return);
          break;

        case "reset_password":
          Helper::validate_form(User::get_form("reset_password"), $_POST, $bypass_required = []);
          $User->check_password($_POST['password'], $_POST['password2']);
          $user = $User->list(["id" => $_POST['id'], "verify_token" => $_POST['verify_token'], "active" => true, "limit" => 1 ]);
          if ( !$user )
            throw new NotFoundException("Usuário: {$_POST['id']} não encontrado ");

          User::verify_token_is_valid($user[0]['verify_token_expiration']);            

          $_POST['login'] = $user[0]['login'];
          $new_data = $User->confirm_password_change($_POST);
          $message =  "Usuário: {$_POST['login']} - Senha de {$_POST['name']} foi alterada com sucesso";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "popup" => ["title" => "Ok!", "text" =>  $message ],
          ];
          ApiHelper::json_return($return);
          break;
        case "reset_password_gui":
          Helper::validate_form(User::get_form("reset_password_gui"), $_POST, $bypass_required = []);
          $User->check_password($_POST['password'], $_POST['password2']);
          $user = $User->list(["id" => $_POST['id'], "login" => $_POST['login'] ]);
          if ( !$user )
            throw new NotFoundException("USuário: {$_POST['id']} não encontrado");        

          $new_data = $User->confirm_password_change_gui($_POST);
          $message =  "Usuário: {$_POST['login']} - {$_POST['name']} senha alterada com sucesso";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "popup" => ["title" => "Ok!", "text" =>  $message ],
          ];
          ApiHelper::json_return($return);
          break;

        case "delete":
          Auth::has_permission("user_delete", $throw_exception = true );
          
          $user = $User->list(["id" => $_POST['id']]);
          if ( !$user )
            throw new NotFoundException("Usuário: {$_POST['id']} não encontrado");

          $User->to_object($_POST);
          $new_data = $User->delete($_POST['id']);
          $return = [
            "type" => "ok",
            "message" => "Usuario {$user[0]['login']} - {$user[0]['name']} excluído com sucesso",
            "id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "remove_profile_picture": // This will delete every file saved as profile picture for this user
          if ( !isset($_POST['id']) || empty($_POST['id']) )
            throw new NotFoundException("ID no proporcionada");

          $user = $User->list(["id" => $_POST['id'], "limit" => 1]);
          if ( !$user )
            throw new NotFoundException("Usuário não encontrado, id: {$_POST['id']} ");

          if ( !Auth::is_admin() ){
            if ( Auth::get_auth_info()['user_id'] != $_POST['id'] )
              throw new NotFoundException("Não é pemitido alterar a foto de outro usuário.");

          }

          $User->remove_profile_picture($_POST['id']);
          $User->edit([
            "id" => $_POST['id'],
            "profile_picture_url" => null
          ]);

          $message = "Usuário: {$user[0]['login']} - {$user[0]['name']} - foto de perfil excluída";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "invite_user":
        case "send_invite":
          if ( !Auth::is_admin() )
            throw new Exception("Ação permitida apenas para administradores");

          Helper::validate_form(User::get_form("invite_user"), $_POST, $bypass_required = []);          
          $User->invite_user($_POST);
          $message = "Convite enviado ao email: : {$_POST['email']}";
          $return = [
            "type" => "ok",
            "message" => $message,
            //"id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;
  
        case "resend_invite":
          if ( !Auth::is_admin() )
            throw new Exception("Ação permitida apenas para administradores");

          Helper::validate_form(User::get_form("resend_invite"), $_POST, $bypass_required = ["id"]);        
          $_POST['resend'] = true;  
          $User->invite_user($_POST);
          $message = "Convite enviado ao email: : {$_POST['email']}";
          $return = [
            "type" => "ok",
            "message" => $message,
            //"id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "request_password_change":        
          Helper::validate_form(User::get_form("forgot_password"), $_POST, $bypass_required = ["id"]);        
          $_POST['resend'] = true;  
          $User->request_password_change($_POST);
          $message = "Convite enviado ao email: : {$_POST['email']}";
          $return = [
            "type" => "ok",
            "message" => $message,
            //"id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;
  
        default:
          throw new ApiException("Ação Inválida");
          break;
      }
      break;

    case "GET":
      break;
  }