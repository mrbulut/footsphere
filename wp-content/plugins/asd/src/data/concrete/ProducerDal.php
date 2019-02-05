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
        if ($UserId == null)
            $this->user = new UserDal();
        $this->Rows = parent::CreateTable(Container::getInstance(new Producer()));
    }

    public function getProducerToId($id)
    {
        if ($id) {
            return $this->select(
                array(
                    'ID' => $id
                )
            );
        } else
            return false;
    }

    public function getProducerToUserId($UserId)
    {
        if ($UserId) {
            return $this->select(
                array(
                    $this->Rows[0] => $UserId
                )
            );
        } else
            return false;
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

    public function updateProducer(Producer $producer)
    {
        if ($producer) {
            $result = array();
            foreach ($producer as $key => $value) {
                if ($value) {
                    $result[$key] = $value;
                }
            }

            return $this->update(
                array(
                    $this->Rows[0] => $this->user->getUserId()
                ),
                $result
            );
        } else
            return false;
    }

    public function deleteProducer()
    {
        if ($this->user->deleteUser()) {
            return $this->delete(
                array(
                    self::$Rows[0] => $this->user->getUserId()
                )
            );
        } else {
            return false;
        }
    }


}