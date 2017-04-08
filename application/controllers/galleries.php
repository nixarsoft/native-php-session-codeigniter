<?

class galleries extends CI_Controller {

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

    //viewi yükle
    $content = $this->load->view( $this->template->getAdminAddres() . "galleries/index", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Galeri", "./admin/galleries" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function edit( $galleryID ) {
    $galleryID = (int)$galleryID;
    if ( $galleryID < 1 ) {
      redirect( "admin" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    $gallery = new Gallery();
    $gallery->id = $galleryID;

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $saveObj = new Gallery();
      $saveObj->id = $galleryID;
      $saveObj->menu = intval( (boolean)$this->input->post( "checkMenu", true ) );

      $saveObj->title = $this->input->post( "txtGaleriBaslikTurkce", true );
      $saveObj->description = $this->input->post( "txtKisaBilgiTurkce", true );

      $this->GalleriesDAO->save( $saveObj );

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı" );
      redirect( "admin/galleries" );
      exit();
    }

    $vdata["gallery"] = $this->GalleriesDAO->getGallery( $gallery );

    $content = $this->load->view( $this->template->getAdminAddres() . "galleries/addedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Galeri", "./admin/galleries" ),
        new Breadcrumb( "Düzenle", "./admin/galleries/edit/" . $galleryID )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function add() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $saveObj = new Gallery();
      $saveObj->menu = intval( (boolean)$this->input->post( "checkMenu", true ) );

      $saveObj->title = $this->input->post( "txtGaleriBaslikTurkce", true );
      $saveObj->description = $this->input->post( "txtKisaBilgiTurkce", true );

      $this->GalleriesDAO->save( $saveObj );

      $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı" );
      redirect( "admin/galleries" );
      exit();
    }

    $vdata["gallery"] = null;
    $content = $this->load->view( $this->template->getAdminAddres() . "galleries/addedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Galeri", "./admin/galleries" ),
        new Breadcrumb( "Ekle", "./admin/galleries/add" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function delete( $galleryID ) {
    $galleryID = (int)$galleryID;
    if ( $galleryID < 1 ) {
      redirect( "admin" );
      exit();
    }

    $delObj = new Gallery();
    $delObj->id = $galleryID;

    $this->GalleriesDAO->delete( $delObj );

    $this->session->set_flashdata( "galobal_message", "Kayıt Silindi" );
    redirect( "admin/galleries" );
    exit();
  }

  public function galleryimages( $galleryID, $editImage = null, $imageID = null ) {
    $galleryID = (int)$galleryID;
    $imageID = (int)$imageID;

    if ( $galleryID < 1 || ( $editImage == "editimage" && $imageID < 1 ) ) {
      redirect( "admin" );
      exit();
    }

    $templateViewData = array();
    $templateViewData["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Galeri", "./admin/galleries" )
    );

    $gallery = new Gallery();
    $gallery->id = $galleryID;

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $this->saveImage( $galleryID, $imageID );
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );
    $vdata["gallery"] = $this->GalleriesDAO->getGallery( $gallery );

    if ( $editImage == "editimage" ) {
      $templateViewData["pageBreadcrumb"][] = new Breadcrumb( $vdata["gallery"]->title . " Resimleri", "./admin/galleries/galleryimages/" . $galleryID );
      $templateViewData["pageBreadcrumb"][] = new Breadcrumb( "Resim Düzenle", "./admin/galleries/edit/" . $galleryID . "/editimage/" . $imageID );

      $galleryImage = new GalleryImage();
      $galleryImage->id = $imageID;

      $vdata["galleryID"] = $galleryID;
      $vdata["galleryImage"] = $this->GalleryImagesDAO->getGalleryImage( $galleryImage );

      $content = $this->load->view( $this->template->getAdminAddres() . "galleries/galleryimageaddedit", $vdata, true );
    }
    else if ( $editImage == "addimage" ) {
      $vdata["galleryID"] = $galleryID;
      $vdata["galleryImage"] = new GalleryImage();

      $templateViewData["pageBreadcrumb"][] = new Breadcrumb( $vdata["gallery"]->title . " Resimleri", "./admin/galleries/galleryimages/" . $galleryID );
      $templateViewData["pageBreadcrumb"][] = new Breadcrumb( "Resim Ekle", "./admin/galleries/add" );

      $content = $this->load->view( $this->template->getAdminAddres() . "galleries/galleryimageaddedit", $vdata, true );
    }
    else {
      $templateViewData["pageBreadcrumb"][] = new Breadcrumb( $vdata["gallery"]->title . " Resimleri", "./admin/galleries/edit/" . $galleryID );

      $content = $this->load->view( $this->template->getAdminAddres() . "galleries/galleryimages", $vdata, true );
    }

    $templateViewData["content"] = & $content;

    $this->load->view( $this->template->getAdminAddres() . 'template', $templateViewData );
  }

  public function deleteimage( $imageID ) {
    $imageID = (int)$imageID;
    if ( $imageID < 0 ) {
      redirect( "admin/galleries" );
      return;
    }

    $tmpImage = new GalleryImage();
    $tmpImage->id = $imageID;

    $originalImage = $this->GalleryImagesDAO->getGalleryImage( $tmpImage );
    if ( $originalImage == null ) {
      redirect( "admin/galleries" );
      return;
    }

    if ( is_readable( "images/uploads/galleries/" . $originalImage->id . ".jpg" ) ) {
      @ unlink( "images/uploads/galleries/" . $originalImage->id . ".jpg" );
    }

    $this->GalleryImagesDAO->delete( $tmpImage );

    $this->session->set_flashdata( "galobal_message", "Resim başarıyla silindi" );
    redirect( "admin/galleries/galleryimages/" . $originalImage->gallery_id );
  }

  private function saveImage( $galleryID, $imageID = null ) {
    $galleryID = (int)$galleryID;
    $imageID = ( (int)$imageID > 0 ? (int)$imageID : null );

    $galleryImage = new GalleryImage();
    $galleryImage->id = $imageID;
    $galleryImage->gallery_id = $galleryID;

    $galleryImage->title = $this->input->post( "txtResimBaslikTR", true );

    $galleryImage->fancybox = $this->input->post( "checkFancybox", true );
    $galleryImage->description = $this->input->post( "txtDescriptionTR", true );

    $newGalleryImageID = $this->GalleryImagesDAO->save( $galleryImage );

    $errorMsg = "";
    if ( $this->input->post( "checkResimKaydet", true ) == "1" ) {
      $saveID = null;
      if ( isset( $imageID ) ) $saveID = $imageID;
      else $saveID = $newGalleryImageID;

      $config['upload_path'] = 'images/uploads/gallery/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = '2048';
      $config['max_width'] = '4096';
      $config['max_height'] = '4096';
      $config["overwrite"] = true;
      $config["file_name"] = $saveID . ".jpg";

      $this->load->library( 'upload', $config );
      if ( !$this->upload->do_upload( "fileResim" ) ) {
        $errorMsg = "Resim kaydedilirken bir hata oluştu: " . $this->upload->display_errors();
      }
    }

    $this->session->set_flashdata( "galobal_message", "Kayıt Başarılı. " . $errorMsg );
    redirect( "admin/galleries/galleryimages/" . $galleryID );
    exit();
  }
}
