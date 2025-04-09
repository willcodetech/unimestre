<?php

  class Base {

    protected $_table_name;
    protected $_class_name;
    protected $_Crud;

    protected $id;
    protected $create_date;
    protected $update_date;
    protected $_non_editable_fields = ["id", "create_date", "create_user_id"];
    
    public function __construct(){
      $this->_Crud = Crud::get_instance();;

    }

    public function to_object($array){
      $fields = array_keys(get_object_vars($this));
      foreach ( $array as $key => $data ){
        if ( in_array($key, $fields) ){          
          $this->$key = $data;
        }
        
      }

      return $this;
    }

    public function to_array(){            
      return get_object_vars($this);    
    }
    
    public static function get_class_vars($object){
      return array_keys(get_class_vars(get_class($object))); // $object
    }

    public static function reorder_sql_filters($filters = []){ // ordering and limit should be last keys 
      $last_key_order = [ "order", "limit" ];
      foreach ( $last_key_order as $key ){
        if ( isset($filters[$key]) ){
          $temp = $filters[$key];
          unset($filters[$key]);
          $filters[$key] = $temp;
        }
      }

      return $filters;
    }

    public function create(){            
      //$Crud = Crud::get_instance();;
      $new_data = $this->to_array();
      unset($new_data['create_date']);
      unset($new_data['id']);
      $new_data['create_user_id'] = ( Auth::get_auth_info()['user_id'] ?? null );
      //Helper::debug_data($new_data);
      return $this->_Crud->create($table = $this->get__table_name(), $new_data );
    }

    public function edit($new_data){
      if ( !$new_data )
        throw new Exception("Edit failed, invalid data provided");

      if ( empty($new_data['id']) )
        throw new Exception("Unique ID invalid, can't edit registers");

      $old_data = $this->list(["id" => $new_data['id'], "limit" => 1]);
      
      if ( !$old_data )
        throw new NotFoundException("{$this->get__class_name()} id: {$new_data['id']} não encontrado, impossível editar o registro");
      
      $id = $new_data['id'];
      foreach ( $new_data as $key => $data ){ // prevent default fields from update
        if ( in_array($key, $this->get__non_editable_fields() ) )
          unset($new_data[$key]);
      }

      $ChangeHistory = new ChangeHistory();
      $change_history_fields = $ChangeHistory->list(["object_name" => $this->get__table_name(), "active" => 1]);

      if ( $change_history_fields ){ // configuration found, register logs
        $LogEdit = new LogEdit();
        foreach ( $change_history_fields as $key => $history ){
          if ( isset($new_data[$history['field']]) && ( $old_data[0][$history['field']] != $new_data[$history['field']] ) ){ // changed values
            $LogEdit->object_name = $this->get__table_name();
            $LogEdit->old_value = $old_data[0][$history['field']];
            $LogEdit->new_value = $new_data[$history['field']];
            $LogEdit->register_id = $id;
            $LogEdit->field = $history['field'];
            $LogEdit->create();
          }
        }
      }
      
      return $this->_Crud->update($table = $this->get__table_name(), $new_data, $where = "id = :id", $bind = [ ":id" => $id ]);
    }

    public function delete($id){
      $data = $this->list(["id" => $id, "limit" => 1]);
    
      if ( !$data )
        throw new NotFoundException("{$this->get__class_name()} id: {$id} não encontrado, impossível excluir o registro");

      //$Crud = Crud::get_instance();;
      return $this->_Crud->delete($table = $this->get__table_name(), $where = "id = :id", $bind = [ ":id" => $id ]);
    }

    protected function get_string_table_prefix($string){
      // Encontrar a posição do primeiro ponto
      $pos = strpos($string, '.');
      
      // Se o ponto existir, extrair o prefixo
      if ($pos !== false) {
        return substr($string, 0, $pos) . ".";
      }
      
      // Se o ponto não existir, retornar uma string vazia
      return $this->get__table_name() .".";
    }

    protected function split_string($string) {
      // Dividir a string na primeira ocorrência do ponto
      $parts = explode('.', $string, 2);
      
      // Se houver dois elementos no array, o prefixo e o campo foram encontrados
      if (count($parts) == 2) {
        return [
          "table" => $parts[0],
          "field" => $parts[1]
        ];
      } else {
        // Se não houver ponto, considerar a string inteira como campo
        return [
          "table" => $this->get__table_name(),
          "field" => $parts[0]
        ];
      }
    }

    protected function create_sql_filter($filters = [], $custom_filters = null){
      $where = "";
      $bind = [];
      $filters = self::reorder_sql_filters($filters);
      $class_vars = self::get_class_vars($this);
      $custom_suffixes = [
        "_ct", // contains full string
        "_as", // contins any string, pices by exploding spaces
        "_sw", // starts with
        "_ew", // ends with
        "_lt", // lower then
        "_le", // lower or equal
        "_gt", // greater then
        "_ge", // greater or equal
        "_bt", // between (comma separated)
        "_is", // is 
        "_ns", // not is
        "_df", // different then
        "_in", // in list
        "_ni", // not in list
      ];
      /*
      Helper::debug_data($class_vars);
      Helper::debug_data($filters);
      Helper::debug_data($custom_filters);
      
      */

      $custom_operators = [
        "_lt" => " < ",
        "_le" => " <= ",
        "_gt" => " > ",
        "_ge" => " >= ",
        "_is" => " IS ",
        "_ns" => " IS NOT ",
        "_df" => " != ",
        "_in" => " IN ",
        "_ni" => " NOT IN "
      ];

      if ( $filters ){
        foreach ( $filters as $key => $filter ){
          $column_filter = $this->split_string($key);          
          if ( in_array(substr($column_filter['field'], -3), $custom_suffixes) ){ // custom filters, like/btween etc
            $suffix = substr($column_filter['field'], -3);
            $db_field = substr($column_filter['field'], 0, -3); // remove custom suffix
            $custom_key = $db_field . "_r_" . rand(); // create random bind key

            switch ( $suffix ){
              case "_ct": // table.field like '%search%'
                $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} like :{$column_filter['table']}_{$custom_key} ";
                $bind[":{$column_filter['table']}_{$custom_key}"] = "%" . $filter . "%";
                break;

              case "_sw": // table.field like '%search'
                $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} like :{$column_filter['table']}_{$custom_key} ";
                $bind[":{$column_filter['table']}_{$custom_key}"] = "%" . $filter;
                break;

              case "_ew": // table.field like 'search%'
                $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} like :{$column_filter['table']}_{$custom_key} ";
                $bind[":{$column_filter['table']}_{$custom_key}"] = $filter . "%";
                break;

              case "_as": // AND table.field like '%search%' AND table.field like '%search%' AND table.field like '%search%' 
                $value = trim($filter);
                $search_strings = explode(" ", $value );
                
                foreach ( $search_strings as $index => $search ){
                  $custom_key .= "_{$index}_as";
                  $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} like :{$column_filter['table']}_{$custom_key} ";
                  $bind[":{$column_filter['table']}_{$custom_key}"] = "%" . $search . "%";
                }
                break;
                
              case "_gt": // AND table.field > 'value'
              case "_ge": // AND table.field >= 'value'
              case "_lt": // AND table.field < 'value'
              case "_le": // AND table.field <= 'value'
              case "_df": // AND table.field != 'value'
                $operator = ( $custom_operators[$suffix] ?? " = " );
                $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} {$operator} :{$column_filter['table']}_{$custom_key} ";
                $bind[":{$column_filter['table']}_{$custom_key}"] = $filter;
                break;
              
              case "_is": // AND table.field IS NULL
              case "_ns": // AND table.field IS NOT NULL
                $operator = ( $custom_operators[$suffix] ?? " = " );
                $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} {$operator} NULL ";
                break;

              case "_in":
              case "_ni":
                $value = trim($filter);
                $operator = ( $custom_operators[$suffix] ?? " = " );
                $search_strings = explode(",", $value );
                $custom_parameters = [];
                foreach ( $search_strings as $index => $search ){
                  $custom_key .= "_{$index}_in_";
                  $bind[":{$custom_key}"] = $search;
                  $custom_parameters[] = ":{$custom_key}";
                }
                $custom_parameters = implode(",", $custom_parameters);

                $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} {$operator} ( {$custom_parameters} ) ";
               // $bind[":{$custom_key}"] = $filter;
                break;
                
              case "_bt":
                $search_values = explode(",", $filter);
                $custom_key_1 = $custom_key . "_bt_1";
                $custom_key_2 = $custom_key . "_bt_2";
                $where .= "\r\n AND " . $column_filter['table'] .".{$db_field} BETWEEN :{$column_filter['table']}_{$custom_key_1} AND :{$column_filter['table']}_{$custom_key_2} ";
                $bind[":{$column_filter['table']}_{$custom_key_1}"] = $search_values[0];
                $bind[":{$column_filter['table']}_{$custom_key_2}"] = $search_values[1];
                break;
            }

          }else if ( in_array($column_filter['field'], $class_vars) ){ // create where based on class attributes 
            $where .= "\r\n AND " . $column_filter['table'] .".{$column_filter['field']} = :{$column_filter['table']}_{$column_filter['field']} ";
            $bind[":{$column_filter['table']}_{$column_filter['field']}"] = $filter;

          }          
                           
        }
      }
      if ( $custom_filters ){
        foreach ( $custom_filters as $key2 => $custom_filter ){
          if ( !isset($bind[$custom_filter['filter_bind_key']]) ){
            $where .= "\r\n {$custom_filter['filter_string']}";
            $bind[$custom_filter['filter_bind_key']] = $custom_filter['value'];

          }
        }

      }  
      if ( isset($filters['order']) && !empty($filters['order']))
        $where .= "\r\n ORDER BY {$filters['order']}";

      if ( isset($filters['limit']) && !empty($filters['limit'])){
        $where .= "\r\n LIMIT :limit";
        $bind[":limit"] = $filters['limit'];
      }

      $return = [ "where" => $where, "bind" => $bind, "custom_filters" => $custom_filters ];      
      return $return;
      
    }

    public function list($filters = []){
      //$Crud = Crud::get_instance();;

      $where = ( !empty($filters) ?  " \r\n 1 = 1 " : "" );
      $field_list = "*";
      if ( !isset($filters['return_all_fields']) || $filters['return_all_fields'] != true ){ 
        if ( !isset($filters['ignore_fields']) || empty($filters['ignore_fields']) ){ // remove
          $ignore_fields = [ ];
        }else {
          $ignore_fields = $filters['ignore_fields'];
        }
        $field_list = $this->_Crud->get_fields(["table" => $this->get__table_name(), "ignore_fields" => $ignore_fields, "return_query_field_list" => true ] );
      }

      $bind = [];
      if ( $filters ){
        $sql_filter = self::create_sql_filter($filters);
        $where .= $sql_filter["where"];
        $bind = $sql_filter["bind"];
      }
      return $this->_Crud->read($table = $this->get__table_name(), $where, $bind, $fields = $field_list);
    }

    // default attributes
    public function get_id(){ return $this->id; }
    public function set_id($id): self { $this->id = $id; return $this; }

    public function get_create_date(){ return $this->create_date; }
    public function set_create_date($create_date): self { $this->create_date = $create_date; return $this; }

    public function get_update_date(){ return $this->update_date; }
    public function set_update_date($update_date): self { $this->update_date = $update_date; return $this; }

    public function get__table_name(){ return $this->_table_name; }
    public function set__table_name($_table_name): self { $this->_table_name = $_table_name; return $this; }
    
    public function get__class_name(){ return $this->_class_name; }
    public function set__class_name($_class_name): self { $this->_class_name = $_class_name; return $this; }

    public function get__non_editable_fields(){ return $this->_non_editable_fields; }

  }