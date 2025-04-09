<?php
  include_once(TEMPLATES_DIR . "core/head.php");
?>
  <body class="bg_light_gray" >
    <header class="navbar navbar-dark sticky-top bg-secondary flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#"><?=$_page_parameters['page_header'];?></a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle">
        <span class="navbar-toggler-icon"></span>
      </button>
    </header>


    <div class="container-fluid">
      <div class="row">

        <!-- sidebar menu -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse" class="bg_light_gray">

          <div class="position-sticky pt-3 sidebar-sticky">
            <ul class="nav flex-column">
              <!--
              <li class="nav-item">
                <a class="nav-link " aria-current="page" href="/recurso/">
                <span data-feather="shield" class="align-text-bottom"></span>
                Recursos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/contrato/">
                <span data-feather="layers" class="align-text-bottom"></span>
                Contratos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/tarefa/">
                <span data-feather="check" class="align-text-bottom"></span>
                Tarefas
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/tarefa_contrato/">
                <span data-feather="list" class="align-text-bottom"></span>
                Tarefas x Contratos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/recurso_contrato/">
                <span data-feather="tool" class="align-text-bottom"></span>
                Recursos x Contratos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/logout/">
                <span data-feather="log-out" class="align-text-bottom"></span>
                Sair
                </a>
              </li>
              -->
              <?php 
                echo HtmlHelper::create_menu();
              ?>
            </ul>
          </div>

        </nav>
        <!-- end siderbar menu -->

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="row">
            <div class="col-12"><hr>
              <h3>
                <?=$_page_parameters['page_subtitle'];?>
                <a href="#" class="btn btn-sm bg-secondary text-white" id="btn_create" >Adicionar</a>
              </h3>
              <div class="">
                <?php
                  /*
                  $Contrato = new Contrato();
                  $list = $Contrato->list();
                  //Helper::debug_data($list);
                  //$list = $Body->get_datatable_list($list);
                  //echo DataTable::array_to_table($list);
                  $parameters = $Contrato->to_datatable($list);
                  //Helper::debug_data($parameters);
                  echo DataTable::create($parameters);
                  */
                ?>
              </div>

              <div class="modal fade modal-lg" id="modal_form_contrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Cadastro de Contrato</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="contrato" name="contrato" class="form form-group form-sm" >
                        
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-primary btn_submit_form" id="btn_submit_form" data-form_id="contrato">Confirmar</button>
                    </div>
                  </div>
                </div>
              </div>
              
              <br>
              <br>
              <hr>
              <div class="modal fade modal-lg" id="modal_resumo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Cadastro de Contrato</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="resumos">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <?php 
      include_once(TEMPLATES_DIR . "core/scripts_js.php");
    ?>
  </body>

</html>
