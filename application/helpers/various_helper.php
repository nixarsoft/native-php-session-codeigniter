<?php

function printAllCategories( $topID = 0 ) {
  $ci = & get_instance();

  $productCat = new ProductCategory();
  $productCat->top_id = $topID;
  $categories = $ci->ProductCategoriesDAO->getCategories( $productCat );

  if ( $categories->num_rows() > 0 ) {
    echo "<ul>\n";

    foreach ( $categories->result( "ProductCategory" ) as $row ) {
      echo "<li>";
      echo '<span class="text">' . $row->title . '</span>' . "\n";

      echo '<span class="buttons">';
      //echo '<a href="admin/products/addcategory/'. $row->id .'">Alt Ktg Ekle</a>&nbsp;|&nbsp;';
      echo '<a href="admin/products/editcategory/'. $row->id .'">Düzenle</a>&nbsp;|&nbsp;';
      echo '<a href="javascript:deleteCat('. $row->id .');">Sil</a>&nbsp;';
      echo "</span>\n";

      printAllCategories($row->id);

      echo "</li>\n";
    }
    echo "</ul>\n";
  }
}


function mail_utf8_smtp($to, $subject = '(No subject)', $message = '') {
  $ci = & get_instance();

  $ci->load->library('email');
  $config['protocol'] = "smtp";
  $config['smtp_host'] = $ci->conf->get("smtp_host");
  $config['smtp_port'] = $ci->conf->get("smtp_port");
  $config['smtp_user'] = $ci->conf->get("smtp_user");
  $config['smtp_pass'] = $ci->conf->get("smtp_pass");
  $config['charset'] = "utf-8";
  $config['mailtype'] = "html";
  $config['newline'] = "\r\n";

  $ci->email->initialize($config);

  $ci->email->from($ci->conf->get("smtp_user"), $ci->conf->get("smtp_user"));
  $list = array($to);
  $ci->email->to($list);
  $ci->email->reply_to($ci->conf->get("smtp_user"), $ci->conf->get("smtp_user"));
  $ci->email->subject( $subject );
  $ci->email->message( $message );
  $ci->email->send();
}
