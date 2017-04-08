<?php

class DealersDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "dealers";

    log_message( "debug", "DealersDAO model instance created" );
  }

  public function save( Dealer $dealer ) {
    // update
    if ( isset( $dealer->id ) ) {
      $this->db->where( "id", $dealer->id );
      $this->db->update( $this->table_name, $dealer );
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $dealer );
    }
  }

  public function getDealer( Dealer $dealer ) {
    $this->ci->db->from( $this->table_name );
    $this->ci->db->where( "id", $dealer->id );
    $result = $this->ci->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "Dealer" );
    }
    else
      return null;
  }
}

class Dealer{
  public $id;
  public $company_name;
  public $address;
  public $city;
  public $phone;
  public $fax;
  public $cellphone;
  public $email;
}

