<?php


/*
 $salt = Hash::salt(32);
 Hash::create('sifre',$salt);


 */
class Hash
{

  
  public static function create($string,$salt='')
  {
    return hash('sha256',$string.$salt);
  }

  

  public static function salt($long='')
  {
    return mcrypt_create_iv($long);
  }

  public static function unique()
  {
    return self::create(uniqid());
  }
}
 ?>
