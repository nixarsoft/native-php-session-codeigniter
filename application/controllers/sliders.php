<?

class sliders extends CI_Controller {

  public $mainBreadcrumb;

  public function __construct() {
    parent::__construct();

    //admin oturum kontrolü yapılacak
    if ( !$this->session->userdata( "adminLogin" ) ) {
      redirect( "admin/login" );
      exit();
    }

    $this->load->model( "usersdao", "UsersDAO" );

    $this->pageBreadcrumb = new Breadcrumb( "Anasayfa", "./admin" );
  }

  public function index() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    //viewi yükle
    $content = $this->load->view( $this->template->getAdminAddres() . "sliders/index", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Slider Resimleri", "./admin/sliders" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function addimage() {
    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $slider = new Slider();
      $slider->id = null;
      $slider->title = $this->input->post( "txtResimBaslikTR", true );

      $newSliderImageID = $this->SlidersDAO->save( $slider );

      $errorMsg = "";
      if ( $this->input->post( "checkResimKaydet", true ) == "1" ) {
        $errorMsg = $this->saveImage( $newSliderImageID );
      }

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı. " . $errorMsg );
      redirect( "admin/sliders" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );
    $vdata["slider"] = new Slider();

    $content = $this->load->view( $this->template->getAdminAddres() . "sliders/imageaddedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Slider Resimleri", "./admin/sliders" ),
        new Breadcrumb( "Resim Ekle", "./admin/sliders/addimage" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function editimage( $sliderID ) {
    $sliderID = (int)$sliderID;
    if ( $sliderID < 1 ) {
      redirect( "admin" );
      exit();
    }

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $slider = new Slider();
      $slider->id = $sliderID;
      $slider->title = $this->input->post( "txtResimBaslikTR", true );

      $this->SlidersDAO->save( $slider );

      $errorMsg = "";
      if ( $this->input->post( "checkResimKaydet", true ) == "1" ) {
        $errorMsg = $this->saveImage( $sliderID );
      }

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı. " . $errorMsg );
      redirect( "admin/sliders" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    $slider = new Slider();
    $slider->id = $sliderID;
    $vdata["slider"] = $this->SlidersDAO->getSlider( $slider );

    $content = $this->load->view( $this->template->getAdminAddres() . "sliders/imageaddedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Slider Resimleri", "./admin/sliders" ),
        new Breadcrumb( "Resim Düzenle", "./admin/sliders/editimage/" . $sliderID )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function deleteimage( $imageID ) {
    $imageID = (int)$imageID;
    if ( $imageID < 0 ) {
      redirect( "admin/sliders" );
      return;
    }

    $tmpImage = new Slider();
    $tmpImage->id = $imageID;

    $originalImage = $this->SlidersDAO->getSlider( $tmpImage );
    if ( $originalImage == null ) {
      redirect( "admin/sliders" );
      return;
    }

    if ( is_readable( "images/uploads/sliders/" . $originalImage->id . ".jpg" ) ) {
      @ unlink( "images/uploads/sliders/" . $originalImage->id . ".jpg" );
    }

    $this->SlidersDAO->delete( $originalImage );

    $this->session->set_flashdata( "galobal_message", "Resim başarıyla silindi" );
    redirect( "admin/sliders" );
  }

  private function saveImage( $imageID ) {
    $config['upload_path'] = 'images/uploads/sliders/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '2048';
    $config['max_width'] = '4096';
    $config['max_height'] = '4096';
    $config["overwrite"] = true;
    $config["file_name"] = $imageID . ".jpg";

    $this->load->library( 'upload', $config );
    if ( !$this->upload->do_upload( "fileResim" ) ) {
      return "Resim kaydedilirken bir hata oluştu: " . $this->upload->display_errors();
    }
    return "";
  }
}
