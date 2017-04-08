<?

class MY_Model extends CI_Model {

  protected $table_name = null;

  public function __construct() {
    parent::__construct();
  }

  public function get_table_name() {
    return $this->table_name;
  }

  public function get_all_data() {
    return $this->db->get( $this->table_name );
  }

  public function delete( $obj ) {
    $obj = (array) $obj;

    foreach ( $obj AS $k => $v ) {
      $this->db->where( $k, $v );
    }

    $this->db->delete( $this->table_name );
  }

  public function getAllData() {
    return $this->get_all_data();
  }


}
