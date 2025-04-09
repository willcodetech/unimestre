<div class="row">
  <div class="col">
    
    <hr>

    <div class="table-responsive">
     
      <?php 
        foreach ( TranslationHelper::get_all_texts() as $key => $text ){
          echo "Key => {$key} Value => {$text}<hr>";
        }
          Helper::debug_data($_SESSION);
      ?>
    </div>
  </div>
</div>

<script>
  docReady(function(){
    $(document).on("click", ".remove_profile_picture", function(){
      let formdata = new FormData();
      formdata.append(`action`, 'remove_profile_picture');
      formdata.append(`id`, $(this).data("id"));
      formdata.append(`api`, `user`);

      let request_parameters = {
        type: 'POST',
        link: "/api/",
        form_data: formdata,
        reload: true
      }

      Swal.fire({
        title: "Remover foto?",
        html: "A foto de perfil será excluída e não poderá ser ruperada. <br>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {             
          console.log("remover")
          custom_ajax(request_parameters);

        }
      });
    })
  })
</script>