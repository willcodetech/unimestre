<?php

  Class HelperSelect2 {
      
    public static function list($parameters = []){      
      /* */
      if ( !isset($parameters['s_token']) || $parameters['s_token'] != HELPER_SELECT2_TOKEN )
        return [];
      
      if ( !isset($parameters['data_source_object']) )
        return [];
     

      $Object = new $parameters['data_source_object']();
      $parameters['filters']['limit'] = 500;

      if ( method_exists($Object,'list_details')){
        $list = $Object->list_details($parameters['filters']);

      } else {
        $list = $Object->list($parameters['filters']);

      }
      $return = self::convert_to_select2($list, $parameters['key_value'], $parameters['key_text'], @$parameters['concat']);
      $return['params'] = $parameters['filters'];
      return $return;
    }

    /** 
      convert array to select2 expected format https://select2.org/data-sources/ajax
    **/
    public static function convert_to_select2($data, $key_value, $key_text, $concat = array()){

      $list = ["results" => []];

      $format_as_cpj = ["CNPJ", "CPF", "CNPJ_CPF", "CPF_CNPJ"];
      foreach ( $data as $key => $item ){

        if ( in_array($key_text, $format_as_cpj) ){
          $label = Helper::format("CNPJ", $item[$key_text]);
            
        }else{
          $label = ( isset($item[$key_text]) ? $item[$key_text] : "" );

        }
        
        // checks if an additional parameter was passed to concatenate results and return something readable
        if ( $concat ){

          $label = "";
          foreach ( $concat as $key => $field ){

            if ( isset($item[$field]) ){
              
              if ( in_array($field, $format_as_cpj) ){  
                $label .= Helper::format("CNPJ", $item[$field]);
                  
              }else{
                $label .= $item[$field];

              }
              if ($key !== array_key_last($concat)) { 
                $label .= " - ";

              }

            }
              
          }
        }

        $html = "<div><span class=''> " . $label . "</span></div>";

        if ( isset($item['active']) && !$item['active'] ){
          $html = "<div><span class='willcode_inactive' > " . $label . "</span></div>";

        }                
        
        if ( isset($item['DELETADO']) && $item['DELETADO'] ){
          $html = "<div><span class='willcode_deleted' > " . $label . "</span></div>";

        }
        
        $list['results'][] = [ "id" => $item[$key_value], "text" => $label, "html" => $html ];

      }

      return $list;

    }

  } 