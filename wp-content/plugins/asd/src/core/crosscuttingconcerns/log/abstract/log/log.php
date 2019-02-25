[25.02.2019 - 08:00:12][FATAL] - Sorgu çalıştırılamadı.Ex
ception: Unknown column 'ProductsAndPrices22' in 'field list' quer
y: INSERT  INTO a_fs_Request (`UserID`, `ProducerNo`, `RequestNo`, `ProductsAn
dPrices`, `Type`)  VALUES (?, ?, ?, ProductsAndPrices22, ?) in /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php:2028
Stack trace:
#0 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1617): MysqliDb->_prepareQuery()
#1 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1555): MysqliDb->_buildQuery(NULL, Array)
#2 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(836): MysqliDb->_buildInsert('a_fs_Request', Array, 'INSERT')
#3 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(134): MysqliDb->insertMysqliDb('a_fs_Request', Array)
#4 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(70): DatabaseTableDao->insert(Array)
#5 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(157): DatabaseTableDao->insertToObject()
#6 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(62): RequestManager->addRequest(Object(Request))
#7 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/models/RequestModel.php(62): RequestManager->createRequest(11, '1', '1', Array, '1')
#8 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/controllers/homeController.php(9): RequestModel->createRequest(Array)
#9 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/core/autoloader.php(54): homeController->index()
#10 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/index.php(17): include('/opt/lampp/htdo...')
#11 /opt/lampp/htdocs/footsphere/wp-settings.php(322): include_once('/opt/lampp/htdo...')
#12 /opt/lampp/htdocs/footsphere/wp-config.php(79): require_once('/opt/lampp/htdo...')
#13 /opt/lampp/htdocs/footsphere/wp-load.php(37): require_once('/opt/lampp/htdo...')
#14 /opt/lampp/htdocs/footsphere/wp-blog-header.php(13): require_once('/opt/lampp/htdo...')
#15 /opt/lampp/htdocs/footsphere/index.php(17): require('/opt/lampp/htdo...')
#16 {main}RequestManager_addRequest
[25.02.2019 - 08:01:38][FATAL] - Sorgu çalıştırılamadı.Exception: Unknown column 'ProductsAndPrices22' in 'field list' query: INSERT  INTO a_fs_Request (`UserID`, `ProducerNo`, `RequestNo`, `ProductsAndPrices`, `Type`)  VALUES (?, ?, ?, ProductsAndPrices22, ?) in /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php:2028
Stack trace:
#0 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1617): MysqliDb->_prepareQuery()
#1 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1555): MysqliDb->_buildQuery(NULL, Array)
#2 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(836): MysqliDb->_buildInsert('a_fs_Request', Array, 'INSERT')
#3 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(134): MysqliDb->insertMysqliDb('a_fs_Request', Array)
#4 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(70): DatabaseTableDao->insert(Array)
#5 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(158): DatabaseTableDao->insertToObject()
#6 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(63): RequestManager->addRequest(Object(Request))
#7 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/models/RequestModel.php(62): RequestManager->createRequest(11, '1', '1', Array, '1')
#8 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/controllers/homeController.php(9): RequestModel->createRequest(Array)
#9 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/core/autoloader.php(54): homeController->index()
#10 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/index.php(17): include('/opt/lampp/htdo...')
#11 /opt/lampp/htdocs/footsphere/wp-settings.php(322): include_once('/opt/lampp/htdo...')
#12 /opt/lampp/htdocs/footsphere/wp-config.php(79): require_once('/opt/lampp/htdo...')
#13 /opt/lampp/htdocs/footsphere/wp-load.php(37): require_once('/opt/lampp/htdo...')
#14 /opt/lampp/htdocs/footsphere/wp-blog-header.php(13): require_once('/opt/lampp/htdo...')
#15 /opt/lampp/htdocs/footsphere/index.php(17): require('/opt/lampp/htdo...')
#16 {main}RequestManager_addRequest
[25.02.2019 - 08:01:56][FATAL] - Sorgu çalıştırılamadı.Exception: Unknown column 'ProductsAndPrices22' in 'field list' query: INSERT  INTO a_fs_Request (`UserID`, `ProducerNo`, `RequestNo`, `ProductsAndPrices`, `Type`)  VALUES (?, ?, ?, ProductsAndPrices22, ?) in /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php:2028
Stack trace:
#0 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1617): MysqliDb->_prepareQuery()
#1 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1555): MysqliDb->_buildQuery(NULL, Array)
#2 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(836): MysqliDb->_buildInsert('a_fs_Request', Array, 'INSERT')
#3 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(134): MysqliDb->insertMysqliDb('a_fs_Request', Array)
#4 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(70): DatabaseTableDao->insert(Array)
#5 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(158): DatabaseTableDao->insertToObject()
#6 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(62): RequestManager->addRequest(Object(Request))
#7 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/models/RequestModel.php(62): RequestManager->createRequest(11, '1', '1', Array, '1')
#8 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/controllers/homeController.php(9): RequestModel->createRequest(Array)
#9 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/core/autoloader.php(54): homeController->index()
#10 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/index.php(17): include('/opt/lampp/htdo...')
#11 /opt/lampp/htdocs/footsphere/wp-settings.php(322): include_once('/opt/lampp/htdo...')
#12 /opt/lampp/htdocs/footsphere/wp-config.php(79): require_once('/opt/lampp/htdo...')
#13 /opt/lampp/htdocs/footsphere/wp-load.php(37): require_once('/opt/lampp/htdo...')
#14 /opt/lampp/htdocs/footsphere/wp-blog-header.php(13): require_once('/opt/lampp/htdo...')
#15 /opt/lampp/htdocs/footsphere/index.php(17): require('/opt/lampp/htdo...')
#16 {main}RequestManager_addRequest
[25.02.2019 - 08:01:57][FATAL] - Sorgu çalıştırılamadı.Exception: Unknown column 'ProductsAndPrices22' in 'field list' query: INSERT  INTO a_fs_Request (`UserID`, `ProducerNo`, `RequestNo`, `ProductsAndPrices`, `Type`)  VALUES (?, ?, ?, ProductsAndPrices22, ?) in /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php:2028
Stack trace:
#0 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1617): MysqliDb->_prepareQuery()
#1 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1555): MysqliDb->_buildQuery(NULL, Array)
#2 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(836): MysqliDb->_buildInsert('a_fs_Request', Array, 'INSERT')
#3 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(134): MysqliDb->insertMysqliDb('a_fs_Request', Array)
#4 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(70): DatabaseTableDao->insert(Array)
#5 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(158): DatabaseTableDao->insertToObject()
#6 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(62): RequestManager->addRequest(Object(Request))
#7 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/models/RequestModel.php(62): RequestManager->createRequest(11, '1', '1', Array, '1')
#8 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/controllers/homeController.php(9): RequestModel->createRequest(Array)
#9 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/core/autoloader.php(54): homeController->index()
#10 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/index.php(17): include('/opt/lampp/htdo...')
#11 /opt/lampp/htdocs/footsphere/wp-settings.php(322): include_once('/opt/lampp/htdo...')
#12 /opt/lampp/htdocs/footsphere/wp-config.php(79): require_once('/opt/lampp/htdo...')
#13 /opt/lampp/htdocs/footsphere/wp-load.php(37): require_once('/opt/lampp/htdo...')
#14 /opt/lampp/htdocs/footsphere/wp-blog-header.php(13): require_once('/opt/lampp/htdo...')
#15 /opt/lampp/htdocs/footsphere/index.php(17): require('/opt/lampp/htdo...')
#16 {main}RequestManager_addRequest
[25.02.2019 - 08:01:57][FATAL] - Sorgu çalıştırılamadı.Ex
ception: Unknown column 'ProductsAndPrices22' in 'field li
st' query: INSERT  INTO a_fs_Request (`UserID`, `ProducerNo`, `R
equestNo`, `ProductsAndPrices`, `Type`)  VALUES (?, ?, ?, Product
sAndPrices22, ?) in /opt/lampp/htdocs/footsphere/wp-content/pl
ugins/asd/src/data/abstract/MysqliDb.php:2028
Stack trace:
#0 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1617): MysqliDb->_prepareQuery()
#1 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1555): MysqliDb->_buildQuery(NULL, Array)
#2 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(836): MysqliDb->_buildInsert('a_fs_Request', Array, 'INSERT')
#3 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(134): MysqliDb->insertMysqliDb('a_fs_Request', Array)
#4 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(70): DatabaseTableDao->insert(Array)
#5 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(158): DatabaseTableDao->insertToObject()
#6 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(62): RequestManager->addRequest(Object(Request))
#7 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/models/RequestModel.php(62): RequestManager->createRequest(11, '1', '1', Array, '1')
#8 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/controllers/homeController.php(9): RequestModel->createRequest(Array)
#9 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/core/autoloader.php(54): homeController->index()
#10 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/index.php(17): include('/opt/lampp/htdo...')
#11 /opt/lampp/htdocs/footsphere/wp-settings.php(322): include_once('/opt/lampp/htdo...')
#12 /opt/lampp/htdocs/footsphere/wp-config.php(79): require_once('/opt/lampp/htdo...')
#13 /opt/lampp/htdocs/footsphere/wp-load.php(37): require_once('/opt/lampp/htdo...')
#14 /opt/lampp/htdocs/footsphere/wp-blog-header.php(13): require_once('/opt/lampp/htdo...')
#15 /opt/lampp/htdocs/footsphere/index.php(17): require('/opt/lampp/htdo...')
#16 {main}RequestManager_addRequest
[25.02.2019 - 08:03:16][FATAL] - Sorgu çalıştırılamadı.Exception: Unknown column 'ProductsAndPrices22' in 'field list' query: INSERT  INTO a_fs_Request (`UserID`, `ProducerNo`, `RequestNo`, `ProductsAndPrices`, `Type`)  VALUES (?, ?, ?, ProductsAndPrices22, ?) in /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php:2028
Stack trace:
#0 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1617): MysqliDb->_prepareQuery()
#1 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1555): MysqliDb->_buildQuery(NULL, Array)
#2 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(836): MysqliDb->_buildInsert('a_fs_Request', Array, 'INSERT')
#3 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(134): MysqliDb->insertMysqliDb('a_fs_Request', Array)
#4 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(70): DatabaseTableDao->insert(Array)
#5 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(158): DatabaseTableDao->insertToObject()
#6 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(62): RequestManager->addRequest(Object(Request))
#7 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/models/RequestModel.php(62): RequestManager->createRequest(11, '1', '1', Array, '1')
#8 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/controllers/homeController.php(9): RequestModel->createRequest(Array)
#9 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/core/autoloader.php(54): homeController->index()
#10 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/index.php(17): include('/opt/lampp/htdo...')
#11 /opt/lampp/htdocs/footsphere/wp-settings.php(322): include_once('/opt/lampp/htdo...')
#12 /opt/lampp/htdocs/footsphere/wp-config.php(79): require_once('/opt/lampp/htdo...')
#13 /opt/lampp/htdocs/footsphere/wp-load.php(37): require_once('/opt/lampp/htdo...')
#14 /opt/lampp/htdocs/footsphere/wp-blog-header.php(13): require_once('/opt/lampp/htdo...')
#15 /opt/lampp/htdocs/footsphere/index.php(17): require('/opt/lampp/htdo...')
#16 {main}RequestManager_addRequest
[25.02.2019 - 08:04:30][FATAL] -


Sorgu çalıştırılamadı.Exception:

Unknown column 'ProductsAndPrices22' in 'field list' query:
INSERT  INTO a_fs_Request
(`UserID`, `ProducerNo`, `RequestNo`, `ProductsAndPrices`, `Type`)
VALUES (?, ?, ?, ProductsAndPrices22, ?) in /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php:2028
Stack trace:
#0 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1617): MysqliDb->_prepareQuery()
#1 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(1555): MysqliDb->_buildQuery(NULL, Array)
#2 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/MysqliDb.php(836): MysqliDb->_buildInsert('a_fs_Request', Array, 'INSERT')
#3 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(134): MysqliDb->insertMysqliDb('a_fs_Request', Array)
#4 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/data/abstract/DatabaseTableDao.php(70): DatabaseTableDao->insert(Array)
#5 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(158): DatabaseTableDao->insertToObject()
#6 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/bussines/concrete/RequestManager.php(62): RequestManager->addRequest(Object(Request))
#7 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/models/RequestModel.php(62): RequestManager->createRequest(11, '1', '1', Array, '1')
#8 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/controllers/homeController.php(9): RequestModel->createRequest(Array)
#9 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/src/ui/core/autoloader.php(54): homeController->index()
#10 /opt/lampp/htdocs/footsphere/wp-content/plugins/asd/index.php(17): include('/opt/lampp/htdo...')
#11 /opt/lampp/htdocs/footsphere/wp-settings.php(322): include_once('/opt/lampp/htdo...')
#12 /opt/lampp/htdocs/footsphere/wp-config.php(79): require_once('/opt/lampp/htdo...')
#13 /opt/lampp/htdocs/footsphere/wp-load.php(37): require_once('/opt/lampp/htdo...')
#14 /opt/lampp/htdocs/footsphere/wp-blog-header.php(13): require_once('/opt/lampp/htdo...')
#15 /opt/lampp/htdocs/footsphere/index.php(17): require('/opt/lampp/htdo...')
#16 {main}RequestManager_addRequest
[25.02.2019 - 08:06:25][NOTICE] - Request Oluşturuldu.RequestManager_addRequest
[25.02.2019 - 08:27:08][NOTICE] - Request Oluşturuldu.RequestManager_addRequest
[25.02.2019 - 08:37:43][NOTICE] - Request Oluşturuldu.RequestManager_addRequest
[25.02.2019 - 08:42:16][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:42:22][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:42:25][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:42:26][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:42:29][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:42:43][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:10][ERROR] - Request verileri getiremedi.RequestManager_getRequestList
[25.02.2019 - 08:44:13][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:25][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:26][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:38][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:41][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:48][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:48][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:44:59][ERROR] - Request verileri getiremedi.RequestManager_getRequestList
[25.02.2019 - 08:45:02][ERROR] - Request verileri getiremedi.RequestManager_getRequestList
[25.02.2019 - 08:45:03][ERROR] - Request verileri getiremedi.RequestManager_getRequestList
[25.02.2019 - 08:45:03][ERROR] - Request verileri getiremedi.RequestManager_getRequestList
[25.02.2019 - 08:45:07][ERROR] - Request verileri getiremedi.RequestManager_getRequestList
[25.02.2019 - 08:45:12][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:45:18][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:45:22][NOTICE] - Request verileri getirildi.RequestManager_getRequestList
[25.02.2019 - 08:47:22][NOTICE] - Request Güncellendi..RequestManager_updateRequest
