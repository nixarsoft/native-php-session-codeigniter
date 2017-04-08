<?

class sendsms extends CI_Controller {

  public $mainBreadcrumb;

  public function __construct() {
    parent::__construct();

    //oturum kontrolü yapılacak
    if ( !$this->session->userdata( "login" ) ) {
      redirect( "login" );
      exit();
    }

    $this->pageBreadcrumb = new Breadcrumb( "Anasayfa", "./" );
  }

  public function index() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    //viewi yükle
    $content = $this->load->view( $this->template->getAddres() . "sendsms/index", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb("Index", "./main/index")
    );

    $this->load->view( $this->template->getAddres() . 'template', $data );
  }
}
