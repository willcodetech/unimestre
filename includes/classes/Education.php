<?php

  Class Education extends Base {
    
    // public $id; // type: int null: NO Key: PRI default:  extra: auto_increment (moved to Base class) 
    public $code; // type: char(2) null: NO Key: UNI default:  extra: 
    public $description; // type: varchar(50) null: NO Key:  default:  extra: 

    public function __construct(){
      $this->set__table_name("education");
      $this->set__class_name("Education");
      parent::__construct();
      
    }
  }