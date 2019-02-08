<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 11:10
 */
include_once ROOT_PATH . "/src/entities/concrete/ProducerConcrete.php";
include_once ROOT_PATH."/src/entities/abstract/Container.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/concrete/UserDal.php";

/**
 * Producer constructor.
 * @param $CompanyName
 * @param $PhoneNumber
 * @param $PhoneNumber2
 * @param $Address
 * @param $PaymentInformantion
 * @param $CargoInformantion
 * @param $OfferLimit --  x-y
 */
class ProducerDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private static $Rows;
    private $user;

    public function __construct($UserId = null)
    {

        $this->Rows = parent::CreateTable(Container::getInstance(new Producer()));
        if ($UserId == null)
            $this->user = new UserDal();
    }


    public function addProducer(User $user, $OfferLimit)
    {
        if ($user) {
            $ID = $this->user->createUser($user);
            if ($ID) {
                return $this->insert(
                    array(
                        $this->Rows[0] = $ID,
                        $this->Rows[7] = $OfferLimit
                    )
                );
            } else {
                return false;
            }

        } else
            return false;
    }



}