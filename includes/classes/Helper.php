<?php

  Class Helper {

    public static function debug_data($data = "", $parameters = []){
      $parameters['class'] = ( $parameters['class'] ?? "" );
      $text = "<div class=\"{$parameters['class']}\"><pre>" . print_r($data, true) . "</pre></div>";
      if ( isset($parameters['return']) )
        return $text;

      echo $text;
    }
    
    public static function is_mobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
    
    public static function create_input($parameters){
      $attr_list = ( isset($parameters['attributes']) ? self::build_custom_attr($parameters['attributes']) : "" );
      $class_list  = ( isset($parameters['classes']) ? self::build_custom_class($parameters['classes']) : "" );
      
      $input_index = "";
      if ( isset($parameters['prefix']) ) { 
        $index = ( isset($parameters['prefix']) ? "[{$parameters['prefix']}]" : "" );
        $input_index = ( isset($parameters['prefix']) ? " data-input_index=\"{$parameters['prefix']}\" " : "" ); 
        $new_name = "{$parameters['prefix']}{$index}[{$parameters['name']}]";
        $new_id = "{$parameters['prefix']}{$index}[{$parameters['id']}]";
        
        $parameters['name'] = $new_name;
        $parameters['id'] = $new_id;
      }
      
      switch ( $parameters['type'] ){
        case "select":
          $options_list = self::build_select_options($parameters['options']);
          $input = "<select id=\"{$parameters['id']}\" name=\"{$parameters['name']}\" class=\"{$class_list} selectpicker\" {$attr_list} {$input_index} >
              {$options_list}
          </select>";
          $parameters["input"] = $input;
          return self::build_form_group_row($parameters);
          break;
        
        case "textarea";
          $input = "<textarea id=\"{$parameters['id']}\" name=\"{$parameters['name']}\" class=\"{$class_list}\" {$attr_list} {$input_index} >{$parameters['VALUE']}</textarea>";
          $parameters["input"] = $input;
          return self::build_form_group_row($parameters);
          break;

        case "checkbox":
          $input = "  <div class=\"form-check form-check-inline\">
                          <input class=\"form-check-input {$class_list}\" id=\"{$parameters['id']}\" name=\"{$parameters['name']}\" value=\"{$parameters['VALUE']}\" data-cbx-id=\"{$parameters['VALUE']}\"  {$attr_list} {$input_index} >
                          <label class=\"form-check-label\" for=\"{$parameters['name']}\" >{$parameters['label']}</label>';
                      </div>";
          break;

        default:
          $input = "<input type=\"{$parameters['type']}\" id=\"{$parameters['id']}\" name=\"{$parameters['name']}\" class=\"{$class_list}\" {$attr_list} {$input_index} value=\"{$parameters['VALUE']}\" >";
          $parameters["input"] = $input;
          return self::build_form_group_row($parameters);
          break;
      }
    }

    public static function build_form_group_row($parameters){
      $label = ( isset($parameters['no_label']) ? "" : "<label for=\"{$parameters['id']}\" class=\"col-sm col-form-label\">{$parameters['label']}</label>" );
      $row_classes = ( isset($parameters['row_classes']) ? self::build_custom_class($parameters['row_classes']) : "" );
    
      return "<div class=\"form-group form-group-sm form-row {$row_classes} \">
                  {$label}
                  <div class=\"col-sm col-sm-9\">
                    {$parameters['input']}
                  </div>
              </div>";
    }

    public static function build_custom_attr($array = []){
      $attr_list = "";
      foreach ( $array as $key => $dados ){
        if ( $key == "data-select2-parametros" || $key == "data-select2_parametros" || $key == "select2_parameters"){
          $attr_list .= " data-select2_parametros='" . json_encode($dados, true). "' ";
        }else {
          $attr_list .= " {$key}=\"{$dados}\"";    
        }
          
      }

      return $attr_list;            
    }

    public static function build_custom_class($data = ""){
      $class_list = $data;
      if ( is_array($data) ){
        $class_list = implode(" ", $data);    
        //$class_list .= "form-control form-control-sm";            
      }
      return $class_list;
    }

    public static function build_select_options($data = [], $selected = null ){ 
      $options_list = "";
      
      foreach ( $data['values'] as $key => $item ){
        $description = $item[$data['description']];
        if ( isset($data['concat_description']) && is_array($data['concat_description']) ){
          $description = "";
          $i = count($data['concat_description']);                
          foreach ( $data['concat_description'] as $temp ){
            $description .= $item[$temp];
            $last_iteration = !(--$i); //boolean true/false
            if ( !$last_iteration ){
              $description .= " - ";
            }
          }
        }
        $selected_option = ( $selected == $item[$data['key']] ? "selected" : "" );
        $options_list .= "<option value=\"{$item[$data['key']]}\" {$selected_option} >{$description}</option>";
      }
      return $options_list;
    }

    public static function validate_form($form, $form_data, $by_pass_required = []){

      $ret_array = [];
      foreach ( $form['fields'] as $field ){
        $fieldDescription = "Campo  ". ( isset($field['label']) ? "<span class=\"text-danger\">" . $field['label'] . "</span>" : "" ) . ( isset($field['attributes']['sufix']) ? " <small >" . $field['attributes']['suffix'] . "</small>" : "") ;

        if ( @$field['required'] && !in_array($field['id'], $by_pass_required)){ 
          if ( !isset($form_data[$field['id']]) || empty($form_data[$field['id']]) && !strlen($form_data[$field['id']]) ) throw new FormException($fieldDescription . " é obrigatório", $field['id']); // check with strlen to allow 0 as value
        }

        if ( @!$field['required'] && empty($form_data[$field['id']]) && !strlen($form_data[$field['id']]) ){
          unset($form_data[$field['id']]);
        }

        if ( isset($form_data[$field['id']]) ){ // validate field

          $data = trim($form_data[$field['id']]); // remove whitespaces 
          
          switch ( $field['type'] ){ 
            case "number":
              if ( !is_numeric($data) ) throw new FormException($fieldDescription . "\r\n Valor: '" . $data . "' não numérico", $field['id'] );    
              break;

            case "radio":
            case "select": 
              if ( !isset($field['options']) )
                break;

              $allowedOptions = array_keys($field['options']);
              if ( @!$field['required'] && ( empty($data) && !strlen($data) ) ) break; //allow empty value
              if ( !isset($field['options'][$data]) ) throw new FormException($fieldDescription . "\r\n Valor: '" . $data . "' Inválido. Apenas os valores " . json_encode($allowedOptions, true) . " são permitidos", $field['id'] );
              break;
            
            case "email":
              if ( @!$field['required'] && ( empty($data) && !strlen($data) ) ) break; //allow empty value
              if ( !self::validate("email", $data) ) throw new FormException($fieldDescription . "\r\n Valor: '" . $data . "' Informe um endereço de e-mail válido", $field['id']);
              break;

            default:
              if ( @!$field['required'] && ( empty($data) && !strlen($data) ) ) break; //allow empty value

          }

          // custom attributes validation
          if ( isset($field['attributes']) ) {

            if ( isset($field['attributes']['minlength']) && ( strlen($data) < $field['attributes']['minlength'] )  ) 
              throw new FormException($fieldDescription . "\r\n Deve conter no mínimo " . $field['attributes']['minlength'] . " caracteres", $field['id']);  

            if ( isset($field['attributes']['maxlength']) && ( strlen($data) > $field['attributes']['maxlength'] )  ) 
              throw new FormException($fieldDescription . "\r\n Deve conter no máximo " . $field['attributes']['maxlength'] . " caracteres", $field['id']);  

            if ( isset($field['attributes']['min']) && ( $data < $field['attributes']['min'] )  ) 
              throw new FormException($fieldDescription . "\r\n Valor deve ser maior ou igual a: " . $field['attributes']['min'], $field['id']);  

            if ( isset($field['attributes']['max']) && ( $data > $field['attributes']['max'] )  ) 
              throw new FormException($fieldDescription . "\r\n Valor deve ser menor ou igual a: " . $field['attributes']['max'], $field['id']);

            if ( isset($field['attributes']['data-type']) && !empty($data) ){

              switch ($field['attributes']['data-type']){
                case "cnpj":
                  if ( !self::validate("cnpj", $data) ) throw new FormException($fieldDescription . "\r\n O CNPJ informado: " . $data  . " é inválido", $field['id']);
                  break;

                case "cpf":
                  if ( !self::validate("cpf", $data) ) throw new FormException($fieldDescription . "\r\n O CPF informado: " . $data  . " é inválido", $field['id']);
                  break;
              }

            }

          }
        }

        $ret_array[$field['id']] = @$form_data[$field['id']];
      }

      return $ret_array;
    }

    public static function validate($type, $value){
      switch ( $type ){
        case "cnpj":
          return self::validateCnpj($value);
          break;
        case "cpf":
          return self::validateCpf($value);
          break;
        case "email":
          return self::validate_email($value);
          break;
      }
    }

    public static function validateCpf($cpf) {

      if (empty($cpf)) throw new Exception("Value not stated. Unable to perform validation");
  
      $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
  
      // validate length
      if (strlen($cpf) != 11)
          return false;
  
      // Checks if all digits are the same
      if (preg_match('/(\d)\1{10}/', $cpf))
          return false;
  
      // Validates first check digit
      for ($i = 0, $soma = 0; $i < 9; $i++) {
          $soma += $cpf[$i] * (10 - $i);
      }
  
      $resto = $soma % 11;
      $digito1 = ($resto < 2) ? 0 : 11 - $resto;
      if ($cpf[9] != $digito1)
          return false;
  
      // Validates second check digit
      for ($i = 0, $soma = 0; $i < 10; $i++) {
          $soma += $cpf[$i] * (11 - $i);
      }
  
      $resto = $soma % 11;
      $digito2 = ($resto < 2) ? 0 : 11 - $resto;
      return $cpf[10] == $digito2;
    }    
    
    public static function validateCnpj($cnpj){

      if ( empty($cnpj) ) throw new Exception("Value not stated. Unable to perform validation");
      $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
              
      // validate length
      if (strlen($cnpj) != 14)
        return false;

      // Checks if all digits are the same
      if (preg_match('/(\d)\1{13}/', $cnpj))
        return false;	

      // Validates first check digit
      for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
      }

      $resto = $soma % 11;
      if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
        return false;

      // Validates second check digit
      for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
      }

      $resto = $soma % 11;
      return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public static function validate_email($email){
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      return ( filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false );
    }

    public static function getFormFieldNames($form) {
      $list = array();
      foreach($form AS $form_element) if ($form_element['id'] != 'id') $list[] = $form_element['id'];      
      return $list;
    }  

    public static function format($type, $value, $options = [] ){

      $decimals = ( !isset($options['decimals']) ? 2 : $options['decimals'] );
      if ( $value == "" ){
        return $value;
      }
      $new_value = $value;

      switch ($type){
        case "bytes":
          $unidade = ( isset($options['unit']) ? $options['unit'] : "MB" );
          $new_value = self::convert_bytes($value, $unidade);
          $new_value = self::format("number_br", $new_value);
          break;

        case "float":
          //number_format ( float $number , int $decimals , string $dec_point , string $thousands_sep )
          $new_value = number_format ( $value , $decimals, "." , "" );
          break;

        case "number":
          $new_value = number_format ( $value , $decimals, "." , "," );
          break;

        case "number_br":
          //number_format ( float $number , int $decimals , string $dec_point , string $thousands_sep )
          $new_value = number_format ( $value , $decimals, "," , "." );
          break;

        case "cpf":
        case "cnpj":
          // remover caracters não numericos 
          $cnpj_cpf = preg_replace("/\D/", '', $value);
          
          switch ( strlen($cnpj_cpf) ){
            // cpf
            case "11":
              $new_value = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);                        
              break;
        
            //cnpj
            case "14":
              $new_value = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
          }
          break;

        case "date":
          $dateFormat = ( isset($options['date_format']) ? $options['date_format'] : "Y-m-d" );
          $new_value = date($dateFormat, strtotime($value));
          break;
              
        case "date_time":
          $dateFormat = ( isset($options['date_format']) ? $options['date_format'] : "Y-m-d" );
          $timeFormat = ( isset($options['time_format']) ? $options['time_format'] : "H:i:s" );
          $new_value = date($dateFormat . " " . $timeFormat, strtotime($value));
          break;

        case "phone":            
          switch ( strlen($value) ){
            case "10":
              $new_value = '(' . substr($value, 0, 2) . ') ' . substr($value, 2, 4)  . '-' . substr($value, 6);
              break;

            case "11":
              $new_value = '(' . substr($value, 0, 2) . ') ' . substr($value, 2, 5)  . '-' . substr($value, 7);
              break;
                
            default:
              $new_value = $value;
              break;
          }
          break;

        case "cep":
        case "zip_code":
          $new_value = substr($value, 0, 5) . '-' . substr($value, 5, 3);
          break;

      }

      return $new_value;
    }
    
    public static function convert_bytes($size,$unit = "MB")  {
      if($unit == "KB") {
        return $fileSize = round($size / 1024,4) ;
      }
      if($unit == "MB") {
        return $fileSize = round($size / 1024 / 1024,4) ;	
      }
      if($unit == "GB") {
        return $fileSize = round($size / 1024 / 1024 / 1024,4) ;
      }
    }

    // search array for specific key = value
    public static function search_sub_array(Array $array, $key, $value) {   
      foreach ($array as $subarray){  
        if (isset($subarray[$key]) && $subarray[$key] == $value)
        return $subarray;       
      } 
    }

    public static function array_keys_exists(array $keys, array $arr) {
      return !array_diff_key(array_flip($keys), $arr);
    }

    // *    $arr - associative multi keys data array
    // *    $group_by_fields - array of fields to group by
    // *    $sum_by_fields - array of fields to calculate sum in group
    public static function array_group_by($arr, $group_by_fields = false, $sum_by_fields = false, $RETORNAR_DIFERENCAS  = false) {

      if ( empty($group_by_fields) ) return; // * nothing to group

      //$fld_count = 'grp:count'; // * field for count of grouped records in each record group
      $fld_count = 'group_count'; // * field for count of grouped records in each record group

      // * format sum by
      if (!empty($sum_by_fields) && !is_array($sum_by_fields)) {
        $sum_by_fields = array($sum_by_fields);
      }

      // * protected  from collecting
      $fields_collected = array();

      // * do
      $out = array();
      foreach($arr as $value) {
        $newval = array();
        $key = '';
        foreach ($group_by_fields as $field) {
          $key .= $value[$field].'_';
          $newval[$field] = $value[$field];
          unset($value[$field]);
        }
        // * format key
        $key = substr($key,0,-1);

        // * count
        if (isset($out[$key])) { // * record already exists
          $out[$key][$fld_count]++;
        } else {
          $out[$key] = $newval;
          $out[$key][$fld_count]=1;
        }
        $newval = $out[$key];

        // * sum by
        if (!empty($sum_by_fields)) {
          foreach ($sum_by_fields as $sum_field) {
            if (!isset($newval[$sum_field])) $newval[$sum_field] = 0;
            $newval[$sum_field] += $value[$sum_field];
            unset($value[$sum_field]);
          }
        }

        // * collect differencies
        if (!empty($value) && $RETORNAR_DIFERENCAS == true ) {
          foreach ($value as $field=>$v) if (!is_null($v)) {
            if (!is_array($v)) {
              $newval[$field][$v] = $v;
            } else $newval[$field][join('_', $v)] = $v; // * array values 
          }
        }
        $out[$key] = $newval;
      }
      return array_values($out);
    }

    public static function get_js_triggers(){
      return  [ "onClick", "onChange", "onBlur", "onFocus", "data-select2-parametros", "data-select2-campo-pesquisa", "data-object_info", "data-confirm_parameters","data-form_hide_fields", "data-form_values" ];
    }

    public static function create_html_custom_attributes($attributes = []){ 
      $custom_attributes = "";
      if ( !$attributes )
        return $custom_attributes;

      foreach ( $attributes as $key => $value ){ // js triggers attributes must be in single quotes
        $custom_attributes .= (  in_array($key, self::get_js_triggers()) ? $custom_attributes .= " {$key}='{$value}'" : " {$key}=\"{$value}\" " );
      }

      return $custom_attributes;

    }

    public static function create_html_custom_classes($class = null){
      if ( !$class )
        return "";

      return ( is_array($class) ? implode(" ", $class) : (!empty($class) ? $class : "" ) );
    }

    public static function create_html_button($parameters){
      /*
      */

      if ( isset($parameters['denied_permission']) && !empty($parameters['denied_permission']) ){
        if ( Auth::has_permission($parameters['denied_permission'], $throw_exception = false ) )
          return;

      }
      
      if ( isset($parameters['required_permission']) && !empty($parameters['required_permission']) ){
        if ( !Auth::has_permission($permission_code = $parameters['required_permission'], $throw_exception = false ) )
          return;

      }

      $custom_attributes = ( isset($parameters['attributes']) ? self::create_html_custom_attributes($parameters['attributes']) : "" );
      $classes = ( isset($parameters['class']) ? self::create_html_custom_classes($parameters['class']) : "" );

      if ( isset($parameters['dropdown']) )
        return self::create_html_button_dropdown($parameters);
        
      switch ( $parameters['type'] ){
        case "link":
          return "<a href=\"{$parameters['href']}\" class=\"{$classes} \" {$custom_attributes} >{$parameters['description']}</a>\r\n";
          break;

        default:
          return "<button type=\"{$parameters['type']}\" class=\"{$classes}\" {$custom_attributes} >{$parameters['description']}</button>\r\n";
          break;
      }
    }

    public static function create_html_button_dropdown($parameters){
      $custom_attributes = ( isset($parameters['attributes']) ? self::create_html_custom_attributes($parameters['attributes']) : "" );
      $classes = ( isset($parameters['class']) ? self::create_html_custom_classes($parameters['class']) : "" );

      $temp_rand = "btn_" . rand();
      $dropdown = "<div class=\"dropdown\">
                        <button class=\"btn btn-sm btn-xs btn-xsm dropdown-toggle {$classes} \" {$custom_attributes} id=\"{$temp_rand}\" type=\"button\" data-bs-toggle=\"dropdown\"  data-toggle=\"dropdown\" aria-expanded=\"false\">...</button>
                        <ul class=\"dropdown-menu w-100_\" aria-labelledby=\"{$temp_rand}\" >";
                          foreach ( $parameters as $key => $data ){
                            if ( isset($data['denied_permission']) && !empty($data['denied_permission']) ){
                              if ( Auth::has_permission($data['denied_permission'], $throw_exception = false ) )
                                continue;

                            }
                            
                            if ( isset($data['required_permission']) && !empty($data['required_permission']) ){
                              if ( !Auth::has_permission($data['required_permission'], $throw_exception = false ) )
                                continue;
                            }
                            $dropdown .= "<li>" . self::create_html_button($data) . "</li>";

                          }
        $dropdown .= "</ul>
                    </div>";

        return $dropdown;
    }

    public static function translate($string) {
      $list = [
        "name" => "nome",
        "ashes" => "cinzas",
        "yes" => "sim",
        "no" => "não",
        "weight" => "peso",
        "buttons" => "Ações/Botões",
        "tracking" => "rastreamento",
        "code" => "código",
        "tracking_code_id" => "Rastreabilidade"
      ];

      return ( isset($list[$string]) ? $list[$string] : $string ); 
    }

    public static function get_icon($parameters){
      $class = "";
      switch ( $parameters['icon'] ){
        case "alert":
          $icon = "alert-triangle";
          $class = "danger ";
          break;

        case "ok":
        case "yes":
        case "check":
        case "true":
        case "1":
          $icon = "check-circle";
          $class = "success";
          break;
        
        case "x":
        case "no";
        case "false":
        case "0":
          $icon = "x-circle";
          $class = "danger";
          break;

        case "print":
          $icon = "printer";
          break;

        default:
          $icon = $parameters['icon'];
          break;
      }

      return "<span class=\"text-{$class}\" data-feather=\"{$icon}\"></span>";
    }

    public static function replace_key_value($string, $data, $start_delimiter = "{{", $end_delimiter = "}}"){
			if ( !$string )
        return "";
        //throw new Exception("String base para substitução de valores não informada");

			if ( !$data || !is_array($data) )
        return $string;
        //throw new Exception("Array com variáveis para sustituição não informado ou inválido");      

			foreach ( $data as $key => $value ){

				$find = $start_delimiter . $key . $end_delimiter;
				
				if ( is_array($value) )
          $string = Helper::replace_key_value($string, $value, $start_delimiter, $end_delimiter);
          
          if ( $value == null)
            $value = "";
					
          $string = str_replace($find, $value, $string);
			}

			return $string;
		}

    public static function clear_string_placeholders($parameters = []){
      $regex = "/{{(.*?)}}/"; // content between {{}}
      $parameters['regex'] = ( isset($parameters['regex']) && !empty($parameters['regex']) ? $parameters['regex'] : $regex );
      $parameters['replace'] = ( isset($parameters['regex']) && !empty($parameters['replace']) ? $parameters['replace'] : '' );
      $parameters['string'] = ( isset($parameters['string']) && !empty($parameters['string']) ? $parameters['string'] : '' );
      return preg_replace($parameters['regex'], $parameters['replace'], $parameters['string']);
    }

    public static function array_to_select_options($array = [], $parameters = []){      
      if ( !$array || !$parameters )
        return [];
     
      if ( !isset($parameters['value']) || !isset($parameters['label']) )
        throw new Exception("Invalid parameters, failed array to selection options conversion");

      $options = [];
      foreach ( $array as $key => $data ){
        //$options[] = [ $data[$parameters['value']] => $data[$parameters['label']] ];
        $options[$data[$parameters['value']]] = $data[$parameters['label']];
      }
      return $options;
    }

    public static function get_month_name($month_id){
      switch ($month_id){
        case "1":
          $name = "Janeiro";
          break;
          
        case "2":
          $name = "Fevereiro";
          break;

        case "3":
          $name = "Março";
          break;
          
        case "4":
          $name = "Abril";
          break;

        case "5":
          $name = "Maio";
          break;
          
        case "6":
          $name = "Junho";
          break;

        case "7":
          $name = "Julho";
          break;
          
        case "8":
          $name = "Agosto";
          break;

        case "9":
          $name = "Setembro";
          break;
          
        case "10":
          $name = "Outubro";
          break;

        case "11":
          $name = "Novembro";
          break;
          
        case "12":
          $name = "Dezembro";
          break;
          
        default:
          $name = "";
          break;
      }

      return $name;
    }
    public static function get_month_name_es($month_id){
      switch ($month_id){
        case "1":
          $name = "Enero";
          break;
          
        case "2":
          $name = "Febrero";
          break;

        case "3":
          $name = "Marzo";
          break;
          
        case "4":
          $name = "Abril";
          break;

        case "5":
          $name = "Mayo";
          break;
          
        case "6":
          $name = "Junio";
          break;

        case "7":
          $name = "Julio";
          break;
          
        case "8":
          $name = "Agosto";
          break;

        case "9":
          $name = "Septiembre";
          break;
          
        case "10":
          $name = "Octubre";
          break;

        case "11":
          $name = "Noviembre";
          break;
          
        case "12":
          $name = "Diciembre";
          break;
          
        default:
          $name = "";
          break;
      }

      return $name;
    }

    public static function get_months($language = "pt-br"){

      switch ( $language ){

        case "es-es":
          return [
            [ "id" => 1, "name" => "Enero" ],
            [ "id" => 2, "name" => "Febrero" ],
            [ "id" => 3, "name" => "Marzo" ],
            [ "id" => 4, "name" => "Abril" ],
            [ "id" => 5, "name" => "Mayo" ],
            [ "id" => 6, "name" => "Junio" ],
            [ "id" => 7, "name" => "Julio" ],
            [ "id" => 8, "name" => "Agosto" ],
            [ "id" => 9, "name" => "Septiembre" ],
            [ "id" => 10, "name" => "Octubre" ],
            [ "id" => 11, "name" => "Noviembre" ],
            [ "id" => 12, "name" => "Diciembre" ],
          ];
        
          break;
        
        case "pt-br":
        default:
          return [
            [ "id" => 1, "name" => "Janeiro" ],
            [ "id" => 2, "name" => "Fevereiro" ],
            [ "id" => 3, "name" => "Março" ],
            [ "id" => 4, "name" => "Abril" ],
            [ "id" => 5, "name" => "Maio" ],
            [ "id" => 6, "name" => "Junho" ],
            [ "id" => 7, "name" => "Julho" ],
            [ "id" => 8, "name" => "Agosto" ],
            [ "id" => 9, "name" => "Setembro" ],
            [ "id" => 10, "name" => "Outubro" ],
            [ "id" => 11, "name" => "Novembro" ],
            [ "id" => 12, "name" => "Dezembro" ],
          ];
      }
    }

    /**
     * Generate a random string, using a cryptographically secure 
     * pseudorandom number generator (random_int)
     *
     * This function uses type hints now (PHP 7+ only), but it was originally
     * written for PHP 5 as well.
     * 
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     * 
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    public static function random_str(
      int $length = 64,
      string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
      if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
      }
      $pieces = [];
      $max = mb_strlen($keyspace, '8bit') - 1;
      for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
      }
      return implode('', $pieces);
    }

    // lz = leading zero
    public static  function lz($num){
      return (strlen($num) < 2) ? "0{$num}" : $num;
    }

    public static function cleanString($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special  chars.
    }
     

    /**
      Convert decimal time to HH:MM
    **/
    public static function decimal_to_time($dec){

      // start by converting to seconds
      $seconds = ($dec * 3600);
      // we're given hours, so let's get those the easy way
      $hours = floor($dec);
      // since we've "calculated" hours, let's remove them from the seconds variable
      $seconds -= $hours * 3600;
      // calculate minutes left
      $minutes = floor($seconds / 60);
      // remove those from seconds as well
      $seconds -= $minutes * 60;
      // return the time formatted HH:MM:SS
      return self::lz($hours).":".self::lz($minutes);
    }

    function format_bytes($bytes, $precision = 2) { 
      $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
  
      $bytes = max($bytes, 0); 
      $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
      $pow = min($pow, count($units) - 1); 
  
      // Uncomment one of the following alternatives
      // $bytes /= pow(1024, $pow);
      // $bytes /= (1 << (10 * $pow)); 
  
      return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 

    public static function create_file_link($file_data){
      if ( !$file_data )
        return "";

      return "<a href='/api/?api=file&action=get&hash={$file_data['hash']} target='_blank' class='file_link' >Abrir</a>";
    }

    public static function to_json($parameters = []){
      return json_encode($parameters, true);
    }

    public static function show_php_errors($show = false){
      ini_set('display_errors', $show);
      ini_set('display_startup_errors', $show);

      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
      

    }

    public static function is_valid_email($email){
      if ( !$email )
        return false;

      return (filter_var($email, FILTER_VALIDATE_EMAIL));
      
    }
    
    public static function only_numbers($string) {
      return preg_replace('/\D/', '', $string);
    }

  }