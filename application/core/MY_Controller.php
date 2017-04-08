<?php

class MY_Controller extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }
}

class Admin_Controller extends MY_Controller {

  public function __construct() {
		parent::__construct();
		
		if (!$this->session->userdata("login"))
		{
			redirect("login");
			exit();
		}
  }
}

class Ajax_Controller extends MY_Controller {
  
}

class Admin_Ajax_Controller extends MY_Controller {
  
  public function __construct() {
    parent::__construct();

    header("Content-Type: application/json");
    
		if ( !$this->session->userdata("login") )
		{
      
		}
  }
}

