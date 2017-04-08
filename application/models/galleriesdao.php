<?php

class GalleriesDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "galleries";

    log_message( "debug", "GalleriesDAO model instance created" );
  }

  public function save( Gallery $gallery ) {
    // update
    if ( isset( $gallery->id ) ) {
      $this->db->where( "id", $gallery->id );
      $this->db->update( $this->table_name, $gallery );
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $gallery );
    }
  }

  public function getGallery( Gallery $gallery ) {
    $this->db->from( $this->table_name );
    $this->db->where( "id", $gallery->id );
    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "Gallery" );
    }
    else
      return null;
  }

  public function getMenuGalleries() {
    $this->db->from( $this->table_name );
    $this->db->where( "menu", "1" );
    return $this->db->get();
  }
}

class Gallery {
  public $id;
  public $menu;
  public $title_tr;
  public $title_en;
  public $description_tr;
  public $description_en;
}

