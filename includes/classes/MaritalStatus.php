<?php

  Class MaritalStatus extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $code; // type: char(2) null: NO Key: UNI default:  extra: 
    public $description; // type: varchar(50) null: NO Key:  default:  extra: 

    public function __construct(){
      $this->set__table_name("marital_status");
      $this->set__class_name("MaritalStatus");
      parent::__construct();
      
    }
  }