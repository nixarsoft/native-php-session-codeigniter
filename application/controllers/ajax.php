<?

class ajax extends CI_Controller {

  private $ajaxFolder;

  public function __construct() {
    parent::__construct();

    if ( !$this->session->userdata( "adminLogin" ) ) {
      redirect( "admin/login" );
      exit();
    }

    $this->ajaxFolder = APPPATH . "controllers/admin/ajaxfolder/";

    header("Content-Type: application/json");
  }

  public function index() {
    echo "Doğrudan çağrı kabul edilmemektedir.";
  }

  public function page() {
    require_once $this->ajaxFolder . "ajaxpage.php";
    new ajaxpage( func_get_args() );
  }

  public function examplemethod() {
    require_once $this->ajaxFolder . "examplemethod.php";

    $exampleMethod = new examplemethod( func_get_args() );
  }
  
  public function elfinderendpoint() {
    require_once $this->ajaxFolder . "elfinderendpoint.php";

    $args = $this->input->get(null);
    
    new elfinderendpoint( $args );
  }

}
