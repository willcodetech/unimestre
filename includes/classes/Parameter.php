<?php

  Class Parameter extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $description; // type: varchar(100) null: NO Key:  default:  extra: 
    public $code; // type: varchar(100) null: NO Key: UNI default:  extra: 
    // public $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // public $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    public $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    public $value; // type: varchar(255) null: YES Key:  default:  extra: 
    public $default_value; // type: varchar(255) null: YES Key:  default:  extra: 

    public static $parameter_list; 
    public function __construct(){
      $this->set__table_name("parameter");
      $this->set__class_name("Parameter");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = [  				
        ["text" => "Code", "classes" => "all"],   				
 				["text" => "Description", "classes" => "all"],  
 				["text" => "Value", "classes" => "all"],  
 				["text" => "Default Value", "classes" => "none"], 
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
      $html_rows = "";
      foreach ( $list as $key => $data ){
        $buttons = ["data" => $data, "action" => ["delete", "edit"], "is_dropdown" => []];
         
        $temp = [     
          
          [
            "text" => $data['code'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['code'], "raw" => $data['code'], ],
            //"format" => "",
          ],
          [
            "text" => $data['description'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['description'], "raw" => $data['description'], ],
            //"format" => "",
          ],
          [
            "text" => $data['value'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['value'],  ],
            //"format" => "",
          ],
          [
            "text" => $data['default_value'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['default_value'],  ],
            //"format" => "",
          ],

          
          [
            "text" =>  $this->create_button($buttons), "classes" => ["text-center"],
            "attributes" => ["order" => '', "raw" => '',],
          ]
        ];
        $items[] = $temp;
        $html_rows .= DataTable::create_row($temp);
      }

      return [ 
        "columns" => $columns, 
        "html_header" => DataTable::create_header(['columns' => $columns]),
        "items" => $items, 
        "html_rows" => $html_rows,
        "extra_parameters" => $parameters  
      ];
    }

    public static function get_form($mode = "create"){
      $form = [
        "id" => "form_parameter",
        "fields" =>[
          ["type" => "hidden" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Description" , "id" => "description" , "name" => "description" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Code" , "id" => "code" , "name" => "code" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          /*
          ["type" => "datetime-local" , "label" => "Create Date" , "id" => "create_date" , "name" => "create_date" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => "Update Date" , "id" => "update_date" , "name" => "update_date" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          
          ["type" => "select" , "label" => "Create User Id" , "id" => "create_user_id" , "name" => "create_user_id" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "ProductType",
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
          ["type" => "textarea" , "label" => "Value" , "id" => "value" , "name" => "value" , 
            "attributes" => ["maxlength" => "255", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "textarea" , "label" => "Default Value" , "id" => "default_value" , "name" => "default_value" , 
            "attributes" => ["maxlength" => "255", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
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
                "data-object" => "parameter",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "parameter",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "parameter",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => json_encode(["title" => TranslationHelper::get_text("confirm_edit_title"), "html" => TranslationHelper::get_text("confirm_edit_text"), "icon" => "question"], true),
              ],
              "href" => "#",
              "required_permission" => ["parameter_edit"],
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
                "data-api" => "parameter",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => ["parameter_delete"],
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

    public static function get($code = null, $return_array = false){
      if ( !$code )
        return [];

      /*
      $Parameter = new self();
      $parameter = $Parameter->list(["code" => $code, "limit" => 1]);
      */

      $list = self::get_all();

      $parameter = array_filter($list, function($item) use ($code) {
        return $item['code'] == $code;
      });
      $parameter = array_values($parameter);
      
      if ( !$parameter )
        throw new NotFoundException("Parameter {$code} not found");

      if ( !$return_array )
        return $parameter[0]['value']; // return only value

      return $parameter[0];

    }

    public static function get_all(){
      if ( !self::$parameter_list ) {
        $Parameter = new Parameter();
        self::$parameter_list = $Parameter->list();
      }

      return self::$parameter_list;
    }
  } 