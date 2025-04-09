<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(0);

Auth::redirect_if_not_logged();

/*
if ( !Auth::is_admin() )
  Auth::redirect("/index.php");
*/

$filters = ["id" => Auth::get_auth_info()['user_id'], "limit" => 1,  ];
$User = new User();
$list = $User->list($filters);
//$table = DataTable::create($User->to_datatable($list));
$UserPermission = new UserPermission();
$permission_list = $UserPermission->list_details(["user_id" => Auth::get_auth_info()['user_id'] ]);

$parameters = [
  "object" => "user",
  "view" => "profile",
  /*
  "extra_files" => [
    ["object" => "user", "view" => "form_modal", "var_name" => "form"],
    ["object" => "user", "view" => "detail_modal", "var_name" => "detail"]
  ],
  */
  "vars" => [
    "_page_title" =>  Parameter::get("system_name"),
    "_page_subtitle" => "Meu Perfil",
    "_form_name" => "user",
    "_api" => "user",
    "_create_modal_text" => "Novo",
    "_search_modal_text" => "Pesquisar",
    //"_table" => $table,
    "_btn_custom_class" => "hide",
    "_btn_create_custom_class" => "hide",
    "_hide_profile_picture" => ( !empty($list[0]['profile_picture_url']) ? "" : "hide" ),
    //"_se
  ]
];

foreach ( $list[0] as $key => $value ){
  $parameters['vars'][$key] = $value;
}

$permissions = "<ul>";
foreach ( $permission_list as $key => $data ){
  $permissions .= "<li>{$data['description']}</li>";
}
$permissions .= "</ul>";
$parameters['vars']['permissions'] = $permissions;
HtmlHelper::load_view($parameters);