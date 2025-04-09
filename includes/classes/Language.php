<?php

  Class Language extends Base {
    
    // protected $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    protected $code; // type: varchar(10) null: NO Key: UNI default:  extra: 
    protected $description; // type: varchar(250) null: NO Key:  default:  extra: 
    protected $texts; // type: json null: NO Key:  default:  extra: 
    protected $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    // protected $create_date; // type: datetime null: YES Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // protected $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    protected $active; // type: tinyint(1) null: YES Key:  default:  extra: 

    
    // public function get_id(){ return $this->id; } (moved to Base class)  
    // public function set_id($id){ $this->id = $id; return $this; } (moved to Base class)  
    public function get_code(){ return $this->code; } 
    public function set_code($code){ $this->code = $code; return $this; } 
    public function get_description(){ return $this->description; } 
    public function set_description($description){ $this->description = $description; return $this; } 
    public function get_texts(){ return $this->texts; } 
    public function set_texts($texts){ $this->texts = $texts; return $this; } 
    public function get_create_user_id(){ return $this->create_user_id; } 
    public function set_create_user_id($create_user_id){ $this->create_user_id = $create_user_id; return $this; } 
    // public function get_create_date(){ return $this->create_date; } (moved to Base class)  
    // public function set_create_date($create_date){ $this->create_date = $create_date; return $this; } (moved to Base class)  
    // public function get_update_date(){ return $this->update_date; } (moved to Base class)  
    // public function set_update_date($update_date){ $this->update_date = $update_date; return $this; } (moved to Base class)  
    public function get_active(){ return $this->active; } 
    public function set_active($active){ $this->active = $active; return $this; } 


    public function __construct(){
      $this->set__table_name("language");
      $this->set__class_name("Language");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = ["Id", "Code", "Description", "Texts", "Create User Id", "Create Date", "Update Date", "Active", "Ações"];
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
            "text" => $data['texts'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['texts'], "raw" => $data['texts'], ],
            //"format" => "",
          ],
          [
            "text" => $data['create_user_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_user_id'], "raw" => $data['create_user_id'], ],
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

      return [ "columns" => $columns, "items" => $items ];
    }

    public static function get_form(){
      return [
        "id" => "form_language",
        "fields" =>[
          ["type" => "number" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Code" , "id" => "code" , "name" => "code" , 
            "attributes" => ["maxlength" => "10", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "textarea" , "label" => "Description" , "id" => "description" , "name" => "description" , 
            "attributes" => ["maxlength" => "250", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "textarea" , "label" => "Texts" , "id" => "texts" , "name" => "texts" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "number" , "label" => "Create User Id" , "id" => "create_user_id" , "name" => "create_user_id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "datetime-local" , "label" => "Create Date" , "id" => "create_date" , "name" => "create_date" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "datetime-local" , "label" => "Update Date" , "id" => "update_date" , "name" => "update_date" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "text" , "label" => "Active" , "id" => "active" , "name" => "active" , 
            "attributes" => ["maxlength" => "1", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
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
                "data-bs-target" => "#modal_form_language",      
                "data-form_id" => "language",                                
              ],
              "href" => "#",
              "required_permission" => "language_edit",
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
                "data-bs-target" => "#modal_form_language",                                      
              ],
              "href" => "#",
              "required_permission" => "language_delete",
            ];
            break;
        }
      }

      if ( !$buttons )
        return "";
      
      return Helper::create_html_button_dropdown($buttons);

    }

  } 