<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  //error_reporting(0);

  Auth::redirect_if_not_logged();
  Auth::redirect_if_not_allowed(["curriculum_list"]);

  $Curriculum = new Curriculum();
  if ( empty($_REQUEST['id']) )
    header("Location: /curriculum/");

  $filters = [
    "id" => $_REQUEST['id'],
    "limit" => 1,
  ];

  $curriculum = $Curriculum->list_details($filters);
  if ( !$curriculum ){
    $table = HtmlHelper::create_alert([
      "title" => "Currículo não encontrado",
      "classes" => "alert-warning",
      "text" => "Verifique as informações"
    ]);
    header("Location: /curriculum/");
  }
  
  $template_parameters['data']['table'] = $Curriculum->get_detail_html($curriculum[0]);
  $template_parameters['page_subtitle']  = TranslationHelper::get_text("page_subtitle_curriculum_detail");
  $template_parameters['page_title'] = TranslationHelper::get_text("page_title_curriculum_detail");
  //$template_parameters['custom_js'] = ["/assets/js/test.js"];
  //$template_parameters['custom_css'] = ["/assets/css/test.css"];
  $template_parameters['views'] = [
    //["object" => "user", "view" => "profile", "extension" => "html" ],
    //["object" => "user", "view" => "profile_full", "extension" => "php" ],
  ];
  $template_parameters['buttons'] = [];
  
  if ( Auth::get_auth_info()['user_id'] == $curriculum[0]['user_id'] ){ // hide search from normal users
    $template_parameters['buttons'][] = [
      "code" => "search",
      "html" => "
        <button type=\"button\" class=\"btn bg-secondary btn-sm text-dark \" 
          onClick='handle_form(this)'
          data-toggle=\"modal\" 
          data-target=\"#form_modal\" 
          data-toggle_ajax=\"modal\" ,
          data-form=\"curriculum\" 
          data-action=\"edit\" 
          data-id=\"{$curriculum[0]['id']}\"
          data-modal_text=\"" . TranslationHelper::get_text("generic_search") . "\"
          data-api=\"curriculum\" 
          data-api_action=\"get_form\" 
          data-mode=\"edit\"                    
          data-method=\"POST\"                      
          data-hide_form=\"true\"
          data-api_id=\"{$curriculum[0]['id']}\"
          data-api_action_get=\"get_curriculum_info\"
          data-reload=\"true\"
          data-hide_form=\"true\"
          data-confirm=\"required\"
          data-modal_text=\"" . TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$curriculum[0]['id']}" . ( isset($curriculum[0]['user_name']) ? " - {$curriculum[0]['user_name']}" : "" ) ."\"
          data-confirm_parameters='". json_encode(["title" => "Editar o cadastro de {$curriculum[0]['user_name']} ?" , "html" => TranslationHelper::get_text("confirm_edit_text"), "icon" => "question"], true) . "'
        >
          <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> " . TranslationHelper::get_text("generic_edit") . "
        </button>",
      "required_permissions" => ["curriculum_list"],
      "denied_permissions" => [],
    ];
  }

  HtmlHelper::load_page($template_parameters, false);