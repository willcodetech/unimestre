<?php

  Class UserPermission extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $user_id; // type: int null: NO Key: MUL default:  extra: 
    public $permission_id; // type: int null: NO Key: MUL default:  extra: 

    public function __construct(){
      $this->set__table_name("user_permission");
      $this->set__class_name("UserPermission");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = ["Id", "User Id", "Permission Id", "Ações"];
      $items = [];
      //Helper::debug_data($list);
      foreach ( $list as $key => $data ){
        $buttons = ["data" => $data, "action" => ["edit", "delete"],];
         
        $temp = [     
          /*
          [
            "text" => $data['record'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['record'], "raw" => $data['record'],],
            //"format" => "cnpj",
          ],
          */
          
          [
            "text" => $data['id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['id'], "raw" => $data['id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['user_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['user_id'], "raw" => $data['user_id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['permission_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['permission_id'], "raw" => $data['permission_id'], ],
            //"format" => "",
          ],

          
          [
            "text" =>  $this->create_button($buttons), "classes" => ["text-center"],
            "attributes" => ["order" => '', "raw" => '',],
          ]
        ];
        $items[] = $temp;
      }

      return [ "columns" => $columns, "items" => $items ];
    }

    public static function get_form(){
      return [
        "id" => "form_user_permission",
        "fields" =>[
          ["type" => "number" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "number" , "label" => "User Id" , "id" => "user_id" , "name" => "user_id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "number" , "label" => "Permission Id" , "id" => "permission_id" , "name" => "permission_id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],

        ]
      ];
    }

    public function create_button($parameters = []){
      
      $buttons = [];
      foreach ( $parameters['action'] as $key => $action ){
        switch ( $action ){
          case  "edit":
            $buttons[] = [ 
              "class" => ["api", "dropdown-item", "btn_edit", "text-dark"], 
              "description" => Helper::get_icon(["icon" => "edit" ]) . " " . TranslationHelper::get_text(["code" => "generic_edit"]), 
              "type" => "link",
              "attributes" => [              
                "data-object" => "user_permission",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "user" ,
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "user_permission",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
              ],
              "href" => "#",
              "required_permission" => "user_permission_edit",
            ];
            break;

          case  "delete":
            $buttons[] = [ 
              "class" => ["api", "dropdown-item", "btn_delete", "text-danger"], 
              "description" => Helper::get_icon(["icon" => "delete" ]) . " " . TranslationHelper::get_text(["code" => "generic_delete"]), 
              "type" => "link",
              "attributes" => [
                "data-object" => get_class($this),
                "data-action" => "delete",
                "data-id" => $parameters['data']['id'],     
                "data-confirm" => "required",
                "data-confirm_parameters" => "{\"title\": \"Excluir: {$parameters['data']['id']} - {$parameters['data']['name']}?\", \"html\": \"Esta operação não poderá ser desfeita\", \"icon\": \"question\"}",
                "data-api" => "user_permission",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => "user_permission_delete",
            ];
            break;
        }
      }

      if ( !$buttons )
        return "";
      
      return Helper::create_html_button_dropdown($buttons);

    }

    public function clear_user_permissions($user_id = null){
      if ( !$user_id )
        throw new Exception("User Id not found, cannot clear permissions");

      $Crud = Crud::get_instance();;
      $data = $this->list(["user_id" => $user_id,]);
    
      if ( !$data )
        return false;

      $Crud = Crud::get_instance();;
      return $this->_Crud->delete($table = $this->get__table_name(), $where = "user_id = :user_id", $bind = [ ":user_id" => $user_id ]);
    }

    public function list_details($filters = [], $custom_filters = []){
      $Crud = Crud::get_instance();;
      $sql = "  SELECT
                  user_permission.*
                  , permission.code 
                  , permission.description
                  , user.name user_name
                                    
                FROM
                  user_permission

                inner join user on
                  user.id = user_permission.user_id 

                  inner join permission on 
                  permission.id = user_permission.permission_id

                where 
                  1
                  -- AND sale.create_user_id = 1

      ";

      $bind = [];      
     
      if ( !Auth::is_admin() ){
        $filters['user_id'] = @Auth::get_auth_info()['user_id']; // set current user id to prevent listing another user data
        //$sql .= " AND sale.create_user_id = :current_user ";
        //$bind[':current_user'] = @Auth::get_auth_info()['user_id'];
        //$sql .= "\r\n AND sale.create_user_id = 1 ";
      }
      if ( $filters || $custom_filters ){
        $sql_filter = $this->create_sql_filter($filters, $custom_filters);
        $sql .= $sql_filter["where"];
        $bind = $sql_filter["bind"];
      }
      /* 
      Helper::debug_data($sql);
      Helper::debug_data($bind);
      Helper::debug_data($custom_filters);
      // die();
      */      
      
      return $Crud->execute_query($sql, $bind);
    }

  } 