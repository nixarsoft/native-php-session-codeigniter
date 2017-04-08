<?

class main extends MY_Controller {

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

    $fb = new Facebook\Facebook([
      'app_id' => FB_APP_ID,
      'app_secret' => FB_APP_SECRET,
      'default_graph_version' => 'v2.2',
    ]);

    $membertoken = $this->session->userdata( "fb_access_token" );

    $groups = $fb->get( '/me/groups', $membertoken, null, "2.3" );
    print_r($groups);exit;
    $groups = json_decode( $groups->getBody(), true );


    foreach ($groups['data'] as $group) {
        $group_name = $group['name'];
        $group_id = $group['id'];
        printf("<li>%s - ID = %s</li>\n", $group_name, $group_id);
    }

    $userInfo = $fb->get( '/me', $membertoken );

    $this->session->set_userdata("sessUser", serialize( json_decode( $userInfo->getBody() ) ) );

    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    print_r( $vdata ); exit;

    //viewi yükle
    $content = $this->load->view( $this->template->getAddres() . "main/index", $vdata, true );

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
