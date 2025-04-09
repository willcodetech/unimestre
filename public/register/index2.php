<?php
  ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 

  try {
    
    if ( !isset($_GET['crypt']) || !isset($_GET['hash']) || !isset($_GET['action']) )
      throw new NotFoundException("Parâmetros inválido, impossível realizar operação");

    $id = base64_decode($_GET['crypt']);
    $verify_token = base64_decode($_GET['hash']);
    $action = base64_decode($_GET['action']);

    switch ( $action ){
      case "register_user":
        $form_mode = "register";
        $title = "Ingressar à plataforma - Criar usuário";
        break;

      case "reset_password":
        $title = "Alteração de Senha";
        $form_mode = "reset_password";
        break;

      default:
        throw new Exception("Ação inválida");
        break;

    }

    $User = new User();
    $temp_user = $User->list( [ "id" => $id, "verify_token" => $verify_token, "limit" => 1 ] );
    
    if ( !$temp_user )
      throw new NotFoundException("Convite inválido, impossível realizar operação");

    $temp_user = $temp_user[0];
    User::verify_token_is_valid($temp_user['verify_token_expiration']);

  } catch ( Exception $error ){

    $_SESSION['error'] = [
      "error_type" => get_class($error),
      "error_code" => $error->getCode() ? $error->getCode() : "",
      "error_message" => $error->getMessage() ? $error->getMessage() : "",  
      "debug" => [
        "request_method" => @$_SERVER['REQUEST_METHOD'],
        "remote_ip" => @$_SERVER['REMOTE_ADDR'],
        "script_executed" => @$_SERVER['SCRIPT_FILENAME'],
        "server_name" => @$_SERVER['SERVER_NAME'],
        "post" => @$_POST,
        "get" => @$_GET,
        //"session" => @$_SESSION,
      ],
    ];
    header("Location: /error");
    
  }
  
  
  //$temp_user['api_token'] = $_GET['hash'];
  $user_json = json_encode($temp_user, true);

  $form_parameters = [
    "action" => "register_user", 
    "api" => "user", 
    "submit_url" => "/api/", 
    "method" => "POST",
    "form_id" => "form_register",
  ];
  $form_parameters = json_encode($form_parameters, true);
?>
<!DOCTYPE html>
<html>
  <head>
    <!--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    -->
     <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="/assets/plugins/datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap5/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/sweetalert2/sweetalert2.min.css"/>
    <style>
      .month_content {
        border-radius: 8pt;
        padding: 10px;
        
      }
      .blue_loss {
        background-color: #084c7e;
        color: white;
      }

      .bg_green_cartera {
        background-color: #02991a;
      }

      .margin_15 {
        margin-top: 15px !important;
        margin-bottom: 15px !important;
        margin-left: 1px !important;
        margin-right: 1px !important;
      }
      .swal2-styled.swal2-confirm {
        background-color: #02991a !important;
      }
    </style>
  </head>
  <body>

    <div class="container" >
      <hr>
      <div class="row">
        <div class="col-12 bg_green_cartera">
          <div class="margin_15">
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="row">
                    <div class="col-sm-12 text-center">
                      <img src="/assets/img/logo.png" width="300" height="100"  >
                    </div>
                    
                </div>
              </div>
              <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text">
                <div class="row">
                  <div class="col-sm-12 text-center">
                    <?php 
                      echo $title;
                    ?>
                    <hr>
                  </div>
                    
                </div>
                <div class="col col-sm ">                    
                  <form name="form_register" id="form_register" data-action="<?php echo $action; ?>" data-form_parameters='<?php echo $form_parameters; ?>' >

                    <div class="col-sm text-left">
                      <div class="form_fields">
                      </div>  
                    </div>                 
                      
                    <div class="col-sm text-center">
                      <button class="btn btn-md text-white bg_green_cartera" > Confirmar Registro</button>
                    </div>
                  </form>
                </div>
                </p>          
              </div>
            </div>
          </div>
        </div>
   </div>   
    <script type="text/javascript" src="/assets/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/datatables/datatables.min.js"></script>

    <script type="text/javascript" src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/assets/js/controller/html.js"></script>
    <script src="/assets/js/controller/app.js"></script>
    <!-- <script src="/assets/js/app.js"></script> -->
    <script>

      function get_user(){
        
        let user_data = <?php echo $user_json; ?>;
        $.each(user_data, function(k, v){
            
          switch ( k ){               
            case "login":
              v = "";                
              break;
          }
          $("#form_register").find(":input[name='" + k + "']").val(v);
        });

      }

      $(document).on("submit", "form", function(e){
          e.preventDefault();
          let form_name = $(this).attr("name");
          let action = $(this).data("action");
          submit_form_register(form_name, action);
        });

        function submit_form_register(form_name, action){
          let formdata = new FormData($(`form[name='${form_name}']`)[0]);
          formdata.append(`action`, action);
          formdata.append(`api`, `user`);
          console.log(formdata);
          var link = "/api/";
          $.ajax({
            type: 'POST',
            url: link,
            data: formdata ,
            processData: false,
            contentType: false
      
          }).fail(function(data){
            let response = (data.responseJSON);
            console.log(data.responseJSON);
            popup("error", response.popup);
          }).done(function (data) {
            console.log(data);
            data.popup.redirect_url = "/login.php";
            popup("success", data.popup);
            
          });
        }

      $(document).ready(function(){

        $.get("/api/?api=user&action=get_form&mode=<?php echo $form_mode;?>", function(data){
          let form_fields = data;
          $.each(data.fields, function(k, v){
            $(".form_fields").append(gerar_campo(v));
          });
          get_user();
        });

      });

    </script>
  </body>
</html>