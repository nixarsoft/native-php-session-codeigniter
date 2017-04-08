<?

class conf {
  private $ci;
  private $conf = array();

  public function __construct() {
    $this->ci = & get_instance();

    $sql = " SELECT * FROM config ";
    $q = $this->ci->db->query( $sql );

    foreach ( $q->result_array() as $row ) {
      $this->conf[$row["k"]] = $row["v"];
    }

    if ($this->conf["language"] == "tr")
      setlocale(LC_TIME, 'tr_TR.UTF-8');
    else
      setlocale(LC_TIME, 'en_EN.UTF-8');
  }

  public function get( $k = null ) {
    if ( is_null( $k ) ) return null;

    return $this->conf[$k];
  }
}
