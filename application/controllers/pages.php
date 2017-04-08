<?

class pages extends CI_Controller {

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

    $content = $this->load->view( $this->template->getAdminAddres() . "pages/index", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Sayfalar", "./admin/pages/index" )
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

    $page = new Page();
    $page->id = $pageID;

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $savePage = new Page();
      $savePage->id = $pageID;

      $savePage->title = $this->input->post( "txtSayfaAdiTurkce", true );
      $savePage->description = $this->input->post( "txtSayfaStopTurkce", true );
      $savePage->content = $this->input->post( "txtSayfaIcerikTurkce", true );

      $this->PagesDAO->save( $savePage );

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı" );
      redirect( "admin/pages" );
      exit();
    }

    $vdata["page"] = $this->PagesDAO->getPage( $page );

    $content = $this->load->view( $this->template->getAdminAddres() . "pages/addedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Sayfalar", "./admin/pages/index" ),
        new Breadcrumb( "Düzenle", "./admin/pages/edit/" . $pageID )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function add() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $savePage = new Page();
      $savePage->id = null;

      $savePage->title = $this->input->post( "txtSayfaAdiTurkce", true );
      $savePage->description = $this->input->post( "txtSayfaStopTurkce", true );
      $savePage->content = $this->input->post( "txtSayfaIcerikTurkce", true );

      $savePage->menu = 1;
      $savePage->picture = "";

      $this->PagesDAO->save( $savePage );

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı" );
      redirect( "admin/pages" );
      exit();
    }

    $vdata["page"] = null;
    $content = $this->load->view( $this->template->getAdminAddres() . "pages/addedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Sayfalar", "./admin/pages/index" ),
        new Breadcrumb( "Ekle", "./admin/pages/add" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function delete( $pageID ) {
    $pageID = (int)$pageID;
    if ( $pageID < 1 ) {
      redirect( "admin" );
      exit();
    }

    $page = new Page();
    $page->id = $pageID;

    $this->PagesDAO->delete( $page );

    $this->session->set_flashdata( "galobal_message", "Kayıt Silindi" );
    redirect( "admin/pages" );
    exit();
  }

}
