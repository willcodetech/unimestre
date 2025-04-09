<?php

  class TranslationHelper {

    protected static $language; 
    protected static $texts = [];
    protected static $files_path = BASE_DIR . "/includes/locales/";

    // This function will be called to get the texts
    public static function get_all_texts() {
      // Set the language if it's not already set
      if (!self::$language) 
        self::$language = Parameter::get("default_language");
      
      // Load the texts if they are not already loaded
      if (empty(self::$texts))
        self::$texts = self::load_file();

      return self::$texts;
    }

    // This function loads the texts from the file
    protected static function load_file() {
      $file_path = self::$files_path . self::$language . ".json";
      if (file_exists($file_path))
        return json_decode(file_get_contents($file_path), true);

      throw new Exception("Language file not found: {$file_path}");
    }

    public static function show_all() {
      Helper::debug_data(self::get_all_texts());
    }

    public static function get_text($parameters = []) {

      $replace_values = [];
      $text_code = "";
      if ( is_array($parameters) ){

        if (empty($parameters))
          return "Invalid parameters, can't find text";

        if (!isset($parameters['code']) || empty($parameters['code']))
          return "Text code not provided";

        $text_code = $parameters['code'];
        $replace_values = (isset($parameters['replace_values']) && !empty($parameters['replace_values']) ? $parameters['replace_values'] : [] ) ;
      }else {
        $text_code = $parameters;
        
      }

      // Get all texts
      $texts = self::get_all_texts();

      // Get the specific text by code
      $text_content = isset($texts[$text_code]) ? $texts[$text_code] : null;

      if (!$text_content)
        return "Text not found! Code: {$text_code}";

      // Replace values if needed
      if ( $replace_values ) 
        return Helper::replace_key_value($text_content, $replace_values);
      
      return Helper::clear_string_placeholders(["string" => $text_content]);
    }
  }
