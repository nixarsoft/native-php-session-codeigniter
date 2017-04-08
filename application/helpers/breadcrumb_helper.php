<?

class Breadcrumb {
  public $title;
  public $link;

  public function __construct($title, $link) {
    $this->title = $title;
    $this->link = $link;
  }
}
