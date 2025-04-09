<?php
  Helper::show_php_errors(true);
  Auth::logout();
  //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 

  try {
    
    if ( !isset($_GET['crypt']) || !isset($_GET['hash']) || !isset($_GET['action']) )
      throw new NotFoundException("Parâmetros inválido, impossível realizar operação");

    $id = base64_decode($_GET['crypt']);
    $verify_token = base64_decode($_GET['hash']);
    $action = base64_decode($_GET['action']);

    switch ( $action ){
      case "register_user":
        $form_mode = "register";
        $title = "Unir-se à plataforma - Criar Usuário";
        break;

      case "reset_password":
        $title = "Alterar Senha";
        $form_mode = "reset_password";
        break;

      default:
        throw new Exception("Ação Inválida --->" . $action . " -->gta -- > {$_GET['action']}");
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
    header("Location: /login");
    echo "<pre>";
    var_dump($error);
    
    
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

  $gradient_start = Parameter::get("gradient_color_start");
  $gradient_end = Parameter::get("gradient_color_end");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $title; ?></title>
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon.ico">
<!-- Custom Stylesheet -->
<link rel="stylesheet" href="/assets/plugins/highlightjs/styles/darkula.css">
<link href="/assets/css/style.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="/assets/plugins/datatables/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/plugins/sweetalert2/sweetalert2.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/plugins/trumbowyg/ui/trumbowyg.min.css"/>
<link rel="stylesheet" href="/assets/plugins/trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css">
<!-- https://select2.org/data-sources/ajax -->
<link rel="stylesheet" type="text/css" href="/assets/plugins/select2/css/select2.css">
<link rel="stylesheet" type="text/css" href="/assets/plugins/select2/css/select2-boostrap.css">
<link rel="stylesheet" type="text/css" href="/assets/plugins/jquery_toast/jquery.toast.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/custom.css"/>    


<!-- Custom Stylesheet -->
<link href="/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link href="/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<link href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">


<link href="/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet">

<!-- Daterange picker plugins css -->
<link href="/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<script>

  function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
      setTimeout(fn, 1);
    } else {
      document.addEventListener("DOMContentLoaded", fn);
    }
  }    
</script>

<style>
body, html {
    height: 100%;
}

.bg-gradient {
    /* background: linear-gradient(to top, green, #ffffff); */
    background: linear-gradient(to top,  <?php echo "{$gradient_start},{$gradient_end}"; ?>);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-container {
    max-width: 400px;
    width: 100%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.login_logo {
  width: 400px;
}

.form_div {
  margin: auto !important;
}

@media (max-width: 768px) {
    .bg-gradient {
      height: auto;
    }
    .logo-container {
        margin-bottom: 20px;
        height: auto;
    }

    .login_logo {
      width: 200px;
    }

    .login_form {
      padding-top: 60px !important;
    }
}
</style>

<?php
   if ( Parameter::get("use_default_colors") == "false" ){
    $custom_colors = [];
    $Parameter = new Parameter();
    $colors = $Parameter->list([
      "code_in" => "custom_color,color_primary,color_secondary,color_success"
    ]);
    if ( $colors ){
      $css_colors = "";
      foreach ( $colors as $color ){
        $css_colors .= "--{$color['code']}: {$color['value']} !important;\r\n";
      }
      echo "
      <style>
        :root{        
          {$css_colors}
        }
      </style>
      ";
    }
  }
  ?>
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
      <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
              <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
          </svg>
      </div>
  </div>
  <!--*******************
      Preloader end
  ********************-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 bg-gradient">
            <div class="text-center logo-container">
            <?php echo "<img src='" . Parameter::get("login_logo_path") . "' " . Parameter::get("login_logo_img_attr") . " >" ?>
            </div>
        </div>
        <div class="col-md-6 form_div">
          <div class="">
           
            <form class='login_form' name="form_register" id="form_register" data-action="<?php echo $action; ?>" data-form_parameters='<?php echo $form_parameters; ?>' >
              <div class='login_title text-center'>
                <h4> <?php echo $title; ?></h4>
              </div>
              <div class="form_fields">
              </div>  
              <button type="submit" class="btn btn-sm btn-primary btn-block">Confirmar</button>
              </form>
          </div>
        </div>
    </div>
</div>


    <!--**********************************
      Scripts
      ***********************************-->
      <script src="/assets/plugins/common/common.min.js"></script>
      <script src="/assets/js/custom.min.js"></script>
      <script src="/assets/js/settings.js"></script>
      <script src="/assets/js/styleSwitcher.js"></script>
      <script src="/assets/plugins/highlightjs/highlight.pack.min.js"></script>
      <script>hljs.initHighlightingOnLoad();</script>
      <script type="text/javascript" src="/assets/plugins/datatables/datatables.min.js"></script>
  
      <script type="text/javascript" src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
      <script type="text/javascript" src="/assets/plugins/jquery_toast/jquery.toast.min.js"></script>
      
      <script src="/assets/js/controller/html.js"></script>
      <script src="/assets/js/controller/app.js"></script>
      <script src="/assets/js/controller/crud.js"></script>
      <script src="/assets/js/controller/datatables.js"></script>
      <script src="/assets/js/controller/notification.js"></script>
 
      <script src="/assets/plugins/trumbowyg/trumbowyg.js"></script>
      <script src="/assets/plugins/trumbowyg/plugins/emoji/trumbowyg.emoji.js"></script>

      <script src="/assets/plugins/moment/moment.js"></script>
      <script src="/assets/plugins/jquery_mask/jquery.mask.min.js"></script> 

      <!-- https://select2.org/data-sources/ajax -->
      <script src="/assets/plugins/select2/js/select2.js"></script>
      <script src="/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
      <!-- Clock Plugin JavaScript -->
      <script src="/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>

      <!-- Date Picker Plugin JavaScript -->
      <script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
      <!-- Date range Plugin JavaScript -->
      <script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
      <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
      <script src="/assets/plugins/confetti/confetti.js"></script>
    
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
            data.popup.redirect_url = "/login/";
            popup("success", data.popup);
            
          });
        }

      $(document).ready(function(){

        $.get("/api/?api=user&action=get_form&mode=<?php echo $form_mode;?>", function(data){
          let form_fields = data;
          $.each(data.fields, function(k, v){
            $(".form_fields").append(gerar_campo(v));
          });
          adjust_form();
          get_user();
        });

      });

      $(document).ajaxStart(function (){
          //Show loading
          $("#preloader").show();
        }).ajaxStop(function () {
          //Hide loading
          $("#preloader").hide();
        })

      function adjust_form(){
        let fields = $('.form_fields').find('.form-group');
        $.each(fields, function(k,v){
          $(v).removeClass("col-sm-6 col-md-6 col-lg-6").addClass("col-12 col-lg-12 col-sm-12 col-md-12");
        })
      }

      </script>
</body>
</html>
