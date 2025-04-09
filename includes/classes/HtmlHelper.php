<?php

  Class HtmlHelper {

    public static function create_menu(){
      $menu_items = Gui::get_menu();
      if ( !$menu_items )
        return "";

      $html_menu = "";
      foreach ( $menu_items as $data ){
        if ( !empty($data['only_admin']) && !Auth::is_admin() )
          continue;
        
        if ( !empty($data['required_permissions']) ){ // check if user has permission
          //if ( !array_intersect($data['required_permissions'], Auth::get_current_user_permssisions()) && 1 == 3)
          if ( !Auth::has_permission($data['required_permissions'], false) )              
            continue;
        }
        $html_menu .= self::create_menu_item($data);
      }

      return $html_menu;

    }
    
    public static function create_menu_link( $parameters = [] ){
      return "<li><a href=\"{$parameters['link']}\"><i class=\"{$parameters['icon']} menu-icon\"></i>{$parameters['title']}</a></li>";
    }

    public static function create_menu_item($parameters = []){

      if ( !empty($parameters['only_admin']) && !Auth::is_admin() )
        return "";

      $subitems = "";
      if ( isset($parameters['subitems']) ){
        foreach ( $parameters['subitems'] as $key => $data ){

          if ( !empty($data['only_admin']) && !Auth::is_admin() )
            continue;

          if ( !empty($data['required_permissions']) && !Auth::is_admin() ){ // check if user has permission
            //if ( !array_intersect($data['required_permissions'], Auth::get_current_user_permssisions()) && 1 == 3)
            if ( !Auth::has_permission($data['required_permissions'], false) )
              continue;
          }
          $subitems .= self::create_menu_link($data);
        }

        return "
        <li class=\"mega-menu mega-menu-sm\">
          <a class=\"has-arrow\" href=\"javascript:void()\" aria-expanded=\"false\">
          <i class=\"{$parameters['icon']} menu-icon\"></i><span class=\"nav-text\">{$parameters['title']}</span>
          </a>
          <ul aria-expanded=\"false\">
            {$subitems}
          </ul>
        </li>
        ";

      }else {
        return self::create_menu_link($parameters);
      }
            
    }

    public static function get_view_path($parameters = [] ){
      if ( !$parameters )
        throw new HtmlException("Invalid parameters");

      if ( !$parameters['object'] )
        throw new HtmlException("Invalid Object");

      if ( !$parameters['view'] )
        throw new HtmlException("Invalid view");

      return VIEWS_DIR . "{$parameters['object']}/{$parameters['view']}." . ( $parameters['extension'] ?? "html");
    }

    public static function load_view($parameters){

      $tpl = new Template(self::get_view_path(["object" => "core", "view" => "base"]));
      
      try {
        $tpl->addFile("_page_content", self::get_view_path(["object" => $parameters['object'], "view" => @$parameters['view']]) );
        
      } catch ( Exception $error ){

      }

      if ( isset($parameters['extra_files']) ){        
        foreach ( $parameters['extra_files'] as $key => $file ){
          $tpl->exists(($file['var_name'] ?? $file['object']));
          $tpl->addFile(($file['var_name'] ?? $file['object']), self::get_view_path(["object" => $file['object'], "view" => $file['view']]) ) ;
        }        
        
      }

      /*
      $main_logo = Parameter::get("main_logo");
      $small_logo = Parameter::get("small_logo");
      */

      $main_logo = "<img src='" . Parameter::get("main_logo_path") . "' " . Parameter::get("main_logo_img_attr") . " >";
      $small_logo = "<img src='" . Parameter::get("small_logo_path") . "' " . Parameter::get("small_logo_img_attr") . " >";
      if ( !$main_logo ){
        $main_logo = "<img src=\"/assets/img/logo_branco.png\" alt=\"\" style=\"margin-left: 20%; margin-top: -14%; margin-right: 50%;\">";
      }
      
      if ( !$small_logo ){
        $small_logo = "<img src=\"/theme/images/logo-compact.png\" alt=\"\">";
      }

      if ( $parameters['vars'] ){     
        $parameters['vars']['_current_user'] = ( $parameters['_current_user'] ?? @Auth::get_auth_info()['user_name']);
        $parameters['vars']['_current_user_id'] = ( $parameters['_current_user_id'] ?? @Auth::get_auth_info()['user_id']);
        $parameters['vars']['_current_user_profile_picture'] = ( $parameters['_current_user_profile_picture'] ?? @Auth::get_auth_info()['user_profile_picture']);
        if ( empty($parameters['vars']['_current_user_profile_picture']) ){
          $parameters['vars']['_current_user_profile_picture'] = "/assets/img/default_user.png";
        } 
        $parameters['vars']['_main_logo'] = $main_logo;
        $parameters['vars']['_small_logo'] = $small_logo;
        foreach ( $parameters['vars'] as $key => $value ){          
          if ( $tpl->exists($key) )
            $tpl->$key = $value;

        }

      }

      $tpl->_page_menu = self::create_menu();
      $tpl->show();

    }

    public static function get_logo($type = "main"){

      try {
        $main_logo = Parameter::get("main_logo");
        $small_logo = Parameter::get("small_logo");

      }catch ( Exception $error ){
        return  "<img src=\"#\" alt=\"Logo não encontrado\" >";
      }

      if ( !$main_logo ){
        $main_logo = "<img src=\"/assets/img/logo_branco.png\" alt=\"\" style=\"margin-left: 20%; margin-top: -14%; margin-right: 50%;\">";
      }
      
      if ( !$small_logo ){
        $small_logo = "<img src=\"/theme/images/logo-compact.png\" alt=\"\">";
      }

      switch ( $type ){
        case "main":
          return $main_logo;

        case "small":
          return $small_logo;
      }

      return "";
    }

    public static function load_custom_view($parameters, $template_parameters = []){

      if ( empty($parameters['object']) || empty($parameters['view']) || empty($parameters['extension']) )
        return "";

      $path = HtmlHelper::get_view_path($parameters);
      if ( file_exists($path) ){
        if ( $parameters['extension'] == "php" ){
          ob_start();
          require_once $path;
          $html = ob_get_contents();
          ob_end_clean();
          return $html;

        }

        return file_get_contents($path);
        
      }
    }

    public static function create_alert($parameters = [] ){
      $alert = <<<HTML
        <div class="col-lg-12 col-md-6 col-sm-12">
          <div class="alert {$parameters['classes']}" role="alert">
            <h4 class="alert-heading">{$parameters['title']}</h4>
            <p>
              {$parameters['text']}<br>
            </p>
            <hr>
          </div>
        </div>
      HTML;

      return $alert;
    }

    public static function load_page($template_parameters = [], $return_string = false ){

      $path = BASE_DIR . "/includes/html/views/core/page.php";

      if ( $return_string ){
        ob_start();
        require_once $path;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;

      }

      include_once($path);
    }

  }