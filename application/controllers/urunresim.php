<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class urunresim extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		//admin oturum kontrolü yapılacak
		if (!$this->session->userdata("adminlogin"))
		{
			redirect("admin");
			exit();
		}
		
		//modeli yükle
		$this->load->model("m_urun_resim");
		
	}
	
	//ajax metoduyla ürün resim upload
	public function index($urun_id=null)
	{
		//sayısal değeri
		$urun_id = intval($urun_id);
		$resimid = $this->m_urun_resim->ekle($urun_id);
		
		$imlib['image_library'] = 'gd2';
		$imlib['source_image'] = $_FILES["urunresim"]["tmp_name"];
		$imlib['create_thumb'] = false;
		$imlib['maintain_ratio'] = TRUE;
		$imlib['new_image'] = './images/urunimg/' . $resimid . "_thumb.png";
		$imlib['width'] = 100;
		$imlib['height'] = 100;
		
		$this->load->library('image_lib', $imlib);
		$this->image_lib->resize();
		
		//dosya yükleme
		$upconf['upload_path'] = './images/urunimg/';
		$upconf['allowed_types'] = 'gif|jpg|png|jpeg';
		$upconf["file_name"] = $resimid . "_buyuk.png";
		$upconf['max_size']	= 1024 * 2;
		$upconf['max_width']  = '3500';
		$upconf['max_height']  = '2500';
		//$this->load->library('upload', $upconf);
		$this->upload->initialize($upconf);
		
		//eğer yükleme başarılıysa
		if ( ! $this->upload->do_upload("urunresim"))
		{
			$error = array('error' => $this->upload->display_errors());
			$arr["error"] = $error;
			
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$arr["data"] = $data;
			
		}
		
		$arr["test"] = "aga bu bir testtir";
		$arr["file"] = $_FILES;
		$arr["urun_id"] = $urun_id;
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: application/json');
		
		echo json_encode($arr);
		
		
	}
	
	
	//ajax ile ürünlerin thumb adreslerini gönder
	public function urunresimthumb($urun_id=null)
	{
		
		//sayısal değerini al
		$urun_id = intval($urun_id);
		
		//ürün resimlerinin idlerini al
		$imgs = $this->m_urun_resim->urun_resimlerini_getir($urun_id);
		//ürün idlerini bu dizide saklıyoruz
		$arr = array();
		//gelen bilgileri al
		foreach ($imgs->result_array() as $img)
		{
			$arr[] = array(
				"resim_id" => $img["id"],
				"urun_id" => $img["urun_id"]
			);
		}
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: application/json');
		
		echo json_encode($arr);
		
		return;
	}
	
	//idsi belli olan resmi sil
	public function buyukresimsil($resim_id=null)
	{
		//sayısal değerini al
		$resim_id = intval($resim_id);
		
		//önce resmi dosya sisteminden sil
		@unlink("images/urunimg/" . $resim_id . "_thumb.png");
		@unlink("images/urunimg/" . $resim_id . "_buyuk.png");
		
		//resmi veritabanından sil
		$this->m_urun_resim->sil($resim_id);
		
		//mesaj verdirmek iyi bi davranıştır
		echo "tamam";
		
		return;
	}
	
}

?>