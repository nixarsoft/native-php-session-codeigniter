<?

class defaultpages extends CI_Controller {

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

    $content = $this->load->view( $this->template->getAdminAddres() . "defaultpages/index", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Standart Sayfalar", "./admin/defaultpages/index" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function edit( $pageID ) {
    $pageID = (int)$pageID;
    if ( $pageID < 1 ) {
      redirect( "admin" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    $page = new DefaultPage();
    $page->id = $pageID;

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $savePage = new DefaultPage();
      $savePage->id = $pageID;
      $savePage->definer = $this->input->post( "txtDefiner", true );

      $savePage->title = $this->input->post( "txtSayfaAdiTurkce", true );
      $savePage->description = $this->input->post( "txtSayfaStopTurkce", true );
      $savePage->content = $this->input->post( "txtSayfaIcerikTurkce", true );

      $this->DefaultPagesDAO->save( $savePage );

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı" );
      redirect( "admin/defaultpages" );
      exit();
    }

    $vdata["page"] = $this->DefaultPagesDAO->getPage( $page );

    $content = $this->load->view( $this->template->getAdminAddres() . "defaultpages/addedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Standart Sayfalar", "./admin/defaultpages/index" ),
        new Breadcrumb( "Düzenle", "./admin/defaultpages/edit/" . $pageID )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

}
