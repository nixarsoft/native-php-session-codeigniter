<?

class products extends CI_Controller {

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
    $content = $this->load->view( $this->template->getAdminAddres() . "products/index", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $products = $this->ProductsDAO->getAllData();

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Kampanyalar", "./admin/products" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function categories() {
    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    //viewi yükle
    $content = $this->load->view( $this->template->getAdminAddres() . "products/categories", $vdata, true );

    //şablonu kullanıcıya gönder
    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Kampanyalar", "./admin/products" ),
        new Breadcrumb( "Kategoriler", "./admin/products/categories" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function deleteproduct( $productID ) {
    $productID = (int)$productID;
    if ( $productID < 1 ) {
      redirect( "admin/products" );
      exit();
    }

    @unlink( "images/uploads/products/" . $productID . ".jpg" );

    $tmpProduct = new Product();
    $tmpProduct->id = $productID;
    $this->ProductsDAO->delete( $tmpProduct );
    $this->session->set_flashdata( "galobal_message", "Kayıt silindi." );
    redirect( "admin/products/" );
  }

  public function addproduct() {
    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $insertID = $this->saveProduct( null );

      $errorMsg = "";
      if ( $this->input->post( "checkResimKaydet", true ) == "1" ) {
        $errorMsg = $this->saveProductImage( $insertID );
      }

      redirect( "admin/products/" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );
    $vdata["product"] = new Product();

    $content = $this->load->view( $this->template->getAdminAddres() . "products/productaddedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Kampanyalar", "./admin/products" ),
        new Breadcrumb( "Ekle", "./admin/products/addproduct" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function editproduct( $productID ) {
    $productID = (int)$productID;
    if ( $productID < 1 ) {
      redirect( "admin/products" );
      exit();
    }

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $insertID = $this->saveProduct( $productID );

      $errorMsg = "";
      if ( $this->input->post( "checkResimKaydet", true ) == "1" ) {
        $errorMsg = $this->saveProductImage( $insertID );
      }

      redirect( "admin/products/" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    $tmpProduct = new Product();
    $tmpProduct->id = $productID;
    $vdata["product"] = $this->ProductsDAO->getProduct( $tmpProduct );

    $content = $this->load->view( $this->template->getAdminAddres() . "products/productaddedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Kampanyalar", "./admin/products" ),
        new Breadcrumb( "Düzenle", "./admin/products/editproduct/" . $productID )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function addcategory( $topID = 0 ) {
    $topID = (int)$topID;

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $insertID = $this->saveCategory( null, $topID );

      $errorMsg = "";
      if ( $this->input->post( "checkResimKaydet", true ) == "1" ) {
        $errorMsg = $this->saveImage( $insertID );
      }

      redirect( "admin/products/categories" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );
    $vdata["category"] = new ProductCategory();

    $content = $this->load->view( $this->template->getAdminAddres() . "products/categoryaddedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Kampanyalar", "./admin/products" ),
        new Breadcrumb( "Kategoriler", "./admin/products/categories" ),
        new Breadcrumb( "Ekle", "./admin/products/addcategory" )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function editcategory( $catID = 0 ) {
    $catID = (int)$catID;

    if ( intval( $this->input->post( "formsubmit" ) ) == 1 ) {
      $tmpCat = new ProductCategory();
      $tmpCat->id = $catID;
      $realCat = $this->ProductCategoriesDAO->getCategory( $tmpCat );

      $insertID = $this->saveCategory( $catID, $realCat->top_id );

      $errorMsg = "";
      if ( $this->input->post( "checkResimKaydet", true ) == "1" ) {
        $errorMsg = $this->saveImage( $insertID );
      }

      redirect( "admin/products/categories" );
      exit();
    }

    $vdata = array();
    $vdata["sessUser"] = unserialize( $this->session->userdata( "sessUser" ) );

    $productCat = new ProductCategory();
    $productCat->id = $catID;
    $vdata["category"] = $this->ProductCategoriesDAO->getCategory( $productCat );

    $content = $this->load->view( $this->template->getAdminAddres() . "products/categoryaddedit", $vdata, true );

    $data = array();
    $data["content"] = & $content;

    $data["pageBreadcrumb"] = array(
        $this->pageBreadcrumb,
        new Breadcrumb( "Kampanyalar", "./admin/products" ),
        new Breadcrumb( "Kategoriler", "./admin/products/categories" ),
        new Breadcrumb( "Düzenle", "./admin/products/editcategory/" . $catID )
    );

    $this->load->view( $this->template->getAdminAddres() . 'template', $data );
  }

  public function deletecategory( $catID = 0 ) {
    $catID = (int)$catID;

    $tmpCat = new ProductCategory();
    $tmpCat->top_id = $catID;
    $categories = $this->ProductCategoriesDAO->getCategories( $tmpCat );
    if ( $categories->num_rows() > 0 ) {
      $this->session->set_flashdata( "galobal_message", "Üst kategori silmek için altındaki kategorileri silin." );
      redirect( "admin/products/categories" );
      exit();
    }

    $tmpProduct = new Product();
    $tmpProduct->cat_id = $catID;
    $products = $this->ProductsDAO->getProducts( $tmpProduct );
    if ( $products->num_rows() > 0 ) {
      $this->session->set_flashdata( "galobal_message", "Önce bu kategoriye ait olan ürünleri silin." );
      redirect( "admin/products/categories" );
      exit();
    }

    @unlink( "images/uploads/product_categories/" . $catID . ".jpg" );

    $tmpCat = new ProductCategory();
    $tmpCat->id = $catID;
    $this->ProductCategoriesDAO->delete( $tmpCat );
    $this->session->set_flashdata( "galobal_message", "Kayıt silindi." );
    redirect( "admin/products/categories" );
  }

  private function saveCategory( $catID = null, $topID = 0 ) {
    $cat = new ProductCategory();
    $cat->id = $catID;
    $cat->top_id = $topID;
    $cat->title = $this->input->post( "txtBaslikTR", true );

    $insertID = $this->ProductCategoriesDAO->saveCategory( $cat );
    return $insertID;
  }

  private function saveImage( $imageID ) {
    $config['upload_path'] = 'images/uploads/product_categories/';
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

  private function saveProduct( $productID = null ) {
    $product = new Product();
    $product->id = $productID;
    $product->cat_id = (int)$this->input->post( "selCategory", true );
    $product->gallery_id = (int)$this->input->post( "selGallery", true );
    $product->title = $this->input->post( "txtBaslikTR", true );
    $product->description = $this->input->post( "txtDescriptionTR", true );
    $product->content = $this->input->post( "txtIcerikTR" );
    $product->youtube = $this->input->post( "txtYoutube", true );

    $insertID = $this->ProductsDAO->save( $product );
    return $insertID;
  }

  private function saveProductImage( $imageID ) {
    $config['upload_path'] = 'images/uploads/products/';
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
