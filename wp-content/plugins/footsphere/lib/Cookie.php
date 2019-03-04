<?php
/*
kullanimi ;
//Cookie oluşturma
Cookie::create($cookie_name,$hashvalue,$cookie_finish_time);

//Cookie kontrolü
if(Cookie::isthere($cookie_name) && Session::isthere($session_name))
echo 'cookie var';

//Cookie silmek
Cookie::delete($cookie_name);
 */class df{

}
class Cookie
{

  function __construct()
  {
    session_start();
  }
  public static function isthere($name)
  {
    return (isset($_COOKIE[$name])) ? true : false;
  }

  public static function get($name)
  {
    return $_COOKIE[$name];
  }

  public static function create($name,$valu)
  {
    if(setcookie($name,$valu,time() + 10000,'/')){
      return true;
    }else{
      return false;
    }
  }

  public static function delete($name)
  {
    self::create($name,'',time()-1);
  }


}

 ?>
