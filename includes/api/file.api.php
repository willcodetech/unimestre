<?php // File Api file

  $current_user_id = $_SESSION['auth']['user_id'];
  $File = new File();
  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_form":
          $mode = ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "create" );
          ApiHelper::json_return(File::get_form($mode));
          break;

        case "list":
          Auth::has_permission("file_list");
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($File->list_details($_REQUEST));          
          break;
        
        case "list_datatable":
          Auth::has_permission("file_list");
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          ApiHelper::json_return($File->get_datatable_list($File->list_details($_REQUEST)));          
          break;

        case "html_table":
          //Auth::has_permission("file_list");
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          $filters = $_REQUEST;
          //$filters = ApiHelper::unset_empty_keys($_REQUEST);
          $list = $File->list_details($filters);          
          $table = DataTable::create($File->to_datatable($list, $summary = $_GET['summary'] ?? null));

          ApiHelper::json_return(["html" => $table, "filters" => $filters, "data" => $list ]);          
          break;

        case "html_table_checkbox":
          //Auth::has_permission("file_list");
          $_REQUEST['ignore_fields'] = ["create_date", "password", "api_token"];
          if ( !isset($_REQUEST["limit"]) || empty($_REQUEST["limit"]) )
            $_REQUEST["limit"] = 1000;

          $filters = $_REQUEST;
          //$filters = ApiHelper::unset_empty_keys($_REQUEST);
          $list = $File->list_details($filters);          
          $table = DataTable::create($File->to_datatable_summary_checkbox($list));

          ApiHelper::json_return(["html" => $table, "filters" => $filters, "data" => $list ]);          
          break;

        case "get":
          if ( !isset($_GET['hash']) || empty($_GET['hash']) )
            throw new Exception("Invalid parameter");

          $file = $File->list_details(["hash" => $_GET['hash']]);

          if ( !$file ){
            throw new NotFoundException("Arquivo não encontrado");
          }

          if ( empty($file[0]['path']) ){
            throw new Exception("Caminho do arquivo não encontrado");
          }

          $file_path = STORAGE_DIR . $file[0]['path'];

          if ( file_exists($file_path) ){

            // se for informado parâmetro para download, forçar o download do arquivo
            if ( isset($_GET['download']) && $_GET['download'] == true ){
              header('Content-Disposition: attachment; filename=' . $file[0]['original_name']);
              header('Pragma: no-cache');   

            }else { // se não, abrir o arquivo direto no browser
              header('Content-Type: ' . $file[0]['mime_type']);
              header('Content-Transfer-Encoding: binary');  
              header('Accept-Ranges: bytes');
            }

            readfile($file_path);

          }else {

            throw new Exception("Arquivo não encontrado no storage");

          }
      
          break;


        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;

    case "POST":
      switch ( $_REQUEST['action'] ){
        case "edit":
          throw new Exception("File edit not allowed");
          break;
       
        case "create":
          $parameters = $_POST;
          //$parameters['type'] = "profile_picture";
          $upload = $File->create_file($parameters);
          $message = "File uploaded";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $new_data,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        case "create_attachment":
          $parameters = $_POST;
          //$parameters['type'] = "profile_picture";
          $upload = $File->create_file($parameters);
          $message = "File uploaded";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $new_data,
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];

          if ( $_POST['register_id'] && $_POST['object'] ){ // return update list
            $list = $File->list_details(["object" =>  $_POST['object'], "register_id" => $_POST['register_id']]);
            $return['html'] = DataTable::create($File->to_datatable($list, $summary = true));
          }
          ApiHelper::json_return($return);
          break;
        case "delete":
        case "destroy":

          if ( !Auth::is_admin() )
            throw new AuthException("Function available only to administrators");

          if ( !isset($_POST['id']) || empty($_POST['id']) )
            throw new Exception("Id not specified, cannot destroy files");

          $destroyed = $File->destroy($_POST['id']);

          if ( !$destroyed )
            throw new Exception("An error occurred while deleting file id: {$_POST['id']}");  

          $message = "File deleted successfully ";
          $return = [
            "type" => "ok",
            "message" => $message,
            "id" => $_POST['id'],
            "popup" => ["type" => "success", "title" => TranslationHelper::get_text(["code" => "popup_success"]), "text" => $message,]
          ];
          ApiHelper::json_return($return);
          break;

        default:
          throw new ApiException(TranslationHelper::get_text(["code" => "api_error_action_invalid"]));
          break;
      }
      break;
      
  }