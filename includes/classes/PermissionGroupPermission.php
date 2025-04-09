<?php

  Class PermissionGroupPermission extends Base {
    
    // protected $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $permission_group_id; // type: int null: NO Key: MUL default:  extra: 
    public $permission_id; // type: int null: NO Key: MUL default:  extra: 

    
    // public function get_id(){ return $this->id; } (moved to Base class)  
    // public function set_id($id){ $this->id = $id; return $this; } (moved to Base class)  
    public function get_permission_group_id(){ return $this->permission_group_id; } 
    public function set_permission_group_id($permission_group_id){ $this->permission_group_id = $permission_group_id; return $this; } 
    public function get_permission_id(){ return $this->permission_id; } 
    public function set_permission_id($permission_id){ $this->permission_id = $permission_id; return $this; } 


    public function __construct(){
      $this->set__table_name("permission_group_permission");
      $this->set__class_name("PermissionGroupPermission");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = ["Id", "Permission Group Id", "Permission Id", "Ações"];
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
            "text" => $data['permission_group_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['permission_group_id'], "raw" => $data['permission_group_id'], ],
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
        "id" => "form_permission_group_permission",
        "fields" =>[
          ["type" => "number" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "number" , "label" => "Permission Group Id" , "id" => "permission_group_id" , "name" => "permission_group_id" , 
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
                "data-object" => get_class($this),
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "data-modal_description" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-bs-toggle" => "modal",
                "data-bs-target" => "#modal_form_permission_group_permission",      
                "data-form_id" => "permission_group_permission",                                
              ],
              "href" => "#",
              "required_permission" => "permission_group_permission_edit",
            ];
            break;

          case  "delete":
            $buttons[] = [ 
              "class" => ["api", "dropdown-item", "btn_delete", "text-danger"], 
              "description" => Helper::get_icon(["icon" => "delete" ]) . " " . TranslationHelper::get_text(["code" => "generic_delete"]), 
              "type" => "link",
              "attributes" => [
                "data-object" => get_class($this),
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "data-object_info" => json_encode($parameters['data'], true),
                "data-modal_description" => TranslationHelper::get_text(["code" => "generic_delete"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-bs-toggle" => "modal",
                "data-bs-target" => "#modal_form_permission_group_permission",                                      
              ],
              "href" => "#",
              "required_permission" => "permission_group_permission_delete",
            ];
            break;
        }
      }

      if ( !$buttons )
        return "";
      
      return Helper::create_html_button_dropdown($buttons);

    }

    public function clear_permission_group_permissions($permission_group_id = null){
      if ( !$permission_group_id )
        throw new Exception("Permission Group Id not found, cannot clear permissions");

      $Crud = Crud::get_instance();;
      $data = $this->list(["permission_group_id" => $permission_group_id,]);
    
      if ( !$data )
        return false;

      $Crud = Crud::get_instance();;
      return $this->_Crud->delete($table = $this->get__table_name(), $where = "permission_group_id = :permission_group_id", $bind = [ ":permission_group_id" => $permission_group_id ]);
    }

  } 