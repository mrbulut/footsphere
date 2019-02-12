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
      $CustomerManager->getProductNoCompoleteCustomers();// return array
      $CustomerManager->getProductCompoleteCustomers();// return array
      $CustomerManager->getProductFixCustomers();// return array
  
      $CustomerManager->setCustomerStatus($UserId,"Fix");
      
</pre></code>

