/*
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong!',
  footer: '<a href="">Why do I have this issue?</a>'
})
*/

function popup(type = "info", parameters = {}){
  // console.table(parameters);
  let config = {    
    icon: type,
    title: parameters.title,
    html: parameters.text,
    reverseButtons: true,
  }
 
  if ( parameters.reload ){
    // console.warn("RECARREGA PAGINA")
    swal.fire(config).then(() => {
      location.reload();
    });
  } else if ( parameters.redirect_url ){
    location.href = parameters.redirect_url;
  } else {
    Swal.fire(config);
  }
}

const api_url = "/api/";

function handle_form2(parameters = {}){
  let form = $(`form[id='${parameters.form_id}']`);
  if ( !form )
    // console.warn(`form not found, id: ${parameters.form_id}`);

  $(form).trigger(`reset`);
  $(form).data(`form_parameters`, JSON.stringify(parameters));
}


      
function submit_form2(parameters = {}){
  let form = $(`form[id='${parameters.form_id}']`);
  let formdata = new FormData($(form)[0]);
  let form_parameters = $(form).data(`form_parameters`);

  $.each(form_parameters, function(parameter, value){ // extra parameters before submit (used for api control and before/after)
    formdata.append(parameter, value);
  });
  
  // console.log(formdata);
  let link = form_parameters.submit_url;
  $.ajax({
    type: form_parameters.method,
    url: link,
    data: formdata ,
    processData: false,
    contentType: false

  }).fail(function(data){
    let response = (data.responseJSON);
    // console.log(data.responseJSON);
    popup("error", response.popup);
  }).done(function (data) {
    // console.log(data);
    data.popup.reload = true;
    popup("success", data.popup);
    
  });
}

function decimalToTime(info) {
  var hrs = parseInt(Number(info));
  var min = Math.round((Number(info)-hrs) * 60);
  if ( hrs < 10 ){
      hrs = "0"+hrs
  }
  if ( min < 10 ){
      min = "0"+min
  }
  return hrs+':'+min;
}

function format(value, format){

  switch (format){

      case "BRL":
        value = value.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
          break;

      case "DECIMAL_TO_TIME":
        value = decimalToTime(value);
          break;

      case "undefined":
      case "":
      case "default":
      default:
        value = parseFloat(value).toFixed(4);
          break;

  }

  return value; 
}


// refresh session every 30 minutes
var check_session = function () {
  $.get("/api/?api=auth&action=check_session", function(data){
    if ( data.redirect_url )
      window.location.href = data.redirect_url;
  });
},

interval = 2 * 60 * 3000;

setInterval(check_session, interval);

function format_number_local(input, clear_value = false) {
  // Obtém o valor do campo
  let valor = input.value;

  // Remove todos os caracteres que não sejam dígitos
  valor = valor.replace(/\D/g, '');

  // Converte o valor para número
  valor = parseFloat(valor) / 100;

  // Formata o valor para o formato de moeda brasileiro
  valorFormatado = valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

  // Atualiza o valor no campo
  input.value = ( clear_value ? valor : valorFormatado );

  // Retorna o valor como número
  return valor;
}

function format_number_currency(input, clear_value = false) {
  // Obtém o valor do campo
  let valor = input.value;

  // Remove todos os caracteres que não sejam dígitos
  valor = valor.replace(/\D/g, '');

  // Converte o valor para número
  valor = parseFloat(valor) / 100;

  // Formata o valor para o formato de moeda 
  valorFormatado = valor.toLocaleString('es-ES', { minimumFractionDigits: 4 });

  // Atualiza o valor no campo
  input.value = ( clear_value ? valor : valorFormatado );

  // Retorna o valor como número
  return valor;
}

