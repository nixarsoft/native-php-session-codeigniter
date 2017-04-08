<?php

class ProductsDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "products";

    log_message( "debug", "ProductsDAO model instance created" );
  }

  public function getProduct( Product $product ) {
    $this->db->from( $this->table_name );
    $this->db->where( "id", $product->id );
    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "Product" );
    }
    else
      return null;
  }

  public function getProducts( Product $product ) {
    $this->db->from( $this->table_name );

    if ( isset( $product->id ) ) $this->db->where( "id", $product->id );
    if ( isset( $product->cat_id ) ) $this->db->where( "cat_id", $product->cat_id );

    return $this->db->get();
  }

  public function getAllViewData() {
    $this->db->from( "v_products" );
    return $this->db->get();
  }

  public function delete( $product ) {
    $this->db->delete( $this->table_name, array( "id" => $product->id ) );
  }

  public function searchProducts( Product $product ) {
    $this->db->from( $this->table_name );

    if ( isset( $product->content ) ) $this->db->or_like( "content", $product->content );
    if ( isset( $product->title ) ) $this->db->or_like( "title", $product->title );

    return $this->db->get();
  }

  public function save( Product $product ) {
    // update
    if ( isset( $product->id ) ) {
      $this->db->where( "id", $product->id );
      $this->db->update( $this->table_name, $product );
      return $product->id;
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $product );
      return $this->db->insert_id();
    }
  }
}

class Product {
  public $id;
  public $cat_id;
  public $gallery_id;
  public $title;
  public $content;
  public $description;
  public $youtube;
}

class VProduct extends Product {
  public $category_title;
}
