<?php

  Class Currency extends Base {
    
    // protected $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    protected $code; // type: varchar(45) null: NO Key: UNI default:  extra: 
    protected $name; // type: varchar(100) null: NO Key:  default:  extra: 
    protected $symbol; // type: varchar(10) null: NO Key:  default:  extra: 
    // protected $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // protected $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    protected $create_user_id; // type: int null: NO Key: MUL default:  extra: 
    protected $active;

    
    // public function get_id(){ return $this->id; } (moved to Base class)  
    // public function set_id($id){ $this->id = $id; return $this; } (moved to Base class)  
    public function get_code(){ return $this->code; } 
    public function set_code($code){ $this->code = $code; return $this; } 
    public function get_name(){ return $this->name; } 
    public function set_name($name){ $this->name = $name; return $this; } 
    public function get_symbol(){ return $this->symbol; } 
    public function set_symbol($symbol){ $this->symbol = $symbol; return $this; } 
    // public function get_create_date(){ return $this->create_date; } (moved to Base class)  
    // public function set_create_date($create_date){ $this->create_date = $create_date; return $this; } (moved to Base class)  
    // public function get_update_date(){ return $this->update_date; } (moved to Base class)  
    // public function set_update_date($update_date){ $this->update_date = $update_date; return $this; } (moved to Base class)  
    public function get_create_user_id(){ return $this->create_user_id; } 
    public function set_create_user_id($create_user_id){ $this->create_user_id = $create_user_id; return $this; } 

    public function get_active(){ return $this->active; } 
    public function set_active($active){ $this->active = $active; return $this; } 


    public function __construct(){
      $this->set__table_name("currency");
      $this->set__class_name("Currency");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = ["Id", "Code", "Name", "Symbol", "Create Date", "Update Date", "Create User Id", "Ações"];
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
            "text" => $data['name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['name'], "raw" => $data['name'], ],
            //"format" => "",
          ],
          [
            "text" => $data['symbol'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['symbol'], "raw" => $data['symbol'], ],
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
        "id" => "form_currency",
        "fields" =>[
          ["type" => "number" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Code" , "id" => "code" , "name" => "code" , 
            "attributes" => ["maxlength" => "45", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Name" , "id" => "name" , "name" => "name" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Symbol" , "id" => "symbol" , "name" => "symbol" , 
            "attributes" => ["maxlength" => "10", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => "Create Date" , "id" => "create_date" , "name" => "create_date" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "datetime-local" , "label" => "Update Date" , "id" => "update_date" , "name" => "update_date" , 
            "attributes" => ["maxlength" => "", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "number" , "label" => "Create User Id" , "id" => "create_user_id" , "name" => "create_user_id" , 
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
                "data-bs-target" => "#modal_form_currency",      
                "data-form_id" => "currency",                                
              ],
              "href" => "#",
              "required_permission" => "currency_edit",
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
                "data-bs-target" => "#modal_form_currency",                                      
              ],
              "href" => "#",
              "required_permission" => "currency_delete",
            ];
            break;
        }
      }

      if ( !$buttons )
        return "";
      
      return Helper::create_html_button_dropdown($buttons);

    }

  } 