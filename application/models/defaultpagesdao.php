<?

class DefaultPagesDAO extends MY_Model {

  public function __construct() {
    parent::__construct();

    $this->table_name = "default_pages";
  }

  public function save( DefaultPage $page ) {
    if ( !isset( $page->definer ) ) return false;

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

  public function getDefaultPage( DefaultPage $page ) {
    $this->db->from( $this->table_name );

    if ( isset( $page->id ) ) $this->db->where( "id", $page->id );
    if ( isset( $page->definer ) ) $this->db->where( "definer", $page->definer );

    $result = $this->db->get();

    if ( $result->num_rows() > 0 ) {
      return $result->row( 0, "DefaultPage" );
    }
    else
      return null;
  }

  public function getPage( DefaultPage $page ) {
    return $this->getDefaultPage( $page );
  }
}

class DefaultPage {
  public $id;
  public $definer;
  public $title;
  public $description;
  public $content;
}

