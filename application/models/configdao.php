<?php

class ConfigDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "config";

    log_message( "debug", "ConfigDAO model instance created" );
  }

  public function save( Config $config ) {

    $arrConfig = get_object_vars( $config );

    foreach ( $arrConfig as $k => $v ) {
      if ( !isset( $v ) || strlen( $v ) == 0 ) continue;

      $this->db->where( "k", $k );

      $this->db->update( $this->table_name, array(
          "v" => $v
      ) );
    }
  }

  public function getConfig() {
    $config = new Config();

    $allData = $this->getAllData();
    foreach ( $allData->result() as $row ) {
      $config->{$row->k} = $row->v;
    }

    return $config;
  }
}

class Config {
  public $sitetitle;
  public $sitedescription;
  public $sitekeywords;
  public $sitetemplate;
  public $admintemplate;
  public $perpagelimit;
  public $address;
  public $email;
  public $cellphone;
  public $workphone;
  public $fax;
  public $facebook;
  public $twitter;
  public $gplus;
}

