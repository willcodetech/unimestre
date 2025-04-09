<?php

  Class File extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $description; // type: varchar(200) null: NO Key:  default:  extra: 
    // public $create_date; // type: datetime null: YES Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    public $create_user_id; // type: int null: YES Key: MUL default:  extra: 
    public $original_name; // type: varchar(200) null: YES Key:  default:  extra: 
    public $size; // type: decimal(10,0) null: YES Key:  default:  extra: 
    public $object; // type: varchar(100) null: YES Key:  default:  extra: 
    public $extension; // type: varchar(15) null: YES Key:  default:  extra: 
    public $mime_type; // type: varchar(100) null: YES Key:  default:  extra: 
    public $name; // type: varchar(100) null: YES Key:  default:  extra: 
    public $register_id; // type: int null: YES Key:  default:  extra: 
    public $path; // type: text null: YES Key:  default:  extra: 
    public $hash; // type: varchar(200) null: YES Key: UNI default:  extra: 
    public $type; // type: varchar(20) null: YES Key:  default:  extra: 

    


    public function __construct(){
      $this->set__table_name("file");
      $this->set__class_name("File");
      parent::__construct();
      
    }

    public function to_datatable($list, $summary = false){
      if ( $summary )
        return $this->to_datatable_related_object($list);

      $return = [];
      $columns = [ 
 				["text" => "Id", "classes" => "all"],  
        ["text" => "Arquivo", "classes" => "all"],  
 				["text" => "Descrição", "classes" => "all"],  
 				["text" => "Create Date", "classes" => "none"],  
 				["text" => "Create User Id", "classes" => "none"],  
 				["text" => "Nome Original", "classes" => "all"],  
 				["text" => "Tamanho", "classes" => "all"],  
 				["text" => "Object", "classes" => "all"],  
 				["text" => "Extensão", "classes" => "all"],  
 				["text" => "Mime Type", "classes" => "none"],  
 				["text" => "Nome", "classes" => "none"],  
 				["text" => "Id do Registro", "classes" => "all"],  
 				["text" => "Path", "classes" => "none"],  
 				["text" => "Hash", "classes" => "none"],  
 				["text" => "Type", "classes" => "none"], 
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
        $buttons = ["data" => $data, "action" => ["delete", "open", "download"],];
        $link = "/api/?api=file&action=get&hash={$data['hash']}";
        if ( $data['group_name'] == "image" ){
          $link = "<a href='{$link}' target='_blank' ><img src='{$link}' width='26' height='26' class='thumbnail' loading='lazy' ></a>";

        }else {
          $link = "<a href='{$link}' target='_blank' ><i class='icon icon-doc'></i></a>";
        }
        $temp = [     
          /*
          [
            "text" => $data['record'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['record'], "raw" => $data['record'],],
            //"format" => "cnpj",
          ],
          */
          
          [
            "text" => $data['id'], "classes" => ["text-center"],
            "attributes" => [ "order" => $data['id'], "raw" => $data['id'], ],
            //"format" => "",
          ],
          [
            "text" => $link, "classes" => ["text-center"],
            "attributes" => [ "order" => $data['id'], "raw" => $data['id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['description'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['description'], "raw" => $data['description'], ],
            //"format" => "",
          ],
          [
            "text" => $data['create_date'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_date'], "raw" => $data['create_date'], ],
            "format" => "date",
          ],
          [
            "text" => $data['create_user_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_user_id'], "raw" => $data['create_user_id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['original_name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['original_name'], "raw" => $data['original_name'], ],
            //"format" => "",
          ],
          [
            "text" => Helper::convert_bytes($data['size']) . " MB", "classes" => ["text-right"],
            "attributes" => [ "order" => $data['size'], "raw" => $data['size'], ],
            //"format" => "",
          ],
          [
            "text" => $data['object'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['object'], "raw" => $data['object'], ],
            //"format" => "",
          ],
          [
            "text" => $data['extension'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['extension'], "raw" => $data['extension'], ],
            //"format" => "",
          ],
          [
            "text" => $data['mime_type'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['mime_type'], "raw" => $data['mime_type'], ],
            //"format" => "",
          ],
          [
            "text" => $data['name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['name'], "raw" => $data['name'], ],
            //"format" => "",
          ],
          [
            "text" => $data['register_id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['register_id'], "raw" => $data['register_id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['path'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['path'], "raw" => $data['path'], ],
            //"format" => "",
          ],
          [
            "text" => $data['hash'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['hash'], "raw" => $data['hash'], ],
            //"format" => "",
          ],
          [
            "text" => $data['type'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['type'], "raw" => $data['type'], ],
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
        "id" => "form_file",
        "fields" =>[
          ["type" => "hidden" , "label" => "Id" , "id" => "id" , "name" => "id" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => "Descrição" , "id" => "description" , "name" => "description" , 
            "attributes" => ["maxlength" => "200", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          /*
          ["type" => "select" , "label" => "Create User Id" , "id" => "create_user_id" , "name" => "create_user_id" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", "ajax_datasetselect_ajax_dataset" ], "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "User",
              "s_token" => HELPER_SELECT2_TOKEN,
              "key_value" => "id",
              "key_text" => "description",
              "concat" => [ "id", "name"],
              "search_field" => "name_ct",
              "related_fields" => [                  
                //"current_form_field" => "suffix_filter", // example            
              ]
            ]
        
          , ] ,],
          */
          
          ["type" => "text" , "label" => "Object" , "id" => "object" , "name" => "Objeto Relacionado" , 
            "attributes" => ["maxlength" => "100", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "number" , "label" => "Id do Relacionamento" , "id" => "register_id" , "name" => "register_id" , 
            "attributes" => ["placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "text" , "label" => "Tipo" , "id" => "type" , "name" => "type" , 
            "attributes" => ["maxlength" => "20", "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          [
            "id" => "file", "name" => "file", "type" => "file_drag", "label" => "Arquivo",
            "required" => true,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "dropzones" ],
            "attributes" => ["classes" => ["input_image_preview"], "multiple" => true ]
          ]

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

        case "edit":
          $required_fields = [ "id", ];
          $readonly_fields = [ "id", "original_name", "name",];
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 1, ]
          ];
          /*
          $form['fields'][] = [
            "id" => "verify_token", "name" => "verify_token", "type" => "hidden", "label" => "Token",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "hide_field"],
            "attributes" => ["minlength" => 1, "value" => ""]
          ];
          */

          foreach ( $form['fields'] as $key => $field ){
            if ( !in_array($field['name'] , $required_fields) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $readonly_fields) )
              $form['fields'][$key]['attributes']['readonly'] = "readonly";

          }
          if ( isset($form['groups']) ){
            foreach ( $form['groups'] as $key => $data ) {
              if ( $data['name'] == "permission" ){
                unset($form['groups'][$key]);
              }
            }
          }
          break;

        case "attachment":
          $required_fields = [ "id", "file", "object", "type", "register_id",];
          $hidden_fields = [ "id", "original_name", "name", "object", "type", "register_id"];
          
          $form['fields'][] = [
            "id" => "id", "name" => "id", "type" => "hidden", "label" => "Id",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 1, ]
          ];
          $form['fields'][] = [
            "id" => "object", "name" => "object", "type" => "hidden", "label" => "Objeto Relacionado",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", ],
            "attributes" => ["minlength" => 1, ]
          ];
          /*
          $form['fields'][] = [
            "id" => "verify_token", "name" => "verify_token", "type" => "hidden", "label" => "Token",
            "required" => true ,
            "classes" => [ "form-control", "input-sm", "text-left", "limpar", "form-control-sm", "hide_field"],
            "attributes" => ["minlength" => 1, "value" => ""]
          ];
          */

          foreach ( $form['fields'] as $key => $field ){
            if ( !in_array($field['name'] , $required_fields) )
              unset($form['fields'][$key]);

            if ( in_array($field['name'], $hidden_fields) )
              $form['fields'][$key]['type'] = "hidden";

          }
          if ( isset($form['groups']) ){
            foreach ( $form['groups'] as $key => $data ) {
              if ( $data['name'] == "permission" ){
                unset($form['groups'][$key]);
              }
            }
          }

          $form['fields'][] = [
            "type" => "text" , "label" => "Descrição <!-- <small class='text-danger'>se preenchido, todos arquivos terão o mesmo texto, caso contrário um nome genérico será gerado</small> -->" , "id" => "description" , "name" => "description" , 
            "attributes" => ["maxlength" => "200", "placeholder" => "", "class" => ["form-control", "input-sm", ], "minlength" => "1", ] ,
          ];
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
                "data-object" => "file",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "file",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "file",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "list",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
              ],
              "href" => "#",
              "required_permission" => "file_edit",
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
                "data-api" => "file",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => "file_delete",
            ];
            break;

          case "open":
            $buttons[] = [ 
              "class" => ["api", "dropdown-item", "btn_open_file", "text-info"], 
              "description" => "Open " , 
              "type" => "link",
              "href" => "/api/?api=file&action=get&hash={$parameters['data']['hash']}",
              "attributes" => [
                "target" => "_blank"
              ],
              "required_permission" => "file_list",
            ];
            break;
            
          case "download":
              $buttons[] = [ 
                "class" => ["api", "dropdown-item", "btn_open_file", "text-info"], 
                "description" => "Download", 
                "type" => "link",
                "href" => "/api/?api=file&action=get&hash={$parameters['data']['hash']}&download=true",
                "attributes" => [
                  "target" => "_blank"
                ],
                "required_permission" => "file_list",
              ];
              break;
        }
      }

      if ( !$buttons )
        return "";
      
      return Helper::create_html_button_dropdown($buttons);

    }

    public function create_file_OLD($parameters = [] ){
      $FileMimeType = new FileMimeType();
      
      if ( !isset($_FILES) || empty($_FILES) )
        throw new NotFoundException("File not received");

      foreach ( $_FILES as $key => $file ){
        if ( $file['error'] ){
          throw new NotFoundException("Upload failed error code: {$file['error']}");
        }
          
      }
      
      //$base_path =  "/var/www/html/SYSTEM_HOST/storage/";
      $base_path = STORAGE_DIR;

      $relative_path = "";
      // object referenced, you must write to the specific folder
      if ( isset($parameters['object']) && !empty($parameters['object']) ){
        $relative_path .= strtolower(trim($parameters['object'])) . "/";

        // id referenced, you must write to the specific folder
        if ( isset($parameters['register_id']) && !empty($parameters['register_id']) ){
          $relative_path .= strtolower(trim($parameters['register_id'])) . "/";
        }
      }
      
      // generates the random file name without extension (for security reasons)
      $file_name = date("Y-m-d_h-m") . "_" . Helper::random_str(25);
      $file_path  = $base_path . $relative_path . $file_name;
      
      $identified_mime = mime_content_type($_FILES['file']['tmp_name']);

      $valid_mime = $FileMimeType->list(array("mime_type" => $identified_mime, "active" => 1) );

      // If the mime type identified by the php registered in the bank does not exist, prevent the upload
      if ( !$valid_mime ){
        throw new NotFoundException("The mime type of the file was not found in the database. Upload denied for security reasons");
      }

      $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

      // checks if there is a record with the specified extension for the identified mime type
      if ( !Helper::search_sub_array($valid_mime, "extension", $ext) ){
        throw new Exception("Extension {$ext} does not match the identified Mime Type: {$identified_mime} r\n Upload denied for security reasons");
      }                        

      $allowed_extension = $FileMimeType->list(array("extension" => $ext, "mime_type" => $identified_mime, "allow_upload" => 1, "active" => 1) );

      if ( !$allowed_extension ){
        throw new NotFoundException("{$ext} extension not allowed");
      }
      
      $write_path = $base_path . $relative_path;
      // If the destination folder does not exist, create it
      if ( !file_exists($write_path) ){
        $old = umask(0);
        mkdir($write_path, 0775, true);
        umask($old);
      }

      if ( !move_uploaded_file($_FILES['file']['tmp_name'], $file_path) ){
        throw new Exception("Failed to move temporary file to storage");
      }

      $file_data = [
        "description" => $parameters['description'] ?? date("Y-m-d") . "_uploaded_file",
        "name" => $file_name,
        "extension" => $ext,
        "original_name" => $_FILES['file']['name'],
        "size" => $_FILES['file']['size'],
        "mime_type" => $identified_mime,
        "register_id" => ( isset($parameters['register_id']) && !empty($parameters['register_id']) ? $parameters['register_id'] : null ),
        "object" => ( isset($parameters['object']) && !empty($parameters['object']) ? $parameters['object'] : null ),
        "path" => $relative_path . $file_name ,
        "type" => ( isset($parameters['type']) && !empty($parameters['type']) ? $parameters['type'] : null ),

      ];

      $File = new File();
      $hash = base64_encode($file_name);
      $File->to_object($file_data);
      //$File->setID_USUARIO_INCLUSAO($ID_USUARIO_LOGADO);
      $File->hash = $hash;
      
      $created = $File->create();
      if ( !$created )
        throw new Exception("Failed to upload, unable to register the file");
    
      return [ 
        "id" => $created,
        "hash" => $hash, 
        "url" => "/api/?api=file&action=get&hash={$hash}",
      ];

    }


    public function create_file($parameters = [] ){
      $FileMimeType = new FileMimeType();
      
      if ( !isset($_FILES) || empty($_FILES) )
        throw new NotFoundException("File not received");

      $return = [];
      foreach ( $_FILES as $key => $file ){

        //throw new Exception(json_encode($file, true));
        if ( $file['error'] ){
          throw new NotFoundException("Upload failed error code: {$file['error']}");
        }
          
        //$base_path =  "/var/www/html/SYSTEM_HOST/storage/";
        $base_path = STORAGE_DIR;

        $relative_path = "";
        // object referenced, you must write to the specific folder
        if ( isset($parameters['object']) && !empty($parameters['object']) ){
          $relative_path .= strtolower(trim($parameters['object'])) . "/";

          // id referenced, you must write to the specific folder
          if ( isset($parameters['register_id']) && !empty($parameters['register_id']) ){
            $relative_path .= strtolower(trim($parameters['register_id'])) . "/";
          }
        }
        
        // generates the random file name without extension (for security reasons)
        $file_name = date("Y-m-d_h-m") . "_" . Helper::random_str(25);
        $file_path  = $base_path . $relative_path . $file_name;
        
        $identified_mime = mime_content_type($file['tmp_name']);

        $valid_mime = $FileMimeType->list(array("mime_type" => $identified_mime, "active" => 1) );

        // If the mime type identified by the php registered in the bank does not exist, prevent the upload
        if ( !$valid_mime ){
          throw new NotFoundException("The mime type of the file was not found in the database. Upload denied for security reasons");
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        // checks if there is a record with the specified extension for the identified mime type
        if ( !Helper::search_sub_array($valid_mime, "extension", $ext) ){
          throw new Exception("Extension {$ext} does not match the identified Mime Type: {$identified_mime} r\n Upload denied for security reasons");
        }                        

        $allowed_extension = $FileMimeType->list(array("extension" => $ext, "mime_type" => $identified_mime, "allow_upload" => 1, "active" => 1) );

        if ( !$allowed_extension ){
          throw new NotFoundException("{$ext} extension not allowed");
        }
        
        $write_path = $base_path . $relative_path;
        // If the destination folder does not exist, create it
        if ( !file_exists($write_path) ){
          $old = umask(0);
          mkdir($write_path, 0775, true);
          umask($old);
        }

        /**/
        // Comprimir imagem se for JPEG
        if ($ext === 'jpg' || $ext === 'jpeg') {
          $source = imagecreatefromjpeg($file['tmp_name']);
          imagejpeg($source, $file['tmp_name'], 70); // 75 é a qualidade da imagem, você pode ajustar conforme necessário
          imagedestroy($source);
        }
        

        if ( !move_uploaded_file($file['tmp_name'], $file_path) ){
          throw new Exception("Failed to move temporary file to storage");
        }

        $file_data = [
          //"description" => $parameters['description'] ?? date("Y-m-d") . "_uploaded_file",
          "description" => $parameters['description'] ?? $file['name'],
          "name" => $file_name,
          "extension" => $ext,
          "original_name" => $file['name'],
          "size" => $file['size'],
          "mime_type" => $identified_mime,
          "register_id" => ( isset($parameters['register_id']) && !empty($parameters['register_id']) ? $parameters['register_id'] : null ),
          "object" => ( isset($parameters['object']) && !empty($parameters['object']) ? $parameters['object'] : null ),
          "path" => $relative_path . $file_name ,
          "type" => ( isset($parameters['type']) && !empty($parameters['type']) ? $parameters['type'] : null ),

        ];

        $File = new File();
        $hash = base64_encode($file_name);
        $File->to_object($file_data);
        //$File->setID_USUARIO_INCLUSAO($ID_USUARIO_LOGADO);
        $File->hash = $hash;
        
        $created = $File->create();
        if ( !$created )
          throw new Exception("Failed to upload, unable to register the file");
      
        $return[] = [ 
          "id" => $created,
          "hash" => $hash, 
          "url" => "/api/?api=file&action=get&hash={$hash}",
        ];
        

      }
      
      return $return;
      
    }

    public function destroy($file_id){
      if ( !$file_id )
        throw new Exception("File not specified");

      $file = $this->list(['id' => $file_id ]);
      if ( !$file )
        throw new NotFoundException("File id {$id} not found");

      if ( !file_exists(STORAGE_DIR . $file[0]['path']) )
        throw new NotFoundException("File id: {$id} does not exist in storage ");

      $file_pointer = STORAGE_DIR . $file[0]['path'];
      if (!unlink($file_pointer))  
        throw new Exception("File name: {$file[0]['name']} cannot be deleted due to an error"); 

      $this->delete($file_id);

      return true;

    }

    public function to_datatable_related_object($list){
      $return = [];
      $columns = [ 
        ["text" => "Arquivo", "classes" => "all"],  
 				["text" => "Descrição", "classes" => "all"],  
 				//["text" => "Nome", "classes" => "all"],  
 				["text" => "Tamanho", "classes" => "all"],  
 				["text" => "Extensão", "classes" => "all"],  
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
        $buttons = ["data" => $data, "action" => ["delete", "open", "download"],];
         

        $link = "/api/?api=file&action=get&hash={$data['hash']}";
        if ( $data['group_name'] == "image" ){
          $link = "<a href='{$link}' target='_blank' ><img src='{$link}' width='26' height='26' class='thumbnail' loading='lazy' ></a>";

        }else {
          $link = "<a href='{$link}' target='_blank' ><i class='icon icon-doc'></i></a>";
        }
        $temp = [    
          [
            "text" => $link, "classes" => ["text-center"],
            "attributes" => [ "order" => $data['description'], "raw" => $data['description'], ],
            //"format" => "",
          ], 
          [
            "text" => $data['description'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['description'], "raw" => $data['description'], ],
            //"format" => "",
          ],
          /*
          [
            "text" => $data['original_name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['original_name'], "raw" => $data['original_name'], ],
            //"format" => "",
          ],
          */
          [
            "text" => Helper::convert_bytes($data['size']) . " MB", "classes" => ["text-right"],
            "attributes" => [ "order" => $data['size'], "raw" => $data['size'], ],
            //"format" => "",
          ],
          [
            "text" => $data['extension'], "classes" => ["text-center"],
            "attributes" => [ "order" => $data['extension'], "raw" => $data['extension'], ],
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

    public function to_datatable_summary_checkbox($list){
      $return = [];
      $columns = [ 
        ["text" => "Arquivo", "classes" => "all"],  
 				["text" => "Descrição", "classes" => "all"],  
 				//["text" => "Nome", "classes" => "all"],  
 				["text" => "Tamanho", "classes" => "all"],  
 				["text" => "Extensão", "classes" => "all"],  
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
        $buttons = ["data" => $data, "action" => ["delete", "open", "download"],];
         

        $checkbox = "<input type='checkbox' name='file[{$data['id']}]' class=' input-sm' data-file_id='{$data['id']}' data-file_object='{$data['object']}' data-file_register_id='{$data['register_id']}' >";
        $link = "/api/?api=file&action=get&hash={$data['hash']}";
        if ( $data['group_name'] == "image" ){
          $link = "<a href='{$link}' target='_blank' ><img src='{$link}' width='26' height='26' class='thumbnail' loading='lazy' ></a>";

        }else {
          $link = "<a href='{$link}' target='_blank' ><i class='icon icon-doc'></i></a>";
        }
        $temp = [    
          [
            "text" => $link, "classes" => ["text-center"],
            "attributes" => [ "order" => $data['description'], "raw" => $data['description'], ],
            //"format" => "",
          ], 
          [
            "text" => $data['description'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['description'], "raw" => $data['description'], ],
            //"format" => "",
          ],
          /*
          [
            "text" => $data['original_name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['original_name'], "raw" => $data['original_name'], ],
            //"format" => "",
          ],
          */
          [
            "text" => Helper::convert_bytes($data['size']) . " MB", "classes" => ["text-right"],
            "attributes" => [ "order" => $data['size'], "raw" => $data['size'], ],
            //"format" => "",
          ],
          [
            "text" => $data['extension'], "classes" => ["text-center"],
            "attributes" => [ "order" => $data['extension'], "raw" => $data['extension'], ],
            //"format" => "",
          ],          
          [
            "text" =>  $checkbox, "classes" => ["text-center"],
            "attributes" => ["order" => '', "raw" => '',],
          ]
        ];
        $items[] = $temp;
      }

      return [ "columns" => $columns, "items" => $items, "extra_parameters" => $parameters  ];
    }

    public function list_details($filters = []){
      $Crud = Crud::get_instance();;
      $sql = "  SELECT
                  file.*
                  , file.description label
                  , user.name user_name
                  , file_mime_type.group_name
                  
                FROM
                  file 
                  
                inner join file_mime_type on 
                  file_mime_type.mime_type = file.mime_type
                  and file_mime_type.extension = file.extension

                left join user on
                  user.id = file.create_user_id 

                where 
                  1

      ";

      $bind = [];      
     
      if ( $filters ){
        $sql_filter = $this->create_sql_filter($filters);
        $sql .= $sql_filter["where"];
        $bind = $sql_filter["bind"];
      }
      if ( !Auth::is_admin() ){
        //$filters['user_id'] = @Auth::get_auth_info()['user_id']; // set current user id to prevent listing another user data
        //$sql .= "\r\n AND investment_plan.user_id = :current_user ";
        //$bind[':current_user'] = @Auth::get_auth_info()['user_id'];
      }

      return $Crud->execute_query($sql, $bind);
    }
  } 