
<code> $database = new CustomerDal(); </code>

///
use in all database object 
<pre><code>
$addObject = new Customer();
$whereObject = new Customer();
$addObject->setAge("1");
$whereObject->setID("1");

$database->settingQuery($addObject,$whereObject); // make input and query
$database->insertToObject(); // return true or false
$database->getToObject();    // return the object
$database->updateToObject(); // return true or false
$database->deleteToObject(); // return true or false
</pre></code>
///