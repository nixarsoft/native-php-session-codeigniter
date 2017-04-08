<?

class account extends CI_Controller {

  public $mainBreadcrumb;

  public function __construct() {
    parent::__construct();

    //admin oturum kontrolü yapılacak
    if ( !$this->session->userdata( "login" ) ) {
      redirect( "login" );
      exit();
    }

    $this->pageBreadcrumb = new Breadcrumb( "Anasayfa", "./" );
  }

  public function index() {
    if ( $this->input->post( "formsubmit", true ) == "1" ) {
      $this->saveCurrentUserAccount();

      $this->session->sess_destroy();
      redirect( "login" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    //viewi yükle
    $content = $this->load->view( $this->template->getAddres() . "account/index", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Hesap", "./account/index" )
    );

    $this->load->view( $this->template->getAddres() . 'template', $data );
  }

  private function saveCurrentUserAccount() {
    $currentUser = unserialize( $this->session->userdata( "sessUser" ) );

    $newUser = new User();
    $newUser->id = $currentUser->id;
    $newUser->username = $currentUser->username;
    $newUser->group_id = $currentUser->group_id;

    $newUser->name = $this->input->post( "name", true );
    $newUser->email = $this->input->post( "email", true );

    if ( strlen( $this->input->post( "password1", true ) ) > 0 ) {
      if ( $this->input->post( "password1", true ) === $this->input->post( "password2", true ) ) {
        $newUser->password = md5( $this->input->post( "password1", true ) );
      }
    }

    $this->UsersDAO->saveUser( $newUser );
  }
}
