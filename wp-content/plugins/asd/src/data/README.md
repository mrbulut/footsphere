

# Use in all database object 
<code> $database = new CustomerDal(); </code>
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
# class CustomerDal; 
<pre><code>
$database = new CustomerDal(); 
$database->getProductWaitingCustomers(); // return array
$database->getProductNoCompoleteCustomers(); // return not compolete users 
$database->getProductCompoleteCustomers(); // return compolete users
$database->getProductFixCustomers(); // return ready users

</code></pre>
-----------
# class MessageDal; 
<pre><code>
$database = new MessageDal(); 
$database->getAllMessagesToUserId($Id,$HowManyMessage); 
$database->getTotalMessage($HowManyMessage); // messages in all of system 
$database->getUnreadMessages($HowManyMessage); // messages in all of system 
$database->isThereAnyUnreadMessage($HowManyMessage); // unread message for the user

</code></pre>
--------------