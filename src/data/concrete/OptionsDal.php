<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 12:49
 */

include_once ROOT_PATH . "/src/entities/concrete/OptionsConcrete.php";
include_once ROOT_PATH . "/src/entities/abstract/Container.php";
include_once ROOT_PATH . "/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH . "/src/data/abstract/IDatabaseTableDao.php";

class OptionsDal extends DatabaseTableDao implements IDatabaseTableDao

{
    private static $Rows;

    private $commission = "%100"; // komisyonumuz
    private $requestTimeLimit = 24; // isteğin 24 saat bekleme süresi
    private $modelLimit = 25;   // üreticinin toplamdaki model sayısı limiti
    private $requestLimit = 10; // isteğe 10 adet ürün teklif edebilir.
    private $OptionsNames = array(
        "request" => "footsphere_request",
        "commission" => "footsphere_settings_commissionArea",
        "requestTimeLimit" => "footsphere_settings_requestTimeArea",
        "modelLimit" => "footsphere_settings_producerModelLimit",
        "requestLimit" => "footsphere_settings_producerRequestLimit",
        "langueages" => "footsphere_lang"
    );


    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Options()), "wp_options");

    }

    public function defineSettings()
    {
        if (!self::selectOption($this->OptionsNames['commission'])) {
            self::addOption($this->OptionsNames['requestTimeLimit'], $this->requestTimeLimit);
            self::addOption($this->OptionsNames['modelLimit'], $this->modelLimit);
            self::addOption($this->OptionsNames['requestLimit'], $this->requestLimit);
            self::addOption($this->OptionsNames['commission'], $this->commission);
        }
    }


    public function getLangueages($userID)
    {
        return self::selectOption($this->OptionsNames['langueages'] . "_" . $userID)["option_value"];;
    }

    public function setLangueages($userID, $langueages)
    {
        return self::updateOptionToOptionName($this->OptionsNames['langueages'] . "_" . $userID, $langueages);
    }

    public function getRequest($UserId, $RequestType)
    {

        return self::selectOption($this->OptionsNames['request'] . "_" . $UserId . "_" . $RequestType)["option_value"];
    }

    public function setRequest($UserId, $RequestType, $date)
    {
        return self::updateOptionToOptionName($this->OptionsNames['request'] . "_" . $UserId . "_" . $RequestType, $date);
    }

    public function addRequest($UserId, $RequestType, $date)
    {
        if(!self::selectOption($this->OptionsNames['request'] . "_" . $UserId . "_" . $RequestType)){
            return self::addOption($this->OptionsNames['request'] . "_" . $UserId . "_" . $RequestType, $date);
        }

    }

    public function deleteRequest($UserId, $RequestType)
    {
        return self::deleteOptionToOptionName($this->OptionsNames['request'] . "_" . $UserId . "_" . $RequestType);
    }


    public function getProducerRequestLimit()
    {

        return self::selectOption($this->OptionsNames['requestLimit'])["option_value"];
    }

    public function setProducerRequestLimit($producerRequestLimit)
    {
        return self::updateOptionToOptionName($this->OptionsNames['requestLimit'], $producerRequestLimit);
    }


    public function getProducerModelLimit()
    {
        return self::selectOption($this->OptionsNames['modelLimit'])["option_value"];;
    }

    public function setProducerModelLimit($producerModelLimit)
    {
        return self::updateOptionToOptionName($this->OptionsNames['modelLimit'], $producerModelLimit);
    }

    public function getRequestTimeArea()
    {
        return self::selectOption($this->OptionsNames['requestTimeLimit'])["option_value"];;
    }

    public function setRequestTimeArea($requestTimeArea)
    {
        return self::updateOptionToOptionName($this->OptionsNames['requestTimeLimit'], $requestTimeArea);
    }

    public function getCommissionArea()
    {
        return self::selectOption($this->OptionsNames['commission'])["option_value"];
    }

    public function setCommissionArea($commissionArea)
    {
        return self::updateOptionToOptionName($this->OptionsNames['commission'], $commissionArea);
    }

    public function getAllRequest(){
         return $this->likeWhere("option_name", $this->OptionsNames['request']."%", 'like');

  //   echo "brda";$this->get();
    }

    private function selectOption($option_name)
    {
        if ($option_name) {
            return $this->select(
                array(
                    "option_name" => $option_name
                )
            );
        } else
            return false;
    }

    private function deleteOption($Id)
    {
        if ($Id) {
            return $this->delete(
                array(
                    self::$Rows[0] => $Id
                )
            );
        } else
            return false;

    }

    private function deleteOptionToOptionName($OptionName)
    {
        if ($OptionName) {
            return $this->delete(
                array(
                    self::$Rows[1] => $OptionName
                )
            );
        } else
            return false;

    }

    public function addOption($option_name, $options_value)
    {
        if ($option_name) {
            if (self::selectOption($option_name)) {
                return false;
            } else {
                return $this->insert(
                    array(
                        "option_name" => $option_name,
                        "option_value" => $options_value,
                        "autoload" => "yes"

                    )
                );
            }


        } else
            return false;
    }

    public function updateOptionToID($options_value, $option_id)
    {
        if ($option_id) {
            return $this->update(
                array(
                    "option_value" => $options_value,

                ),
                array(
                    "option_id" => $option_id
                )
            );


        } else
            return false;
    }


    public function updateOptionToOptionName($option_name, $option_value)
    {
        if (self::selectOption($option_name)) {
            return $this->update(

                array(
                    "option_name"  => $option_name,
                    "option_value" => $option_value,

                ),
                array(
                    "option_name"  => $option_name
                )
            );


        } else {
            return $this->insert(

                array(
                    "option_name" => $option_name,
                    "option_value"  => $option_value,

                )
            );
        }
    }

    public function addOptionPrual($array)
    {
        foreach ($array as $key => $value) {
            self::addOption($key, $value);
        }
    }


}