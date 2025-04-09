<?php

  Class DataTable {

    public static function array_to_table($array = []){
      $classes = implode(" ", [ "table", "table-sm", "table-condensed", "table-bordered", "table-striped", "table-hover", "display", "nowrap" ]);
      $html = "<table class=\"table table-sm table-xsm table-condensed table-striped table-hover table-responsive\" >";
      $columns = "";
      foreach ( $array[0] as $key => $column ){
        $name = ucfirst(Helper::translate($key));
        $columns .= "<th class=\"text-center\" >{$name}</th>";
      }
      $lines = "";
      $contador = 0;
      foreach ( $array as $key => $data ){
        $teste = "";
        if ( $contador % 2 > 0)
          $teste = "bg-warning";
        $lines .= "<tr>";
        foreach ( $data as $key2 => $column ){
          $column = Helper::translate($column);
          $lines .= "<td class='text-center {$teste}' >{$column}</td>";
        }
        $lines .= "</tr>";
        $contador++; 
      }

      $html .= "<thead><tr>{$columns}</tr></thead>";
      $html .= "<tbody>{$lines}</tbody>";
      $html .= "</table>";

      return $html;
    }

    public static function create_old($parameters = [] ){
      //Helper::debug_data($parameters);
      $html = "<div class=\"table_container\">";
      $table_id = ( @$parameters['extra_parameters']['table_id'] ?? "table_id_" . rand() );
      $classes = implode(" ", [ "table", "table-sm", "table-condensed", "table-bordered", "table-striped_", "table-hover", "display", "nowrap" ]);
      $datatables_config = ( @$parameters['extra_parameters']['datatables_config'] ? json_encode($parameters['extra_parameters']['datatables_config'], true) : "");
      if ( isset($parameters['extra_parameters']['datatables_config']['totalizer']) && $parameters['extra_parameters']['datatables_config']['totalizer'] == true ){
        $html .= "<div class=\"willcode-table-container\">
          <div class=\"row\" data-table-id=\"{$table_id}\">
            <div class=\"col\">
              <div class=\"row totalizer\" >
                <div class=\"col-md-12 col-12 text-center totalizer-table \" data-table_id=\"{$table_id}\"></div>
              </div>
            </div>
          </div>
        </div>";
      }

      $html .= "<div class=\"table-responsive\" >
      <table class=\"table table-sm table-xsm table-condensed table-striped_ table-hover {$classes}\" style=\"width: 100% !important\" 
        id=\"{$table_id}\" data-datatables_config='{$datatables_config}'>";
      $columns = "";
      $columns_search = "";
      foreach ( $parameters['columns'] as $key => $column ){
        $column_classes = "";
        $column_attributes = "";
        if ( is_array($column) ){
          $name = ucfirst(Helper::translate($column['text']));
          $column_attributes .= ( isset($column['attributes']) ? Helper::create_html_custom_attributes($column['attributes']) : "" );
          $column_classes .= ( isset($column['classes']) ? Helper::create_html_custom_classes($column['classes']) : "" );

        }else {
          $name = ucfirst(Helper::translate($column));

        }
        $columns .= "<th class=\"text-center {$column_classes} \" {$column_attributes} >{$name}</th>";
        $columns_search .= "<td class=\"text-center search\" >{$name}</td>";
      }
      
      $lines = "";
      foreach ( $parameters['items'] as $key => $data ){
        $temp = "<tr>"; 
          foreach ( $data as $key2 => $column ){
            $attributes = ( isset($column['attributes']) ? Helper::create_html_custom_attributes($column['attributes']) : "" );
            $classes = ( isset($column['classes']) ? Helper::create_html_custom_classes($column['classes']) : "" );

            if ( isset($column['format']) && !empty($column['format']) )
              $column['text'] = Helper::format($column['format'], $column['text'], $column['format_options'] ?? null);
              
            $temp .= "<td class=\"{$classes}\" {$attributes} >{$column['text']}</td>";
          }
        $temp .= "</tr>";
        $lines .= $temp;
      }
      $html .= "<thead><tr>{$columns}</tr></thead>";

      if ( ( isset($parameters['extra_parameters']['enable_column_search']) && $parameters['extra_parameters']['enable_column_search'] == true ) ){
        $html .= "<tfoot><tr>{$columns_search}</tr></tfoot>";
      }
      $html .= "<tbody>{$lines}</tbody>";
      $html .= "</table></div>";

      if ( ( isset($parameters['extra_parameters']['load_datatables']) && ( $parameters['extra_parameters']['load_datatables'] == true )  ) ){

        //$idController = "_" . round(microtime(true) * 1000) . "_" . rand();
        $html .= "
          <script> 
            docReady(function(){

              if ( ControllerDataTables != undefined ) {
                ControllerDataTables.create('#" . $table_id ."');
              } 

            });
          </script>
        ";
      }
      $html .= "</div>";
      return $html;
    }

    public static function create($parameters = []) {

      // show message if table has no rows
      //if ( isset($parameters['extra_parameters']['empty_text']) && !empty($parameters['extra_parameters']['empty_text']) && empty($parameters['items']) ){
      if ( empty($parameters['items']) ){
        return HtmlHelper::create_alert([
          "classes" => $parameters['extra_parameters']['empty_text']['classes'] ?? "alert-info",
          "title" => $parameters['extra_parameters']['empty_text']['title'] ?? "Sem registros a exibir",
          "text" => $parameters['extra_parameters']['empty_text']['text'] ?? "",
        ]);
      }
      $html = [];
      $html[] = "<div class=\"table_container\">";
      $table_id = $parameters['extra_parameters']['table_id'] ?? "table_id_" . rand();
      $classes = implode(" ", ["table", "table-sm", "table-condensed", "table-bordered", "table-striped_", "table-hover", "display", "nowrap"]);
      $datatables_config = isset($parameters['extra_parameters']['datatables_config']) ? json_encode($parameters['extra_parameters']['datatables_config'], true) : "";

      if (isset($parameters['extra_parameters']['datatables_config']['totalizer']) && $parameters['extra_parameters']['datatables_config']['totalizer'] == true) {
          $html[] = "<div class=\"willcode-table-container\">
              <div class=\"row\" data-table-id=\"{$table_id}\">
                  <div class=\"col\">
                      <div class=\"row totalizer\">
                          <div class=\"col-md-12 col-12 text-center totalizer-table\" data-table_id=\"{$table_id}\"></div>
                      </div>
                  </div>
              </div>
          </div>";
      }

      $html[] = "<div class=\"table-responsive\">
          <table class=\"table table-sm table-xsm table-condensed table-striped_ table-hover {$classes}\" style=\"width: 100% !important\" id=\"{$table_id}\" data-datatables_config='{$datatables_config}'>
              <thead><tr>";
      
      foreach ($parameters['columns'] as $column) {
          $column_classes = isset($column['classes']) && is_array($column['classes']) ? implode(' ', $column['classes']) : @$column['classes'] ;
          $column_attributes = isset($column['attributes']) ? implode(' ', array_map(fn($k, $v) => "$k=\"$v\"", array_keys($column['attributes']), $column['attributes'])) : '';
          $name = ucfirst($column['text']);
          $html[] = "<th class=\"text-center {$column_classes}\" {$column_attributes}>{$name}</th>";
      }

      $html[] = "</tr></thead>"; //<tbody>";

      if (isset($parameters['extra_parameters']['enable_column_search']) && $parameters['extra_parameters']['enable_column_search'] == true) {
        $html[] = "<tfoot><tr>";
        foreach ($parameters['columns'] as $column) {
            $name = ucfirst($column['text']);
            $html[] = "<td class=\"text-center search\">{$name}</td>";
        }
        $html[] = "</tr></tfoot>";
      }

      $html[] = "<tbody>";

      foreach ($parameters['items'] as $row) {
          $html[] = "<tr>";
          foreach ($row as $column) {
            $classes = isset($column['classes']) ? implode(' ', $column['classes']) : '';
            $attributes = isset($column['attributes']) ? implode(' ', array_map(fn($k, $v) => "$k=\"$v\"", array_keys($column['attributes']), $column['attributes'])) : '';
            $text = isset($column['format']) && !empty($column['format']) ? Helper::format($column['format'], $column['text'], $column['format_options'] ?? null) : $column['text'];
            $html[] = "<td class=\"{$classes}\" {$attributes}>{$text}</td>";
          }
          $html[] = "</tr>";
      }

      $html[] = "</tbody>";


      $html[] = "</table></div>";

      if (isset($parameters['extra_parameters']['load_datatables']) && $parameters['extra_parameters']['load_datatables'] == true) {
        $html[] = "
          <script>
            docReady(function() {
              if (ControllerDataTables != undefined) {
                ControllerDataTables.create('#{$table_id}');
              }
            });
          </script>";
      }

      $html[] = "</div>";
     
      return implode("", $html);
      
    }

    public static function create_row($row = [] ){
      if ( !$row )
        return "";

      $html = [];
      $html[] = "<tr>";
      foreach ($row as $column) {
        $classes = isset($column['classes']) ? implode(' ', $column['classes']) : '';
        $attributes = isset($column['attributes']) ? implode(' ', array_map(fn($k, $v) => "$k=\"$v\"", array_keys($column['attributes']), $column['attributes'])) : '';
        $text = isset($column['format']) && !empty($column['format']) ? Helper::format($column['format'], $column['text'], $column['format_options'] ?? null) : $column['text'];
        $html[] = "<td class=\"{$classes}\" {$attributes}>{$text}</td>";
      }
      $html[] = "</tr>";

      return implode("", $html);
    }

    public static function create_header($parameters = []){
      if ( !$parameters )
        return "";

      $html = [];
      $html[] = "<thead><tr>";
      
      foreach ($parameters['columns'] as $column) {
        $column_classes = isset($column['classes']) && is_array($column['classes']) ? implode(' ', $column['classes']) : @$column['classes'] ;
        $column_attributes = isset($column['attributes']) ? implode(' ', array_map(fn($k, $v) => "$k=\"$v\"", array_keys($column['attributes']), $column['attributes'])) : '';
        $name = ucfirst($column['text']);
        $html[] = "<th class=\"text-center {$column_classes}\" {$column_attributes}>{$name}</th>";
      }

      $html[] = "</tr></thead>"; //<tbody>";
      return implode("", $html);

    }

    public static function create_tfoot_search($parameters =[]){
      if (isset($parameters['extra_parameters']['enable_column_search']) && $parameters['extra_parameters']['enable_column_search'] == true) {
        $html[] = "<tfoot><tr>";
        foreach ($parameters['columns'] as $column) {
            $name = ucfirst($column['text']);
            $html[] = "<td class=\"text-center search\">{$name}</td>";
        }
        $html[] = "</tr></tfoot>";
      }
      return implode("", $html);
    }

    public static function build_table($parameters = [] ){
      $html = [];
      $html[] = "<div class=\"table_container\">";
      $table_id = $parameters['extra_parameters']['table_id'] ?? "table_id_" . rand();
      $classes = implode(" ", ["table", "table-sm", "table-condensed", "table-bordered", "table-striped_", "table-hover", "display", "nowrap"]);
      $datatables_config = isset($parameters['extra_parameters']['datatables_config']) ? json_encode($parameters['extra_parameters']['datatables_config'], true) : "";

      if (isset($parameters['extra_parameters']['datatables_config']['totalizer']) && $parameters['extra_parameters']['datatables_config']['totalizer'] == true) {
        $html[] = "<div class=\"willcode-table-container\">
            <div class=\"row\" data-table-id=\"{$table_id}\">
                <div class=\"col\">
                    <div class=\"row totalizer\">
                        <div class=\"col-md-12 col-12 text-center totalizer-table\" data-table_id=\"{$table_id}\"></div>
                    </div>
                </div>
            </div>
        </div>";
      }

      $html[] = "
        <div class=\"table-responsive\">
          <table class=\"table table-sm table-xsm table-condensed table-striped_ table-hover {$classes}\" style=\"width: 100% !important\" id=\"{$table_id}\" data-datatables_config='{$datatables_config}'>";

      $html[]  = $parameters['html_header'];
      $html[]  = self::create_tfoot_search($parameters);      
      $html[] = "<tbody>";
      $html[] = $parameters['html_rows'];
      $html[] = "</tbody>"; 
      
      $html[] = "</table></div>";

      if (isset($parameters['extra_parameters']['load_datatables']) && $parameters['extra_parameters']['load_datatables'] == true) {
        $html[] = "
          <script>
            docReady(function() {
              if (ControllerDataTables != undefined) {
                ControllerDataTables.create('#{$table_id}');
              }
            });
          </script>";
      }

      $html[] = "</div>";

      if ( isset($parameters['extra_parameters']['custom_html']))
        $html[] = $parameters['extra_parameters']['custom_html'];
      
      return implode("", $html);
    }
  }