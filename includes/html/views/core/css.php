<?php 
  $custom_css = "";
  if ( isset($template_parameters['custom_css']) && !empty($template_parameters['custom_css']) ){
    if ( !is_array($template_parameters['custom_css']) )
      $template_parameters['custom_css'] = [$template_parameters['custom_css']];

    foreach ( $template_parameters['custom_css'] as $key => $data ){
      $custom_css .= <<<HTML
        <link href="{$data}" rel="stylesheet">\r\n
      HTML;
    }
  }
  
  $_page_config['css'] = <<<HTML
    <link rel="stylesheet" href="/assets/plugins/highlightjs/styles/darkula.css">
    <link href="/assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/assets/plugins/datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/sweetalert2/sweetalert2.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/trumbowyg/ui/trumbowyg.min.css"/>
    <link rel="stylesheet" href="/assets/plugins/trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css">
    <!-- https://select2.org/data-sources/ajax -->
    <link rel="stylesheet" type="text/css" href="/assets/plugins/select2/css/select2.css">
    <link rel="stylesheet" type="text/css" href="/assets/plugins/select2/css/select2-boostrap.css">
    <link rel="stylesheet" type="text/css" href="/assets/plugins/jquery_toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.css"/>    
    <link rel="stylesheet" href="/assets/plugins/dropzone/dropzone.min.css" type="text/css" />
    
    <!-- Custom Stylesheet -->
    <link href="/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <link href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    
    <link href="/assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet">

    <!-- Daterange picker plugins css -->
    <link href="/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <style>
      .dropzone {
        border: 2px dashed #ccc;
        padding: 20px;
        margin-bottom: 20px;
      }
      .file-preview {
        margin-top: 10px;
      }
      .file-preview img {
        max-width: 100px;
        max-height: 100px;
        margin-right: 10px;
        margin-bottom: 10px;
      }
    </style>
    {$custom_css}
  HTML;

  if ( Parameter::get("use_default_colors") == "false"){
    $custom_colors = [];
    $Parameter = new Parameter();
    $colors = $Parameter->list([
      "code_in" => "custom_color,color_primary,color_secondary,color_success"
    ]);
    if ( $colors ){
      $css_colors = "";
      foreach ( $colors as $color ){
        $css_colors .= "--{$color['code']}: {$color['value']} !important;\r\n";
      }
      $_page_config['css'] .= <<<HTML
      <style>
        :root{        
          {$css_colors}
        }
      </style>
      HTML;
    }

    $color_header = Parameter::get("color_header");
    if ( $color_header ){
      $_page_config['css'] .= <<<HTML
        <style>
          .header, .nav-header {        
            background-color: {$color_header} !important;
          }
  
          [data-nav-headerbg="color_1"] .nav-header {
            background-color: {$color_header} !important;
          }
  
        </style>
        HTML;
    }
    
  }