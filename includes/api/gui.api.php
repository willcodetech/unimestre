<?php // Gui Api file

  switch ( $_SERVER['REQUEST_METHOD'] ){
    case "POST":
      switch ( $_POST['action'] ){
              
        default:
          throw new ApiException("Ação inválida");
          break;
      }
      break;

    case "GET":
      switch ( $_REQUEST['action'] ){
        case "get_menu":
          ApiHelper::json_return(Gui::get_menu());
          break;
        
        default:
          throw new ApiException("Ação inválida");
          break;
      }
      break;
  }