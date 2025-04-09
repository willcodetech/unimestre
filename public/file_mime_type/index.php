<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(0);

Auth::redirect_if_not_logged();

$filters = $_REQUEST;
$filters["limit"] = ( $_REQUEST['limit'] ??  100 );
  
$filters = [
  //"price_gt" => 5000,
  //  "date_bt" => date('Y-m-01') . "," . date('Y-m-t'), //"2024-02-03,2024-02-04"
  //"id_in" => "1,10"
];
$FileMimeType = new FileMimeType();
$list = $FileMimeType->list($filters);
$table = DataTable::create($FileMimeType->to_datatable($list));

$parameters = [
  "object" => "FileMimeType",
  //"view" => "list",
  /*
  "extra_files" => [
    ["object" => "user", "view" => "form_modal", "var_name" => "form"],
    ["object" => "user", "view" => "detail_modal", "var_name" => "detail"]
  ],
  */
  "vars" => [
    "_page_title" => Parameter::get("system_name"),
    "_page_subtitle" => "Cadastro de FileMimeType",
    "_form_name" => "file_mime_type",
    "_api" => "file_mime_type",
    "_create_modal_text" => "Novo",
    "_search_modal_text" => "Pesquisar",
    "_table" => $table,
    //"_session" => "<pre>" . print_r($_SESSION, true) . "</pre>",
  ]
];
HtmlHelper::load_view($parameters);