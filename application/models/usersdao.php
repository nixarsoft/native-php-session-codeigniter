<?php

class UsersDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "users";

    log_message( "debug", "UsersDAO model instance created" );
  }

  public function getUser( User $user ) {
    $this->db->from( "v_users" );
    $this->db->where( "username", $user->username );
    $this->db->where( "password", $user->password );
    $this->db->where( "group_definition", $user->group_definition );
    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "User" );
    }
    else
      return null;
  }

  public function saveUser( User $user ) {
    // update
    if ( isset( $user->id ) ) {
      $this->db->where( "id", $user->id );

      $saveData = array();
      if ( isset( $user->name ) ) $saveData["name"] = $user->name;
      if ( isset( $user->email ) ) $saveData["email"] = $user->email;
      if ( isset( $user->password ) ) $saveData["password"] = $user->password;

      $this->db->update( $this->table_name, $saveData );
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $user );
    }

    return $this->db->insert_id();
  }
}

class User {
  public $id;
  public $group_id;
  public $username;
  public $password;
  public $email;
  public $name;
  public $group_definition;
  public $group_title_tr;
  public $group_title_en;
}

class UserGroup {
  public $id;
  public $definition;
  public $title_tr;
  public $title_en;
}
