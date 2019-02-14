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


<b>Using The ProductManager class in ProductManager.php</b> "/bussines/concrete/ProductManager.php"

<pre><code>
include_once ROOT_PATH."/src/bussines/concrete/ProductManager.php";


$ProductManager = new ProductManager();
$Product = new Product();
$ProductWhere = new Product();
$Product->setStatus("fix");
$Product->setPName("Denemeürünü");
$Product->setDescProduct("Açıklaması");
$Product->setPrice("55");
$Product->setImage("imageadresi/ddd.com");

        function createProduct(Product $product); // creating product for producer 
 
        function getAllProduct($Type);            // return array ({0,productArray},{1,product2array},..)
    
        function getAllProductByProducerNo($ProducerNo);  // return array ({0,productArray},{1,product2array},..)
    
        function getProductById($ID);// return array;
            
        function getProductByIdArray($ID);        // return array ({0,productArray},{1,product2array},..)
    
        function getProductByObject(Product $product); // return array ({0,productArray},{1,product2array},..)
    
        function setProductStatus($ID, $Status); //Approved,Waiting,NoApproved
    
        function getProductStatus($ID); //Approved,Waiting,NoApproved
    
        function removeProduct($ID);    // everywhere are cleaning
    
        function upgradeProduct(Product $product, $ID);  // everywhere are updating
    
        function addProductForUser($ProductId, $UserId); // 
    
       
    
        function getAllListForTheUser($UserId);          // return array ({0,productArray},{1,product2array},..)
    
        function removeProductPermissionForUser($UserId, $ProductId); //


   


</pre></code>



<b>Using The RequestManager class in RequestManager.php</b> "/bussines/concrete/RequestManager.php"
 
 <pre><code>
 include_once ROOT_PATH."/src/bussines/concrete/RequestManager.php";
 
     function getAllRequest(); // return array ({0,productArray},{1,product2array},..)
 
     function getRequestByProducerNo($ProducerNo); // return array ({0,productArray},{1,product2array},..)
 
     function getRequestById($Id); return array 
 
     function getRequestByUserId($UserId); return array 
 
     function getRequestByUserIdAndProducerNo($UserId, $ProducerNo);
 
     function setRequestByUserId($UserId, $Status);
 
     function createRequest($UserId, $ProducerNo, $RequestID, $Products, $Type); // return true or false
 
     function removeRequest($RequestID);
 
     function getRequestStatus($ID);
 
     function setRequestStatusByID($ID, $Status);
 
     function getRequestStatusByRequestNo($RequestNo);
 
     function setRequestStatusByRequestNo($RequestNo, $Status);
 
     function getProducerStatistics($ProducerNo); // return  $array['all'] = count($all);
                                                             $array['pass'] = count($pass);
                                                              $array['refuse'] = count($refuse);

 
 
 
 
 
 </pre></code>
