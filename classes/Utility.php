<?php
class Utility {

  public static function redirect($url = 'index.php'){
    if(!headers_sent()){
      header('Location: '.$url);
    }else{
      $redirect = '<script type="text/javascript">';
      $redirect .= 'window.location.href="'.$url.'";';
      $redirect .= '</script>';
      $redirect .= '<noscript>';
      $redirect .= '<meta http-equiv="refresh" content="0;url='.$url.'" />';
      $redirect .= '</noscript>';
      echo $redirect;
    }
  }  
};
?>