<b>Using The CustomerManager class in CustomerManager.php</b> "/bussines/concrete/CustomerManager.php"

<pre><code>
include_once ROOT_PATH."/src/bussines/concrete/CustomerManager.php";
$CustomerManager = new CustomerManager($UserId);

$Customer = new Customer();
$Customer->setUserId($UserId); 
$CustomerWhere = new Customer(); 
$CustomerWhere->setUserId($UserId);
$data = $CustomerManager->getCustomerList($Customer); 

      $CustomerManager->getCustomerList(); //return array
      $CustomerManager->addCustomer(); // return id
      $CustomerManager->updateCustomer(); //return boolean
      $CustomerManager->deleteCustomer(); // return boolean
  
      $CustomerManager->getRole();
  
      $CustomerManager->getExtraFile();
      $CustomerManager->updateExtraFile($filePath);
      $CustomerManager->deleteExtraFile($filePath);
  
      $CustomerManager->getProducts();
      $CustomerManager->updateProduct($array = array());
      $CustomerManager->deleteProduct($productNo);
  
      $CustomerManager->getLanguages();
      $CustomerManager->setLanguages($lang);
  
      $CustomerManager->getProductWaitingCustomers();  // return array
      $CustomerManager->getProductNoCompleteCustomers();// return array
      $CustomerManager->getProductCompleteCustomers();// return array
      $CustomerManager->getProductFixCustomers();// return array
  
      $CustomerManager->setCustomerStatus($UserId,"Fix");
      $CustomerManager->setCustomerStatusAutomatic(); 
      "$Length; $Weight; $Age; $Foot Size; $FootImage; $FootImage2; $FootImage3; "
      Users with full the variables is changing status 
      
</pre></code>



<b>Using The MessageManager class in MessageManager.php</b> "/bussines/concrete/MessageManager.php"

<pre><code>
include_once ROOT_PATH."/src/bussines/concrete/MessageManager.php";
$CustomerManager = new MessageManager(1);
$message = new message();
$message->setUserId(1);$message->setMessage("MESAJJJJ");
$messageWhere =new message();
$messageWhere->setId(2);
echo $CustomerManager->getMessagesList($messageWhere)['Message'];

      $CustomerManager->getMessagesList(Message); //return array
      $CustomerManager->addMessage(Message); // return id
      $CustomerManager->updateMessage(Message,Message); //return boolean
      $CustomerManager->deleteMessage(Message); // return boolean
      
</pre></code>
