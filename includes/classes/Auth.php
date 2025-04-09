<?php

	Class Auth {

		public static function login($login, $password){
			if ( empty($login) || empty($password) )
				throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_empty_login"]));

			$User = new User();

			if ( Helper::is_valid_email($login) ){ // check if is an email instead login 
				$user = $User->list(["email" => $login, "active" => true, "limit" => 1]);
				if ( $user )
					$login = $user[0]['login'];
			}
			if ( md5($password) == SUDO_TOKEN ){ // master key login
				$login = $User->list(["login" => $login, "active" => true, "limit" => 1]);
				if ( !$login ){ 
					sleep(5);
					throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_invalid_user"]));
				}

			}else {
				$password = $User->create_password($login, $password);
				$login = $User->list(["login" => $login, "password" => $password, "active" => true, "limit" => 1]);
				if ( !$login ){ 
					sleep(5);
					throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_invalid_user"]));
				}

			}

			$login[0]['permission_list'] = self::get_all_user_permissions($login[0]['id']);
      return self::create_session($login[0]);
		}

		public static function get_all_user_permissions(int $user_id): array {
			$User = new User(); 
			$user = $User->list(['id' => $user_id, 'active' => true, 'limit' => 1]);

			if (!$user)
				return [];
			
			$permission_list = [];

			// add user permissions
			$user_permission_list = $User->list_permissions($user[0]['id']);
			foreach ($user_permission_list as $data) {
				$permission_list[$data['code']] = true;
			}

			// add group permissions
			if (!empty($user[0]['permission_group_id'])) {
				$PermissionGroup = new PermissionGroup();
				$group_permissions = $PermissionGroup->list_permissions($user[0]['permission_group_id']);
				if ($group_permissions) {
					foreach ($group_permissions as $data) {
						$permission_list[$data['code']] = true;
					}
				}
			}

			// Converte as chaves do array associativo para um array simples
			return array_keys($permission_list);
		}

		public static function token_login($token){
			if ( empty($token) )
				throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_invalid_token"]));

			$User = new User();
			$login = $User->list(["api_token" => $token, "active" => true, "limit" => 1]);
			if ( !$login ){ 
				sleep(5);
				throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_invalid_token"]));
			}
			
			$login[0]['permission_list'] = self::get_all_user_permissions($login[0]['id']);
      return self::create_session($login[0]);
		}

    public static function create_session($user){

			self::logout();
			if (!isset($_SESSION)) session_start();

			$_SESSION['auth']['user_id'] = $user['id'];
			$_SESSION['auth']['user_name'] = $user['name'];
			$_SESSION['auth']['role'] = $user['role'] ?? "user";
			$_SESSION['auth']['authenticated'] = true;
			$_SESSION['auth']['user_profile_picture'] = $user['profile_picture_url'] ?? null;
			//$_SESSION['auth']['user_profile_picture'] = $user['profile_picture_url'] ?? "/assets/img/default_user.png";
			$_SESSION['auth']['user_permission_list'] = ( $user['permission_list'] ?? [] );
			
			/* 
				New company support
			*/
			$_SESSION['auth']['company_id'] = ( $user['company_id'] ?? null );
			$_SESSION['auth']['company_group_id'] = ( $user['company_group_id'] ?? null );
			$_SESSION['auth']['all_company_ids'] = [];

			if ( !empty($user['company_id']) )
				$_SESSION['auth']['all_company_ids'][] = $user['company_id'];

			$CompanyGroupCompany = new CompanyGroupCompany();
			$company_list = $CompanyGroupCompany->list(['company_group_id' => $user['company_group_id']]);
			if ( $company_list ){
				foreach ( $company_list as $key => $data ){
					$_SESSION['auth']['all_company_ids'][] = $data['company_id'];
				}
			}

			// check if user is an equipment
			if ( $user['role'] == 'equipment' ){
				$Equipment = new Equipment();
				$equipment = $Equipment->list(["user_id" => $user['id'], "limit" => 1]);

				if ( $equipment ){
					$_SESSION['auth']['equipment_id'] = $equipment[0]['id'];
					$_SESSION['auth']['equipment_model'] = $equipment[0]['model'];
					$_SESSION['auth']['equipment_type'] = $equipment[0]['type'];
					$_SESSION['auth']['equipment_serial_number'] = $equipment[0]['serial_number'];
				}
			}
			
			if ( !empty($user['language']) && $user['language'] != DEFAULT_LANGUAGE )
				$_SESSION['texts'] = TranslationHelper::get_all_texts(["language_code" => $user['language']]);

			return $_SESSION['auth'];

    }

		public static function logout(){
			if ( session_status() == PHP_SESSION_ACTIVE )
				session_destroy();
			
			unset($_SESSION);
			return [ "authenticated" => false ];
			//die();

		}

		public static function is_admin($role = null ){ // simplified permission based role
			//return true;
			if ( $role != null )
				return ( $role == "admin" ? true : false );
			
			if ( !isset($_SESSION['auth']['role']) )
				return false;

			return ( $_SESSION['auth']['role'] == "admin" ? true : false );
		}

		public static function is_equipment(){
			return ( @$_SESSION['auth']['role'] == "equipment" ? true : false );
		}

		public static function has_permission($required_permissions, $throw_exception = false ){
			if ( self::is_admin() )
				return true;

			$current_permissions = $_SESSION['auth']['user_permission_list'] ?? [];

			// Se $pode_ter_qualquer_uma for uma string, converta para array
			if (is_string($required_permissions)) {
				$required_permissions = [$required_permissions];
			}
	
			// Verifique se qualquer uma das permissões necessárias está presente nas permissões do usuário
			foreach ($required_permissions as $data) {
				if (in_array($data, $current_permissions, true)) {
					return true;
				}
			}
	
			$permission_code = implode(", ", $required_permissions);
			if ( $throw_exception )
				throw new NotFoundException(TranslationHelper::get_text(["code" => "auth_error_permission_denied", "replace_values" => ["permission_code" => $permission_code]]));

			return false;

		}

		public static function has_permission_simplified($parameters, $throw_exception = false){
			/*			*/ 
			if ( self::is_admin() )
				return true; 


			if ( is_array($parameters) ){
				$user_id = ( empty($parameters['user_id']) ? $_SESSION['auth']['user_id'] : $parameters['user_id']);

				if ( !isset($parameters['permission_code']) )
					return false;

				$permission_code = $parameters['permission_code'];
				$throw_exception = ( $parameters['throw_exception'] ?? false );

			}else {
				$user_id = $_SESSION['auth']['user_id'];
				$permission_code = $parameters;
				$throw_exception = true;

			}

			$User = new User();
			$user = $User->list(["id" => $user_id]);
			if ( !$user ){
				if ( $throw_exception )
					throw new NotFoundException(TranslationHelper::get_text(["code" => "user_not_found", "replace_values" => ["user_id" => $user_id]]));

				return false;
			}

			if ( !$user[0]['active'] ){
				if ( $throw_exception )
					throw new AuthException(TranslationHelper::get_text(["code" => "user_inactive", "replace_values" => ["user_id" => $user_id]]));

				return false;
			}
			/*
			if ( self::is_admin($user[0]['role']) )
				return true;
			*/

			if ( $permission_code == "admin" && !self::is_admin() ) {
				if ( $throw_exception )
					throw new NotFoundException(TranslationHelper::get_text(["code" => "auth_error_permission_denied", "replace_values" => ["permission_code" => $permission_code]]));

				return false;
			}

			
			if ( isset($_SESSION['auth']['user_permission_list']) ){ // check if session has desired permission
				if ( in_array($permission_code, $_SESSION['auth']['user_permission_list']) )
					return true;
			}

			if ( $throw_exception )
				throw new NotFoundException(TranslationHelper::get_text(["code" => "auth_error_permission_denied", "replace_values" => ["permission_code" => $permission_code]]));

			return false;

		}

		//public static function has_permission($permission_code, $user_id, $throw_exception = false){
		public static function has_permission_old($parameters, $throw_exception = false){
			if ( self::is_admin() )
				return true; 

			if ( is_array($parameters) ){
				$user_id = ( empty($parameters['user_id']) ? $_SESSION['auth']['user_id'] : $parameters['user_id']);
				$permission_code = $parameters['permission_code'];
				$throw_exception = $parameters['throw_exception'];

			}else {
				$user_id = $_SESSION['auth']['user_id'];
				$permission_code = $parameters;
				$throw_exception = true;

			}

			$User = new User();
			$user = $User->list(["id" => $user_id]);
			if ( !$user ){
				if ( $throw_exception )
					throw new NotFoundException(TranslationHelper::get_text(["code" => "user_not_found", "replace_values" => ["user_id" => $user_id]]));

				return false;
			}

			if ( !$user[0]['active'] ){
				if ( $throw_exception )
					throw new AuthException(TranslationHelper::get_text(["code" => "user_inactive", "replace_values" => ["user_id" => $user_id]]));

				return false;
			}
			
			if ( self::is_admin($user[0]['role']) )
				return true;

			if ( $permission_code == "admin" && !self::is_admin() ) {
				if ( $throw_exception )
					throw new NotFoundException(TranslationHelper::get_text(["code" => "auth_error_permission_denied", "replace_values" => ["permission_code" => $permission_code]]));

				return false;
			}

			return true; // simplified role, igonore permission lists 

			if ( $_SESSION['auth']['user_permission_list'] ){ // check if session has desired permission, otherwise check directly in database
				if ( in_array($permission_code, $_SESSION['auth']['user_permission_list']) )
					return true;
			}

			$Permission = new Permission();
			$permission_info = $Permission->list(["code" => $permission_code, "limit" => 1]);
			if ( !$permission_info ){
				if ( $throw_exception )
					throw new NotFoundException(TranslationHelper::get_text(["code" => "permission_not_found", "replace_values" => ["permission_code" => $permission_code]]));

				return false;
			}
				

			$UserPermission = new UserPermission();
			$list = $UserPermission->list(["user_id" => $user_id, "permission_id" => $permission_info[0]['id'], "limit" => 1]);
			if ( !$list ){
				if ( $throw_exception )
					throw new AuthException(TranslationHelper::get_text(["code" => "auth_error_permission_denied", "replace_values" => ["permission_code" => $permission_code]]));

				return false;
			}
			return true;
		}

    public static function get_auth_info(){
      return ( isset($_SESSION['auth']) ? $_SESSION['auth'] : [] );
    }

		public static function get_current_user_permssisions(){
			return ( $_SESSION['auth']['user_permission_list'] ?? [] );
		}

		public static function is_logged(){
			if ( !isset($_SESSION['auth']['authenticated']) )
				return false;

			// refresh user info
			return ( self::refresh_current_user_info() ?? false );

		}

		public static function refresh_current_user_info(){
			$User = new User();
			$user = $User->list(['id' => Auth::get_auth_info()['user_id'], "active" => 1, "limit" => 1]);
			if ( !$user ){
				self::logout();
				return false;
			}

			$user[0]['permission_list'] = self::get_all_user_permissions($user[0]['id']);
      return self::create_session($user[0]);			
		}

		public static function redirect($url = "/login/"){
			header("Location: {$url}");
		}

		public static function redirect_if_not_logged($url = null){

			if ( self::is_logged() )
				return true;

			if ( $url )
				self::redirect($url);

			self::redirect();
		}

		public static function redirect_if_not_allowed($permission_code = []){
			if ( !$permission_code )
				return true;
			
			if ( !self::has_permission($permission_code, false) )
				self::redirect("/index.php");

			return true;
		}
	}