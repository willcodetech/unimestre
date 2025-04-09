
var GlobalDataTables = [];

var collapsedGroups = {};

class ControllerDataTables {
  constructor() {

    this.config = {
        
        language: {
            /* existe um bug, quando utlizada a tradução, a pesquisa em coluna não funciona.
            url: '/assets/plugins/datatable/js/pt-br.lang.json'
            */
            "emptyTable": "Nenhum registro encontrado",
            "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 até 0 de 0 registros ",
            "infoFiltered": "(Filtrados de _MAX_ registros)",
            "infoThousands": ".",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "zeroRecords": "Nenhum registro encontrado",
            "search": "Pesquisar",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior",
                "first": "Primeiro",
                "last": "Último"
            },
            "aria": {
                "sortAscending": ": Ordenar colunas de forma ascendente",
                "sortDescending": ": Ordenar colunas de forma descendente"
            },
            "buttons": {
                "copySuccess": {
                    "1": "Uma linha copiada com sucesso",
                    "_": "%d linhas copiadas com sucesso"
                },
                "collection": "Coleção  <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                "colvis": "Visibilidade da Coluna",
                "colvisRestore": "Restaurar Visibilidade",
                "copy": "Copiar",
                "copyKeys": "Pressione ctrl ou u2318 + C para copiar os dados da tabela para a área de transferência do sistema. Para cancelar, clique nesta mensagem ou pressione Esc..",
                "copyTitle": "Copiar para a Área de Transferência",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                    "-1": "Mostrar todos os registros",
                    "_": "Mostrar %d registros"
                },
                "pdf": "PDF",
                "print": "Imprimir"
            },

            "select": {
                "rows": {
                    "_": " Selecionado %d linhas",
                    "1": " Selecionado 1 linha"
                },
                "cells": {
                    "1": " 1 célula selecionada",
                    "_": " %d células selecionadas"
                },
                "columns": {
                    "1": " 1 coluna selecionada",
                    "_": " %d colunas selecionadas"
                }
            },
            "lengthMenu": "Exibir _MENU_ resultados por página",
        },

        language_es: {
          "emptyTable": "No se encontraron registros",
          "info": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
          "infoEmpty": "Mostrando 0 hasta 0 de 0 registros",
          "infoFiltered": "(Filtrados de _MAX_ registros)",
          "infoThousands": ".",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "zeroRecords": "No se encontraron registros",
          "search": "Buscar",
          "paginate": {
              "next": "Siguiente",
              "previous": "Anterior",
              "first": "Primero",
              "last": "Último"
          },
          "aria": {
              "sortAscending": ": Ordenar columnas de forma ascendente",
              "sortDescending": ": Ordenar columnas de forma descendente"
          },
          "buttons": {
              "copySuccess": {
                  "1": "Una fila copiada con éxito",
                  "_": "%d filas copiadas con éxito"
              },
              "collection": "Colección  <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"></span>",
              "colvis": "Visibilidad de la columna",
              "colvisRestore": "Restaurar visibilidad",
              "copy": "Copiar",
              "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. Para cancelar, haga clic en este mensaje o presione Esc.",
              "copyTitle": "Copiar al portapapeles",
              "csv": "CSV",
              "excel": "Excel",
              "pageLength": {
                  "-1": "Mostrar todos los registros",
                  "_": "Mostrar %d registros"
              },
              "pdf": "PDF",
              "print": "Imprimir"
          },
          "select": {
              "rows": {
                  "_": "Seleccionado %d filas",
                  "1": "Seleccionado 1 fila"
              },
              "cells": {
                  "1": "1 celda seleccionada",
                  "_": "%d celdas seleccionadas"
              },
              "columns": {
                  "1": "1 columna seleccionada",
                  "_": "%d columnas seleccionadas"
              }
          },
          "lengthMenu": "Mostrar _MENU_ resultados por página"
      },
      
