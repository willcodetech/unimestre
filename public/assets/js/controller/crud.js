
function handle_form(parameters){
  for (let key in $("#generic_form").dataset)
    delete $("#generic_form").dataset[key];

  // console.log(parameters);
  let custom_parameters = $(parameters).data();

  /*
    data-toggle="modal" 
    data-target="#form_modal" 
    data-form="user" 
    data-action="create" 
    data-modal_text="Novo Usuário"
    data-api="user" 
    data-api_action="get_form" 
    data-mode="create"
  */
 
  if ( custom_parameters['target'] ){
    if ( custom_parameters['modal_text'] ){
      $(custom_parameters['target']).find(".modal_text").html(custom_parameters['modal_text'])
    }

  }

  $(".form_file_list_table").html(""); // always clear dynamic file list 
  
  if ( custom_parameters['clear_html_element'] )
    $(custom_parameters['clear_html_element']).html("");

  $(`#generic_form`).attr("name", custom_parameters['form']);

  $.each(custom_parameters, function(key, value){
    $(`#generic_form`).data(key, value);
  })

  $(`form[name='${custom_parameters['form']}']`).find(`:input[name='action']`).val(custom_parameters['action']);
  $(`form[name='${custom_parameters['form']}']`).find(`:input[name='api']`).val(custom_parameters['api']);

  if ( custom_parameters['api'] && custom_parameters['api_action'] ){        
    get_form(custom_parameters);
  }

}

