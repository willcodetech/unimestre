<?php

  Class CompanyGroup extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $name; // type: varchar(150) null: YES Key:  default:  extra: 
    // public $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // public $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    public $active; // type: tinyint null: YES Key:  default: 1 extra: 
    public $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    public $code; // type: varchar(100) null: NO Key: UNI default:  extra: 

    


    public function __construct(){
      $this->set__table_name("company_group");
      $this->set__class_name("CompanyGroup");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = [ 
 				//["text" => TranslationHelper::get_text("generic_id"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_name"), "classes" => "all"],  
 				//["text" => TranslationHelper::get_text("generic_create_date"), "classes" => "all"],  
 				//["text" => TranslationHelper::get_text("generic_update_date"), "classes" => "all"],  
 				//["text" => TranslationHelper::get_text("generic_active"), "classes" => "all"],  
 				//["text" => TranslationHelper::get_text("generic_create_user_id"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_code"), "classes" => "all"], 
 				["text" => TranslationHelper::get_text("generic_actions"), "classes" => ["no_export", "all"] ]
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
          "select" => false,
          "paging" => true, // enable paging function                 
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

        ],
      ];
      foreach ( $list as $key => $data ){
        $buttons = ["data" => $data, "action" => ["edit", "delete"], "is_dropdown" => []];
         
        $temp = [     
          /*
          [
            "text" => $data['record'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['record'], "raw" => $data['record'],],
            //"format" => "cnpj",
          ],
      
          
          [
            "text" => $data['id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['id'], "raw" => $data['id'], ],
            //"format" => "",
          ],
              */
          [
            "text" => $data['name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['name'], "raw" => $data['name'], ],
            //"format" => "",
          ],
          /*
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
            "text" => $data['active'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['active'], "raw" => $data['active'], ],
            //"format" => "",
          ],
          [
            "text" => $data['create_user_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_user_id'], "raw" => $data['create_user_id'], ],
            //"format" => "",
          ],
          */
          [
            "text" => $data['code'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['code'], "raw" => $data['code'], ],
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
      $Company = new Company();
      $company_list = $Company->list(["order" => " company.name asc "]);
      $form = [
        "id" => "form_company_group",
        "fields" =>[
          ["type" => "hidden" , "label" => TranslationHelper::get_text("generic_id") , "id" => "id" , "name" => "id" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_name") , "id" => "name" , "name" => "name" , 
            "attributes" => ["maxlength" => "150", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          [
            "id" => "active", "name" => "active", "type" => "select", "label" => "Status",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "form-select", "limpar", "form-control-sm", ],
            "attributes" => [ "data-db-origin" => "active", "emptyval" => "Selecione" ],
            "options" => [ 
              "1" => TranslationHelper::get_text("generic_active"),
              "0" => TranslationHelper::get_text("generic_inactive"),
            ]
          ],
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_code") , "id" => "code" , "name" => "code" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          /*
          ["type" => "datetime-local" , "label" => TranslationHelper::get_text("generic_create_date") , "id" => "create_date" , "name" => "create_date" , 
            "attributes" => [, "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => TranslationHelper::get_text("generic_update_date") , "id" => "update_date" , "name" => "update_date" , 
            "attributes" => [, "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "select" , "label" => TranslationHelper::get_text("generic_create_user_id") , "id" => "create_user_id" , "name" => "create_user_id" , 
            "attributes" => [, "placeholder" => "", "class" => ["form-control", "input-sm", ], "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "User",
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
        
          , ] ,
          ],
          */

        ]
      ];


      if ( $company_list ){
        $company_fields = [];        
        foreach ( $company_list as $key => $data ){
          $company_fields[] = [
            "id" => "company[{$data['id']}]", "name" => "company[{$data['id']}]", "type" => "checkbox", "label" => "{$data['name']}",          
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["value" => "{$data['id']}" ]
          ];
        }
        /*  disabled service checkboxes*/
         
          $form['groups'][] = ["name" => "company", "label" => TranslationHelper::get_text("generic_group_company"), "fields" => $company_fields ];
        
      }
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

          if ( isset( $form['groups']) )
            unset($form['groups']);
          break;
      }
      return $form;
    }

    public function create_button($parameters = []){
      
      $buttons = [];
      $dropdowns = [];
      foreach ( $parameters['action'] as $key => $action ){
        switch ( $action ){
          case  "edit":
            $temp = [ 
              "class" => ["api", "bg-secondary", "text-white", "btn_edit", "text-dark", "btn", "btn-sm", "btn-xsm"], 
              "description" => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',  
              "type" => "link",
              "attributes" => [              
                "data-object" => "company_group",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "company_group",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "company_group",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list_with_company",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => json_encode(["title" => TranslationHelper::get_text("confirm_edit_title"), "html" => TranslationHelper::get_text("confirm_edit_text"), "icon" => "question"], true),
              ],
              "href" => "#",
              "required_permission" => ["company_group_edit"],
              "denied_permission" => [],
            ];

            if ( isset($parameters['is_dropdown']) && ( in_array($action, $parameters['is_dropdown']) ) ){
              $dropdowns[] = $temp;

            }else {
              $buttons[] = $temp;
            }
            break;

          case  "delete":
            $temp = [ 
              "class" => ["api","bg-secondary", "btn", "btn-sm", "btn-xsm", "btn_delete", "text-dark"], 
              "description" => '<i class="fa fa-trash-o" aria-hidden="true"></i>', 
              "type" => "link",
              "attributes" => [
                "data-object" => get_class($this),
                "data-action" => "delete",
                "data-id" => $parameters['data']['id'],     
                "data-confirm" => "required",
                "data-confirm_parameters" => json_encode(["title" => TranslationHelper::get_text("confirm_delete_title"), "html" => TranslationHelper::get_text("confirm_delete_text"), "icon" => "question"], true),
                "data-api" => "company_group",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => ["company_group_delete"],
              "denied_permission" => [],
            ];

            if ( isset($parameters['is_dropdown']) && ( in_array($action, $parameters['is_dropdown']) ) ){
              $temp['class'][] = "dropdown-item";
              $dropdowns[] = $temp;

            }else {
              $buttons[] = $temp;
            }
            break;
        }
      }

      if ( !$buttons )
        return "";
    
      $html = "";
      if ( $buttons ){
        foreach ( $buttons as $key => $data ){
          $html .= Helper::create_html_button($data);
        }
      }
        
      if ( $dropdowns )
        $html .= Helper::create_html_button_dropdown($dropdowns);

      return $html;

    }

  } 