<?php

  Class Gui {

    public static function get_menu(){
      return [

        [
          "title" => TranslationHelper::get_text("menu_configuration"), "icon" => "fa fa-cogs",
          "link" => "#",
          "only_admin" => false,
          "required_permissions" => ['employee_list', 'user_group_list', 'employee_work_hour_list', 'user_list', 'company_list'],
          "subitems" => [
           
            /*
            [
              "title" => TranslationHelper::get_text("menu_company"),
              "link" => "/company/",
              "required_permissions" => ['company_list'],
              //"only_admin" => true,
              "icon" => " fa fa-building-o"
            ],  
            [
              "title" => TranslationHelper::get_text("menu_company_group"),
              "link" => "/company_group/",
              "required_permissions" => ['company_group_list'],
              //"only_admin" => true,
              "icon" => " fa fa-bank"
            ],  
            [
              "title" => TranslationHelper::get_text("menu_user_group"),
              "link" => "/permission_group/",
              "required_permissions" => ['user_group_list'],
              "only_admin" => true,
              "icon" => "fa fa-users"
            ],
            */
            [
              "title" => TranslationHelper::get_text("menu_log"),
              "link" => "/log/",
              //"required_permissions" => ['employee_work_hour_list'],
              "only_admin" => true,
              "icon" => " fa fa-bug"
            ],
            [
              "title" => TranslationHelper::get_text("menu_user"),
              "link" => "/user/",
              "required_permissions" => ['user_list'],
              //"only_admin" => true,
              "icon" => "fa fa-user-o"
            ],
          ]
        ],
       
        [
          "title" => TranslationHelper::get_text("menu_registration"), "icon" => "icon-folder-alt",
          "link" => "#",
          "only_admin" => false,
          "required_permissions" => ['curriculum_list'],
          "subitems" => [                  
            [
              "title" => TranslationHelper::get_text("menu_curriculum"),
              "link" => "/curriculum/",
              "required_permissions" => ['curriculum_list'],
              //"only_admin" => true,
              "icon" => "fa fa-file-text-o"
            ],   
            
          ]
        ], 
        
        
      ];
    }

  }