<?php

  Class PermissionGroup extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra:  (moved to Base class) 
    public $name; // type: varchar(150) null: YES Key:  default:  extra: 
    // public $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // public $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    public $active; // type: tinyint null: YES Key:  default: 1 extra: 
    public $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    public $code; // type: varchar(100) null: NO Key: UNI default:  extra: 

    public function __construct(){
      $this->set__table_name("permission_group");
      $this->set__class_name("PermissionGroup");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = [ 
 				["text" => "Código", "classes" => "all"],  
 				["text" => "Nome", "classes" => "all"],  
 				["text" => "Ativo", "classes" => "none"],  
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
      foreach ( $list as $key => $data ){
        $buttons = ["data" => $data, "action" => ["edit", "delete"],];
         
        $temp = [     
          [
            "text" => $data['code'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['code'], "raw" => $data['code'], ],
            //"format" => "",
          ],
          [
            "text" => $data['name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['name'], "raw" => $data['name'], ],
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
      $Permission = new Permission();
      $permission_list = $Permission->list(["order" => "permission.code asc"]);
      $form = [
        "id" => "form_permission_group",
        "fields" =>[
          ["type" => "hidden" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],

          ["type" => "text" , "label" => "Código" , "id" => "code" , "name" => "code" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Descrição" , "id" => "name" , "name" => "name" , 
            "attributes" => ["maxlength" => "150", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          /*
          ["type" => "datetime-local" , "label" => "Create Date" , "id" => "create_date" , "name" => "create_date" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => "Update Date" , "id" => "update_date" , "name" => "update_date" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          */
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
          /*
          ["type" => "select" , "label" => "Create User Id" , "id" => "create_user_id" , "name" => "create_user_id" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", ], "emptyval" => "Selecione...", 
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
          */

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
              "class" => ["api", "bg-secondary", "text-white", "btn_edit", "text-dark", "btn", "btn-sm", "btn-xsm"], 
              "description" => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
              "type" => "link",
              "attributes" => [              
                "data-object" => "permission_group",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "permission_group",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "permission_group",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list_with_permission",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => "{\"title\": \"Editar: {$parameters['data']['id']} - {$parameters['data']['name']}?\", \"html\": \"O registro será alterado\", \"icon\": \"question\"}",
              ],
              "href" => "#",
              "required_permission" => "permission_group_edit",
            ];
            break;

          case  "delete":
            $buttons[] = [ 
              "class" => ["api","bg-secondary", "btn", "btn-sm", "btn-xsm", "btn_delete", "text-dark"], 
              "description" => '<i class="fa fa-trash-o" aria-hidden="true"></i>',
              "type" => "link",
              "attributes" => [
                "data-object" => get_class($this),
                "data-action" => "delete",
                "data-id" => $parameters['data']['id'],     
                "data-confirm" => "required",
                "data-confirm_parameters" => "{\"title\": \"Excluir: {$parameters['data']['id']} - {$parameters['data']['name']}?\", \"html\": \"Esta operação não poderá ser desfeita\", \"icon\": \"question\"}",
                "data-api" => "permission_group",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => "permission_group_delete",
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

    public function list_permissions($permission_group_id){
      $Crud = Crud::get_instance();;
      $sql = "SELECT DISTINCT
                permission.code
              
              FROM 
                permission_group 
                
              inner join permission_group_permission on
                permission_group_permission.permission_group_id = permission_group.id

              inner join permission on 
                permission.id = permission_group_permission.permission_id
                                  
              WHERE 
                permission_group_permission.permission_group_id = :permission_group_id

      ";

      $bind = [':permission_group_id' => $permission_group_id];

      return $Crud->execute_query($sql, $bind);
    }

  } 