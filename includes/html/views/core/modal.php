<?php

  $custom_modal = "";
  if ( isset($template_parameters['custom_modal']) && !empty($template_parameters['custom_modal']) ){
    if ( !is_array($template_parameters['custom_modal']) )
      $template_parameters['custom_modal'] = [$template_parameters['custom_modal']];

    foreach ( $template_parameters['custom_modal'] as $key => $data ){
      $custom_modal .= <<<HTML
        
      HTML;
    }
  }
  $_page_config['modal'] = "

    <div class=\"modal fade\" id=\"form_modal\" role=\"dialog\" aria-labelledby=\"form_modal\" aria-hidden=\"true\" data-focus=\"false\">
      <div class=\"modal-dialog modal-dialog-centered  modal-lg \" role=\"document\">
        <div class=\"modal-content\">
          <div class=\"modal-header\">
            <h5 class=\"modal-title\" id=\"exampleModalLabel\"><span class=\"modal_text\"></span></h5>
            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span>
            </button>
          </div>
          <div class=\"modal-body\">
            <form id=\"generic_form\" name=\"\" >
              <input type=\"hidden\" name=\"action\">
              <input type=\"hidden\" name=\"api\">

              <div class=\"h-90 \">
                <div class=\"form_fields row row-fluid\"></div>
              </div>
              

              <div class=\"row\">
                <div class=\"col-sm-12 col-md-12 col-sm-12 form_file_list_table\">

                </div>
              </div>
              <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn bg_willcode_red text-white\" data-dismiss=\"modal\">" . TranslationHelper::get_text("generic_cancel") . "</button>
                <button type=\"submit\" class=\"btn bg_willcode_blue text-white\">" . TranslationHelper::get_text("generic_confirm") . "</button>
              </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>
  ";