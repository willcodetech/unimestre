<?php

  Class ChangeHistory extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $object_name; // type: varchar(50) null: NO Key:  default:  extra: 
    // public $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // public $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    public $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    public $field; // type: varchar(100) null: YES Key:  default:  extra: 
    public $active; // type: tinyint(1) null: YES Key:  default: 0 extra: 

    public function __construct(){
      $this->set__table_name("change_history");
      $this->set__class_name("ChangeHistory");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = [ 
 				["text" => "Id", "classes" => "all"],  
 				["text" => "Table", "classes" => "all"],  
 				["text" => "Create Date", "classes" => "all"],  
 				["text" => "Update Date", "classes" => "all"],  
 				["text" => "Create User Id", "classes" => "all"],  
 				["text" => "Field", "classes" => "all"],  
 				["text" => "Active", "classes" => "all"], 
 				["text" => "Ações", "classes" => ["no_export", "all"] ]
      ];
      $items = [];
      $table_id = $this->get__table_name() . "_" .rand();
      $parameters = [
        "default_classes" => true,
        "classes" => ["tabela-teste", "responsive"],
        "table_id" => $table_id,
        "enable_column_search" => true,
        "load_datatables" => true,
        "datatables_config" => [
          "order" => [[ 0, "asc" ]], // column ordering               
          "keys" => true, // enable keyboard navigation                   
          "colReorder" => false, // enable column reorder drag'n drop
          "ordering" => true, // enable sorting             
          "responsive" => true, // enable responsivness                    
          "fixedHeader" => false,
          //"rowGroup" => [ 1 ], // group rows
          "select" => true,
          "paging" => true, // enable paging function                 
          "pageLength" => 50,                                       
          "export_file_name" => $table_id,
          "totalizer" => true,                   
          "sum_columns" => [
            //[ "index" => 6,], 
            //[ "index" => 10, "format" => "BRL" ], // currency format

          ],
          "table_id" => $table_id,
          "scrolX" => true,
          //"scrolx" => true,
          //"sScrollXInner" => "100%",

        ],
      ];
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
            "text" => $data['object_name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['object_name'], "raw" => $data['object_name'], ],
            //"format" => "",
          ],
          [
            "text" => $data['create_date'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_date'], "raw" => $data['create_date'], ],
            //"format" => "",
          ],
          [
            "text" => $data['update_date'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['update_date'], "raw" => $data['update_date'], ],
            //"format" => "",
          ],
          [
            "text" => $data['create_user_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_user_id'], "raw" => $data['create_user_id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['field'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['field'], "raw" => $data['field'], ],
            //"format" => "",
          ],
          [
            "text" => $data['active'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['active'], "raw" => $data['active'], ],
            //"format" => "",
          ],

          
          [
            "text" =>  $this->create_button($buttons), "classes" => ["text-center"],
            "attributes" => ["order" => '', "raw" => '',],
          ]
        ];
        $items[] = $temp;
      }

      return [ "columns" => $columns, "items" => $items, "extra_parameters" => $parameters  ];
    }

    public static function get_form($mode = "create"){
      $form = [
        "id" => "form_change_history",
        "fields" =>[
          ["type" => "hidden" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Table" , "id" => "object_name" , "name" => "object_name" , 
            "attributes" => ["maxlength" => "50", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Field" , "id" => "field" , "name" => "field" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
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
        ]
      ];


      if ( Auth::is_admin() ){ // example fields for admin only
        /*
        $form['fields'][] = [
          "id" => "user_id", "name" => "user_id", "type" => "select", "label" => "user_id",
          "required" => true,
          "classes" => [ "form-control", "input-sm", "form-select", "limpar", "form-control-sm", ],
          "attributes" => [ "data-db-origin" => "ceate_user_id", "emptyval" => "Selecione",  ],
          "options" => $seller_options,
          "default" => ( $mode == "create" ? Auth::get_auth_info()['user_id'] : "" ),
          
        ];
        */
      }

      switch ( $mode ){
        case "search":
          $required_fields = [ "limit" ];
          $like_fields = [ "name", "phone", "description", "code", "text", "label" ];          

          foreach ( $form['fields'] as $key => $field ){
            if ( !in_array($field['name'], $required_fields) ){
              unset($form['fields'][$key]['required']);
              unset($form['fields'][$key]['attributes']['required']);
              unset($form['fields'][$key]['default']);
            }

            if ( in_array($field['name'], $like_fields) ){
              $form['fields'][$key]['name'] .= "_ct";               
              $form['fields'][$key]['id'] .= "_ct";          
            }
            
            if ( $field['name'] == "price" ){
              unset($form['fields'][$key]);
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
              "class" => ["api", "dropdown-item", "btn_edit", "text-dark"], 
              "description" => Helper::get_icon(["icon" => "edit" ]) . " " . TranslationHelper::get_text(["code" => "generic_edit"]), 
              "type" => "link",
              "attributes" => [              
                "data-object" => "change_history",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "change_history",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "change_history",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
              ],
              "href" => "#",
              "required_permission" => "change_history_manage",
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
                "data-confirm_parameters" => "{\"title\": \"Excluir: {$parameters['data']['id']} - {$parameters['data']['object_name']} -> {$parameters['data']['field']}?\", \"html\": \"Esta operação não poderá ser desfeita\", \"icon\": \"question\"}",
                "data-api" => "change_history",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => "change_history_manage",
            ];
            break;
        }
      }

      if ( !$buttons )
        return "";
      
      return Helper::create_html_button_dropdown($buttons);

    }

    public function list_details($filters = [], $custom_filters = []){
      $Crud = Crud::get_instance();;
      $sql = "  SELECT
                  change_history.*                  
                  , user.name user_name
                                    
                FROM
                  change_history

                left join user on
                  user.id = change_history.create_user_id 

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

    public function list_tables($filters = [], $custom_filters = []){
      $Crud = Crud::get_instance();;
      $sql = "  SELECT 
                  table_name 
                FROM 
                  information_schema.tables
                WHERE 
                  table_schema = :db_name 

                limit 2
      ";

      $bind = [":db_name" => DB_CONFIG['DB']];           
   
      if ( $filters || $custom_filters ){
        $sql_filter = $this->create_sql_filter($filters, $custom_filters);
        $sql .= $sql_filter["where"];
        $bind = $sql_filter["bind"];
      }

      return $Crud->execute_query($sql, $bind);
    }

    public function list_table_columns($filters = [], $custom_filters = []){
      $Crud = Crud::get_instance();;
      $sql = "  SELECT 
                  table_name
                  , column_name
                FROM 
                  INFORMATION_SCHEMA.COLUMNS
                WHERE 
                  TABLE_SCHEMA = '" . DB_CONFIG['DB'] . "'
                  -- AND TABLE_NAME = 'my_table'
    
      ";

      //$bind = [":db_name" => DB_CONFIG['DB']];           
      $bind = [];
   
      if ( $filters || $custom_filters ){
        $sql_filter = $this->create_sql_filter($filters, $custom_filters);
        $sql .= $sql_filter["where"];
        $bind = $sql_filter["bind"];
      }

      Helper::debug_data($sql);
      Helper::debug_data($bind);
      Helper::debug_data($custom_filters);
      return $Crud->execute_query($sql, $bind);
    }

  } 