function get_form(parameters){
  $("masked_value").unmask();
  let current_form = $(`form[name='${parameters['form']}']`);
  $.get(`/api/?api=${parameters['api']}&action=${parameters['api_action']}&mode=${parameters['mode']}`, function(data){
    let form_fields = data;
    // console.warn(data);
    $(current_form).find(`.form_fields`).html(``);
    $.each(data.fields, function(k, v){
      $(current_form).find(`.form_fields`).append(gerar_campo(v));
    });

    if ( data.groups ){
      $.each(data.groups, function(k, v){
        let group_fields = "";
        $.each(v.fields, function(index, field){
          group_fields += gerar_campo(field);
        })
        $(current_form).find(`.form_fields`).append(`
          <div class="form-group col-sm-12 col-md-12 col-lg-12" data-group_fields_id="${v.name}">
            <span class="fields_group_label">${v.label}</span><hr>
            <div class="container">
              <div class="row">
              ${group_fields}        
              </div>     
            </div>
          </div>
          
        `);
      })
      
    }

    if ( data.html ){
      $.each(data.html, function(k, v){       
        $(current_form).find(`.form_fields`).append(`
          <div class="form-group col-sm-12 col-md-12 col-lg-12" data-group_fields_id="${v.name}">
            <span class="fields_group_label">${v.label}</span><hr>
            <div class="container">
              <div class="row">
              ${v.html}        
              </div>     
            </div>
          </div>
          
        `);
      })
    }

    $('select').select2({
      width: '100%',
      //minimumInputLength: 1,
      allowClear: true,
      placeholder: "Selecione...",
      theme: 'bootstrap4',
    });
    enable_select2();

    $(document).on('select2:open', () => {
      document.querySelector('.select2-search__field').focus();
    });
    enable_text_editor();

    enable_date_range_picker();

  }).fail(function(data){
    let response = (data.responseJSON);
    // console.log(data.responseJSON);
    popup("error", response.popup);

  }).done(function(){    
    
    initializeAutoNumericFields('.numeric_field');
    if ( parameters['api_action_get'] && parameters['api_id'] ){
      
      //$(`form[name='${parameters['form']}']`).find(":input.masked_value").unmask();
      
      $.get(`/api/?api=${parameters['api']}&action=${parameters['api_action_get']}&id=${parameters['api_id']}`, function(data){

        if ( data ){
          $.each(data[0], function(field_name, new_value){   
            let field = $(current_form).find(`:input[name='${field_name}']`);
            
            //$(field).val(new_value);
            
            if ( $(field).hasClass("textarea_editor") ){
              $(field).trumbowyg('html', new_value);
            }

            if ( $(field).hasClass("select_ajax_dataset") ){
              // console.error("TEM A CLASSE")
              let search_parameters = $(field).data("select2_parameters");
              var search_field = search_parameters.search_field;

              // identifica o campo que foi usado como referência no valor
              let key_value = search_parameters.key_value                                     

              if (!search_field || !search_parameters ){
                  
              }else if ( new_value ) {

                let query_string = {filters: {}};
                query_string['filters'][key_value] = new_value;
                // console.table(query_string)
                $.ajax({
                  type: 'GET',
                  url: `/api/?api=helper_select2&action=get_itens&${$.param(search_parameters)}`,
                  data: query_string,
                }).then(function (data) {
                    
                  let selected = data.results[0];

                  // create the option and append to Select2
                  var option = new Option(selected.text, selected.id, true, true);
                  field.append(option).trigger('change');

                  // manually trigger the `select2:select` event
                  field.trigger({
                    type: 'select2:select',
                    params: {
                      data: data
                    }
                  });

                });
              }
             
            } else if ( $(field).hasClass("numeric_field") ){
              
              let formatted_value = formatInitialValues(new_value);
              $(field).val(formatted_value);
              
            }else {
              $(field).val(new_value);
            }
          })

          if ( data.permissions ){
            $.each(data.permissions, function(k, v){
              $(current_form).find(`:input[name='permission[${v.permission_id}]']`).prop(`checked`, true);
            });
          }

          if ( data.services ){
            $.each(data.services, function(k, v){
              $(current_form).find(`:input[name='service[${v.service_id}]']`).prop(`checked`, true);
            });
          }

          if ( data.service_groups ){
            $.each(data.service_groups, function(k, v){
              $(current_form).find(`:input[name='service_group[${v.service_group_id}]']`).prop(`checked`, true);
            });
          }

          if ( data.checkboxes_array ){ // mark as checked
            $.each(data.checkboxes_array, function(k, v){
              mark_as_checked(current_form, v.data, v.field, v.value);
            })
            
          }

          // show modal only on sucess
          if ( parameters['toggle_ajax'] == "modal" && parameters['target'] ){
            var temp_modal = new bootstrap.Modal(document.getElementById(parameters['target'].replace("#", "")))
            temp_modal.show()
          }
          $(".masked_value").trigger("input")
          $("select").trigger('change.select2');
        }
    
      }).fail(function(data){
        let response = (data.responseJSON);
        // console.log(data.responseJSON);
        popup("error", response.popup);
      });
    } 

    if ( parameters['form_values'] ){ // popoulate form with pre-defined values
      // console.table(parameters['form_values']);

      $.each(parameters['form_values'], function(k, v){
        //$(current_form).find(`:input[name=${k}]`).val(v);

        let current_field = $(current_form).find(`:input[name=${k}]`);
        $(current_field).val(v);
        if ( $(current_field).hasClass("select_ajax_dataset") ){
          // console.error("TEM A CLASSE")
          let search_parameters = $(current_field).data("select2_parameters");
          var search_field = search_parameters.search_field;

          // identifica o campo que foi usado como referência no valor
          let key_value = search_parameters.key_value                                     

          if (!search_field || !search_parameters ){
              
          }else if ( v ) {

            let query_string = {filters: {}};
            query_string['filters'][key_value] = v;
            // console.table(query_string)
            $.ajax({
              type: 'GET',
              url: `/api/?api=helper_select2&action=get_itens&${$.param(search_parameters)}`,
              data: query_string,
            }).then(function (data) {
                
              let selected = data.results[0];

              // create the option and append to Select2
              var option = new Option(selected.text, selected.id, true, true);
              current_field.append(option).trigger('change');

              // manually trigger the `select2:select` event
              current_field.trigger({
                type: 'select2:select',
                params: {
                  data: data
                }
              });

            });
          }
         
        }
      })

      $('select').trigger('change.select2'); // Notify only Select2 of changes
    }


    if ( parameters['form_hide_fields'] ){ // hide fields from form
      $.each(parameters['form_hide_fields'], function(k,v){
        let hide = $(current_form).find(`:input[name=${v}]`);
        $(hide).closest(`.div_field_${v}`).hide();
      })
    }

  })

}

$(document).on("submit", "#generic_form", function(e){
  e.preventDefault();
  handle_submit(this);

});

/*
$(document).on("click", ".confirm_generic_form", function(e){
  $(`form#generic_form`).trigger("submit");
});
*/

