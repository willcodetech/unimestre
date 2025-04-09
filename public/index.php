<?php

  /*
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(1);
  */

  Auth::redirect_if_not_logged();

  if ( !Auth::is_admin() )
    header("Location: /curriculum");

  $custom_button = '';
  
  $template_parameters = [];
  $template_parameters['data']['table'] = "";
  $template_parameters['page_subtitle']  = ""; //TranslationHelper::get_text("page_subtitle_dashboard") ;
  $template_parameters['page_title'] = TranslationHelper::get_text("page_title_dashboard");
  //$template_parameters['custom_js'] = ["/assets/js/rfid.js"];
  $template_parameters['custom_js'] = [
    //"/assets/plugins/apexcharts/apexcharts.min.js",
  ];
  $template_parameters['custom_css'] = [
    //"/assets/plugins/apexcharts/apexcharts.css",
    //"/assets/css/test.css"
  ];
  $template_parameters['views'] = [
    //["object" => "user", "view" => "profile", "extension" => "html" ],
    //["object" => "process", "view" => "dashboard_charts", "extension" => "php" ],
  ];
  HtmlHelper::load_page($template_parameters, false);