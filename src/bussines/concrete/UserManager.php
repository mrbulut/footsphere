<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 15.02.2019
 * Time: 09:21
 */

include_once ROOT_PATH . "/src/bussines/abstract/IUserService.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";
include_once ROOT_PATH . "/src/bussines/abstract/ICustomerService.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";
include_once ROOT_PATH . "/src/bussines/abstract/IManager.php";

class UserManager implements IUserService,IManager
{

    private $Logger;
    private $UserDal;
    private $UserId;
    private $User;
    private $UserWhere;
    private $UserObjectData;

    public function __construct()
    {
        $this->UserDal = new UserDal();
        $this->Logger = new Logger(new FileLogger());
        $this->User = new User();
        $this->UserWhere = new User();
      //  $this->User->setUserId($this->UserDal->getUserId());
      //  $this->UserObjectData = self::getCustomerList($this->Customer);

    }

    function getUser($UserId)
    {
        $this->UserDal->getUserWP($UserId);
        return $this->UserDal->getUser();
    }

    function createUser(User $user, $capability)
    {
        return $this->UserDal->createUser($user,$capability);
    }

    function deleteUser($UserId)
    {
        return $this->UserDal->deleteUser($UserId);
    }

    function updateUser(User $user,$UserId)
    {
        $this->UserWhere->ResetObject();
        $this->UserWhere->setID($UserId);
        return $this->UserDal->updateUserWP($user, $this->UserWhere);

    }
}