<?php

  Class Company extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $name; // type: varchar(200) null: NO Key:  default:  extra: 
    public $code; // type: varchar(10) null: YES Key:  default:  extra: 
    // public $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // public $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    public $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    public $record; // type: varchar(45) null: YES Key:  default:  extra: 
    public $email; // type: varchar(100) null: YES Key:  default:  extra: 
    public $phone; // type: varchar(20) null: YES Key:  default:  extra: 
    public $address; // type: json null: YES Key:  default:  extra:    


    public function __construct(){
      $this->set__table_name("company");
      $this->set__class_name("Company");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = [ 
 				["text" => TranslationHelper::get_text("generic_id"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_name"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_code"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_create_date"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_update_date"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_create_user"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_record"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_email"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_phone"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_address"), "classes" => "none"], 
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
        $buttons = ["data" => $data, "action" => ["edit", "delete", "import_traking_codes_intranet"], "is_dropdown" => []];
         
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
            "text" => $data['name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['name'], "raw" => $data['name'], ],
            //"format" => "",
          ],
          [
            "text" => $data['code'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['code'], "raw" => $data['code'], ],
            //"format" => "",
          ],
          [
            "text" => $data['create_date'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_date'], "raw" => $data['create_date'], ],            
            "format" => "date", "format_options" => [ "date_format" => "d/m/Y h:i"]
          ],
          [
            "text" => $data['update_date'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['update_date'], "raw" => $data['update_date'], ],
            "format" => "date", "format_options" => [ "date_format" => "d/m/Y h:i"]
          ],
          [
            "text" => $data['create_user_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_user_id'], "raw" => $data['create_user_id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['record'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['record'], "raw" => $data['record'], ],
            //"format" => "",
          ],
          [
            "text" => $data['email'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['email'], "raw" => $data['email'], ],
            //"format" => "",
          ],
          [
            "text" => $data['phone'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['phone'], "raw" => $data['phone'], ],
            "format" => "phone",
          ],
          [
            "text" => $data['address'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['address'], "raw" => $data['address'], ],
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
        "id" => "form_company",
        "fields" =>[
          ["type" => "hidden" , "label" => TranslationHelper::get_text("generic_id") , "id" => "id" , "name" => "id" , 
            
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_name"), "id" => "name" , "name" => "name" , 
            "required" => true,
            "attributes" => ["maxlength" => "200", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_code") , "id" => "code" , "name" => "code" , 
            "required" => true,
            "attributes" => ["maxlength" => "10", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          /*
          ["type" => "datetime-local" , "label" => TranslationHelper::get_text("generic_create_date"), "id" => "create_date" , "name" => "create_date" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => TranslationHelper::get_text("generic_update_date") , "id" => "update_date" , "name" => "update_date" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          
          ["type" => "select" , "label" => TranslationHelper::get_text("generic_create_user") , "id" => "create_user_id" , "name" => "create_user_id" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset"  ], "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "User",
              "s_token" => HELPER_SELECT2_TOKEN,
              "key_value" => "id",
              "key_text" => "name",
              "concat" => [ ],
              "search_field" => "name_ct",
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
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_record") , "id" => "record" , "name" => "record" , 
            "required" => true,
            "attributes" => ["maxlength" => "45", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "email" , "label" => TranslationHelper::get_text("generic_email") , "id" => "email" , "name" => "email" , 
            "required" => true,
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], 
            "suffix" => "@"
            ] ,
          ],
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_phone") , "id" => "phone" , "name" => "phone" , 
            "required" => true,
            "attributes" => ["maxlength" => "20", "placeholder" => "", "class" => ["form-control", "input-sm", ], 
            "suffix" => "<i class=\"fa fa-phone\" aria-hidden=\"true\"></i>",
            ] ,
          ],
          /* */
          ["type" => "textarea" , "label" => TranslationHelper::get_text("generic_address") , "id" => "address" , "name" => "address" , 
            "required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
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
      $dropdowns = [];
      foreach ( $parameters['action'] as $key => $action ){
        switch ( $action ){
          case  "edit":
            $temp = [ 
              "class" => ["api", "bg-secondary", "text-white", "btn_edit", "text-dark", "btn", "btn-sm", "btn-xsm"], 
              "description" => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',  
              "type" => "link",
              "attributes" => [              
                "data-object" => "company",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "company",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "company",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => json_encode(["title" => TranslationHelper::get_text(["code" =>"confirm_edit_title", "replace_values" => ["label" => $parameters['data']['name']] ]), "html" => TranslationHelper::get_text("confirm_edit_text"), "icon" => "question"], true),
              ],
              "href" => "#",
              "required_permission" => ["company_edit"],
              "denied_permission" => [],
            ];

            if ( isset($parameters['is_dropdown']) && ( in_array($action, $parameters['is_dropdown']) ) ){
              $dropdowns[] = $temp;

            }else {
              $buttons[] = $temp;
            }
            break;

          case  "import_traking_codes_intranet":
            $form_values = json_encode([
              "record" => $parameters['data']['record'],
              "name" => $parameters['data']['name'],
            ], true);
            $temp = [ 
              "class" => ["api", "bg-secondary", "text-white", "btn_edit", "text-dark", "btn", "btn-sm", "btn-xsm"], 
              "description" => '<i class="fa fa-cloud-upload" aria-hidden="true"></i>',  
              "type" => "link",
              "attributes" => [              
                "data-object" => "tracking_code",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "import_batch_intranet",
                "data-action" => "import_batch_intranet" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "company_import_tracking_codes"]),
                "data-api" => "tracking_code",
                "data-api_action" => "get_form" ,
                "data-mode" => "import_batch_intranet",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['record'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => json_encode(["title" => TranslationHelper::get_text(["code" =>"confirm_import_tracking_codes_title",]), "html" => TranslationHelper::get_text(["code" => "confirm_import_tracking_codes_text",  "replace_values" => ["label" => $parameters['data']['name']] ]), "icon" => "question"], true),
                "onclick" =>"handle_form(this)", 
                "data-toggle" => "modal" ,
                "data-target" => "#form_modal",
                "data-form_values" => "{$form_values}",
                "title" => "Importar Kit de Rastreabilidade"
              ],
              "href" => "#",
              "required_permission" => ["tracking_code_create"],
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
                "data-api" => "company",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => ["company_delete"],
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