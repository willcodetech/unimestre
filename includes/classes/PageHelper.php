<?php

  Class PageHelper {

    private static $core_html_dir = TEMPLATES_DIR . "core/";

    public static function get_head($parameters = []){
      $html = file_get_contents(self::$core_html_dir . "head.php");
      return Helper::replace_key_value($html, $parameters);
    }

    public static function get_page($parameters = []){
      $html = file_get_contents(self::$core_html_dir . "head.php");
      return Helper::replace_key_value($html, $parameters);
    }

  }