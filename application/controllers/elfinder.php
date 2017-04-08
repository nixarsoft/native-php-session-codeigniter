<?

class elfinder extends CI_Controller {
  public function __construct() {
    parent::__construct();

    //oturum kontrolü yapılacak
    if ( !$this->session->userdata( "adminLogin" ) ) {
      redirect( "login" );
      exit();
    }
  }

  public function index() {
    $data = array();
    
    $this->load->view( $this->template->getAdminAddres() . 'elfinder', $data );
  }
}
