

** Use in all database object **


<pre><code>
$database = new CustomerDal(); 
</pre></code>
---------
<pre><code>
$addObject = new Customer();
$whereObject = new Customer();
$addObject->setAge("1");
$whereObject->setID("1");

$database->settingQuery($addObject,$whereObject); // make input and query
$database->insertToObject(); // return true or false
$database->getToObject();    // return the array
$database->updateToObject(); // return true or false
$database->deleteToObject(); // return true or false
</pre></code>

https://github.com/ThingEngineer/PHP-MySQLi-Database-Class
You can use features in This github link with $database object 
---------
** # class CustomerDal; **

<pre><code>
$ExtraFilePath // File1,File2,...
$CanUseProducts // ProductID1,ProductID2,..
$BespokeStatus  // NoCompolete, Compolete, Waiting, Fix

$database = new CustomerDal(); 
$database->getProductWaitingCustomers(); // return array
$database->getProductNoCompoleteCustomers(); // return not compolete users 
$database->getProductCompoleteCustomers(); // return compolete users
$database->getProductFixCustomers(); // return ready users

</code></pre>
-----------
** # class MessageDal; **
<pre><code>
$WhoIsMessage // Producer, Customer, OperationManager
$Status       // UnReaded, Readed

$database = new MessageDal(); 
$database->getAllMessagesToUserId($Id,$HowManyMessage); 
$database->getTotalMessage($HowManyMessage); // messages in all of system 
$database->getUnreadMessages($HowManyMessage); // messages in all of system 
$database->isThereAnyUnreadMessage($HowManyMessage); // unread message for the user

</code></pre>
--------------

** # class OptionsDal; **

<pre><code>
// defineCaps() // User's permission 
// defineSettings() // General const

$database = new OptionsDal(); 
$database->setLangueages($UserId,$lang); // Langueages's short code (Tr)
$database->getLangueages($UserId); 

$database->setRequest($UserId,$lang); // user's shoes request
$database->getRequest($UserId); 

$database->setProducerRequestLimit($producerRequestLimit); // all of producer's offer limit
$database->getProducerRequestLimit(); 

$database->setProducerModelLimit($producerModelLimit); // all of producer's model limit
$database->getProducerModelLimit(); 

$database->setRequestTimeArea($requestTimeArea); // all of user's request time limit
$database->getRequestTimeArea(); 

$database->setCommissionArea($UserId); // it is my commision (%60)
$database->getCommissionArea(); 

//all of private
$database->selectOption($option_name); // get in the option value
$database->deleteOption($option_name); // delete the option
$database->addOption($option_name,$options_value); // add 
$database->updateOptionToID($options_value,$option_id); // update option by id 
$database->updateOptionToID($option_name,$option_value); // update option by option name 
// 

</code></pre>
--------------
** # class ProducerDal; **
<pre><code>
$database = new ProducerDal(); 
$database->addProducer(User $user,$offerLimit); // like the offerlimit min max = 50-100 

</code></pre>
--------------
--------------
** # class ProductDal; **
<pre><code>
$database = new ProductDal(); 


</code></pre>
--------------

** # class RequestDal; **
<pre><code>
$ProductsAndPrices // ProductId:Price, ProductId2:Price2,...
$Status            // Continue, Accepted, Onaylandi, Reddedildi.
$Type              // Shoes, Slipper
$database = new RequestDal(); 
$ProductsAndPrices = 
$database->getAllRequestsToContinue(); // all of not finish time requests
$database->getProducerStatistics(); //   return $array
  $array['all']  int
  $array['pass'] int
  $array['refuse'] int

</code></pre>
--------------
** # class UserDal; **
<pre><code>
$database = new UserDal(); 

$database->getUserId(); 
$database->createUser(User $user); 
$database->deleteUser(); first make $database->setUserId($UserId); 
$database->updateUserWp(User $user); first make $database->setUserId($UserId); 

  
</code></pre>
--------------