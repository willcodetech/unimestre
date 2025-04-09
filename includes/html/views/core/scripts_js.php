<?php

  $custom_js = "";
  if ( isset($template_parameters['custom_js']) && !empty($template_parameters['custom_js']) ){
    if ( !is_array($template_parameters['custom_js']) )
      $template_parameters['custom_js'] = [$template_parameters['custom_js']];

    foreach ( $template_parameters['custom_js'] as $key => $data ){
      $custom_js .= <<<HTML
        <script type="text/javascript" src="{$data}"></script>\r\n
      HTML;
    }
  }

  $_page_config['scripts_js'] = <<<HTML
    <!--**********************************
      Scripts
    ***********************************-->
    <!--
    <script src="/theme/plugins/common/common.min.js"></script>
    <script src="/theme/js/custom.min.js"></script>
    <script src="/theme/js/settings.js"></script>
    <script src="/theme/js/styleSwitcher.js"></script>
    <script src="/theme/plugins/highlightjs/highlight.pack.min.js"></script>
    -->

    <script src="/assets/plugins/common/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/styleSwitcher.js"></script>
    <script src="/assets/plugins/highlightjs/highlight.pack.min.js"></script>

    <script>hljs.initHighlightingOnLoad();</script>
    <script type="text/javascript" src="/assets/plugins/datatables/datatables.min.js"></script>

    <script type="text/javascript" src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery_toast/jquery.toast.min.js"></script>
    
    <script src="/assets/js/controller/html.js"></script>
    <script src="/assets/js/controller/app.js"></script>
    <script src="/assets/js/controller/crud.js"></script>
    <script src="/assets/js/controller/datatables.js"></script>
    <script src="/assets/js/controller/notification.js"></script>
    <!-- 
    -->
    <script src="/assets/plugins/jquery_mask/jquery.mask.min.js"></script> 
    <script src="/theme/plugins/validation/jquery.validate.min.js"></script>
    <script src="/theme/plugins/validation/jquery.validate-init.js"></script>
    <!--https://alex-d.github.io/Trumbowyg/documentation -->
    <script src="/assets/plugins/trumbowyg/trumbowyg.js"></script>
    <script src="/assets/plugins/trumbowyg/plugins/emoji/trumbowyg.emoji.js"></script>
    

    <!-- https://select2.org/data-sources/ajax -->
    <script src="/assets/plugins/select2/js/select2.js"></script>
    <!-- 
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    -->
    <script type="text/javascript" src="/assets/plugins/autonumeric/autonumeric.min.js"></script>
    <script src="/assets/plugins/dropzone/dropzone.min.js"></script>
    
    <!-- full calendar-->
    <script src="/assets/plugins/fullcalendar/index.global.min.js"></script>
    <script src="/assets/plugins/fullcalendar/pt-br.global.js"></script>

    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>

    <!-- Date Picker Plugin JavaScript -->
    <script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/assets/plugins/confetti/confetti.js"></script>
   
    {$custom_js}
    <script>
      (function($) {
      "use strict"
    
        new quixSettings({
          version: "light", //2 options "light" and "dark"
          layout: "vertical", //2 options, "vertical" and "horizontal"
          navheaderBg: "color_1", //have 10 options, "color_1" to "color_10"
          headerBg: "color_1", //have 10 options, "color_1" to "color_10"
          sidebarStyle: "full", //defines how sidebar should look like, options are: "full", "compact", "mini" and "overlay". If layout is "horizontal", sidebarStyle won't take "overlay" argument anymore, this will turn into "full" automatically!
          sidebarBg: "color_1", //have 10 options, "color_1" to "color_10"
          sidebarPosition: "fixed", //have two options, "static" and "fixed"
          headerPosition: "fixed", //have two options, "static" and "fixed"
          containerLayout: "wide",  //"boxed" and  "wide". If layout "vertical" and containerLayout "boxed", sidebarStyle will automatically turn into "overlay".
          direction: "ltr" //"ltr" = Left to Right; "rtl" = Right to Left
        });
      
      
      })(jQuery);
    </script>
  HTML;