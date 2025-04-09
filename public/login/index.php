<?php 

  //ini_set('display_errors', 1);
  //ini_set('display_startup_errors', 1);
  //error_reporting(0);
  Auth::logout();
  $title = Parameter::get("system_name");

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
           
            <form class="login_form" id="auth">
              <div class='login_title text-center'>
                <h4 style='color: ;'><?php echo Parameter::get("system_name"); ?></h4>
              </div>
              <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control form-control-sm input-sm" id="login" name="login" placeholder="">
              </div>
              <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control  form-control-sm " id="password" name="password" placeholder="">
              </div>
              <button type="submit" class="btn btn-sm btn-primary btn-block">Entrar</button>

              <button type="button" class="btn btn-sm btn-primary btn-block " 
                onclick="handle_form(this)" 
                data-toggle="modal" 
                data-target="#form_modal" 
                data-form="form_user" 
                data-action="create_simplified" 
                data-modal_text="Novo usuário" 
                data-api="user" 
                data-api_action="get_form" 
                data-mode="create_simplified" 
                data-confirm="required" 
                data-confirm_parameters="{&quot;title&quot;:&quot;Incluir ?&quot;,&quot;html&quot;:&quot;Um novo registro ser\u00e1 criado.&quot;,&quot;icon&quot;:&quot;question&quot;}" 
                data-method="POST" 
                data-reload="true" 
                data-hide_form="true">
                <i class="icon-plus menu-icon"></i> Cadastre-se
              </button>
              <p class="mt-3 mb-0 text-center">
                <small><a href="#" style="/*color: green*/"
                
                  
                  onClick="handle_form(this)" 
                  data-toggle="modal" 
                  data-target="#form_modal" 
                  data-form="user" 
                  data-action="request_password_change" 
                  data-modal_text="Recuperação de Senha" 
                  data-api="user" 
                  data-api_action="get_form" 
                  data-mode="forgot_password" 
                  data-confirm="required" 
                  data-confirm_parameters='{"title": "Solicitar recuperação de senha?", "html": "Será enviado um email com as instruções para recuperação.", "icon": "question"}'  
                  data-method="POST"
                  data-reload="true"
                  data-hide_form="true"
                >
                  Esqueceu sua senha?
                </a></small>
              </p>
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
       
    <script type="text/javascript" src="/assets/plugins/autonumeric/autonumeric.min.js"></script>
      <!-- 
      -->

    <script>

      function login(){
        let formdata = new FormData($("#auth")[0]);
        console.log(formdata);
        formdata.append(`action`, `login`);
        $("button.submit").prop("disabled", true);
        $.ajax({
          type: `POST`,
          url: `/api/?api=auth`,
          data: formdata ,
          processData: false,
          contentType: false,
          xhrFields: {
            withCredentials: true
          },
    
        }).fail(function(data){
          let response = (data.responseJSON);
          console.log(data.responseJSON);
          $("button.submit").prop("disabled", false);
          popup("error", response.popup);

        }).done(function (data) {
          console.log(data);
          if ( data.authenticated ){
            location.href = "/"
          }
          
        });

        
        
      }

      $(document).ready(function(){
        console.log("iniciado");

        $("form#auth").on("submit", function(e){
          e.preventDefault();
          login();

        });

        $(document).ajaxStart(function (){
          //Show loading
          $("#preloader").show();
        }).ajaxStop(function () {
          //Hide loading
          $("#preloader").hide();
        })
      })

    </script>

<div class="modal fade" id="form_modal" role="dialog" aria-labelledby="form_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="modal_text"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="generic_form" name="" >
                    <input type="hidden" name="action">
                    <input type="hidden" name="api">

                  <div class="h-90 ">
                    <div class="form_fields row row-fluid"></div>
                  </div>
                  

                  <div class="row">
                    <div class="col-sm-12 col-md-12 col-sm-12 form_file_list_table">

                    </div>
                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn bg_willcode_red text-white" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn bg_willcode_blue text-white">Confirmar</button>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
  </div>
</body>
</html>
