<?php

  Class LogEdit extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $object_name; // type: varchar(50) null: NO Key:  default:  extra: 
    public $register_id; // type: varchar(100) null: NO Key:  default:  extra: 
    // public $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // public $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    public $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    public $old_value; // type: varchar(255) null: YES Key:  default:  extra: 
    public $new_value; // type: varchar(255) null: YES Key:  default:  extra: 
    public $field; // type: varchar(100) null: YES Key:  default:  extra: 

    


    public function __construct(){
      $this->set__table_name("log_edit");
      $this->set__class_name("LogEdit");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = [ 
 				["text" => "Id", "classes" => "all"],  
 				["text" => "Object Name", "classes" => "all"],  
 				["text" => "Register Id", "classes" => "all"],  
 				["text" => "Create Date", "classes" => "all"],  
 				["text" => "Update Date", "classes" => "all"],  
 				["text" => "Create User Id", "classes" => "all"],  
 				["text" => "Old Value", "classes" => "all"],  
 				["text" => "New Value", "classes" => "all"],  
 				["text" => "Field", "classes" => "all"], 
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
            "text" => $data['register_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['register_id'], "raw" => $data['register_id'], ],
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
            "text" => $data['old_value'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['old_value'], "raw" => $data['old_value'], ],
            //"format" => "",
          ],
          [
            "text" => $data['new_value'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['new_value'], "raw" => $data['new_value'], ],
            //"format" => "",
          ],
          [
            "text" => $data['field'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['field'], "raw" => $data['field'], ],
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
        "id" => "form_log_edit",
        "fields" =>[
          ["type" => "number" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Object Name" , "id" => "object_name" , "name" => "object_name" , 
            "attributes" => ["maxlength" => "50", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Register Id" , "id" => "register_id" , "name" => "register_id" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => "Create Date" , "id" => "create_date" , "name" => "create_date" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => "Update Date" , "id" => "update_date" , "name" => "update_date" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "select" , "label" => "Create User Id" , "id" => "create_user_id" , "name" => "create_user_id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "ProductType",
              "s_token" => HELPER_SELECT2_TOKEN,
              "key_value" => "id",
              "key_text" => "description",
              "concat" => [ "id", "description"],
              "search_field" => "description_ct",
              "related_fields" => [                  
                //"current_form_field" => "suffix_filter", // example            
              ]
            ]
        
        , ] ,
          ],
          ["type" => "textarea" , "label" => "Old Value" , "id" => "old_value" , "name" => "old_value" , 
            "attributes" => ["maxlength" => "255", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "textarea" , "label" => "New Value" , "id" => "new_value" , "name" => "new_value" , 
            "attributes" => ["maxlength" => "255", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "text" , "label" => "Field" , "id" => "field" , "name" => "field" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
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
                "data-object" => "log_edit",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "log_edit",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "log_edit",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
              ],
              "href" => "#",
              "required_permission" => "log_edit_manage",
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
                "data-api" => "log_edit",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => "log_edit_manage",
            ];
            break;
        }
      }

      if ( !$buttons )
        return "";
      
      return Helper::create_html_button_dropdown($buttons);

    }

  } 