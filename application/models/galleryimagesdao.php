<?

class GalleryImagesDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "gallery_images";

    log_message( "debug", "GalleryImagesDAO model instance created" );
  }

  public function save( GalleryImage $galleryImage ) {
    // update
    if ( isset( $galleryImage->id ) ) {
      $this->db->where( "id", $galleryImage->id );
      $this->db->update( $this->table_name, $galleryImage );
    }
    // insert
    else {
      $this->db->insert( $this->table_name, $galleryImage );
    }

    return $this->db->insert_id();
  }

  public function getGalleryImage( GalleryImage $galleryImage ) {
    $this->db->from( $this->table_name );

    if ( isset( $galleryImage->id ) ) $this->db->where( "id", $galleryImage->id );

    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "GalleryImage" );
    }
    else
      return null;
  }

  public function getGalleryImages( GalleryImage $galleryImage ) {
    $this->db->from( $this->table_name );

    if ( isset( $galleryImage->id ) ) $this->db->where( "id", $galleryImage->id );
    if ( isset( $galleryImage->gallery_id ) ) $this->db->where( "gallery_id", $galleryImage->gallery_id );

    return $this->db->get();
  }

  public function delete( GalleryImage $obj ) {

    $this->db->delete( $this->table_name, array( "id" => $obj->id ) );

  }
}

class GalleryImage {
  public $id;
  public $gallery_id;
  public $title_tr;
  public $title_en;
  public $fancybox;
  public $description_tr;
  public $description_en;
  public $long_text_tr;
  public $long_text_en;
}