function handle_delete(parameters){

  let custom_parameters = $(parameters).data();
  // console.warn("==== HANDLE DELETE =====");
  // console.log(custom_parameters);
  // console.warn("==== HANDLE DELETE =====");

  if ( !custom_parameters['id'] ){
    popup("error", {
      "title": "Dados incompletos",
      "text": "Id não informado, impossível excluir registro",
      "type": "error"
    })
    return false;
  }

  let formdata = new FormData();
  formdata.append(`action`, custom_parameters['action']);
  formdata.append(`id`, custom_parameters['id']);
  formdata.append(`api`, custom_parameters['api']);

  let request_parameters = {
    type: custom_parameters['method'],
    link: "/api/",
    form_data: formdata,
  }


  if ( custom_parameters['reload'] )
    request_parameters['reload'] = 'true';

  if ( custom_parameters['redirect_url'] )
    request_parameters['redirect_url'] = custom_parameters['redirect_url'];


  if ( custom_parameters['confirm'] && custom_parameters['confirm'] == "required" ){
    if ( custom_parameters['confirm_parameters'] ){
      let confirm_parameters = custom_parameters['confirm_parameters'];
      Swal.fire({
        title: confirm_parameters['title'],
        html: confirm_parameters['html'],
        icon: confirm_parameters['icon'],
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        focusConfirm: false,

      }).then((result) => {
        if (result.isConfirmed) {             
          custom_ajax(request_parameters);
        }
      });

    }
  }else {
    custom_ajax(request_parameters);
  }

}
function custom_ajax(parameters){
  // console.table(parameters);
  $.ajax({
    type: parameters['type'],
    url: parameters['link'],
    data: parameters['form_data'] ,
    processData: false,
    contentType: false,
    xhrFields: {
      withCredentials: true
    },

  }).fail(function(data){
    let response = (data.responseJSON);
    // console.log(data.responseJSON);
    popup("error", response.popup);
    
  }).done(function (data) {
    // console.log(data);
    if ( parameters['hide_form'] && parameters['form_name'] ){ //hide modal
      $(`form[name='${parameters['form_name']}']`).closest(".modal").find("button[data-dismiss='modal']").trigger("click");
    }

    if ( parameters['return_element'] ){
      // console.warn("DEVERIA ATUALIZAR TABEL")
    }
    if ( parameters['return_element'] && data.html ){
      // console.log("VEIO HTML")
      $(parameters['return_element']).html(data.html);
    }

    if ( data.popup ){
    
      if ( parameters['reload'] ){        
        data.popup.reload = true;
        
      }else if ( parameters['redirect_url'] ){
        //data.popup.redirect_url = "/login.php";
  
      }

      popup("success", data.popup);
    }
    
  });

  //$.applyDataMask();
}

function handle_submit(form){
  let form_name = $(form).attr("name");
  
  //$(":input.masked_value").unmask();
 
  let formdata = new FormData($(`form[name='${form_name}']`)[0]);
  $(`form[name='${form_name}']`).find(":input.masked_value").each(function(k,v){
    let mask_type = $(v).data("mask-type");
    switch ( mask_type ){
      case "currency":
        //format_number_local(v, true); // remove mask
        formdata.set($(v).attr("name"), format_number_local(v)); // remove mask
        break;

      case "currency_raw":
        formdata.set($(v).attr("name"), format_number_currency(v)); // remove mask
        break;

      case "phone":
        formdata.set($(v).attr("name"), clear_phone_value(v)); // remove mask
        break;
    }
    
  });

  $(`form[name='${form_name}']`).find(":input.date_range_picker").each(function(k,v){    
    let range = $(v).data("range");
    // console.warn(range)
    if ( range != undefined )
      formdata.set($(v).attr("name"), range); // remove mask 
    //$(this).val(range);
    
  });


  // console.warn(formdata);
  //formdata.append(`auth_token`, `3d5e93081a73f88ac7b67f577d9183b2`); // admin auth token
  let queryString = new URLSearchParams(formdata).toString();
  let request_parameters = {
    type: $(form).data("method"),
    //link: "/api/?" + ( $(form).data("method") == "GET" ? $(form).serialize() : ""),
    link: "/api/?" + ( $(form).data("method") == "GET" ? queryString : ""),
    
    form_data: formdata,
    form_name: form_name
  }

  if ( $(form).data("hide_form") )
    request_parameters['hide_form'] = 'true';

  if ( $(form).data("reload") )
    request_parameters['reload'] = 'true';

  if ( $(form).data("redirect_url") )
    request_parameters['redirect_url'] = $(form).data("redirect_url");

  if ( $(form).data("return_element") )
    request_parameters['return_element'] = $(form).data("return_element");

  if ( $(form).data("confirm") && $(form).data("confirm") == "required" ){
    if ( $(form).data("confirm_parameters") ){
      let confirm_parameters = $(form).data("confirm_parameters");
      Swal.fire({
        title: confirm_parameters['title'],
        html: confirm_parameters['html'],
        icon: confirm_parameters['icon'],
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {             
          custom_ajax(request_parameters);
        }
      });

    }
  }else {
    custom_ajax(request_parameters);
  }
  return false;
 
}

$(document).ajaxStart(function (){
  //Show loading
  timer = setTimeout(function() { 
    $("#preloader").show();
  }, 3500);
  
}).ajaxStop(function () {
  clearTimeout(timer);
  //Hide loading
  $("#preloader").hide();
})

function mark_as_checked(current_form, data, field, value) {
  if (data) {
    $.each(data, function(k, v) {
      $(current_form).find(`input[name='${field}[${v[value]}]']`).prop('checked', true);
    });
  }
}

/*
// Exemplo de uso para diferentes conjuntos de dados e campos de valor
mark_as_checked(current_form, data.permissions, 'permission', 'permission_id');
mark_as_checked(current_form, data.services, 'service', 'service_id');
mark_as_checked(current_form, data.service_groups, 'service_group', 'service_group_id');
*/