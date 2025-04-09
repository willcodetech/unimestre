<?php 

  include_once("scripts_js.php");
  include_once("modal.php");
  $buttons = ( $template_parameters['buttons'] ?? [] );
  $html_buttons = "";
  if ( $buttons ){
    foreach ( $buttons as $key => $data ){
      if ( $data['denied_permissions'] )
        if ( Auth::has_permission($data['denied_permissions']) )
          continue;

      if ( $data['required_permissions'] )
        if ( !Auth::has_permission($data['required_permissions']) )
          continue;

      $html_buttons .= $data['html'];
    }
  }

  $views = "";
  if ( $template_parameters['views'] ){
    foreach ( $template_parameters['views'] as $key => $view ){
      $views .= HtmlHelper::load_custom_view($view, $template_parameters);

    }
  }
  $_page_config['body'] = "

  <body>
    <!--*******************
      Preloader start
    ********************-->
    <div id=\"preloader\">
      <div class=\"loader\">
        <svg class=\"circular\" viewBox=\"25 25 50 50\">
          <circle class=\"path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"3\" stroke-miterlimit=\"10\" />
        </svg>
      </div>
    </div>
    <!--*******************
      Preloader end
    ********************-->
    <!--**********************************
      Main wrapper start
    ***********************************-->
    <div id=\"main-wrapper\">
      <!--**********************************
        Nav header start
      ***********************************-->
      <div class=\"nav-header\">
        <div class=\"brand-logo\">
          <a href=\"/index.php\">
            <b class=\"logo-abbr\">
              <img src='" . Parameter::get("small_logo_path") . "' " . Parameter::get("small_logo_img_attr") . " >
            </b>
          <span class=\"logo-compact\"><img src=\"/theme/images/logo-compact.png\" alt=\"\"></span>
          <span class=\"brand-title\">
            <img src='" . Parameter::get("main_logo_path") . "' " . Parameter::get("main_logo_img_attr") . " >
          </span>
          </a>
        </div>
      </div>
      <!--**********************************
        Nav header end
        ***********************************-->
      <!--**********************************
        Header start
        ***********************************-->
      <div class=\"header bg_willcode_blacks\">
        <div class=\"header-content clearfix\">
          <div class=\"nav-control\">
            <div class=\"hamburger\">
              <span class=\"toggle-icon\"><i class=\"icon-menu\"></i></span>
            </div>
          </div>
          <div class=\"header-left\">
            <div class=\"input-group icons\">
            
            </div>
          </div>

          <div class=\"header-right\">
            <ul class=\"clearfix\">
              
              <li class=\"icons dropdown\">
                <div class=\"user-img c-pointer position-relative\"   data-toggle=\"dropdown\">
                  <img src=\"" . ( Auth::get_auth_info()['user_profile_picture'] ?? "/assets/img/default_user.png" ) . "\" height=\"40\" width=\"40\" alt=\"\" loading='lazy'>
                </div>
                <div class=\"drop-down dropdown-profile   dropdown-menu\">
                  <div class=\"dropdown-content-body\">
                    <ul>                   
                      <li>
                        <span>" . @Auth::get_auth_info()['user_name'] . "<hr></span>
                      </li>
                      <li>
                        <a href=\"/my_profile/\"><i class=\"icon-user\"></i> <span>" . TranslationHelper::get_text("my_profile") . "</span></a>
                      </li>
                      <li>
                        <a href=\"/login/\"><i class=\"icon-logout\"></i> <span>" . TranslationHelper::get_text("generic_exit") . "</span></a>
                      </li>                    
                    </ul>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--**********************************
        Header end ti-comment-alt
        ***********************************-->
      <!--**********************************
        Sidebar start
        ***********************************-->
      <div class=\"nk-sidebar\">
        <div class=\"nk-nav-scroll\">
          <ul class=\"metismenu\" id=\"menu\">
            <li>
              <a class=\"has-arrow\" href=\"/index.php\" >
                <i class=\"icon-speedometer menu-icon\"></i><span class=\"nav-text\">" . TranslationHelper::get_text("menu_dashboard") . "</span>
              </a>
            </li>
            " . HtmlHelper::create_menu() . "
          </ul>
        </div>
      </div>
      <!--**********************************
        Sidebar end
        ***********************************-->
      <!--**********************************
        Content body start
        ***********************************-->
      <div class=\"content-body\">
        <!--
        <div class=\"row page-titles mx-0\">
          <div class=\"col p-md-0\">
            <ol class=\"breadcrumb\">
              <li class=\"breadcrumb-item\"><a href=\"javascript:void(0)\">Teste</a></li>
              <li class=\"breadcrumb-item active\"><a href=\"javascript:void(0)\"></a></li>
            </ol>
          </div>
        </div>
        -->
        <!-- row -->
        <div class=\"container-fluid\">
          <div class=\"row\">
            <div class=\"col\">
              <div class=\"card\">
                <div class=\"card-body\">
                  
                    <p><h6><span class=\"page_title\">" . $template_parameters['page_subtitle'] . "</span></h6>
                      
                    {$html_buttons}
                    <!--
                      <button type=\"button\" class=\"btn bg-primary btn-sm text-white {_btn_create_custom_class}\" 
                        onClick='handle_form(this)'
                        data-toggle=\"modal\" 
                        data-target=\"#form_modal\" 
                        data-form=\"{_form_name}\" 
                        data-action=\"create\" 
                        data-modal_text=\"{_create_modal_text}\"
                        data-api=\"{_api}\" 
                        data-api_action=\"get_form\" 
                        data-mode=\"create\"
                        data-confirm=\"required\"
                        data-confirm_parameters='{\"title\": \"Incluir?\", \"html\": \"Será criado um novo registro\", \"icon\": \"question\"}'  
                        data-method=\"POST\"
                        data-reload=\"true\"
                        data-hide_form=\"true\"
                        {_btn_create_custom_attributes}
                      >
                        <i class=\"icon-plus menu-icon\"></i> Incluir
                      </button>

                      <button type=\"button\" class=\"btn bg-secondary btn-sm text-dark {_btn_custom_class}\" 
                        onClick='handle_form(this)'
                        data-toggle=\"modal\" 
                        data-target=\"#form_modal\" 
                        data-form=\"search\" 
                        data-action=\"html_table\" 
                        data-modal_text=\"{_search_modal_text}\"
                        data-api=\"{_api}\" 
                        data-api_action=\"get_form\" 
                        data-mode=\"search\"                    
                        data-method=\"GET\"                      
                        data-hide_form=\"true\",
                        data-confirm_parameters=\"\"
                        data-confirm=\"false\"
                        data-return_element=\"#dynamic_content\"
                        
                      >
                        <i class=\"fa fa-search\" aria-hidden=\"true\"></i> Pesquisar
                      </button>
                      -->
                      
                    </p>
                  <div class=\"dynamic_content\" id=\"dynamic_content\">
                    {$template_parameters['data']['table']}  
                  </div>
                  
                </div>
              </div>
              
            </div>
          </div>

          <div class='row'>
            <div class='col-12'>
              {$views}
            </div>
          </div>
        </div>
        <!-- #/ container -->
      </div>
      <!--**********************************
        Content body end
        ***********************************-->
      <!--**********************************
        Footer start
        ***********************************-->
      <div class=\"footer\">
        <div class=\"copyright\">
          <p>" . TranslationHelper::get_text("developed_by") . " <a href=\"https://willcode.tech/s/\" target=\"_blank\">WillCode Sistemas</a></p>
        </div>
      </div>
      <!--**********************************
        Footer end
        ***********************************-->
    </div>
    <!--**********************************
      Main wrapper end
    ***********************************-->
    {$_page_config['scripts_js']}
    {$_page_config['modal']}
    </div>
  </body>
  
  ";