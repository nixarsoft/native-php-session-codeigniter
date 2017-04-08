<?

class template {
  private $ci;
  private $template = null;

  public function __construct() {
    $ci = &get_instance();

    $this->template = $ci->conf->get( "template" );
  }

  public function getName() {
    return $this->template;
  }

  public function getAddres() {
    return "template/" . $this->template . "/";
  }
}