function format_phone_local(input) {
  // Obtém o valor do campo
  let telefone = input.value;

  // Remove todos os caracteres que não sejam dígitos
  telefone = telefone.replace(/\D/g, '');

  // Verifica se o número tem 10 ou 11 dígitos (com DDD)
  if (telefone.length === 11) {
      // Formata o telefone com DDD
      telefoneFormatado = `(${telefone.substring(0, 2)}) ${telefone.substring(2, 7)}-${telefone.substring(7)}`;
  } else if (telefone.length === 10) {
      // Formata o telefone sem DDD
      telefoneFormatado = `${telefone.substring(0, 2)} ${telefone.substring(2, 6)}-${telefone.substring(6)}`;
  } else {
      // Retorna o valor original se não for possível formatar
      telefoneFormatado = telefone;
  }

  // Atualiza o valor no campo
  input.value = telefoneFormatado;

  // Retorna o telefone formatado
  return telefone;
}

function clear_phone_value(input) {
  //let input = document.getElementById('telefone');
  let telefoneSemFormato = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
  // Aqui você pode enviar o telefoneSemFormato para o backend
  // console.log(telefoneSemFormato); // Telefone sem formatação
  return telefoneSemFormato;
}


// Campo select com opções vindas do ajax https://select2.org/data-sources/ajax
//$(document).ready(function(){

function enable_select2(){
	$(".select_ajax_dataset").each(function(){

    var campo = this;
    var parametrosPesquisa = $(campo).data("select2_parameters");
    //var campoPesquisa = $(campo).data("select2-campo-pesquisa");
    var campoPesquisa = parametrosPesquisa.search_field;

    let url_parameters = parametrosPesquisa;
    // console.warn(parametrosPesquisa);
   

    // console.table(url_parameters);
    // console.warn($.param(url_parameters));

    if ( campoPesquisa == "" || parametrosPesquisa == ""){
        
    }else{
                
      $(campo).select2({
        width: '100%',
        //minimumInputLength: 1,
        allowClear: true,
        placeholder: "Selecione...",

        theme: 'bootstrap4',    
        dropdownParent: $(campo).closest("form"), // impedia a digitação quando existem muitos campos
        ajax: {

          url: `/api/?api=helper_select2&action=get_itens&${$.param(url_parameters)}`,
          delay: 450,                      
          data: function (params) {
    
            var query = {filters: {} }

            if ( parametrosPesquisa.related_fields != undefined ){
              $.each(parametrosPesquisa.related_fields, function(field_name, filter){                
                filter_key = `${field_name}${filter}`; 
                let current_value = $(campo).closest("form").find(":input[name='" + field_name + "']").val();
                if ( current_value  )
                  query['filters'][filter_key] = current_value;

              })
              
            }
            if ( parametrosPesquisa.query_filters != undefined ){
              $.each(parametrosPesquisa.query_filters, function(field_name, filter_value){
                console.warn(`field_name -> ${field_name} value -> ${filter_value}`)

                if ( ( field_name != undefined ) && filter_value ){
                  query['filters'][field_name] = filter_value;
                   
                }                  

              })
              
            }
            
            if ( parametrosPesquisa.related_fields_required ){
              $.each(parametrosPesquisa.related_fields_required, function(k, v){
                let current_value = $(campo).closest("form").find(":input[name='" + v + "']").val();
                if ( !current_value ){
                  let label = $(`label[for='${v}']`).text();
                  popup("error", { text: `Campo ${label} deve ser informado`, title: 'Aviso'});
                  $(campo).val("");
                  $(campo).trigger('change.select2');
                  return;
                }
                query['filters'][v] = current_value;
              });
            };
            query['filters'][campoPesquisa] = params.term;
            return query;
            
          },
            
        },
        
        escapeMarkup: function(markup) {
          return markup;
        },
        templateResult: function(data) {
          return data.html;
        },
        templateSelection: function(data) {
          return data.text;
        }
      });
    }

	})
}

