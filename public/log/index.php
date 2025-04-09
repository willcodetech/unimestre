<?php

  //ini_set('display_errors', 1);
  //ini_set('display_startup_errors', 1);
  //error_reporting(1);
  //$Teste = new Banana();

  Auth::redirect_if_not_logged();

  if ( !Auth::is_admin() )
    Auth::redirect("/index.php");

  if ( isset($_REQUEST['clear'])){
		file_put_contents(ERROR_LOG, "");
		header("Location: /log/");
	}

  $log = file_get_contents(ERROR_LOG);

	$log_content = <<<HTML
			
		<!DOCTYPE html>
		<html>
			<title>Error Log</title>

		<script type="text/javascript" src="/assets/plugins/datatables/datatables.min.js"></script>

		<style>
			
				.erro{
					
					color: #ffffff;
					background-color: #b70303;
					
				}
				
				.info{
					
					color: #070707;
					background-color: #5ddd40;
					
				}
			
				.warning{
					
					color: #383635;
					background-color: #f49841;
					
				}
				
				
				.depre{
					
					color: #000000;
					background-color: #ad42f4;
					
				}
				
			
		</style>

		<script>

			$(document).ready( function() {
				
				$("pre:contains('Deprecated')").html(function(_, html) {
					return  html.replace(/(Deprecated)/g, '<span class="depre">$1</span>')
				});
				
				$("pre:contains('ERROR')").html(function(_, html) {
					return  html.replace(/(ERROR)/g, '<span class="erro">$1</span>')
				});
				
				$("pre:contains('Fatal')").html(function(_, html) {
					return  html.replace(/(Fatal)/g, '<span class="erro">$1</span>')
				});
				
				$("pre:contains('INFO')").html(function(_, html) {
					return  html.replace(/(INFO)/g, '<span class="info">$1</span>')
				});
				
				$("pre:contains('Notice')").html(function(_, html) {
					return  html.replace(/(Notice)/g, '<span class="info">$1</span>')
				});

				$("pre:contains('WARNING')").html(function(_, html) {
					return  html.replace(/(WARNING)/g, '<span class="warning">$1</span>')
				});
				
				$("pre:contains('Warning')").html(function(_, html) {
					return  html.replace(/(Warning)/g, '<span class="warning">$1</span>')
				});
				
				//$('html,body').animate({scrollTop: document.body.scrollHeight},"fast");
				
			});

		</script>

		<pre>{$log}</pre><a href="?clear" class='btn btn-sm btn-primary'>Clear log</a>
		</html>
		HTML;
  $filters = $_REQUEST;
  $filters["limit"] = ( $_REQUEST['limit'] ??  10000 );
    
  $template_parameters['data']['table'] = $log_content;

  $template_parameters['page_subtitle']  = TranslationHelper::get_text("page_subtitle_log");
  $template_parameters['page_title'] = TranslationHelper::get_text("page_title_log");
  //$template_parameters['custom_js'] = ["/assets/js/test.js"];
  //$template_parameters['custom_css'] = ["/assets/css/test.css"];
  $template_parameters['views'] = [
    //["object" => "user", "view" => "profile", "extension" => "html" ],
    //["object" => "user", "view" => "profile_full", "extension" => "php" ],
  ];
  $template_parameters['buttons'] = [];
  HtmlHelper::load_page($template_parameters, false);