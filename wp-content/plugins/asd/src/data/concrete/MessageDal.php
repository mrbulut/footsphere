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
    /**
     * MessageDal constructor.
     * @param String $TableName
     * @param IEntity $IEntity
     */

    /**
     * Message constructor.
     * @param int $Id
     * @param $UserId
     * @param $WhoIsMessage
     * @param $Message
     * @param $Date
     * @param $Status  Okunmamis,Okunmus
     */
    private static $Rows;

    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Message()));
    }


    // Gonderilen id degerine sahip satırı geri döndürürr.
    public function getMessageToId($id)
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

    // UserId nin kayıtlı olduğu tüm mesajları döndürür
    // $HowManyMessage değişkeni kaç adet mesaj istediğini temsil eder.
    public function getAllMessagesToUserId($UserId, $HowManyMessage = null)
    {
        if ($UserId) {
            return $this->selectAll(
                array(
                    'UserId' => $UserId
                )
                , $HowManyMessage);
        } else
            return false;
    }

    // Sistemdeki toplam atılan mesaj sayısını döndürür.
    public function getTotalMessage($HowManyMessage = null)
    {
        return $this->selectAll(array(), $HowManyMessage);
    }

    // Okunmamış mesajları döndürür.
    public function getUnreadMessages($HowManyMessage = null)
    {
        return $this->selectAll(
            array(
                'Status' => 'Okunmamis'
            )
            , $HowManyMessage);
    }

    // Kullanıcının mesajını görüldü yap.UserId
    public function makeMessagesViewedToUserId($UserId)
    {
        if ($UserId) {
            return $this->update(
                array(
                    'Status' => 'Okunmus'
                ),
                array(
                    'UserId' => $UserId
                )
            );
        } else
            return false;
    }

    // Mesaj yazma
    public function writeMessage(Message $message)
    {
        if ($message) {
            return $this->insert(
                array(
                    'Message' => $message->Message,
                    'WhoIsMessage' => $message->WhoIsMessage,
                    'Date' => $message->Date,
                    'Status' => $message->Status,
                    'UserId' => $message->UserId,
                )
            );
        } else
            return false;
    }

    //
    public function isThereAnyUnreadMessage($UserId, $HowManyMessage = null){
        if ($UserId) {
            return $this->selectAll(
                array(
                    'Status' => 'Okunmamis',
                    'UserId' => $UserId
                ),
                $HowManyMessage
            );
        } else
            return false;
    }

    public function usersLastMessageDate($UserId){
        if ($UserId) {
            $list =  $this->selectAll(
                array(
                    'UserId' => $UserId
                )
            );
            return $list[count($list)-1]['Date'];
        } else
            return false;
    }



}