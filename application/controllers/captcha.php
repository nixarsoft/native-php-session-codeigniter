<?

class captcha extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->load->library('captchalib');
    
    $captcha = new CaptchaLib();
    $captcha->width = 100;
    $captcha->height = 20;
    $captcha->charCnt = 4;
    $captcha->fontSize = 10;
    $code = $captcha->generateCode();
    
    $this->session->set_userdata( "captcha", $code );
    
    $captcha->createImage( $code );
  }
}
