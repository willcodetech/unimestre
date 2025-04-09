<?php

  Class User{

    private $id;
    private $login;
    private $name;
    private $email;
    private $password;
    private $create_date;
    private $active;
    private $api_token;
    private $create_user_id;
    private $verify_token;
    private $verify_token_expiration;
    private $role;
    private $profile_picture_url;
    private $permission_group_id;
    private $company_id;
    private $company_group_id;
    
    private $table_name = "user";
    const MIN_PASS_LEN = 8;

    public function get_id(){ return $this->id; }
    public function set_id($id): self { $this->id = $id; return $this; }

    public function get_login(){ return $this->login; }
    public function set_login($login): self { $this->login = $login; return $this; }

    public function get_name(){ return $this->name; }
    public function set_name($name): self { $this->name = $name; return $this; }

    public function get_email(){ return $this->email; }
    public function set_email($email): self { $this->email = $email; return $this; }
    
    public function get_create_date(){ return $this->create_date; }
    public function set_create_date($create_date): self { $this->create_date = $create_date; return $this; }

    public function get_active(){ return $this->active; }
    public function set_active($active): self { $this->active = $active; return $this; }

    public function get_create_user_id(){ return $this->create_user_id; }
    public function set_create_user_id($create_user_id): self { $this->create_user_id = $create_user_id; return $this; }

    public function get_verify_token(){ return $this->verify_token; }
    public function set_verify_token($verify_token): self { $this->verify_token = $verify_token; return $this; }

    public function get_verify_token_expiration(){ return $this->verify_token_expiration; }
    public function set_verify_token_expiration($verify_token_expiration): self { $this->verify_token_expiration = $verify_token_expiration; return $this; }

    public function get_role(){ return $this->role; }
    public function set_role($role): self { $this->role = $role; return $this; }

    public function get_profile_picture_url(){ return $this->profile_picture_url; }
    public function set_profile_picture_url($profile_picture_url): self { $this->profile_picture_url = $profile_picture_url; return $this; }

    public function get_api_token(){ return $this->api_token; }
    /* public function set_api_token($api_token): self { $this->api_token = $api_token; return $this; } */
    
    public function get_permission_group_id(){ return $this->permission_group_id; }
    public function set_permission_group_id($permission_group_id): self { $this->permission_group_id = $permission_group_id; return $this; }

    public function get_table_name(){ return $this->table_name; }

    public function create_password($login, $password){
      if ( strlen($password) < self::MIN_PASS_LEN )
        throw new FormException("A senha deve conter ao menos " . self::MIN_PASS_LEN . " caracteres", $field = "password");

      return md5($login.$password.PW_SALT);
    }

    public function create_api_token($login, $password){
      return md5($login.$password.rand().API_TOKEN_SALT);
    }

    public function build($data){      
      $data['password'] = $this->create_password($data['login'], $data['password']);
      $data['api_token'] = $this->create_api_token($data['login'], $data['password']);
      return $this->to_object($data);
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

    public function create(){            
      $Crud = Crud::get_instance();;
      $user_data = $this->to_array();
      unset($user_data['create_date']);

      if ( empty($user_data['password']) )
        throw new Exception("Senha não informada, impossível criar o cadastro");
      return $Crud->create($table = $this->get_table_name(), $user_data );
    }

    public function edit($new_data){
      $Crud = Crud::get_instance();;
      //$new_data = $this->to_array();
      $id = $new_data['id'];
      unset($new_data['id']);

      /*
      if ( empty($new_data['password']) )
        throw new Exception("Senha não informada, impossível editar o cadastro");
      */

      return $Crud->update($table = $this->get_table_name(), $new_data, $where = "id = :id", $bind = [ ":id" => $id ]);
    }

    public function confirm_register($user_data){
      if (!$user_data)
        throw new Exception("Dados do usuário não informados, impossível realizar operação");

      $this->check_password($_POST['password'], $_POST['password2']);
      $new_data = [
        "login" => $user_data['login'],
        "name" => $user_data['name'],
        "email" => $user_data['email'],
        "password" => $this->create_password($user_data['login'], $user_data['password']),
        "api_token" => $this->create_api_token($user_data['login'], $user_data['password']),
        "active" => 1,
        "verify_token" => null, // clear token
        "verify_token_expiration" => null, // clear token expiration limit
        "token_type" => null,
      ];
      $Crud = Crud::get_instance();;
      return $Crud->update($table = $this->get_table_name(), $new_data, $where = "id = :id AND verify_token = :verify_token ", $bind = [ ":id" => $user_data['id'], ":verify_token" => $user_data['verify_token'] ]);
    }

    public function confirm_password_change($user_data){
      if (!$user_data)
        throw new Exception("Dados do usuário não informados, impossível realizar operação");

      $this->check_password($_POST['password'], $_POST['password2']);
      $new_data = [
        "password" => $this->create_password($user_data['login'], $user_data['password']),
        "api_token" => $this->create_api_token($user_data['login'], $user_data['password']),
        "verify_token" => null, // clear token
        "verify_token_expiration" => null, // clear token expiration limit
        "token_type" => null,
      ];
      $Crud = Crud::get_instance();;
      return $Crud->update($table = $this->get_table_name(), $new_data, $where = "id = :id AND verify_token = :verify_token ", $bind = [ ":id" => $user_data['id'], ":verify_token" => $user_data['verify_token'] ]);
    }

    public function confirm_password_change_gui($user_data){
      if (!$user_data)
        throw new Exception("Dados do usuário não informados, impossível realizar operação");

      $this->check_password($_POST['password'], $_POST['password2']);
      $new_data = [
        "password" => $this->create_password($user_data['login'], $user_data['password']),
        "api_token" => $this->create_api_token($user_data['login'], $user_data['password']),        
      ];
      $Crud = Crud::get_instance();;
      return $Crud->update($table = $this->get_table_name(), $new_data, $where = "id = :id ", $bind = [ ":id" => $user_data['id'], ]);
    }

    private function enable_verify($parameters = []){

      if ( !isset($parameters['id']) )
        throw new Exception("Id não informado, impossível gerar token temporário");

      $user = $this->list(["id" => $parameters['id'], "limit" => 1]);
      if ( !$user )
        throw new NotFoundException("Usuário não encontrado, impossível habilitar o token de verificação");

      $fake_login = "dummy_" . md5(date('ymdhms') . rand()); // randon login
      $fake_password = md5($fake_login . PW_SALT . rand());
      $token = $this->create_verify_token($fake_login, $fake_password);
      $new_data = [
        "verify_token" => $token,
        "verify_token_expiration" => $this->create_verify_token_expiration(),
      ];
      $Crud = Crud::get_instance();;
      $Crud->update($table = $this->get_table_name(), $new_data, $where = "id = :id ", $bind = [ ":id" => $parameters['id'] ]);
      return $token;
    }

    public function delete($id){
      $data = $this->list(["id" => $id, "limit" => 1]);
      
      if ( !$data )
        throw new NotFoundException("Usuário id: {$id} não encontrado, impossível excluir");

      if ( $id == 1 )
        throw new NotFoundException("Usuário id: {$id} não pode ser excluído");

      $Crud = Crud::get_instance();;
      return $Crud->delete($table = $this->get_table_name(), $where = "id = :id", $bind = [ ":id" => $id ]);
    }

    public function check_password($password, $password2){
      if ($password != $password2)
        throw new FormException('As senhas digitadas precisam ser iguais');

      if ( strlen($password) < self::MIN_PASS_LEN )
        throw new FormException("A senha deve ter pelo menos 8 caracteres.");
      
      // Verifica se a senha contém pelo menos uma letra maiúscula
      if (!preg_match('/[A-Z]/', $password))
        throw new FormException("A senha deve conter pelo menos uma letra maiúscula.");

      // Verifica se a senha contém pelo menos um número
      if (!preg_match('/[0-9]/', $password))
        throw new FormException("A senha deve conter pelo menos um número.");

      // Verifica se a senha contém pelo menos um caractere especial
      if (!preg_match('/[\W]/', $password)) 
        throw new FormException("A senha deve conter pelo menos um caractere especial.");

      // Se passou por todas as verificações, a senha é válida
      return true;

    }

    public function set_password($password, $password2){
      $this->check_password($password, $password2);   

      $this->password = self::create_password($this->login, $password);
    }

    public function set_api_token($password){
      if (strlen($pass1) < self::MIN_PASS_LEN)
        throw new FormException('La contraseña debe ser al menos '. self::MIN_PASS_LEN . ' caracteres.');

      $this->api_token = self::create_api_token($this->login, $password);
    }

    /*
    private function create_sql_filter($filters = []){
      $where = "";
      $bind = [];
      $class_vars = self::get_class_vars($this);
      if ( $filters ){
        foreach ( $filters as $key => $filter ){
          if ( in_array($key, $class_vars) ){ // create where based on class attributes 
            $where .= "\r\n AND {$this->get_table_name()}.{$key} = :{$key} ";
            $bind[":{$key}"] = $filter;
          }else {
            switch ( $key ){
              case "order":
                $where .= "ORDER BY {$filter}";
                //$bind[":{$key}"] = $filter;
                break;

              case "limit":
                $where .= "\r\n LIMIT :{$key}";
                $bind[":{$key}"] = $filter;
                break;
            }
          }
        }
      }

      return [ "where" => $where, "bind" => $bind ];
    }
    */

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
          if ( in_array(substr($key, -3), $custom_suffixes) ){ // custom filters, like/btween etc
            $suffix = substr($key, -3);
            $db_field = substr($key, 0, -3); // remove custom suffix
            $custom_key = $db_field . "_r_" . rand(); // create random bind key

            switch ( $suffix ){
              case "_ct": // table.field like '%search%'
                $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} like :{$custom_key} ";
                $bind[":{$custom_key}"] = "%" . $filter . "%";
                break;

              case "_sw": // table.field like '%search'
                $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} like :{$custom_key} ";
                $bind[":{$custom_key}"] = "%" . $filter;
                break;

              case "_ew": // table.field like 'search%'
                $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} like :{$custom_key} ";
                $bind[":{$custom_key}"] = $filter . "%";
                break;

              case "_as": // AND table.field like '%search%' AND table.field like '%search%' AND table.field like '%search%' 
                $value = trim($filter);
                $search_strings = explode(" ", $value );
                
                foreach ( $search_strings as $index => $search ){
                  $custom_key .= "_{$index}_as";
                  $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} like :{$custom_key} ";
                  $bind[":{$custom_key}"] = "%" . $search . "%";
                }
                break;
                
              case "_gt": // AND table.field > 'value'
              case "_ge": // AND table.field >= 'value'
              case "_lt": // AND table.field < 'value'
              case "_le": // AND table.field <= 'value'
              case "_df": // AND table.field != 'value'
                $operator = ( $custom_operators[$suffix] ?? " = " );
                $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} {$operator} :{$custom_key} ";
                $bind[":{$custom_key}"] = $filter;
                break;
              
              case "_is": // AND table.field IS NULL
              case "_ns": // AND table.field IS NOT NULL
                $operator = ( $custom_operators[$suffix] ?? " = " );
                $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} {$operator} NULL ";
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

                $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} {$operator} ( {$custom_parameters} ) ";
               // $bind[":{$custom_key}"] = $filter;
                break;
                
              case "_bt":
                $search_values = explode(",", $filter);
                $custom_key_1 = $custom_key . "_bt_1";
                $custom_key_2 = $custom_key . "_bt_2";
                $where .= "\r\n AND " . $this->get_table_name() .".{$db_field} BETWEEN :{$custom_key_1} AND :{$custom_key_2} ";
                $bind[":{$custom_key_1}"] = $search_values[0];
                $bind[":{$custom_key_2}"] = $search_values[1];
                break;
            }

          }else if ( in_array($key, $class_vars) ){ // create where based on class attributes 
            $where .= "\r\n AND " . $this->get_table_name() .".{$key} = :{$key} ";
            $bind[":{$key}"] = $filter;

          }          
          
          if ( $custom_filters ){
            foreach ( $custom_filters as $key2 => $custom_filter ){
              if ( !isset($bind[$custom_filter['filter_bind_key']]) ){
                $where .= "\r\n {$custom_filter['filter_string']}";
                $bind[$custom_filter['filter_bind_key']] = $custom_filter['value'];

              }
            }

          }
          switch ( $key ){
            case "order":
              $where .= "\r\n ORDER BY {$filter}";
              break;

            case "limit":
              $where .= "\r\n LIMIT :{$key}";
              $bind[":{$key}"] = $filter;
              break;
          }
        }
      }

      return [ "where" => $where, "bind" => $bind, "custom_filters" => $custom_filters ];
    }
    public function list($filters = []){
      $Crud = Crud::get_instance();;

      $where = ( !empty($filters) ?  " \r\n 1 = 1 " : "" );
      $field_list = "*";
      if ( !isset($filters['return_all_fields']) || $filters['return_all_fields'] != true ){ 
        if ( !isset($filters['ignore_fields']) || empty($filters['ignore_fields']) ){ // remove password and token
          $ignore_fields = ["password", "api_token"];
        }else {
          $ignore_fields = $filters['ignore_fields'];
        }
        $field_list = $Crud->get_fields(["table" => $this->get_table_name(), "ignore_fields" => $ignore_fields, "return_query_field_list" => true ] );
      }

      $bind = [];
      if ( $filters ){
        $sql_filter = $this->create_sql_filter($filters);
        $where .= $sql_filter["where"];
        $bind = $sql_filter["bind"];
      }
      return $Crud->read($table = $this->get_table_name(), $where, $bind, $fields = $field_list);
    }

    public function list_permissions($user_id){
      $Crud = Crud::get_instance();;
      $sql = "SELECT DISTINCT
                permission.code
              
              FROM 
                user 
                
              inner join user_permission on
                user_permission.user_id = user.id

              inner join permission on 
                permission.id = user_permission.permission_id
                                  
              WHERE 
                user_permission.user_id = :user_id

      ";

      $bind = [':user_id' => $user_id];

      return $Crud->execute_query($sql, $bind);
    }

    public static function get_form($mode = "create"){
      $Permission = new Permission();
      $permission_list = $Permission->list(["active" => 1, "order" => "permission.code asc"]);
      $form = [
        "id" => "form_user",
        "fields" => [
            
          [
            "id" => "login", "name" => "login", "type" => "text", "label" => "Login",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 3 ]
          ],
          [
            "id" => "name", "name" => "name", "type" => "text", "label" => "Nome",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 3 ]
          ],
          [
            "id" => "email", "name" => "email", "type" => "email", "label" => "E-mail",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 10 ]
          ],
          [
            "id" => "password", "name" => "password", "type" => "password", "label" => "Senha",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 8 ]
          ],
          [
            "id" => "password2", "name" => "password2", "type" => "password", "label" => "Confirmação da Senha",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 8 ]
          ],
          [
            "id" => "active", "name" => "active", "type" => "select", "label" => "Status",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "form-select", "limpar", "form-control-sm", ],
            "attributes" => [ "data-db-origin" => "active", "emptyval" => "Selecione" ],
            "options" => [ 
              "1" => "Ativo",
              "0" => "Bloqueado",
            ]
          ],
          [
            "id" => "role", "name" => "role", "type" => "select", "label" => "Perfil",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "form-select", "limpar", "form-control-sm", ],
            "attributes" => [ "data-db-origin" => "active", "emptyval" => "Selecione" ],
            "options" => [ 
              "user" => "Usuário",
              "admin" => "Administrador",
              "equipment" => "Equipamento",
            ]
          ],
          ["type" => "select" , "label" => "Grupo de Permissões" , "id" => "permission_group_id" , "name" => "permission_group_id" , 
            //"required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "emptyval" => "Selecione...", 
              "data-select2_parameters" => [
                "data_source_object" => "PermissionGroup",
                "s_token" => HELPER_SELECT2_TOKEN,
                "key_value" => "id",
                "key_text" => "name",
                //"concat" => [ "id", "name"],
                "search_field" => "name_ct",
                "related_fields" => [                  
                  //"current_form_field" => "suffix_filter", // example            
                ]
              ], 
            ] ,
          ],
          ["type" => "select" , "label" => "Grupo de Empresas" , "id" => "company_group_id" , "name" => "company_group_id" , 
            //"required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "emptyval" => "Selecione...", 
              "data-select2_parameters" => [
                "data_source_object" => "CompanyGroup",
                "s_token" => HELPER_SELECT2_TOKEN,
                "key_value" => "id",
                "key_text" => "name",
                //"concat" => [ "id", "name"],
                "search_field" => "name_ct",
                "related_fields" => [                  
                  //"current_form_field" => "suffix_filter", // example            
                ]
              ], 
            ] ,
          ],
          ["type" => "select" , "label" => "Empresa" , "id" => "company_id" , "name" => "company_id" , 
            //"required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "emptyval" => "Selecione...", 
              "data-select2_parameters" => [
                "data_source_object" => "Company",
                "s_token" => HELPER_SELECT2_TOKEN,
                "key_value" => "id",
                "key_text" => "name",
                //"concat" => [ "id", "name"],
                "search_field" => "name_ct",
                "related_fields" => [                  
                  //"current_form_field" => "suffix_filter", // example            
                ]
              ], 
            ] ,
          ],

        ]
      ];

      if ( $permission_list ){
        $permission_fields = [];        
        foreach ( $permission_list as $key => $data ){
          $permission_fields[] = [
            "id" => "permission[{$data['id']}]", "name" => "permission[{$data['id']}]", "type" => "checkbox", "label" => "{$data['description']}",          
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["value" => "{$data['code']}" ]
          ];
        }
        /*  disabled permission checkboxes*/
         
        $form['groups'][] = ["name" => "permission", "label" => "Permissões", "fields" => $permission_fields ];
        
      }

      switch ( $mode ){
        case "edit":
          $ignore = [  "password", "password2" ];
          $readonly_fields = [ "id", "login", ];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["min" => 1 ]
          ];
          foreach ( $form['fields'] as $key => $field ){
            if ( in_array($field['name'] , $ignore) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $readonly_fields) )
              $form['fields'][$key]['attributes']['readonly'] = "readonly";
          }
          break;

        case "register":
          $ignore = [ "active", "token", "role", "company_id", "company_group_id", "permission_group_id"];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 1 ]
          ];
          $form['fields'][] = [
            "id" => "verify_token", "name" => "verify_token", "type" => "hidden", "label" => "Token",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "hide_field"],
            "attributes" => ["minlength" => 1, "value" => ""]
          ];

          /*
          $form['fields'][] = [
            "id" => "file", "name" => "file", "type" => "file", "label" => "Foto de Perfil",
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "input_image_preview"],
            "attributes" => ["min" => 1, "accept" => "image/png, image/jpeg, image/gif", "classes" => ["input_image_preview"] ]
          ];
          */

          foreach ( $form['fields'] as $key => $field ){
            if ( in_array($field['name'] , $ignore) )
              unset($form['fields'][$key]);
          }
          break;

        case "reset_password":
          $required_fields = [ "id", "password", "password2", "name", "verify_token", "email"  ];
          $readonly_fields = [ "id", "name", "verify_token", "email"  ];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 1, ]
          ];
          $form['fields'][] = [
            "id" => "verify_token", "name" => "verify_token", "type" => "hidden", "label" => "Token",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "hide_field"],
            "attributes" => ["minlength" => 1, "value" => ""]
          ];
          
          foreach ( $form['fields'] as $key => $field ){
            if ( !in_array($field['name'] , $required_fields) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $readonly_fields) )
              $form['fields'][$key]['attributes']['readonly'] = "readonly";

          }
          if ( isset($form['groups']) ){
            foreach ( $form['groups'] as $key => $data ) {
              if ( $data['name'] == "permission" ){
                unset($form['groups'][$key]);
              }
            }
          }
          break;

        case "reset_password_gui":
          $required_fields = [ "id", "login", "password", "password2", "name", "email", ];
          $readonly_fields = [ "id", "name", "email", "login" ];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 1, ]
          ];
          /*
          $form['fields'][] = [
            "id" => "verify_token", "name" => "verify_token", "type" => "hidden", "label" => "Token",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "hide_field"],
            "attributes" => ["minlength" => 1, "value" => ""]
          ];
          */

          foreach ( $form['fields'] as $key => $field ){
            if ( !in_array($field['name'] , $required_fields) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $readonly_fields) )
              $form['fields'][$key]['attributes']['readonly'] = "readonly";

          }
          if ( isset($form['groups']) ){
            foreach ( $form['groups'] as $key => $data ) {
              if ( $data['name'] == "permission" ){
                unset($form['groups'][$key]);
              }
            }
          }
          break;
        
        case "searchs":
          $ignore = [  "password", "password2" ];
          $readonly_fields = [ ];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "number", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["min" => 1 ]
          ];
          foreach ( $form['fields'] as $key => $field ){
            if ( in_array($field['name'] , $ignore) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $readonly_fields) )
              $form['fields'][$key]['attributes']['readonly'] = "readonly";

            unset($form['fields'][$key]['required']);
          }
          break;

        case "search":
          $required_fields = [ "limit",];
          $ignore = [ "password", "password2"];
          $like_fields = [ "email", "login", "name" ];

          $form['fields'][] =  [ "type" => "text" , "label" => "Limite de Resultados" , "id" => "limit" , "name" => "limit" , 
            "required" => true,
            "attributes" => ["maxlength" => "10", "placeholder" => "", "class" => ["form-control", "input-sm", "text-right" ], ] ,
            "default" => "100",
          ];

          foreach ( $form['fields'] as $key => $field ){
            if ( !in_array($field['name'], $required_fields) ){
              unset($form['fields'][$key]['required']);
              unset($form['fields'][$key]['attributes']['required']);
              unset($form['fields'][$key]['default']);
            }
            unset($form['fields'][$key]['attributes']['minlength']);

            if ( in_array($field['name'], $like_fields) ){
              $form['fields'][$key]['name'] .= "_ct";               
              $form['fields'][$key]['id'] .= "_ct";          
            }

            if ( in_array($field['name'] , $ignore) )
              unset($form['fields'][$key]);
          }
          break;

        case "edit_own":
          $ignore = [  "password", "password2", "role", "active", "permission_group_id", "company_id", "company_group_id" ];
          $readonly_fields = [ "id", "login", ];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["min" => 1 ]
          ];

          $form['groups'][] = ["name" => "images", "label" => "Foto", "fields" => [[
              "id" => "file", "name" => "file", "type" => "file", "label" => "Foto de Perfil",
              "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "input_image_preview"],
              "attributes" => ["min" => 1, "accept" => "image/png, image/jpeg, image/gif", "classes" => ["input_image_preview"] ]
            ]]
          ];
          foreach ( $form['fields'] as $key => $field ){
            if ( in_array($field['name'] , $ignore) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $readonly_fields) )
              $form['fields'][$key]['attributes']['readonly'] = "readonly";
          }

          if ( isset($form['groups']) ){
            foreach ( $form['groups'] as $key => $data ) {
              if ( $data['name'] == "permission" ){
                unset($form['groups'][$key]);
              }
            }
          }
          break;

        case "invite_user":
          $form['title'] = "Convidar Usuário";
          $form['fields'] = [
            [
              "id" => "name", "name" => "name", "type" => "text", "label" => "Nome",
              "required" => true,
              "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
              "attributes" => ["minlength" => 3 ]
            ],
            [
              "id" => "email", "name" => "email", "type" => "email", "label" => "E-mail",
              "required" => true,
              "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
              "attributes" => ["minlength" => 10 ]
            ],
            [
              "id" => "role", "name" => "role", "type" => "select", "label" => "Perfil",
              "required" => true,
              "classes" => [ "form-control", "input-sm", "form-select", "limpar", "form-control-sm", ],
              "attributes" => [ "data-db-origin" => "active", "emptyval" => "Selecione" ],
              "options" => [ 
                "user" => "Usuário",
                "admin" => "Administrador",
                "equipment" => "Equipamento",
              ]
            ],
            ["type" => "select" , "label" => "Grupo de Permissões" , "id" => "permission_group_id" , "name" => "permission_group_id" , 
              //"required" => true,
              "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "emptyval" => "Selecione...", 
                "data-select2_parameters" => [
                  "data_source_object" => "PermissionGroup",
                  "s_token" => HELPER_SELECT2_TOKEN,
                  "key_value" => "id",
                  "key_text" => "name",
                  //"concat" => [ "id", "name"],
                  "search_field" => "name_ct",
                  "related_fields" => [                  
                    //"current_form_field" => "suffix_filter", // example            
                  ]
                ], 
              ] ,
            ],
            ["type" => "select" , "label" => "Grupo de Empresas" , "id" => "company_group_id" , "name" => "company_group_id" , 
              //"required" => true,
              "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "emptyval" => "Selecione...", 
                "data-select2_parameters" => [
                  "data_source_object" => "CompanyGroup",
                  "s_token" => HELPER_SELECT2_TOKEN,
                  "key_value" => "id",
                  "key_text" => "name",
                  //"concat" => [ "id", "name"],
                  "search_field" => "name_ct",
                  "related_fields" => [                  
                    //"current_form_field" => "suffix_filter", // example            
                  ]
                ], 
              ] ,
            ],
            ["type" => "select" , "label" => "Empresa" , "id" => "company_id" , "name" => "company_id" , 
              //"required" => true,
              "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "emptyval" => "Selecione...", 
                "data-select2_parameters" => [
                  "data_source_object" => "Company",
                  "s_token" => HELPER_SELECT2_TOKEN,
                  "key_value" => "id",
                  "key_text" => "name",
                  //"concat" => [ "id", "name"],
                  "search_field" => "name_ct",
                  "related_fields" => [                  
                    //"current_form_field" => "suffix_filter", // example            
                  ]
                ], 
              ] ,
            ],
          ];

          if ( isset($form['groups']) ){
            unset($form['groups']);
          }
          break;

        case "resend_invite":
          $form['title'] = "Reenviar Convite";
          $form['fields'] = [
            [
              "id" => "email", "name" => "email", "type" => "email", "label" => "E-mail",
              "required" => true,
              "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
              "attributes" => ["minlength" => 10 ]
            ],
          ];

          if ( isset($form['groups']) ){
            unset($form['groups']);
          }
          break;

        case "forgot_password":
          $form['title'] = "Solicitar Recuperação de Senha";
          $form['fields'] = [            
            [
              "id" => "email", "name" => "email", "type" => "email", "label" => "E-mail",
              "required" => true,
              "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
              "attributes" => ["minlength" => 10 ]
            ],
          ];

          if ( isset($form['groups']) ){
            unset($form['groups']);
          }
          break;

        case "create_simplified":
          $ignore = [ "role", "active", "permission_group_id", "company_id", "company_group_id" ];
          $readonly_fields = [ "id", ];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["min" => 1 ]
          ]; 
          foreach ( $form['fields'] as $key => $field ){
            if ( in_array($field['name'] , $ignore) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $readonly_fields) )
              $form['fields'][$key]['attributes']['readonly'] = "readonly";
          }

          if ( isset($form['groups']) ){
            foreach ( $form['groups'] as $key => $data ) {
              if ( $data['name'] == "permission" ){
                unset($form['groups'][$key]);
              }
            }
          }
          break;

      }

      return $form;
    }

    public function create_button($parameters = []){
      
      $buttons = [];
      foreach ( $parameters['action'] as $key => $action ){
        switch ( $action ){
          case  "edit":
            $buttons[] = [ 
              "class" => ["api", "bg-secondary", "text-white", "btn_edit", "text-dark", "btn", "btn-sm", "btn-xsm"], 
              "description" => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',//Helper::get_icon(["icon" => "edit" ]) . " " . TranslationHelper::get_text(["code" => "generic_edit"]), 
              "type" => "link",
              "attributes" => [
                'title' => 'Editar',
                "data-object" => get_class($this),
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "user" ,
                "data-action" => "edit" ,
                "data-modal_text" => "Editar Usuário: {$parameters['data']['id']} - {$parameters['data']['name']}",
                "data-api" => "user" ,
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list_with_permission",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => "{\"title\": \"Editar: {$parameters['data']['id']} - {$parameters['data']['name']}?\", \"html\": \"O registro será alterado \", \"icon\": \"question\"}",
              ],
              "href" => "#",
              "required_permission" => "user_edit",
            ];
            break;

          case  "resend_invite":
            /* */
            if ( $parameters['data']['token_type'] != "invite" ) // only pending ivites can be resend
              break;
           
            $buttons[] = [ 
              "class" => ["api", "bg-secondary", "text-white", "btn_edit", "text-dark", "btn", "btn-sm", "btn-xsm"], 
              "description" => '<i class="fa fa-paper-plane-o" aria-hidden="true"></i>',//Helper::get_icon(["icon" => "edit" ]) . " " . TranslationHelper::get_text(["code" => "generic_edit"]), 
              "type" => "link",
              "attributes" => [
                'title' => 'Reenviar Convite',
                "data-object" => get_class($this),
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "user" ,
                "data-action" => "resend_invite" ,
                "data-modal_text" => "Reenviar Convite: {$parameters['data']['id']} - {$parameters['data']['name']}",
                "data-api" => "user" ,
                "data-api_action" => "get_form" ,
                "data-mode" => "resend_invite",
                "data-api_action_get" => "list_with_permission",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => "{\"title\": \"Reenviar Convite: {$parameters['data']['id']} - {$parameters['data']['name']}?\", \"html\": \"Um novo convite será enviado \", \"icon\": \"question\"}",
              ],
              "href" => "#",
              "required_permission" => "user_edit",
              
            ];
            break;

          case  "reset_password_gui":
            $buttons[] = [ 
              "class" => ["api","bg-secondary", "btn", "btn-sm", "btn-xsm", "btn_delete", "text-dark"], 
              "description" => '<i class="fa fa-lock" aria-hidden="true"></i>', //Helper::get_icon(["icon" => "delete" ]) . " " . TranslationHelper::get_text(["code" => "generic_delete"]), 
              "type" => "link",
              "attributes" => [
                'title' => 'Alterar Senha',
                "data-object" => get_class($this),
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "user" ,
                "data-action" => "reset_password_gui" ,
                "data-modal_text" => "Alterar Senha: {$parameters['data']['id']} - {$parameters['data']['name']}",
                "data-api" => "user" ,
                "data-api_action" => "get_form" ,
                "data-mode" => "reset_password_gui",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => "{\"title\": \"Alterar Senha: {$parameters['data']['id']} - {$parameters['data']['name']}?\", \"html\": \"O a senha será alterada \", \"icon\": \"question\"}",
              ],
              "href" => "#",
              "required_permission" => "user_edit",
            ];
            break;

          case  "delete":
            if ( $parameters['data']['id'] == Auth::get_auth_info()['user_id'] ) // user can't delete himself 
              break;

            $buttons[] = [ 
              
              "class" => ["api","bg-secondary", "btn", "btn-sm", "btn-xsm", "btn_delete", "text-dark"], 
              "description" => '<i class="fa fa-trash-o" aria-hidden="true"></i>', //Helper::get_icon(["icon" => "delete" ]) . " " . TranslationHelper::get_text(["code" => "generic_delete"]), 
              "type" => "link",
              "attributes" => [
                'title' => 'Excluir',
                "data-object" => get_class($this),
                "data-action" => "delete",
                "data-id" => $parameters['data']['id'],     
                "data-confirm" => "required",
                "data-confirm_parameters" => "{\"title\": \"Excluir Usuário: {$parameters['data']['id']} - {$parameters['data']['name']}?\", \"html\": \"Esta operação não poderá ser desfeita \", \"icon\": \"question\"}",
                "data-api" => "user",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => "user_delete",
            ];
            break;
        }
      }

      if ( !$buttons )
        return "";
    
      $html = "";
      foreach ( $buttons as $button )  {
        $html .= Helper::create_html_button($button);
      }
      return $html;
      return Helper::create_html_button_dropdown($buttons);

    }

    public function get_datatable_list($list){

      $return = [];
      foreach ( $list as $key => $data ){
        $list[$key]['buttons'] = $this->create_button(["data" => $data, "action" => ["edit", "delete"],]);
        
      }
      return $list;
      return [ "data" => $list ];
    }

    private function create_verify_token($login, $email){
      return md5($login.$email.rand().VERIFY_TOKEN_SALT);
    }

    private function create_verify_token_expiration(){
      return date("Y-m-d H:i:s", strtotime(VERIFY_TOKEN_EXPIRATION_HOURS));
    }

    public static function verify_token_is_valid($expiration_date = null){
      $now = date("Y-m-d H:i:s");
      if ( ( !$expiration_date ) || ( $now > $expiration_date ) )
        throw new Exception("Token de validação expirado");

    }

    private function create_dummy_user($parameters = []){
      $required_parameters = ["email", "name"];
      
      foreach ( $required_parameters as $field ){
        if ( !$parameters['email'] )
          throw new Exception(TranslationHelper::get_text(["code" => "generic_required_field_invalid", "replace_values" => [ "field" => $field ]]));

      }

      $fake_login = "dummy_" . md5(date('ymdhms') . rand()); // randon login
      $fake_password = md5($fake_login . PW_SALT . rand());
      $fake_api_token = $this->create_api_token($fake_login, $fake_password );      
      $user_data = [ 
        "login" => $fake_login,
        "email" => $parameters['email'],
        "password" => $fake_password,
        "active" => 0,
        "name" => $parameters['name'],
        "api_token" => $fake_api_token,        
        "create_user_id" => ( $_SESSION['auth']['user_id'] ?? null ),
        "role" => $parameters['role'] ?? "user",
        "verify_token" => $this->create_verify_token($fake_login, $fake_password),
        "verify_token_expiration" => $this->create_verify_token_expiration(),
        "token_type" => "invite",
        "company_id" => $parameters['company_id'] ?? null,
        "company_group_id" => $parameters['company_group_id'] ?? null,
        "permission_group_id" => $parameters['permission_group_id'] ?? null,
      ];

      $Crud = Crud::get_instance();;
      $new_user_id = $Crud->create($table = $this->get_table_name(), $user_data );
      
      if ( !$new_user_id )
        throw new Exception("Falha ao criar usuário genérico");

      $created_user = $this->list(["id" => $new_user_id]);

      if ( !$created_user )
        throw new Exception("Falha ao retornar usuário genérico {$new_user_id}");

      return $created_user;

    }

    public function invite_user($parameters = []){     

      if ( isset($parameters['resend']) && $parameters['resend'] == true ){ // resend, find pending invite
        $required_parameters = ["email"];
      
        foreach ( $required_parameters as $field ){
          if ( !$parameters[$field] )
            throw new Exception(TranslationHelper::get_text(["code" => "generic_required_field_invalid", "replace_values" => [ "field" => $field ]]));
  
        }
        $fake_user = $this->list(["email" => $parameters['email'], "active" => false, "token_type" => "invite"] );
        if ( !$fake_user )
          throw new NotFoundException("Usuário não encontrado ou não existe convite pendente");

        $update_fields = [
          "verify_token_expiration" => $this->create_verify_token_expiration(),
        ];
        $Crud = Crud::get_instance();;
        $Crud->update("user", $update_fields, " user.id = :user_id ", [":user_id" => $fake_user[0]['id'] ] );        

      }else { //create new fake user
        $required_parameters = ["email", "name"];
      
        foreach ( $required_parameters as $field ){
          if ( !$parameters[$field] )
            throw new Exception(TranslationHelper::get_text(["code" => "generic_required_field_invalid", "replace_values" => [ "field" => $field ]]));
  
        }
        $fake_user = $this->create_dummy_user($parameters);

      }

      if ( !$fake_user )
        throw new Exception("Não foi possível criar o usuário temporário");

      $fake_user = $fake_user[0];
      $subject = Parameter::get("user_invite_email_subject");
      //$template = file_get_contents(TEMPLATES_DIR . "email/user_invite.html");
      //$fake_user['crypt'] = base64_encode($fake_user['id']);
      //$fake_user['crypt_token'] = base64_encode($fake_user['verify_token']);
      //$fake_user['crypt_action'] = base64_encode("register_user");
      $fake_user['action'] = "register_user";
      $fake_user['app_url'] = Parameter::get("base_url");;
      $user['app_name'] = Parameter::get("system_name");
      $user['logo'] = Parameter::get("default_logo");
      $fake_user['message_text'] = Parameter::get("user_invite_email_text");
      //$body = Helper::replace_key_value($template, $fake_user);
      $parameters = [
        "object" => "user",
        "view" => "email_invite",
        "extension" => "php"
      ];
    
      $body = HtmlHelper::load_custom_view($parameters, $template_parameters = ['data' => $fake_user ]);
      
      $mail_parameters = [
        "destination" => [ $fake_user['email'] ],
        "subject" => $subject,
        "body" => $body,
        "copy" => [], // [ "william@willcode.tech" ],
        "send" => true,
        "debug" => false,
      ];
      MailHelper::send_email($mail_parameters);
      //Helper::debug_data($fake_user);

      return [
        "email" => $fake_user['email'],
        "sent" => true,
      ];
    }

    public function request_password_change($parameters = []){
      $required_parameters = ["email"];
      
      foreach ( $required_parameters as $field ){
        if ( !$parameters[$field] )
          throw new Exception(TranslationHelper::get_text(["code" => "generic_required_field_invalid", "replace_values" => [ "field" => $field ]]));

      }

      $user = $this->list(["email" => $parameters['email'], "active" => 1, "limit" => 1]);

      if ( !$user )
        throw new Exception("Usuário não encontrado, verifique se o email informado está correto");

      $user = $user[0];

     
      $user['verify_token'] = $this->enable_verify(["id" => $user['id']]);
      $subject = Parameter::get("user_reset_password_email_subject");
      $template = file_get_contents(TEMPLATES_DIR . "email/user_invite.html");
      //$user['crypt'] = base64_encode($user['id']);
      //$user['crypt_token'] = base64_encode($user['verify_token']);
      //$user['crypt_action'] = base64_encode("reset_password");
      $user['action'] = "reset_password";
      $user['app_url'] = Parameter::get("base_url");
      $user['app_name'] = Parameter::get("system_name");
      $user['logo'] = Parameter::get("default_logo");
      $user['message_text'] = Parameter::get("user_reset_password_email_text");
      //$body = Helper::replace_key_value($template, $user);
      
      $parameters = [
        "object" => "user",
        "view" => "email_invite",
        "extension" => "php"
      ];
    
      $body = HtmlHelper::load_custom_view($parameters, $template_parameters = ['data' => $user ]);
      
      $mail_parameters = [
        "destination" => [ $user['email'] ],
        "subject" => $subject,
        "body" => $body,
        "copy" => [], //[ "william@willcode.tech" ],
        "send" => true,
        "debug" => false,
      ];
      MailHelper::send_email($mail_parameters);
      //Helper::debug_data($fake_user);

    }

    public function to_datatable($list){
      $return = [];
      $columns = [ 
        ["text" => "Foto", "classes" => ["no_export", "all"]], 
        ["text" => "Login", "classes" => ["none"]], 
        ["text" => "Nome", "classes" => ["all"]], 
        ["text" => "Email", "classes" => ["none"]], 
        ["text" => "Perfil", "classes" => ["none"]], 
        ["text" => "Ações", "classes" => ["no_export", "all"]] ];
      $items = [];
      $parameters = [
        "default_classes" => true,
        "classes" => ["tabela-teste", "responsive"],
        "table_id" => $table_id,
        "enable_column_search" => true,
        "load_datatables" => true,
        "datatables_config" => [
          "order" => [[ 0, "asc" ]], // column ordering               
          //"keys" => true, // enable keyboard navigation                   
          "colReorder" => false, // enable column reorder drag'n drop
          "ordering" => true, // enable sorting             
          "responsive" => true, // enable responsivness                    
          "fixedHeader" => false,
          //"rowGroup" => [ 1 ], // group rows
          //"select" => true,
          "paging" => false, // enable paging function                 
          "pageLength" => 50,                                       
          "export_file_name" => $table_id,
          "totalizer" => false,                   
          "sum_columns" => [
            //[ "index" => 6,], 
            //[ "index" => 10, "format" => "BRL" ], // currency format

          ],
          "table_id" => $table_id,
          "scrolX" => true,
          //"scrolx" => true,
          //"sScrollXInner" => "100%",
          "remove_buttons" => true,
          //"searching" => false,

        ],
      ];
      //Helper::debug_data($list);
      foreach ( $list as $key => $data ){
        $buttons = ["data" => $data, "action" => ["edit", "delete", "reset_password_gui", "resend_invite"],];
        $user_picture = "";
        if ( !empty($data['profile_picture_url']) ){
          $user_picture = "
          <img src=\"{$data['profile_picture_url']}\" height=\"40\" width=\"40\" alt=\"\"
            style='
              height: 40px;
              width: 40px;
              border: 3px solid #fff;
              border-radius: 50%;
              margin: 0;
              padding: 0;
              box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
            '
            loading='lazy'
          >";

        }

        $login = ( $data['token_type'] == "invite" ? "" : $data['login'] );
        switch ( $data['role'] ){
          case "admin":
            $role = "Administrador";
            break;
          
          case "user":
            $role = "Usuário";
            break;
          
          case "equipment":
            $role = "Equipamento";
            break;
        }
        //$role = ( $data['role'] == "admin" ? "Administrador": "Usuario" );
        $temp = [     
          /*
          [
            "text" => $data['record'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['record'], "raw" => $data['record'],],
            //"format" => "cnpj",
          ],
          */
          
          /*
          [
            "text" => $data['id'], "classes" => ["text-center"],
            "attributes" => [ "order" => $data['id'], "raw" => $data['id'], ],
            //"format" => "",
          ],
          */
          [
            "text" => $user_picture, "classes" => ["text-center"],
            "attributes" => [ "order" => $data['login'], "raw" => $data['login'], ],
            //"format" => "",
          ],
          [
            "text" => $login, "classes" => ["text-left"],
            "attributes" => [ "order" => $data['login'], "raw" => $data['login'], ],
            //"format" => "",
          ],
          [
            "text" => $data['name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['name'], "raw" => $data['name'], ],
            //"format" => "",
          ],
          [
            "text" => $data['email'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['email'], "raw" => $data['email'], ],
            //"format" => "",
          ],
          /*
          [
            "text" => $data['active'] ? "" : "bloqueado", "classes" => ["text-center"],
            "attributes" => [ "order" => $data['active'], "raw" => $data['active'], ],
            //"format" => "",
          ],
          */
          [
            "text" => $role, "classes" => ["text-center"],
            "attributes" => [ "order" => $data['role'], "raw" => $data['role'], ],
            //"format" => "",
          ],
          
          [
            //"text" =>  $this->create_button([]), 
            "text" =>  $this->create_button($buttons), 
            "classes" => ["text-center"],
            "attributes" => ["order" => '', "raw" => '',],
          ]
        ];
        $items[] = $temp;
      }

      return [ "columns" => $columns, "items" => $items, "extra_parameters" => $parameters ];
    }

    public function remove_profile_picture($user_id, $except_id = null){

      try {
        $File = new File();

        // delete all profile picture reletade files from that user
        $user_referenced_files = $File->list(["register_id" => $user_id, "type" => "profile_picture", "object" => "user" ]);
        foreach ( $user_referenced_files as $key => $data ){
          if ( $except_id != null && $data['id'] == $except_id ) // ignore that file id
            continue;

          $File->destroy($data['id']);
        }

      } catch ( Exception $error ){
        // do nothing, just supress errors
        //throw $error;
      }
    }


  }
