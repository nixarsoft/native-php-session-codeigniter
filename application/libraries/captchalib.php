<?

class CaptchaLib {

  public $width;
  public $height;
  public $fontSize;
  
  public function generateCode() {
    $possible = '23456789';
    $code = '';
    $i = 0;

    while ($i < $this->charCnt) {
      $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
      $i++;
    }
    return $code;
  }

  public function createImage( $code ) {
    header('Content-Type: image/png');
    $font = $this->fontSize;
    $string = $code;
    $width = $this->width;
    $height = $this->height;

    $im = @imagecreatetruecolor( $width, $height );
    imagesavealpha($im, true);
    imagealphablending($im, false);
    $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $white);
    $lime = imagecolorallocate($im, 204, 255, 51);
    imagettftext($im, $font, 0, 10, 10, $lime, BASEPATH . "fonts/texb.ttf", $string);
    imagepng($im);
    imagedestroy($im);
  }

  public function createImage2($code) {
    $width = $this->width;
    $height = $this->height;

    $img = imagecreatetruecolor( $width,$height ); 
    imagesavealpha($img, true); 

    // Fill the image with transparent color 
    $color = imagecolorallocatealpha($img,0x00,0x00,0x00,127); 
    imagefill($img, 0, 0, $color); 

    // Save the image to file.png 
    imagepng($img, "file.png"); 

    // Destroy image 
    imagedestroy($img); 
  }
}
