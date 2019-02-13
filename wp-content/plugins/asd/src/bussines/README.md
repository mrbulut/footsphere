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
$MessageManager = new MessageManager($UserId);

      $MessageManager->getMessagesList(Message); //return array
      $MessageManager->addMessage(Message); // return id
      $MessageManager->updateMessage(Message,Message); //return boolean
      $MessageManager->deleteMessage(Message); // return boolean

      $MessageManager->getAllMessageForUser($UserId); // array - all message of users 
      $MessageManager->isThereUnreadMessageForUser($UserId);array - all message of users
      $MessageManager->getAllMessage(); // array - all messages of system
      $MessageManager->getAllMessageLenght(); int 
      $MessageManager->getAllUnDreadMessages(); // array - get undread messages
      $MessageManager->setTheUserMessagesRead($UserId); // bolean - do has been read messages for user
      $MessageManager->writeMessage($UserId,$Message,$Who); //  



</pre></code>


<b>Using The OptionsManager class in OptionsManager.php</b> "/bussines/concrete/OptionsManager.php"

<pre><code>
include_once ROOT_PATH."/src/bussines/concrete/OptionsManager.php";
$OptionsManager = new OptionsManager($UserId); // maybe null

       function addOption($option_name,$option_value); r
       function updateOptionById($option_id,$option_value);
       function updateOptionByName($option_name,$option_value);
   
       function denineDefaultSettings();
       function getLangueages($UserId);
       function setLangueages($UserId, $langueages);
       function getRequest($UserId);
       function setRequest($UserId, $request); 
   
       function getProducerRequestLimit();
       function setProducerRequestLimit($producerRequestLimit);
   
       function getProducerModelLimit();
       function setProducerModelLimit($producerModelLimit);
   
       function getRequestTimeArea();
       function setRequestTimeArea($requestTimeArea);
   
       function getCommissionArea();
       function setCommissionArea($commissionArea);

</pre></code>


<b>Using The ProducerManager class in ProducerManager.php</b> "/bussines/concrete/ProducerManager.php"

<pre><code>
include_once ROOT_PATH."/src/bussines/concrete/ProducerManager.php";
$ProducerManager = new ProducerManager($UserId); // maybe null

           function getProducerProducts(); // Return String ex : 122,333,444,...
           function addProduct($UserId,$array=array());// ex: array(ProductId,ProductId2,ProductId3);
           function deleteProduct($UserId,$ProductNo); // return bolean
       
           function getProducerByUserId($UserId); // return array 
           function getProducerAll();   // all producers info of system
       
           function updateProducerByUserId(Producer $producer,$UserId);
           function createProducer($Name,$Email,$Pass,$OfferLimit);// if is there return false
           function removeProducer($UserId);

</pre></code>
