<?php  
  $message = @$_GET['message'];
  
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
    </style>
  </head>
  <body>

    <div class="container" >
      <hr>
      <div class="row">
        <div class="col-12 bg-danger">
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

                    <hr>
                  </div>
                    
                </div>
                <div class="col col-sm ">                    

                  <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error 
                      <?php 
                        echo "
                          {$_SESSION['error']['error_type']} {$_SESSION['error']['error_code']}
                        ";
                        
                      ?>
                    </h4>
                    <p>
                      <?php
                        echo "
                          {$_SESSION['error']['error_message']}
                        ";
                      ?>
                    </p>
                    <hr>
                    <p class="mb-0">
                      <h5>Debug info</h5>
                      <pre>
                        <?php
                          Helper::debug_data($_SESSION['error']['debug']);
                        ?>
                      </pre>
                    </p>
                  </div>

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
    <script src="/assets/js/app.js"></script>

  </body>
</html>