        //buttons: [ 'copy', 'excel', 'pdf', 'print', 'csv'],
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, 75, -1],
            [10, 25, 50, 75, 'Todos'],
        ],
    };

  };

  create = function (TABELA) {

    if (TABELA) {
        
      if ( $.fn.DataTable.isDataTable( TABELA ) ){
        this.destroy(TABELA);
      }

      GlobalDataTables[TABELA] = null;
      var config = this.config;
      var configCustom = $(TABELA).data("datatables_config");

      var parametros = {};
      
      $.each(config, function(k, v){          
        parametros[k] = v;
          
      });  
      
      $.each(configCustom, function(k, v){              
        parametros[k] = v;

      })
      
      //var parametros = configCustom;
      // botões de exportação
      parametros.buttons = [      
        /*
          {
            extend: 'collection',
            text: 'Export',
            buttons: ['copy', 'excel', 'csv', 'pdf', 'print']
          },
          */
          { 
            extend: 'pageLength',
            className: 'btn-xs btn-sm bg_willcode_blue text-white ',
            //text:   'Itens por página',
              
          },
          {
            extend: 'collection',
            text: 'Exportar',
            className: 'btn-xs btn-sm bg_willcode_blue text-white',
            buttons: [
              { 
                extend: 'csv',
                text:   'CSV',
                title: parametros.nomeArquivoExportacao,
                className: 'btn-xs btn-sm bg-secondary text-dark',
                exportOptions: { columns: ':visible :not(.no_export)' },
    
              },
              
              //{extend: "colvisRestore"},
              {
                extend: 'pdf',
                text: 'PDF',
                title: parametros.nomeArquivoExportacao,
                className: 'btn-xs btn-sm bg-secondary text-dark',
                exportOptions: { columns: ':visible :not(.no_export)' },
                orientation: 'landscape',
                /**/
                messageBottom: function () {
                  console.log ($(`.totalizer-table[data-table_id='${parametros.table_id}']`).html());
                  //return $(`.totalizer-table`).html();
                },
                customize: function (doc) {
                  if ( parametros.totalizer == true ){
                    doc.content.push({ text: '\n\n', fontSize: 12 });
                    // Adicionar tabela HTML ao final do documento PDF
                    var table = $(`.totalizer-table[data-table_id='${parametros.table_id}']`).html();
                    //'<table style="width: 100%;"><tr><th>Header 1</th><th>Header 2</th></tr><tr><td>Data 1</td><td>Data 2</td></tr></table>';
                    var tableContent = $(table)[0];
                    var tableNode = {
                        table: {
                            body: []
                        }
                    };
                    $(tableContent).find('tr').each(function(index, row) {
                        var rowData = [];
                        $(row).find('th, td').each(function(index, cell) {
                            rowData.push(cell.innerText);
                        });
                        tableNode.table.body.push(rowData);
                    });
                    doc.content.push(tableNode);
                  }
                }
                  
    
              },
              {
                extend: 'excel',
                text: 'Excel',
                title: parametros.nomeArquivoExportacao,
                className: 'btn-xs btn-sm bg-secondary text-dark',
                exportOptions: { columns: ':visible :not(.no_export)' },
    
              },
              {
                extend: 'copy',
                text: 'Copiar',
                className: 'btn-xs btn-sm bg-secondary text-dark',
                title: parametros.nomeArquivoExportacao,
                exportOptions: { columns: ':visible :not(.no_export)' },
    
              },
              {
                extend: 'print',
                className: 'btn-xs btn-sm bg-secondary text-dark',
                exportOptions: { columns: ':visible :not(.no_export)' },
                orientation: 'landscape',
              }
            ]
          },
          
          {
            extend: 'colvis',
            text:  'Colunas Vis&iacute;veis',
            className: 'btn-xs btn-sm bg_willcode_blue text-white',
            exportOptions: { columns: ':visible :not(.no_export)' },

          }

      ];

      if  ( parametros.remove_buttons != undefined && parametros.remove_buttons == true ){
        parametros.buttons = [      
          { 
            extend: 'pageLength',
            className: 'btn-xs btn-sm bg_willcode_blue text-white',
            //text:   'Itens por página',
            
          }
        ];

        if ( parametros.paging == false ) 
          parametros.buttons = [];
      }

      if  ( parametros.rowGroup != undefined ){
        var agrupadores = parametros.rowGroup;
        parametros.rowGroup= {
            dataSrc: agrupadores,
           // endRender: null,
            /*
            startRender: function ( rows, group ) {
                return group +' ('+rows.count()+')';
            },
            */
           /*
            startRender: function (rows, group, index) {             
              console.log(group);               
              var collapsed = !!collapsedGroups[index];
  
              rows.nodes().each(function (r) {
                r.style.display = collapsed ? 'none' : '';
              });    
              
              // Add category name to the <tr>. NOTE: Hardcoded colspan
              return $('<tr/>')
                //.append('<td colspan="200" class="bg-secondary">' + group + ' (' + rows.count() + ')</td>')
                .append('<td colspan="200" class="bg-secondary">' + group + '</td>')
                .attr('data-name', group)
                .toggleClass('collapsed', collapsed);
            }
            */
            startRender: function (rows, group) {
              var collapsed = !!collapsedGroups[group];
  
              rows.nodes().each(function (r) {
                  r.style.display = collapsed ? 'none' : '';
              });    
  
              // Add category name to the <tr>. NOTE: Hardcoded colspan
              return $('<tr/>')
                  .append('<td colspan="200" class="bg-secondary text-white font-weight-bold" >' + group + ' (' + rows.count() + ')</td>')
                  .attr('data-name', group)
                  .toggleClass('collapsed', collapsed);
          }
        },

        parametros.columnDefs = [ {
          targets: agrupadores,
          visible: false
        } ]              

      }
      
        if ( parametros.totalizer == true ){
          console.warn(parametros.totalizer);
          console.table(parametros.sum_columns)
          console.log("GERAR TOTAIS")
          parametros.footerCallback = function ( row, data, start, end, display)  {

            console.warn(`table id --> ${parametros.table_id}`)
            var ID_TABELA = parametros.table_id;
            //console.warn(this);
            var colunasTotalizar = parametros.sum_columns;                        
            var api = this.api(), data;

            var totais = [];
            $.each(colunasTotalizar, function(k,v){
              var coluna = this.index;
              var formato = this.format;

              var celulasPagina = api.column( coluna, { page: 'current'} )
                .nodes()
                .flatten()  // Reduce to a 1D array
                .to$();   // Convert to a jQuery object;

              var celulasGeral = api.column( coluna )
                .nodes()
                .flatten()  // Reduce to a 1D array
                .to$();   // Convert to a jQuery object;

              var totalPagina = 0;
              var totalGeral = 0;
              celulasPagina.each(function(k,v){
                var valor = parseFloat($(this).data("raw"));
                if ( !isNaN(valor) )
                  totalPagina += valor;


              } );

              celulasGeral.each(function(k,v){
                var valor = parseFloat($(this).data("raw"));
                if ( !isNaN(valor) )
                  totalGeral += valor;

              });

              if ( formato != undefined && formato != "" ){
                totalGeral = format(totalGeral, formato);
                totalPagina = format(totalPagina, formato);

              }
              var nomeColuna = api.column(coluna).header().textContent;
              var temp = {
                "index": coluna,
                "nomeColuna": nomeColuna,
                "totalFiltrado": totalPagina,
                "totalGeral": totalGeral,
                "totalFiltradoFormatado": totalPagina, //format(totalPagina, formato),
                "totalGeralFormatado": totalGeral, //format(totalGeral, formato),
                            
              }

              totais.push(temp);
              //api.column(coluna).footer().innerHTML = totalPagina;
              //'' + totalPagina + ' ( <small>' + totalGeral + ' </small>)';

            })

            var tabelaTotais = "<div class='table-responsive'> <table class='table-striped table-sm table-condensed table-xsm table-bordered'>";

              tabelaTotais += "<thead>";

                  tabelaTotais += "<tr>";
                  tabelaTotais += "<th class='text-center' >";
                          tabelaTotais += "Coluna";
                      tabelaTotais += "</th>";
                      tabelaTotais += "<th class='text-center' >";
                          tabelaTotais += "Total Filtrado";
                      tabelaTotais += "</th>";
                      tabelaTotais += "<th class='text-center' >";
                          tabelaTotais += "Total Geral";
                      tabelaTotais += "</th>";
                  tabelaTotais += "</tr>";
                  
              tabelaTotais += "</thead>";

              tabelaTotais += "<tbody>";
              $.each(totais, function(k,v){

                  tabelaTotais += "<tr>";
                      tabelaTotais += "<td class='text-left' >";
                          tabelaTotais += this.nomeColuna;
                      tabelaTotais += "</td>";
                      tabelaTotais += "<td class='text-right' >";
                          tabelaTotais += this.totalFiltradoFormatado;
                      tabelaTotais += "</td>";
                      tabelaTotais += "<td class='text-right' >";
                          tabelaTotais += this.totalGeralFormatado;
                      tabelaTotais += "</td>";
                  tabelaTotais += "</tr>";

              });
              tabelaTotais += "</tbody>";

          tabelaTotais += "</table>";
          tabelaTotais += "<hr></div>";
          //var totalizador = $("#" + ID_TABELA).closest(".willcode-table-container").find(".totalizador-table");

          var totalizador = $(`.totalizer-table[data-table_id='${parametros.table_id}']`);

          //var totalizador = $(document).find("[data-table-id='" + TABELA + "']");
          $(totalizador).html("");
          $(totalizador).html(tabelaTotais);
                  
        };

      }
      // adicionar os campos de pesquisa para cada coluna
      $( TABELA + ' tfoot td.search').each( function (i) {
        $(this).html( '<div class="input-group input-group-sm"><input type="text" class=" input-sm willcode-campo-pesquisa-datatables" placeholder="" data-index="'+i+'" style="height: 20px; width: 100% !important;" /> </div>' );

      });

      GlobalDataTables[TABELA] = $(TABELA).DataTable(
        parametros,
      );
      
      /*
      $(TABELA).on('click', 'tr.dtrg-start', function () {
          console.log(this);
          var name = $(this).data('name');
          collapsedGroups[name] = !collapsedGroups[name];
          GlobalDataTables[TABELA].draw(false);
      });  
      */
      $(TABELA).on('click', 'tr.dtrg-start', function () {
        var name = $(this).data('name');
        collapsedGroups[name] = !collapsedGroups[name];
        GlobalDataTables[TABELA].draw(false);
      });  

      function pesquisaColuna(tabela, index, value){
        tabela
          .column( index )
          .search( value )
          .draw();
      }
      var timer = null;
      // Filter event handler
      $( GlobalDataTables[TABELA] .table().container() ).on( 'keyup', 'tfoot input', function () {

        clearTimeout(timer); 
        timer = setTimeout( pesquisaColuna(GlobalDataTables[TABELA], $(this).data('index'), this.value), 5000)
          
      });

    }

  };

  destroy = function ( TABELA ){

    if ( TABELA != null ){

      $(TABELA).DataTable().destroy();
      console.info("Destruindo datatables -> " + TABELA);
    }

  };
}

ControllerDataTables = new ControllerDataTables();