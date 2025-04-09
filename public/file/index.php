<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(0);

Auth::redirect_if_not_logged();

$filters = $_REQUEST;
$filters["limit"] = ( $_REQUEST['limit'] ??  100 );
  
$filters = [];
$File = new File();
$list = $File->list_details($filters);
$table = DataTable::create($File->to_datatable($list));

$parameters = [
  "object" => "File",
  //"view" => "list",
  /*
  "extra_files" => [
    ["object" => "user", "view" => "form_modal", "var_name" => "form"],
    ["object" => "user", "view" => "detail_modal", "var_name" => "detail"]
  ],
  */
  "vars" => [
    "_page_title" => Parameter::get("system_name"),
    "_page_subtitle" => "Registro de Archivos",
    "_form_name" => "file",
    "_api" => "file",
    "_create_modal_text" => "Nuevo",
    "_search_modal_text" => "Buscar",
    "_table" => $table,
    //"_session" => "<pre>" . print_r($_SESSION, true) . "</pre>",
  ]
];
HtmlHelper::load_view($parameters);