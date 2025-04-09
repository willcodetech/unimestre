<?php

  Class SourceGenerator extends Base {

    protected const TEMPLATE_PATH = "/var/www/html/portal.willcode.tech/portal/includes/templates/";
    protected const CREATED_FILES_DESTINATION = "/var/www/html/portal.willcode.tech/portal/includes/temp/";
    protected const NEW_LINE = "\n";
    protected const IDENT = "    ";
    protected const DEFAULT_BASE_FIELDS = [ "id", "create_date", "update_date" ];

    public function __construct(){
      parent::__construct();
      
    }
    public static function create_field_name($field_name = ""){
      return ucwords(str_replace("_", " ", $field_name));
    }

    public static function create_class_name($table_name = ""){ // convert table_name to TableName 
      return str_replace(" ", "", ucwords(str_replace("_", " ", $table_name)));
    }

    public static function create_datatable_lines($parameters = [] ){
      $ident = str_repeat(self::IDENT, 2) . "  ";
      $new_line  = self::NEW_LINE;
      $datatable_lines = self::NEW_LINE;
      foreach ( $parameters as $key => $data ){
        $datatable_lines .= "{$ident}[{$new_line}{$ident}  \"text\" => \$data['{$data['Field']}'], \"classes\" => [\"text-left\"],{$new_line}{$ident}  \"attributes\" => [ \"order\" => \$data['{$data['Field']}'], \"raw\" => \$data['{$data['Field']}'], ],{$new_line}{$ident}  //\"format\" => \"\",{$new_line}{$ident}],{$new_line}";
      }
      
      return $datatable_lines;
    }

    public static function create_datatable_columns($parameters = [] ){
      //$columns = [];
      $columns = "";
      foreach ( $parameters as $key => $data ){
        //if ( !in_array($data['Field'], $columns) ){
          //$columns[] = self::create_field_name($data['Field']);
          //$column_name = self::create_field_name($data['Field']);
          $column_name = "TranslationHelper::get_text(\"generic_{$data['Field']}\")";
          //$columns .= " \n \t\t\t\t[\"text\" => \"{$column_name}\", \"classes\" => \"all\"], ";
          $columns .= " \n \t\t\t\t[\"text\" => {$column_name}, \"classes\" => \"all\"], ";
          
        //}

      }
      //$columns[] = "Ações";
      $columns .= "\n \t\t\t\t[\"text\" => TranslationHelper::get_text(\"generic_actions\"), \"classes\" => [\"no_export\", \"all\"] ]";
      //return '"' . implode('", "', $columns) . '"';
      return $columns;
    }

    public static function is_default_field($field_name = null ){
      return ( ( in_array($field_name, self::DEFAULT_BASE_FIELDS) ) ? true : false );
    }

    public static function create_class($table_name = null ){
      if ( !$table_name )
        throw new Exception("Tabela não informada, impossível gerar código fonte da classe");

      $Crud = Crud::get_instance();;
      $fields = $Crud->get_columns(["table" => $table_name ]);
      /*
      (
        [Field] => login
        [Type] => varchar(200)
        [Null] => NO
        [Key] => UNI
        [Default] => 
        [Extra] => 
      )
      */
      $ident = self::IDENT;
      $new_line  = self::NEW_LINE;
      $field_list = self::NEW_LINE;
      $getters_setters = self::NEW_LINE;
      $custom_switch_fields = self::NEW_LINE;
      foreach ( $fields as $key => $data ){     
        $field_list .= "{$ident}" . ( self::is_default_field($data['Field']) ? "// " : "" ) . "public \${$data['Field']}; // type: {$data['Type']} null: {$data['Null']} Key: {$data['Key']} default: {$data['Default']} extra: {$data['Extra']}" . ( self::is_default_field($data['Field']) ? " (moved to Base class) " : "" ) . "{$new_line}";
        //$getters_setters .= "{$ident}" . ( self::is_default_field($data['Field']) ? "// " : "" ) . "public function get_{$data['Field']}(){ return \$this->{$data['Field']}; }" . ( self::is_default_field($data['Field']) ? " (moved to Base class) " : "" ) . " {$new_line}";
        //$getters_setters .= "{$ident}" . ( self::is_default_field($data['Field']) ? "// " : "" ) . "public function set_{$data['Field']}(\${$data['Field']}){ \$this->{$data['Field']} = \${$data['Field']}; return \$this; }" . ( self::is_default_field($data['Field']) ? " (moved to Base class) " : "" ) . " {$new_line}";
        $custom_switch_fields .= str_repeat($ident, 2) . "case \"{$data['Field']}\":{$new_line}";

      }

      $form = self::create_inputs($fields, $table_name);
      
      $class_name = self::create_class_name($table_name);
      $template = file_get_contents(self::TEMPLATE_PATH . "class.template");
      $replace = [
        "class_name" => $class_name,
        "table_name" => $table_name,
        "fields" => $field_list,
        "methods" => $getters_setters,
        "datatable_columns" => self::create_datatable_columns($fields),
        "datatable_lines" => self::create_datatable_lines($fields),
        "form" => $form,
        //"get" => $custom_switch_fields,
        //"set" => $custom_switch_fields,
      ];

      foreach ( $replace as $key => $data ){
        $find = "{{" . $key . "}}";
        $template = str_replace($find, $data, $template);
      }

      //$file_name = self::CREATED_FILES_DESTINATION . date("Y-m-d") . "_Teste.php";
      $file_name = "{$class_name}.php";
      file_put_contents($file_name, $template);

      self::create_api(["table_name" => $table_name, "class_name" => $class_name]);
      self::create_page(["table_name" => $table_name, "class_name" => $class_name]);
      Helper::debug_data(self::create_permission_inserts($table_name));
    }

    public static function create_permission_inserts($table_name = "table_name"){
      $class_name = self::create_field_name($table_name);
      $insert = " INSERT INTO permission ( code, description, active )
                  values 
                  ( '{$table_name}_list', 'List {$class_name}', 1 ),
                  ( '{$table_name}_create', 'Create {$class_name}', 1 ),
                  ( '{$table_name}_edit', 'Edit {$class_name}', 1 ),
                  ( '{$table_name}_delete', 'Delete {$class_name}', 1 );
      ";

      return $insert;

    }

    public static function create_api($parameters = null ){
      if ( !$parameters )
        throw new Exception("Parâmetros não informados, impossível gerar código fonte da api");

      $template = file_get_contents(self::TEMPLATE_PATH . "api.template");
      $replace = [
        "class_name" => $parameters['class_name'],
        "table_name" => $parameters['table_name'], 
      ];

      foreach ( $replace as $key => $data ){
        $find = "{{" . $key . "}}";
        $template = str_replace($find, $data, $template);
      }

      //$file_name = self::CREATED_FILES_DESTINATION . date("Y-m-d") . "_Teste.php";
      $file_name = "{$parameters['table_name']}.api.php";
      file_put_contents($file_name, $template);
    }

    public static function create_page($parameters = null ){
      if ( !$parameters )
        throw new Exception("Parâmetros não informados, impossível gerar código fonte da página");

      $template = file_get_contents(self::TEMPLATE_PATH . "page.template");
      $replace = [
        "class_name" => $parameters['class_name'],
        "table_name" => $parameters['table_name'], 
      ];

      foreach ( $replace as $key => $data ){
        $find = "{{" . $key . "}}";
        $template = str_replace($find, $data, $template);
      }

      //$file_name = self::CREATED_FILES_DESTINATION . date("Y-m-d") . "_Teste.php";
      $file_name = "{$parameters['table_name']}.page.php";
      file_put_contents($file_name, $template);
    }

    public static function create_input_field($parameters = [], $table_name = null){
      $input = [];
      $input["attributes"]["maxlength"] = false;
      $input["attributes"]["placeholder"] = "";
      $input["attributes"]["class"] = ["form-control", "input-sm"];
      if ( str_contains($parameters['Type'], "(") ){
        $max_length = explode(')', (explode('(', $parameters['Type'])[1]))[0];
        $input["attributes"]["maxlength"] = $max_length;
      }

      $parameters['is_fk'] = false;
      if ( $table_name ){ // check if is FK
        $fk_filters = [ "column" => $parameters['Field']];
        $fk = self::get_table_relattionship($table_name, $fk_filters);
        Helper::debug_data($fk);

        if ( $fk ){ // get table and field referenced
          if ( !empty($fk[0]['REFERENCED_COLUMN_NAME']) && !empty($fk[0]['REFERENCED_TABLE_NAME']) ){
            $parameters['is_fk'] = true;
            $parameters['referenced_table'] = $fk[0]['REFERENCED_TABLE_NAME'];
            $parameters['referenced_column'] = $fk[0]['REFERENCED_COLUMN_NAME'];
          }
        }

      }
      

      if ( $input["attributes"]["maxlength"] && $input["attributes"]["maxlength"] > 200 ){
        $input["type"] = "textarea";

      }else {
        switch ( $parameters['Type'] ){
          case "json":
            $input["type"] = "textarea";
            break;

          case "int":
          case "float":
            $input["type"] = "number";
            break;

          case "date":
            $input["type"] = "date";
            break;

          case "datetime":
            $input["type"] = "datetime-local";
            break;

          default:
            $input["type"] = "text";
            break;
        }
      }

      if ( $parameters['Null'] == "NO" ) {
        $input["attributes"]["required"] = true;
        $input["attributes"]["minlength"] = 1;
      }
      if ( $parameters['is_fk'] ){ // field must be select with ajax data
        $input["type"] = "select";
        $input["attributes"]["emptyval"] = "Selecione...";
        $input["attributes"]["data-select2_parameters"] = '[
              "data_source_object" => "' . self::create_class_name($parameters['referenced_table']) . '",
              "s_token" => HELPER_SELECT2_TOKEN,
              "key_value" => "id",
              "key_text" => "description",
              "concat" => [ "id", "description"],
              "search_field" => "description_ct",
              "related_fields" => [                  
                //"current_form_field" => "suffix_filter", // example            
              ],
              "related_fields_required" => [ // fields specified here cant be empty on form
                //"service_type_id"
              ],
              "query_filters" => [ // aditional filters to returned list

              ]
            ]
        
        ';

      }
      $attributes = $input["attributes"];
      unset($input["attributes"]);
      //$input["label"] = self::create_field_name($parameters['Field']);
      $input['label'] = "TranslationHelper::get_text(\"generic_{$parameters['Field']}\")";
      $input["id"] = $parameters['Field'];
      $input["name"] = $parameters['Field'];
      $input["attributes"] = $attributes;
      //Helper::debug_data($input);
      return $input;
    }

    public static function create_array_string($parameters = [], $create_key = true){     
      $string = "[";
      $array_keys = ["class", ];
      foreach ( $parameters as $key => $data ){
        
        if ( in_array($key, $array_keys) && is_array($data) ){
          $content = ( is_array($data) ? self::create_array_string($data, false) : $data );
          $string .= "\"{$key}\" => {$content}, ";

        }else {
          $content = ( is_array($data) ? "" . self::create_array_string($data) : $data );
          if ( $key == "data-select2_parameters" ){
            $string .= "
            \"{$key}\" => {$content}, ";
          }else  if ( $create_key ){
            $string .= "\"{$key}\" => \"{$content}\", ";
          }else {
            $string .= "\"{$content}\", ";
          }
          

        }
      }
      $string .= "]";
      return $string;
    }

    public static function create_inputs($parameters = [], $table_name = null ){
      /*
      [
        ['id' => 'id', 'type' => 'hidden', 'required' => true],
        ['id' => 'name',  'label' => 'Razão Social', 'required' => true,
          'type' => 'text', 'attributes' => ['minlength' => 1, 'maxlength' => 200, "placeholder" => "Informe o Nome"]],  
        ['id' => 'record',  'label' => 'Registro / CNPJ', 'required' => true,
          'type' => 'text', 'attributes' => ['minlength' => 1, 'maxlength' => 200, "placeholder" => ""]],         
        
      ]
      */
      $ident = self::IDENT;
      $new_line  = self::NEW_LINE;
      $field_list = self::NEW_LINE;
      $fields = "";
      Helper::debug_data($parameters);

      $first = true;
      foreach ( $parameters as $key => $data ){
        $field = self::create_input_field($data, $table_name);
        Helper::debug_data($field);
        $temp = ( $first ? "" : "{$ident}{$ident}  " ) ."[";
        foreach ( $field as $key2 => $attribute ){

          if ( !is_array($attribute) ){
            $temp .= "\"{$key2}\" => \"{$attribute}\" , ";

          } else if ( is_array($attribute) ){
            $array_string = self::create_array_string($attribute);
            $temp .= "{$new_line}{$ident}{$ident}{$ident}\"{$key2}\" => {$array_string} ,";
          }
        }
        $temp .= "{$new_line}{$ident}{$ident}  ],{$new_line}" ;
        $fields .= $temp;
        //Helper::debug_data($temp);
        //break;
       // $fields .= "{$ident}[\"{$data['Field']}, \" ";
       $first = false;
      }

      return $fields;
    }

    public static function get_table_relattionship( $table_name, $filters = []){
      $Crud = Crud::get_instance();;
      $sql = "SELECT
                TABLE_NAME,
                COLUMN_NAME,
                CONSTRAINT_NAME,
                REFERENCED_TABLE_SCHEMA,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME

              FROM
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE

              WHERE
                -- REFERENCED_TABLE_SCHEMA = 'prospera_NDI'
                TABLE_NAME = :table_name
              
      ";

      $bind = [ ":table_name" => $table_name ];           

      foreach ( $filters as $key => $filter ){

        switch ( $key ){

          case "column":
            $sql .= " \r\n AND COLUMN_NAME = :column ";
            $bind[':column'] = $filter;
            break;

          case "referenced_table":
            $sql .= " \r\n AND REFERENCED_TABLE_NAME = :referenced_table ";
            $bind[':referenced_table'] = $filter;
            break;

          case "referenced_column":
            $sql .= " \r\n AND REFERENCED_COLUMN_NAME = :referenced_column ";
            $bind[':referenced_column'] = $filter;
            break;

        }
    }

    return $Crud->execute_query($sql, $bind);
    
  }

}
  