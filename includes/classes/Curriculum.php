<?php

  Class Curriculum extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    // public $create_date; // type: datetime null: NO Key:  default: CURRENT_TIMESTAMP extra: DEFAULT_GENERATED (moved to Base class) 
    // public $update_date; // type: datetime null: YES Key:  default:  extra:  (moved to Base class) 
    public $create_user_id; // type: int null: NO Key:  default:  extra: 
    public $user_id; // type: int null: NO Key: UNI default:  extra: 
    public $cpf; // type: varchar(11) null: NO Key: UNI default:  extra: 
    public $birth_date; // type: date null: NO Key:  default:  extra: 
    public $gender_id; // type: int null: NO Key: MUL default:  extra: 
    public $marital_status_id; // type: int null: NO Key:  default:  extra: 
    public $education_id; // type: int null: NO Key:  default:  extra: 
    public $courses; // type: json null: YES Key:  default:  extra: 
    public $experiences; // type: json null: YES Key:  default:  extra: 
    public $salary_claim; // type: decimal(10,2) null: YES Key:  default: 0.00 extra: 

    


    public function __construct(){
      $this->set__table_name("curriculum");
      $this->set__class_name("Curriculum");
      parent::__construct();
      
    }

    public function to_datatable($list){
      $return = [];
      $columns = [ 
 				["text" => TranslationHelper::get_text("generic_id"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_create_date"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_update_date"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_create_user_id"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_user_name"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_cpf"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_age"), "classes" => "all"],  
        ["text" => TranslationHelper::get_text("generic_birth_date"), "classes" => "none"],  
 				["text" => TranslationHelper::get_text("generic_gender"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_marital_status"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_education"), "classes" => "all"],  
 				["text" => TranslationHelper::get_text("generic_salary_claim"), "classes" => "all"], 
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

      $values = self::calculate_values(['data' => $list, 'field' => 'salary_claim' ]);
      $avg_value = $values['avg'];
      
      $html_rows = "";
      foreach ( $list as $key => $data ){
        $buttons = ["data" => $data, "action" => ["edit", "delete"], "is_dropdown" => []];
        $salary_class = "";
        if ( $data['salary_claim'] > $avg_value )
          $salary_class = "text-info";

        if (  $data['salary_claim'] < $avg_value)
          $salary_class = "text-success";
        $link_details = "<a class='btn btn-sm btn-info' href='/curriculum/detail/?id={$data['id']}' target='_blank' title='detalhes'>
          <i class=\"fa fa-eye\" aria-hidden=\"true\"></i>
        </a>";
        $temp = [     
          /*
          [
            "text" => $data['record'], "classes" => ["text-left"],
            "attributes" => [ "data-order" => $data['record'], "data-raw" => $data['record'],],
            //"format" => "cnpj",
          ],
          */
          
          [
            "text" => $data['id'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['id'], "raw" => $data['id'], ],
            //"format" => "",
          ],
          [
            "text" => $data['create_date'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_date'], "raw" => $data['create_date'], ],
            "format" => "date_time",  "format_options" => ["date_format" => "d/m/Y", "time_format" => "H:i" ]
          ],
          [
            "text" => $data['update_date'], "classes" => ["text-left"],
            "format" => "date_time",  "format_options" => ["date_format" => "d/m/Y", "time_format" => "H:i" ]
            //"format" => "",
          ],
          [
            "text" => $data['create_user_name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['create_user_name'], "raw" => $data['create_user_name'], ],
            //"format" => "",
          ],
          [
            "text" => $data['user_name'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['user_name'], "raw" => $data['user_name'], ],
            //"format" => "",
          ],
          [
            "text" => $data['cpf'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['cpf'], "raw" => $data['cpf'], ],
            "format" => "cpf",
          ],
          [
            "text" => self::calculate_year($data['birth_date']),"classes" => ["text-right"],
            "attributes" => [ "order" => self::calculate_year($data['birth_date']), "raw" => self::calculate_year($data['birth_date']), ],
            
          ],
          [
            "text" => $data['birth_date'], "classes" => ["text-center"],
            "attributes" => [ "order" => $data['birth_date'], "raw" => $data['birth_date'], ],
            "format" => "date",  "format_options" => ["date_format" => "d/m/Y"]
          ],
          [
            "text" => $data['gender_description'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['gender_description'], "raw" => $data['gender_description'], ],
            //"format" => "",
          ],
          [
            "text" => $data['marital_status_description'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['marital_status_description'], "raw" => $data['marital_status_description'], ],
            //"format" => "",
          ],
          [
            "text" => $data['education_description'], "classes" => ["text-left"],
            "attributes" => [ "order" => $data['education_description'], "raw" => $data['education_description'], ],
            //"format" => "",
          ],
          [
            "text" => $data['salary_claim'], "classes" => ["text-right", $salary_class],
            "attributes" => [ "order" => $data['salary_claim'], "raw" => $data['salary_claim'], ],
            "format" => "number_br",
          ],

          
          [
            "text" =>  $this->create_button($buttons) . " " . $link_details, "classes" => ["text-center"],
            "attributes" => ["data-order" => '', "data-raw" => '',],
          ]
        ];
        $items[] = $temp;
        $html_rows .= DataTable::create_row($temp);
      }

      $parameters['custom_html'] = "
        <div class='row'>
          <div class='d-flex justify-content-end'>
          <br>
            <table class='table table-sm table-condensed'>
              <tr>
                <th class='text-right'>Total:</th>
                <td class='text-right'>R$ ". Helper::format("number_br", $values['sum']) . "</td>
              </tr>
              <tr>
                <th class='text-right'>Média:</th>
                <td class='text-right'>R$ ". Helper::format("number_br", $avg_value ) . "</td>
              </tr>
            </table>
          </div>
        </div>
      ";
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
        "id" => "form_curriculum",
        "fields" =>[
          ["type" => "hidden" , "label" => TranslationHelper::get_text("generic_id") , "id" => "id" , "name" => "id" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_cpf"), "id" => "cpf" , "name" => "cpf" , 
            "required" => true,
            "attributes" => ["maxlength" => "14", "minlenght" => "11", "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", "placeholder" => "Somente Números",
            "data-type" => "cpf"] ,
          ],
          ["type" => "date" , "label" => TranslationHelper::get_text("generic_birth_date") , "id" => "birth_date" , "name" => "birth_date" , 
            "required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], "required" => "1", "minlength" => "1", ] ,
          ],
          ["type" => "text" , "label" => TranslationHelper::get_text("generic_salary_claim") , "id" => "salary_claim" , "name" => "salary_claim" , 
            "required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "masked_value", "text-right" ], 
            "oninput" => "format_number_local(this);",  "data-mask-type" => "currency"
            ] ,
          ],
          ["type" => "select" , "label" => TranslationHelper::get_text("generic_gender"), "id" => "gender_id" , "name" => "gender_id" , 
            "required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "required" => "1", "minlength" => "1", "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "Gender",
              "s_token" => HELPER_SELECT2_TOKEN,
              "key_value" => "id",
              "key_text" => "description",
              //"concat" => [ "id", "name"],
              "search_field" => "description_ct",
              "related_fields" => [                  
                //"current_form_field" => "suffix_filter", // example            
              ],
              "related_fields_required" => [ // fields specified here cant be empty on form
                //"service_type_id"
              ],
              "query_filters" => [], // aditional filters to returned list
            ]
        
          , ] ,
          ],

          ["type" => "select" , "label" => TranslationHelper::get_text("generic_marital_status"), "id" => "marital_status_id" , "name" => "marital_status_id" , 
            "required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "required" => "1", "minlength" => "1", "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "MaritalStatus",
              "s_token" => HELPER_SELECT2_TOKEN,
              "key_value" => "id",
              "key_text" => "description",
              //"concat" => [ "id", "name"],
              "search_field" => "description_ct",
              "related_fields" => [                  
                //"current_form_field" => "suffix_filter", // example            
              ],
              "related_fields_required" => [ // fields specified here cant be empty on form
                //"service_type_id"
              ],
              "query_filters" => [], // aditional filters to returned list
            ]
        
          , ] ,
          ],

          ["type" => "select" , "label" => TranslationHelper::get_text("generic_education"), "id" => "education_id" , "name" => "education_id" , 
            "required" => true,
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", "select_ajax_dataset" ], "required" => "1", "minlength" => "1", "emptyval" => "Selecione...", 
            "data-select2_parameters" => [
              "data_source_object" => "Education",
              "s_token" => HELPER_SELECT2_TOKEN,
              "key_value" => "id",
              "key_text" => "description",
              //"concat" => [ "id", "name"],
              "search_field" => "description_ct",
              "related_fields" => [                  
                //"current_form_field" => "suffix_filter", // example            
              ],
              "related_fields_required" => [ // fields specified here cant be empty on form
                //"service_type_id"
              ],
              "query_filters" => [], // aditional filters to returned list
            ]
        
          , ] ,
          ],
          /*
          ["type" => "textarea" , "label" => TranslationHelper::get_text("generic_courses"), "id" => "courses" , "name" => "courses" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          ["type" => "textarea" , "label" => TranslationHelper::get_text("generic_experiences") , "id" => "experiences" , "name" => "experiences" , 
            "attributes" => [ "placeholder" => "", "class" => ["form-control", "input-sm", ], ] ,
          ],
          */

        ]
      ];
      $max_items = 3;
      $course_lines = "";
      $experiences_lines = "";
      for ( $index = 1; $index <= $max_items; $index++ ){       

        $course_lines .= "
          <tr>
            <td class='text-center'>
              <input type='text' name='courses[{$index}][name]' id='courses[{$index}][name]' class='form-control-sm  form-control' data-dborigin='courses[{$index}][name]' >
            </td>
            <td class='text-center'>
              <input type='text' name='courses[{$index}][institution]' id='courses[{$index}][institution]' class='form-control-sm  form-control' data-dborigin='courses[{$index}][institution]' >
            </td>
            <td class='text-center'>
              <input type='date' name='courses[{$index}][date_start]' id='courses[{$index}][date_start]' min='{$min_date}' value='' class='form-control-sm  form-control' data-dborigin='courses[{$index}][date_start]' >
            </td>
            <td class='text-center'>
              <input type='date' name='courses[{$index}][date_end]' id='courses[{$index}][date_end]' class='form-control-sm  form-control' data-dborigin='courses[{$index}][date_end]' >
            </td>
          </tr>
        ";

        $experiences_lines .= "
          <div class='row'>
            <div class='form-group  col-sm-12 col-md-6 col-lg-6 '>
              <label class='col-form-label' for='experiences[{$index}][name]'>Cargo</label>
              <input type='text' name='experiences[{$index}][name]' id='experiences[{$index}][name]' class='form-control-sm  form-control' data-dborigin='experiences[{$index}][name]' >
            </div>
            
            <div class='form-group  col-sm-12 col-md-6 col-lg-6 '>
              <label class='col-form-label' for='experiences[{$index}][company]'>Empresa</label>
              <input type='text' name='experiences[{$index}][company]' id='experiences[{$index}][company]' class='form-control-sm  form-control' data-dborigin='experiences[{$index}][company]' >
            </div>

            <div class='form-group  col-sm-12 col-md-6 col-lg-6 '>
              <label class='col-form-label' for='experiences[{$index}][date_start]'>Início</label>
              <input type='date' name='experiences[{$index}][date_start]' id='experiences[{$index}][date_start]' min='{$min_date}' value='' class='form-control-sm  form-control' data-dborigin='experiences[{$index}][date_start]' >
            </div>

            <div class='form-group  col-sm-12 col-md-6 col-lg-6 '>
              <label class='col-form-label' for='experiences[{$index}][date_end]'>Fim</label>
              <input type='date' name='experiences[{$index}][date_end]' id='experiences[{$index}][date_end]' class='form-control-sm  form-control' data-dborigin='experiences[{$index}][date_end]' >
            </div>

            <div class='form-group  col-sm-12 col-md-12 col-lg-12 '>
              <label class='col-form-label' for='experiences[{$index}][description]'>Descrição</label>
              <textarea name='experiences[{$index}][description]' id='experiences[{$index}][description]' class='form-control-sm textarea_editor form-control' data-dborigin='experiences[{$index}][description]' ></textarea>
            </div>

            <div class='col'>
              <hr>
            </div>
          </div>
        ";
      }
      $html_course_form = "
        
        <div class='col-sm-12 col-md-12 col-lg-12'>
          <table class='table-sm table table-condensed table-bordered table-striped table-xsm table-collapse' style='width: 100% !important;' >
            <thead>
              <tr>
                <th class='text-center'>Curso</th>
                <th class='text-center'>Instituição</th>
                <th class='text-center'>Início</th>
                <th class='text-center'>Fim</th>
              </tr>
            </thead>
            <tbody>
              {$course_lines}
            </tbody>
          </table>
        </div>
      ";
      /*
      $html_experience_form = "
        
        <div class='col-sm-12 col-md-12 col-lg-12'>
          <table class='table-sm table table-condensed table-bordered table-striped table-xsm table-collapse' style='width: 100% !important;' >
            <thead>
              <tr>
                <th class='text-center'>Cargo</th>
                <th class='text-center'>Empresa</th>
                <th class='text-center'>Início</th>
                <th class='text-center'>Fim</th>
              </tr>
            </thead>
            <tbody>
              {$experiences_lines}
            </tbody>
          </table>
        </div>
      ";
      */
      $html_experience_form = $experiences_lines;
      $form['html'][] = ["name" => "courses", "label" => "Cursos e Especilizações", "html" => [$html_course_form] ];
      $form['html'][] = ["name" => "experiences", "label" => "Experiências profissionais", "html" => [$html_experience_form] ];

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
                "data-object" => "curriculum",
                "data-action" => $action,
                "data-id" => $parameters['data']['id'],
                "onClick" => "handle_form(this);",
                "data-toggle_ajax" => "modal" ,
                "data-target" => "#form_modal" ,
                "data-form" => "curriculum",
                "data-action" => "edit" ,
                "data-modal_text" => TranslationHelper::get_text(["code" => "generic_edit"]) . ": {$parameters['data']['id']}" . ( isset($parameters['data']['name']) ? " - {$parameters['data']['name']}" : "" ),
                "data-api" => "curriculum",
                "data-api_action" => "get_form" ,
                "data-mode" => "edit",
                "data-api_action_get" => "get_curriculum_info",
                "data-api_id" => $parameters['data']['id'],
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "data-confirm" => "required",
                "data-confirm_parameters" => json_encode(["title" => TranslationHelper::get_text("confirm_edit_title"), "html" => TranslationHelper::get_text("confirm_edit_text"), "icon" => "question"], true),
              ],
              "href" => "#",
              "required_permission" => ["curriculum_edit"],
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
                "data-api" => "curriculum",
                "data-method" => "POST",
                "data-reload" => "true",
                "data-hide_form" => true,
                "onClick" => "handle_delete(this);",

              ],
              "href" => "#",
              "required_permission" => ["curriculum_delete"],
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
    
    public function list_details($filters = [], $custom_filters = []){
      $Crud = Crud::get_instance();;
      $sql = "  SELECT
                  curriculum.*
                  , user.name user_name
                  , create_user.name create_user_name
                  , gender.code gender_code
                  , gender.description gender_description                  
                  , marital_status.code marital_status_code
                  , marital_status.description marital_status_description
                  , education.code education_code
                  , education.description education_description
                                                                                          
                FROM
                  curriculum

                left join user create_user on
                  create_user.id = curriculum.create_user_id 

                left join user on
                  user.id = curriculum.user_id 

                left join gender on
                  gender.id = curriculum.gender_id

                left join marital_status on
                  marital_status.id = curriculum.marital_status_id 

                left join education on 
                  education.id = curriculum.education_id

                where 
                  1
                  -- AND sale.create_user_id = 1

      ";

      $bind = [];      
     
      if ( Auth::is_logged() && !Auth::is_admin() ){     
        $filters['user_id'] = Auth::get_auth_info()['user_id'];
      }
      if ( $filters || $custom_filters ){
        $sql_filter = $this->create_sql_filter($filters, $custom_filters);
        $sql .= $sql_filter["where"];
        $bind = $sql_filter["bind"];
      }
      return $Crud->execute_query($sql, $bind);
    }

    public static function calculate_year($date) {
      $date = new DateTime($date);
      $today = new DateTime();
  
      // Calcula a diferença
      $diff = $date->diff($today);
  
      // Retorna apenas os anos completos
      return $diff->y;
    }

    public static function calculate_values($parameters = []){
      if ( !$parameters['data'] || !$parameters['field'] )
        return [ 'avg' => 0, 'sum' => 0];

      $counter = 0;
      $sum = 0;
      foreach ( $parameters['data'] as $key => $data ){
        $sum += $data[$parameters['field']];
        $counter++;
      }
      
      if ( !$counter )
        return 0;

      return [
        'avg' => ( $sum / $counter ), 
        'sum' => $sum,
      ];
    }

    public static function get_detail_html($data){

      if ( !$data )
        return "";
      
      $age = self::calculate_year($data['birth_date']);
      $birth_date = Helper::format("date", $data['birth_date'], ['date_format' => "d/m/Y"]);
      $salary_claim = Helper::format("number_br", $data['salary_claim']);
      $cpf = Helper::format("cpf", $data['cpf']);

      $courses = ( !empty($data['courses']) ? json_decode($data['courses'], true) : []);
      $courses_list = "";
      if ( $courses ){
        foreach ( $courses as $course ){
          if ( empty($course['name']) )
            continue;

          $date_start = Helper::format("date", $course['date_start'], ['date_format' => "d/m/Y"]);
          $date_end = Helper::format("date", $course['date_end'], ['date_format' => "d/m/Y"]);
          $courses_list .= "
            <tr>
              <td class='' colspan=''>{$course['name']}</td>
              <td class=''>{$course['institution']}</td>
              <td class=''>{$date_start}</td>
              <td>{$date_end}</td>
            <tr>
          ";
        }
      }

      $experiences = ( !empty($data['experiences']) ? json_decode($data['experiences'], true) : []);
      $experiences_list = "";
      if ( $experiences ){
        foreach ( $experiences as $experience ){
          if ( empty($experience['name']) )
            continue;
          
          $date_start = Helper::format("date", $experience['date_start'], ['date_format' => "d/m/Y"]);
          $date_end = Helper::format("date", $experience['date_end'], ['date_format' => "d/m/Y"]);
          $experiences_list .= "
            <tr>
              <td class='' colspan=''>{$experience['name']}</td>
              <td class=''>{$experience['company']}</td>
              <td class=''>{$date_start}" . ( !empty($date_end) ? " - {$date_end}" : "") . "</td>
              <td colspan=''>{$experience['description']}</td>
            </tr>
          ";
        }
      }

      $html = <<<HTML

        <div class="row">
          <div class="col">
          <hr>
            <div class="table-responsive">
              <table class="table table-bordered responsive table-sm table-condensed table-collapse collapsed">
                <tr>
                  <th colspan="6" class="text-left bg-secondary">Dados Pessoais</th>
                </tr> 
                <tr>
                  <th>Nome:</th>
                  <td>{$data['user_name']}</td>

                  <th>CPF:</th>
                  <td colspan=''>{$cpf}</td>
                </tr>
                <tr>
                  <th>Idade:</th>
                  <td>{$age}</td>

                  <th>Data de Nascimento:</th>
                  <td colspan=''>{$birth_date}</td>
                </tr>
                <tr>
                  <th>Estado Civil:</th>
                  <td>{$data['marital_status_description']}</td>

                  <th>Escolaridade:</th>
                  <td>{$data['education_description']}</td>

                </tr>
                <tr>
                  <th>Sexo:</th>
                  <td colspan=''>{$data['gender_description']}</td>

                  <th>Pretensão Salarial:</th>
                  <td colspan='' class='text-right'>R$ {$salary_claim}</td>
                </tr>
                <tr>
                  <th colspan="6" class="text-left bg-secondary">Cursos e Especializações</th>
                </tr> 
                <tr>
                  <th class='text-center bg-primary' >Descrição</th>
                  <th class='text-center bg-primary' >Instituição</th>
                  <th class='text-center bg-primary' >Início</th>
                  <th class='text-center bg-primary' >Término</th>
                </tr>
                {$courses_list}
                <tr>
                  <th colspan="6" class="text-left bg-secondary">Experiências Profissionais</th>
                </tr> 
                <tr>
                  <th class='text-center bg-primary' >Cargo/Função</th>
                  <th class='text-center bg-primary' >Empresa</th>
                  <th class='text-center bg-primary' >Período</th>
                  <th class='text-center bg-primary' >Detalhes</th>
                </tr>
                {$experiences_list}
              </table>
            </div>
          </div>
        </div>

      HTML;

      return $html;

    }
  } 