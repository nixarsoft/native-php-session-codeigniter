<?php

class SlidersDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "sliders";

    log_message( "debug", "SlidersDAO model instance created" );
  }

  public function save( Slider $slider ) {
    // update
    if ( isset( $slider->id ) ) {
      $this->db->where( "id", $slider->id );
      $this->db->update( $this->table_name, $slider );
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $slider );
    }

    return $this->db->insert_id();
  }

  public function getSlider( Slider $slider ) {
    $this->db->from( $this->table_name );
    $this->db->where( "id", $slider->id );
    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "Slider" );
    }
    else
      return null;
  }
}

class Slider {
  public $id;
  public $title;
}
