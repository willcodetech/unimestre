<?php

  $filters = ["id" => Auth::get_auth_info()['user_id'], "limit" => 1,  ];
  $User = new User();
  $current_user = $User->list($filters);
  $UserPermission = new UserPermission();
  $permission_list = $UserPermission->list_details(["user_id" => Auth::get_auth_info()['user_id'] ]);

  $permissions = "";
  if ( $permission_list ){

    $permissions = "<ul>";
    foreach ( $permission_list as $key => $data ){
      $permissions .= "<li>{$data['description']}</li>";
    }
    $permissions .= "</ul>";
  }
?>

<div class=' col-sm-12 col-md-12 col-lg-12'>
  <div class='card'>
    <div class='card-body'>
    <div class="row">
      <div class="col">
        <button type="button" class="btn bg_willcode_blue btn-sm text-white" 
          onClick='handle_form(this)'
          data-object="user"
          data-action="edit_own"
          data-id="<?= $current_user[0]['id']; ?>"
          onClick="handle_form(this);"
          data-toggle_ajax="modal" 
          data-target="#form_modal" 
          data-form="user" 
          data-modal_text= "<?= TranslationHelper::get_text("generic_edit"); ?>: <?= $current_user[0]['login']; ?> - <?= $current_user[0]['name']; ?>"
          data-api="user" 
          data-api_action="get_form" 
          data-mode= "edit_own",
          data-api_action_get="list_own"
          data-api_id="<?= $current_user[0]['id']; ?>"
          data-method="POST"
          data-reload="true"
          data-hide_form="true"
        >
          <i class="icon-pencil menu-icon"></i> <?= TranslationHelper::get_text("generic_edit"); ?>
        </button>

        <button type="button" class="btn bg-secondary btn-sm text-dark" 
          onClick='handle_form(this)'
          data-object="user"
          data-action="reset_password_gui"
          data-id="<?= $current_user[0]['id']; ?>"
          onClick= "handle_form(this);"
          data-toggle_ajax="modal" 
          data-target="#form_modal" 
          data-form="user"
          data-modal_text="Resetar Senha: <?= $current_user[0]['login']; ?> - <?= $current_user[0]['name']; ?>"
          data-api="user"
          data-api_action="get_form"
          data-mode="reset_password_gui"
          data-api_action_get="list_own"
          data-api_id="<?= $current_user[0]['id']; ?>"
          data-method="POST"
          data-reload="true"
          data-hide_form="true"
        >
          <i class="icon-lock menu-icon"></i> <?= TranslationHelper::get_text("generic_change_password"); ?>
        </button>
        <hr>

        <div class="table-responsive">
          <table class="table table-bordered responsive">
            <tr>
              <th colspan="2" class="text-center bg-secondary"><?= TranslationHelper::get_text("my_data"); ?></th>
            </tr>
            <tr>
              <th><?= TranslationHelper::get_text("generic_name"); ?>:</th>
              <td><?= $current_user[0]['name']; ?></td>
            </tr>
            <tr>
              <th><?= TranslationHelper::get_text("generic_email"); ?>:</th>
              <td><?= $current_user[0]['email']; ?></td>
            </tr>
            <tr>
              <th><?= TranslationHelper::get_text("generic_login"); ?>:</th>
              <td><?= $current_user[0]['login']; ?></td>
            </tr>
            <?php 
              if ( $current_user[0]['profile_picture_url'] ){
            ?>
            <tr class="{_hide_profile_picture}">
              <th><?= TranslationHelper::get_text("generic_profile_picture"); ?>: <button type="button" class="btn bg-secondary btn-sm remove_profile_picture" data-id="<?= $current_user[0]['id']; ?>"><?= TranslationHelper::get_text("remove_profile_picture"); ?></button></th>
              <td><img src="<?= $current_user[0]['profile_picture_url']; ?>" height="200" width="200" alt=""></td>
            </tr>
            <?php 
              }
            ?>
            <tr>
              <th><?= TranslationHelper::get_text("generic_profile"); ?></th>
              <td><?= $current_user[0]['role']; ?></td>
            </tr>
            <!--
            <tr>
              <th colspan="2" class="text-center bg-secondary"><?= TranslationHelper::get_text("my_permissions"); ?></th>
            </tr>
            <tr>
              <td colspan="2"><?= $permissions; ?></td>
            </tr>
            -->
            
          </table>
        </div>
      </div>
    </div>
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
        title: '<?= TranslationHelper::get_text("confirm_remove_profile_picture_title"); ?>',
        html: '<?= TranslationHelper::get_text("confirm_remove_profile_picture_text"); ?>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "<?= TranslationHelper::get_text("generic_confirm"); ?>",
        cancelButtonText: "<?= TranslationHelper::get_text("generic_cancel"); ?>"
      }).then((result) => {
        if (result.isConfirmed) {             
          console.log("remover")
          custom_ajax(request_parameters);

        }
      });
    })
  })
</script>