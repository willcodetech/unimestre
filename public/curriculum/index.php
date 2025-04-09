<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  //error_reporting(0);

  Auth::redirect_if_not_logged();
  Auth::redirect_if_not_allowed(["curriculum_list"]);

  $filters = $_REQUEST;
  $filters["limit"] = ( $_REQUEST['limit'] ??  10000 );
    
  $Curriculum = new Curriculum();
  $list = $Curriculum->list_details($filters);
  $table = DataTable::create($Curriculum->to_datatable($list));
  $template_parameters['data']['table'] = DataTable::build_table($Curriculum->to_datatable($list));


  $has_own_register = $Curriculum->list([
    'user_id' => Auth::get_auth_info()['user_id']
  ]);

  $template_parameters['page_subtitle']  = TranslationHelper::get_text("page_subtitle_curriculum");
  $template_parameters['page_title'] = TranslationHelper::get_text("page_title_curriculum");
  //$template_parameters['custom_js'] = ["/assets/js/test.js"];
  //$template_parameters['custom_css'] = ["/assets/css/test.css"];
  $template_parameters['views'] = [
    //["object" => "user", "view" => "profile", "extension" => "html" ],
    //["object" => "user", "view" => "profile_full", "extension" => "php" ],
  ];
  $template_parameters['buttons'] = [];
   
  /**/
  if ( !$has_own_register ){ // prevent duplicate
    $template_parameters['buttons'][] =  [
      "code" => "create",
      "html" => "
        <button type=\"button\" class=\"btn bg-primary btn-sm text-white \" 
          onClick='handle_form(this)'
          data-toggle=\"modal\" 
          data-target=\"#form_modal\" 
          data-form=\"form_curriculum\" 
          data-action=\"create\" 
          data-modal_text=\"" . TranslationHelper::get_text("generic_create") . "\"
          data-api=\"curriculum\" 
          data-api_action=\"get_form\" 
          data-mode=\"create\"
          data-confirm=\"required\"
          data-confirm_parameters='" . json_encode(["title" => TranslationHelper::get_text("confirm_create_title"), "html" => TranslationHelper::get_text("confirm_create_text"), "icon" => "question"], true) . "'  
          data-method=\"POST\"
          data-reload=\"true\"
          data-hide_form=\"true\"
          
        >
          <i class=\"icon-plus menu-icon\"></i> " . TranslationHelper::get_text("button_create") . "
        </button>",
      "required_permissions" => ['curriculum_create'],
      "denied_permissions" => [],
    ];
  }

  if ( Auth::is_admin() ){ // hide search from normal users
    $template_parameters['buttons'][] = [
      "code" => "search",
      "html" => "
        <button type=\"button\" class=\"btn bg-secondary btn-sm text-dark \" 
          onClick='handle_form(this)'
          data-toggle=\"modal\" 
          data-target=\"#form_modal\" 
          data-form=\"search\" 
          data-action=\"html_table\" 
          data-modal_text=\"" . TranslationHelper::get_text("generic_search") . "\"
          data-api=\"curriculum\" 
          data-api_action=\"get_form\" 
          data-mode=\"search\"                    
          data-method=\"GET\"                      
          data-hide_form=\"true\",
          data-confirm_parameters=\"\"
          data-confirm=\"false\"
          data-return_element=\"#dynamic_content\"
          
        >
          <i class=\"fa fa-search\" aria-hidden=\"true\"></i> " . TranslationHelper::get_text("button_search") . "
        </button>",
      "required_permissions" => ["curriculum_list"],
      "denied_permissions" => [],
    ];
  }
  

  HtmlHelper::load_page($template_parameters, false);