<?

class dealers extends CI_Controller {

  public $mainBreadcrumb;

  public function __construct() {
    parent::__construct();

    //admin oturum kontrolü yapılacak
    if ( !$this->session->userdata( "adminLogin" ) ) {
      redirect( "admin/login" );
      exit();
    }

    $this->pageBreadcrumb = new Breadcrumb( "Anasayfa", "./admin" );
  }

  public function index() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    $content = $this->load->view( $this->template->getAdminAddres() . "dealers/index", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Bayiler", "./admin/dealers/index" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function edit( $dealerID ) {
    $dealerID = (int)$dealerID;
    if ( $dealerID < 1 ) {
      redirect( "admin" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    $dealer = new Dealer();
    $dealer->id = $dealerID;

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $dealer = new Dealer();
      $dealer->id = $dealerID;

      $dealer->company_name = $this->input->post( "company_name", true );
      $dealer->address = $this->input->post( "address", true );
      $dealer->city = $this->input->post( "city", true );
      $dealer->phone = $this->input->post( "phone", true );
      $dealer->fax = $this->input->post( "fax", true );
      $dealer->cellphone = $this->input->post( "cellphone", true );
      $dealer->email = $this->input->post( "email", true );

      $this->DealersDAO->save( $dealer );

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı" );
      redirect( "admin/dealers" );
      exit();
    }

    $vdata["dealer"] = $this->DealersDAO->getDealer( $dealer );

    $content = $this->load->view( $this->template->getAdminAddres() . "dealers/addedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Bayiler", "./admin/dealers/index" ),
        new Breadcrumb( "Düzenle", "./admin/dealers/edit/" . $dealerID )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function add() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $dealer = new Dealer();
      $dealer->id = null;

      $dealer->company_name = $this->input->post( "company_name", true );
      $dealer->address = $this->input->post( "address", true );
      $dealer->city = $this->input->post( "city", true );
      $dealer->phone = $this->input->post( "phone", true );
      $dealer->fax = $this->input->post( "fax", true );
      $dealer->cellphone = $this->input->post( "cellphone", true );
      $dealer->email = $this->input->post( "email", true );

      $this->DealersDAO->save( $dealer );

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı" );
      redirect( "admin/dealers" );
      exit();
    }

    $vdata["dealer"] = null;
    $content = $this->load->view( $this->template->getAdminAddres() . "dealers/addedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Bayiler", "./admin/dealers/index" ),
        new Breadcrumb( "Ekle", "./admin/dealers/add" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function delete( $dealerID ) {
    $dealerID = (int)$dealerID;
    if ( $dealerID < 1 ) {
      redirect( "admin" );
      exit();
    }

    $dealer = new Dealer();
    $dealer->id = $dealerID;

    $this->DealersDAO->delete( $dealer );

    $this->session->set_flashdata( "galobal_message", "Kayıt Silindi" );
    redirect( "admin/dealers" );
    exit();
  }

}
