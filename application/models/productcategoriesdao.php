<?php

class ProductCategoriesDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "product_categories";

    log_message( "debug", "ProductCategoriesDAO model instance created" );
  }

  public function getCategory( ProductCategory $cat ) {
    $this->db->from( $this->table_name );
    $this->db->where( "id", $cat->id );
    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "ProductCategory" );
    }
    else
      return null;
  }

  public function getCategories( ProductCategory $cat ) {
    $this->db->from( $this->table_name );

    if ( isset( $cat->id ) ) $this->db->where( "id", $cat->id );
    if ( isset( $cat->top_id ) ) $this->db->where( "top_id", $cat->top_id );

    return $this->db->get();
  }

  public function saveCategory( ProductCategory $productCat ) {
    // update
    if ( isset( $productCat->id ) ) {
      $this->db->where( "id", $productCat->id );
      $this->db->update( $this->table_name, $productCat );
      return $productCat->id;
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $productCat );
      return $this->db->insert_id();
    }
  }

  public function delete( $category ) {
    $id = (int)$category->id;
    $this->db->delete( $this->table_name, array( 'id' => $id ) );
  }

}

class ProductCategory {
  public $id;
  public $top_id;
  public $title;
}
