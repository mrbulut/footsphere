<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 12:56
 */
include_once ROOT_PATH . "/src/entities/concrete/MessageConcrete.php";
include_once ROOT_PATH."/src/entities/abstract/Container.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/abstract/IDatabaseTableDao.php";

class MessageDal extends DatabaseTableDao implements IDatabaseTableDao
{

    private static $Rows;

    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Message()));
    }


    public function getAllMessagesToUserId($UserId, $HowManyMessage = null)
    {
        if ($UserId) {
            return $this->selectAll(
                array(
                    $this->Rows[1] => $UserId
                )
                , $HowManyMessage);
        } else
            return false;
    }

    public function getTotalMessage($HowManyMessage = null)
    {
        return $this->selectAll(array(), $HowManyMessage);
    }

    // Okunmamış mesajları döndürür.
    public function getUnreadMessages($HowManyMessage = null)
    {
        return $this->selectAll(
            array(
                $this->Rows[5] => 'Okunmamis'
            )
            , $HowManyMessage);
    }



    //
    public function isThereAnyUnreadMessage($UserId, $HowManyMessage = null){
        if ($UserId) {
            return $this->selectAll(
                array(
                    $this->Rows[5] => 'Okunmamis',
                    $this->Rows[1] => $UserId
                ),
                $HowManyMessage
            );
        } else
            return false;
    }




}