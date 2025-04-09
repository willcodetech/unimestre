<?php

  include_once("css.php");
  $_page_lang = Parameter::get("default_language");
  $_page_config['head'] = <<<HTML
    <!DOCTYPE html>
    <html lang="{$_page_lang}">
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>{$template_parameters['page_title']}</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon.ico">
        {$_page_config['css']}
        <script>

          function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === "complete" || document.readyState === "interactive") {
                // call on next available tick
              setTimeout(fn, 1);
            } else {
              document.addEventListener("DOMContentLoaded", fn);
            }
          }    
        </script>
      </head>

    HTML;

    include_once("body.php");
    echo $_page_config['head'] , $_page_config['body'];
    