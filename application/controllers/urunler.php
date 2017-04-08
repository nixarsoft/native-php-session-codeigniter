<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class urunler extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		//admin oturum kontrolü yapılacak
		if (!$this->session->userdata("adminlogin"))
		{
			redirect("admin");
			exit();
		}
	}
	
	public function index($sayfa=null)
	{
		//modeli yükle
		$this->load->model("m_urunler");
		
		//sayısal değeri al
		$sayfa = intval($sayfa);
		
		//sayfanın en küçük değeri
		if ($sayfa < 1) $sayfa = 1;
		
		//viewe gidecek olan veriler
		$vdata = array();
		$vdata["urun_sayfasi"] = $sayfa;
		
		//her sayfada kaç kayıt görülecek
		$limit = 10;
		
		//ürünleri sayfa sayfa getir aga
		$vdata["urunler"] = $this->m_urunler->urunleri_getir($sayfa, $limit);
		
		//sayfalama sınıfını yükle
		$this->load->library('pagination');
		
		//temel adres
		$config['base_url'] = site_url('admin/urunler/index/');
		//toplam kayıt sayısı
		$urun_miktar = $this->m_urunler->urun_miktar();
		$urun_miktar = $urun_miktar["urun_miktar"];
        $config['total_rows'] = $urun_miktar;
		
        $config['per_page'] = $limit;
		
		//kaç tane sayfa linki görünecek
		$config['num_links'] = 6;
		
		//  admin/urun/index/sayfano
		//  admin:1 urun:2 index:3 sayfanumarası:4
		//  yani sayfa numarasının kaçıncı segmentte bulunduğunu belirliyoruz.
		//  belirlemezsen kafasına göre atıyo
		$config["uri_segment"] = 4;
		
		//linkleri güzelleştirelim
		$config['full_tag_open'] = '<p class="pagination_container">';
		$config['full_tag_close'] = '</p>';
		//ayarları tekrar yükle
        $this->pagination->initialize($config);
		
		//linkleri al. viewe gönderilecek
		$vdata['pagination'] = $this->pagination->create_links();
		
		//kaçıncı sayfada bulunduğumuzu bilmemiz bizim için iyi olur
		$offset = $this->pagination->get_offset();
		$vdata["offset"] = $offset;
		
		//viewi yükle
		$content = $this->load->view($this->template->getAdminAddres() . "urunler", $vdata, true);
		
		//şablonu kullanıcıya gönder
		$data = array();
		$data["content"] =& $content;
		$this->load->view($this->template->getAdminAddres() . 'template', $data);
		
	}
	
	public function kategoriler()
	{
		//kategoriler modelini yükle
		$this->load->model("m_kategoriler");
		
		//viewi yükle
		$content = $this->load->view($this->template->getAdminAddres() . "kategoriler", array(), true);
		
		//şablonu kullanıcıya gönder
		$data = array();
		$data["content"] =& $content;
		$this->load->view($this->template->getAdminAddres() . 'template', $data);
	}
	
	
	public function kategori($islem=null, $kat_id=null)
	{
		//kategoriler modelini yükle
		$this->load->model("m_kategoriler");
		
		//viewi yükle
		if ($islem == "ekle")
		{
			//eğer herhangi bir form girişi varsa
			if ($this->input->post("txt_kategori"))
			{
				//gelen bilgiyi temizleyip al
				$kat = $this->input->post("txt_kategori", true);
				//tabloya ekle
				$this->m_kategoriler->ekle($kat);
				//yönlendir ve çık
				redirect("admin/urunler/kategoriler");
				exit();
				
			}
			
			$content = $this->load->view($this->template->getAdminAddres() . "kategori_ekle", array(), true);
		}
		else if ($islem == "sil")
		{
			//kategoriyi sil
			$kat_id = (int)$kat_id;
			$this->m_kategoriler->sil($kat_id);
			//yönlendir
			redirect("admin/urunler/kategoriler");
			exit();
		}
		
		//şablonu kullanıcıya gönder
		$data = array();
		$data["content"] =& $content;
		$this->load->view($this->template->getAdminAddres() . 'template', $data);
		
	}
	
	
	
	public function urun($islem=null, $id=null)
	{
		//modeli yükle
		$this->load->model("m_urunler");
		$this->load->model("m_kategoriler");
		
		//viewi yükle
		if ($islem == "ekle")
		{
			//eğer herhangi bir form girişi varsa
			if ($this->input->post("hid_bilgi"))
			{
				//form doğrulama sınıfı
				$this->load->library('form_validation');
				
				//[sel_kategori] => 3 [txt_urun_adi] => aerg [txt_aciklama] => aerg [txt_fiyat] =>
				$this->form_validation->set_rules('txt_urun_adi', 'Ürün adı', 
					'required|min_length[4]|max_length[64]');
				$this->form_validation->set_rules('txt_aciklama', 'Açıklama', 
					'required|min_length[4]');
				$this->form_validation->set_rules('txt_fiyat', 'Ürün fiyatı', 
					'required|min_length[1]|max_length[64]');
				$this->form_validation->set_rules('sel_kategori', 'Kategori', 
					'required|min_length[1]');
				
				$this->form_validation->set_error_delimiters('<div class="hatali_form_girisi">', '</div>');
				
				//kontrolü gerçekleştir
				if ($this->form_validation->run() == true)
				{
					//form girişleri geçerli
					
					//ürün bilgilerini kaydet
					//sel_kategori txt_urun_adi txt_aciklama txt_fiyat
					//form bilgilerini güvenli hale getir
					$data["kat_id"] = (int)$this->input->post("sel_kategori");
					$data["baslik"] = addslashes($this->input->post("txt_urun_adi"));
					$data["detay"] = addslashes($this->input->post("txt_aciklama"));
					$data["fiyat"] = (float)$this->input->post("txt_fiyat");
					//ürünü ekle
					$this->m_urunler->ekle($data);
					
					//küçük resim ekleme bölümü
					$urun_id = $this->db->insert_id();
					$config['file_name'] = $urun_id . '_kucuk.png';
					
					$config['upload_path'] = './images/urunimg/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= '2048';
					
					
					//$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					if ( ! $this->upload->do_upload("file_kucuk_resim"))
					{
						//yükleme başarısız
					}
					else
					{
						//yükleme başarılı
						
						$imlib['image_library'] = 'gd2';
						$imlib['source_image'] = './images/urunimg/' . $urun_id . '_kucuk.png';
						$imlib['create_thumb'] = false;
						$imlib['maintain_ratio'] = TRUE;
						$imlib['new_image'] = './images/urunimg/' . $urun_id . '_kucuk.png';
						$imlib['width'] = 150;
						$imlib['height'] = 150;
						
						$this->load->library('image_lib', $imlib);
						$this->image_lib->resize();
						
					}
					
					//yönlendir ve çık
					redirect("admin/urunler/urun/duzenle/". $urun_id ."#urunresimtab");
					exit();
				}
				else
				{
					//form girişlerinde hata var
					
				}
				
				
			}
			//viewi yükle
			$content = $this->load->view($this->template->getAdminAddres() . "urun_ekle", array(), true);
			
		}
		else if ($islem == "sil")
		{
			//id bilgisinin sayısal değeri
			$id = (int)$id;
			
			//herşeye rağmen id bilgisinin kontrolünü yapalım
			if ($id > 0)
			{
				//önce ilgili küçük resmi siliyoruz
				@unlink("images/urunimg/".$id."_kucuk.png");
				
				//sonra ürünün büyük resimlerini alıyoruz
				$this->load->model("m_urun_resim");
				$resimler = $this->m_urun_resim->urun_resimlerini_getir($id);
				
				//bu resimleri döngüyle sil
				foreach ($resimler->result_array() as $resim)
				{
					//dosya sisteminden sil
					@unlink("images/urunimg/" . $resim["id"] . "_thumb.png");
					@unlink("images/urunimg/" . $resim["id"] . "_buyuk.png");
					//veritabanından sil
					$this->m_urun_resim->sil($resim["id"]);
				}
				
				//ürünün kendisini sil
				$this->m_urunler->sil($id);
				
			}
			
			//yönlendir ve çık
			redirect("admin/urunler");
			exit();
			
		}
		else if ($islem == "duzenle")
		{
			//id bilgisinin sayısal değeri
			$id = (int)$id;
			
			//eğer herhangi bir form girişi varsa
			if ($this->input->post("hid_bilgi"))
			{
				//form doğrulama sınıfı
				$this->load->library('form_validation');
				
				//[sel_kategori] => 3 [txt_urun_adi] => aerg [txt_aciklama] => aerg [txt_fiyat] =>
				$this->form_validation->set_rules('txt_urun_adi', 'Ürün adı', 
					'required|min_length[4]|max_length[64]');
				$this->form_validation->set_rules('txt_aciklama', 'Açıklama', 
					'required|min_length[4]');
				$this->form_validation->set_rules('txt_fiyat', 'Ürün fiyatı', 
					'required|min_length[1]|max_length[64]');
				$this->form_validation->set_rules('sel_kategori', 'Kategori', 
					'required|min_length[1]');
				
				$this->form_validation->set_error_delimiters('<div class="hatali_form_girisi">', '</div>');
				
				//kontrolü gerçekleştir
				if ($this->form_validation->run() == true)
				{
					//form girişleri geçerli
					
					//ürün bilgilerini kaydet
					//sel_kategori txt_urun_adi txt_aciklama txt_fiyat
					//form bilgilerini güvenli hale getir
					$data["kat_id"] = (int)$this->input->post("sel_kategori");
					$data["baslik"] = addslashes($this->input->post("txt_urun_adi"));
					$data["detay"] = addslashes($this->input->post("txt_aciklama"));
					$data["fiyat"] = (float)$this->input->post("txt_fiyat");
					$data["id"] = $id;
					
					//ürünü ekle
					$this->m_urunler->duzenle($data);
					
					//küçük resmi güncelle
					if ($this->input->post("check_yeni_resim"))
					{
						//küçük resim ekleme bölümü
						$urun_id = $id;
						
						
						$config['file_name'] = $urun_id . '_kucuk.png';
						
						$config['upload_path'] = './images/urunimg/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']	= '2048';
						
						//eğer ürünün küçük resmi varsa sil
						@unlink($config["upload_path"] . $config["file_name"]);
						
						//$this->load->library('upload', $config);
						$this->upload->initialize($config);
						
						if ( ! $this->upload->do_upload("file_kucuk_resim"))
						{
							//yükleme başarısız
						}
						else
						{
							//yeniden boyutlandırma muhabbetini buraya koy
							
							$imlib['image_library'] = 'gd2';
							$imlib['source_image'] = './images/urunimg/' . $urun_id . '_kucuk.png';
							$imlib['create_thumb'] = false;
							$imlib['maintain_ratio'] = TRUE;
							$imlib['new_image'] = './images/urunimg/' . $urun_id . '_kucuk.png';
							$imlib['width'] = 150;
							$imlib['height'] = 150;
							
							$this->load->library('image_lib', $imlib);
							$this->image_lib->resize();
							
						}
					}
					
					/*
					//yönlendir ve çık
					redirect("admin/urunler/urun/duzenle/". $urun_id ."#urunresimtab");
					exit();
					*/
					
				}
				else
				{
					//form girişlerinde hata var
					
				}
				
			}
			
			
			//viewe gidecek olan bilgiler
			$vdata["urun_id"] = (int)$id;
			
			//viewi yükle
			$content = $this->load->view($this->template->getAdminAddres() . "urun_duzenle", $vdata, true);
			
			
		}
		
		//şablonu kullanıcıya gönder
		$data = array();
		$data["content"] =& $content;
		$this->load->view($this->template->getAdminAddres() . 'template', $data);
		
	}
	
}

?>