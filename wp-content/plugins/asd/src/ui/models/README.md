


<b>Using The UserModel class in UserModel.php</b> "/ui/models/UserModel.php"

<pre><code>

$UserModel = new UserModel($UserId or null); // eğer null ise giriş yapan k. idsi allır


$UserModel->getRole(); // return string Kullanıcının rolü
$data = $UserModel->getUser(); // return User Object
 - $data->getUserName() like;
 
$UserModel->addCustomer(
            array(
                'email' => "example@domain.com",
                'username' => "username",
                'password' => "123456",
                'display_name' => "Steve Wick"
            )
        );

$UserModel = new UserModel(2);
$UserModel->updateCustomer(
            array(
                'email' => "NewExample@domain.com",
                'display_name' => "New Steve Wick",
                'Length' => "1",
                'Weight' => "1",
                'Age' => "1",
                'FootSize' => "1",
                'ExtraInfo' => "1",
                'FootImage' => "1",
                'FootImage2' => "1",
                'FootImage3' => "1",
                'FootsphereFilePath' => "1",
                'Status' => "1",
                'Language' => "1",
                'ExtraFilePath' => "1",
                'Products' => array(
                    1,44,66
                )

            )
        );

 $UserModel->getCustomer();
 
  result array ; 
  Array
  (
      [ID] => 1
      [UserId] => 2
      [Length] => 1
      [Weight] => 1
      [Age] => 1
      [FootSize] => 1
      [FootsphereFilePath] => 1
      [ExtraFilePath] => 1+-+
      [CanUseProducts] => 1,44,66,1,44,66,
      [BespokeStatus] => 1
      [ExtraInfo] => 1
      [FootImage] => 1
      [FootImage2] => 1
      [FootImage3] => 1
      [Language] => 1
  )
  
  
  

$UserModel->deleteCustomer(); // return true or false
$UserModel->deleteExtraFileCustomer("filePath"); return true or false
$UserModel->deleteProductCustomer(array(1,66)); 
$UserModel->getWaitingCustomerForProduct(); // Ürün bekleyenler geliii return array 
$UserModel->setCustomerStatusAutomatic(); // eğer boy,kilo,yaş ve ayak fotoları varsa
kullanıcı durumunu "Complete" yapıyor.



// producer 


$UserModel = new UserModel();
 $UserModel->addProducer(
    array(
        "username" => "usernameTest",
        "email" => "testEmail@testsite.com",
        "password"  =>"passwords",
        "offer" =>"50-250"
     )
);

$UserModel->getAllProducer() // return array $data[][]

$UserModel = new UserModel(11); // return array 
        echo $UserModel->getProducer()['ID'];


$UserModel = new UserModel(11);
 $UserModel->updateProducer(
    array(
        "email" => "NewtestEmail@testsite.com",
        "password"  =>"passwords",
        "OfferLimit" =>"50-250",
        'display_name' => "New",
        'CompanyName' => "New",
        'PhoneNumber' => "New",
        'PhoneNumber2' => "New",
        'Address' => "New",
        'PaymentInformantion' => "New",
        'CargoInformantion' => "New",

    )
);



</pre></code>


