<?php

  //ini_set('display_errors', 1);
  //ini_set('display_startup_errors', 1);
  //error_reporting(0);

  Auth::redirect_if_not_logged();
  Auth::redirect_if_not_allowed(["permission_group_list"]);

  $filters = $_REQUEST;
  $filters["limit"] = ( $_REQUEST['limit'] ??  10000 );
  
  $template_parameters['page_subtitle']  = TranslationHelper::get_text("page_subtitle_my_profile");
  $template_parameters['page_title'] = TranslationHelper::get_text("page_title_my_profile");
  //$template_parameters['custom_js'] = ["/assets/js/test.js"];
  //$template_parameters['custom_css'] = ["/assets/css/test.css"];
  $template_parameters['views'] = [
    ["object" => "user", "view" => "profile", "extension" => "php" ],
    //["object" => "user", "view" => "profile_full", "extension" => "php" ],
  ];
  $template_parameters['buttons'] = [];

  HtmlHelper::load_page($template_parameters, false);