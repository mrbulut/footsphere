<?php
/*
kullanimi ;

Routing(404) - > hata sayfasına yönlendirir.
Routing('page.php') page.php sayfasına yönlendirir.
*/
class routing
{

  public static function go ($location=null)
  {
    if ($location){
      if(is_numeric($location)){
        switch ($location) {
          case 404:
          include('class/404.php');
          header('class/404.php');
          exit();
          break;

          default:
          // code...
          break;
        }

      }
      header ('Location: '.$location);
      exit();
    }
  }
}class df{

}

?>