function testes_(){
  if ( $(PARAMETROS.FORM).find("textarea.codemirror") ){

    if ( camposCodeMirror[$(PARAMETROS.FORM).find("textarea.codemirror").attr("id")] != undefined ) {
        camposCodeMirror[$(PARAMETROS.FORM).find("textarea.codemirror").attr("id")].setValue("");

        /**/
        setTimeout(function() {
            camposCodeMirror[$(PARAMETROS.FORM).find("textarea.codemirror").attr("id")].refresh();
            camposCodeMirror[$(PARAMETROS.FORM).find("textarea.codemirror").attr("id")].save();
        },100);
        
        $($(PARAMETROS.FORM).find("textarea.codemirror")).trigger("focus");
        
    }
  }
}

  /*
   * Hacky fix for a bug in select2 with jQuery 3.6.0's new nested-focus "protection"
   * see: https://github.com/select2/select2/issues/5993
   * see: https://github.com/jquery/jquery/issues/4382
   *
   * TODO: Recheck with the select2 GH issue and remove once this is fixed on their side
   */


  docReady(function(){

    $('select').select2();

    $(document).on('select2:open', function(e) {
      document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
    });
  });


  function enable_text_editor(parameters = {}){

    docReady(function(){

      $('.textarea_editor').trumbowyg({
        //prefix: 'custom-prefix'
      });
    })
  }

  // generate table with attchment and select fields
  function get_html_table_attachments(register_id_in, object_in){
    // console.log(`register_id ${register_id_in} \n object ${object_in}`)

    if ( !register_id_in && !object_in )
      return false;

    let request_parameters_files = {
      action: "html_table_checkbox",
      api: "file",
      //object_in: 'notification,sale',
      object_in: object_in,
      //register_id_in: `${notification_id},${sale_id}`,
      register_id_in: register_id_in,
      summary: true,
      type: "attachment"
    }
    $.get("/api/", request_parameters_files, function(data){
      //// console.warn(data);
      if ( data.html )
        $(".form_file_list_table").html(data.html);
    });

  }
  $(document).on("change", "select.get_notification_text", function(){
    // console.log(this);
    //$(".form_file_list_table").html("");
    let notification_id = $(this).val();
    let form = $(this).closest("form");
    let field = $(form).find(":input[name='text']");
    let sale_id = $(form).find(":input[name='id']").val();

    get_html_table_attachments(`${notification_id},${sale_id}`, 'notification,sale' );
    /*
    if ( !notification_id )
      return false;
    */
    let request_parameters = {
      action: "list",
      id: notification_id, 
      api: "notification"
    }
    $.get("/api/", request_parameters, function(data){
      // console.warn(data);
      if ( data[0] ){
        if ( data[0].text ){
          
          if ( $(field).hasClass("textarea_editor") ){
            $(field).trumbowyg('html', data[0].text);
          }
        }

      }
    });


  })

  function enable_date_range_picker2(){
    $('.date_range_picker').daterangepicker({
      ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
        'Este Mês': [moment().startOf('month'), moment().endOf('month')],
        'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },   
      "showDropdowns": true,
      "opens": "center",
      //"drops": "up",
      "alwaysShowCalendars": true,
      "applyButtonClasses" : "bg_willcode_blue",
      "cancelButtonClasses": "bg_willcode_red",
      //"startDate": new Date(),
      //"endDate": new Date(),
      "parentEl": $(this).parent() ,
      "autoUpdateInput": false,
      "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Até",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Dom",
            "Seg",
            "Ter",
            "Qua",
            "Qui",
            "Sex",
            "Sab"
        ],
        "monthNames": [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ],
        "firstDay": 1,
        "drops": "auto"
      },
    }, function(start, end, label) {
      // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });

    $('input.date_range_picker').on('apply.daterangepicker', function(ev, picker) {
      let range = picker.startDate.format('YYYY-MM-DD') + ',' + picker.endDate.format('YYYY-MM-DD')
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
      $(this).data("range", range)
    });

    /**/
    $('input.date_range_picker').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $(this).data("range", '')
    });

    $('input.date_range_picker').on('show.daterangepicker', function() {
      var windowHeight = $(window).height(); // altura da janela
      var windowWidth = $(window).width(); // largura da janela
      var calendarHeight = $('.daterangepicker').outerHeight(); // altura do calendário
      var calendarWidth = $('.daterangepicker').outerWidth(); // largura do calendário
  
      // calcula a posição do topo e da esquerda do calendário para centralizá-lo
      var topPosition = (windowHeight - calendarHeight) / 2;
      var leftPosition = (windowWidth - calendarWidth) / 2;
  
      // define a posição do calendário
      $('.daterangepicker').css({
          'top': topPosition + 'px',
          'left': leftPosition + 'px'
      });
  });
  

  }

  function enable_date_range_picker(){
    $('.date_range_picker').daterangepicker({
      ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
        'Este Mês': [moment().startOf('month'), moment().endOf('month')],
        'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },   
      "showDropdowns": true,
      "opens": "center",
      //"drops": "up",
      "alwaysShowCalendars": true,
      "applyButtonClasses" : "bg_willcode_blue",
      "cancelButtonClasses": "bg_willcode_red",
      //"startDate": new Date(),
      //"endDate": new Date(),
      "parentEl": $(this).parent() ,
      "autoUpdateInput": false,
      "autoApply": true,
      "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Até",
        "showCustomRangeLabel": false,
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Dom",
            "Seg",
            "Ter",
            "Qua",
            "Qui",
            "Sex",
            "Sab"
        ],
        "monthNames": [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ],
        "firstDay": 1,
        "drops": "auto"
      },
    }, function(start, end, label) {
      // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });

    $('input.date_range_picker').on('apply.daterangepicker', function(ev, picker) {
      let range = picker.startDate.format('YYYY-MM-DD') + ',' + picker.endDate.format('YYYY-MM-DD')
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
      $(this).data("range", range)
    });

    /**/
    $('input.date_range_picker').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $(this).data("range", '')
    });

    $('input.date_range_picker').on('show.daterangepicker',  function() {
      // console.log(" MOSTRAR ")
      var windowHeight = $(window).height(); // altura da janela
      var windowWidth = $(window).width(); // largura da janela
      var calendarHeight = $('.daterangepicker').outerHeight(); // altura do calendário
      var calendarWidth = $('.daterangepicker').outerWidth(); // largura do calendário
  
      // calcula a posição do topo e da esquerda do calendário para centralizá-lo
      var topPosition = (windowHeight - calendarHeight) / 2;
      var leftPosition = (windowWidth - calendarWidth) / 2;
  
      // define a posição do calendário
      $('.daterangepicker').css({
        'top': topPosition + 'px',
        'left': leftPosition + 'px'
      });
  });
  

  }
  function show_confetti(){
    var count = 900;
       var defaults = {
          origin: { y: 0.7 }
       };

       function fire(particleRatio, opts) {
          confetti({
          ...defaults,
          ...opts,
          particleCount: Math.floor(count * particleRatio)
          });
       }

       fire(0.25, {
          spread: 26,
          startVelocity: 55,
       });
       fire(0.2, {
          spread: 60,
       });
       fire(0.35, {
          spread: 100,
          decay: 0.91,
          scalar: 0.8
       });
       fire(0.1, {
          spread: 120,
          startVelocity: 25,
          decay: 0.92,
          scalar: 1.2
       });
       fire(0.1, {
          spread: 120,
          startVelocity: 45,
       });
 }


 function initializeAutoNumericFields(selector) {
  AutoNumeric.multiple(selector, {
    digitGroupSeparator: '.',
    decimalCharacter: ',',
    decimalPlaces: 2,
    allowDecimalPadding: true,
    alwaysAllowDecimalCharacter: true,
    modifyValueOnWheel: false,
    watchExternalChanges: true,
    unformatOnHover: false, // Evita desformatar ao passar o mouse
    unformatOnSubmit: true // Remove a formatação ao enviar o formulário
      
  });
}

function formatInitialValues(value) {
  var formattedValue = AutoNumeric.format(value, {
    digitGroupSeparator: '.',
    decimalCharacter: ',',
    decimalPlaces: 2
  });
  return formattedValue;

}

docReady(function(){
  // Inicializar campos autoNumeric existentes na página
  initializeAutoNumericFields('.numeric_field');
});
