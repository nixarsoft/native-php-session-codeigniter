<?php

class newsCategories extends CI_Controller {
  private $ci;

  public function __construct() {
    parent::__construct();
    $this->ci = & get_instance();

    $this->load->model( "m_news" );
  }

  public function index() {
    $content = $this->load->view( $this->template->getAddres() . "anasayfa/index", array(), true );

    $data = array();
    $data["content"] = & $content;
    $this->load->view( $this->template->getAddres() . 'template', $data );
  }

  public function getNewsForTopMenu( $catID = null ) {
    $catID = (int)$catID;

    $vArray = array();
    $vArray["catID"] = $catID;
    $this->load->view( $this->template->getAddres() . "ajax/getNewsForTopMenu", $vArray );
  }
}
