<?

class site extends CI_Controller {

  public $mainBreadcrumb;

  public function __construct() {
    parent::__construct();

    //admin oturum kontrolü yapılacak
    if ( !$this->session->userdata( "login" ) ) {
      redirect( "login" );
      exit();
    }

    $this->load->model( "usersdao", "UsersDAO" );

    $this->pageBreadcrumb = new Breadcrumb( "Anasayfa", "./" );
  }

  public function index() {
    redirect( "admin" );
  }

  public function settings() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $this->saveSettings();
      redirect(current_url());
      exit;
    }

    //viewi yükle
    $content = $this->load->view( $this->template->getAddres() . "site/settings", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Site Ayarları", "./site/settings" )
    );

    $this->load->view( $this->template->getAddres() . 'template', $data );
  }

  public function statistics() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    //viewi yükle
    $content = $this->load->view( $this->template->getAddres() . "site/statistics", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "İstatistikler", "./site/statistics" )
    );

    $this->load->view( $this->template->getAddres() . 'template', $data );
  }

  private function saveSettings() {
    $saveConf = new Config();

    $saveConf->sitetitle = $this->input->post("sitetitle", true);
    $saveConf->sitedescription = $this->input->post("sitedescription", true);
    $saveConf->sitekeywords = $this->input->post("sitekeywords", true);
    $saveConf->sitetemplate = $this->input->post("sitetemplate", true);
    $saveConf->admintemplate = $this->input->post("admintemplate", true);
    $saveConf->perpagelimit = $this->input->post("perpagelimit", true);
    $saveConf->address = $this->input->post("address", true);
    $saveConf->email = $this->input->post("email", true);
    $saveConf->cellphone = $this->input->post("cellphone", true);
    $saveConf->workphone = $this->input->post("workphone", true);
    $saveConf->fax = $this->input->post("fax", true);
    $saveConf->facebook = $this->input->post("facebook", true);
    $saveConf->twitter = $this->input->post("twitter", true);
    $saveConf->gplus = $this->input->post("gplus", true);

    $this->ConfigDAO->save($saveConf);
  }
}
