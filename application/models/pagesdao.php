<?php

class PagesDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "pages";

    log_message( "debug", "PagesDAO model instance created" );
  }

  public function save( Page $page ) {
    // update
    if ( isset( $page->id ) ) {
      $this->db->where( "id", $page->id );
      $this->db->update( $this->table_name, $page );
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $page );
    }
  }

  public function getPage( Page $page ) {
    $this->db->from( $this->table_name );
    $this->db->where( "id", $page->id );
    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "Page" );
    }
    else
      return null;
  }
}

class Page {
  public $id;
  public $menu;
  public $title_tr;
  public $title_en;
  public $description_tr;
  public $description_en;
  public $content_tr;
  public $content_en;
  public $picture;
}

