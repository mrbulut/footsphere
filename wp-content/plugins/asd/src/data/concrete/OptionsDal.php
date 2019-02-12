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
        self::defineSettings();

    }

    private function defineSettings()
    {
        self::addOption($this->OptionsNames['requestTimeLimit'], $this->requestTimeLimit);
        self::addOption($this->OptionsNames['modelLimit'], $this->modelLimit);
        self::addOption($this->OptionsNames['requestLimit'], $this->requestLimit);
        self::addOption($this->OptionsNames['commission'], $this->commission);

    }



    public function getLangueages($userID)
    {
        return self::selectOption($this->OptionsNames['langueages'] . "_" . $userID)[$this->Rows[2]];;
    }

    public function setLangueages($userID, $langueages)
    {
        return self::updateOptionToOptionName($this->OptionsNames['langueages'] . "_" . $userID, $langueages);
    }

    public function getRequest($userID)
    {
        return self::selectOption($this->OptionsNames['request'] . "_" . $userID)[$this->Rows[2]];;
    }

    public function setRequest($userID, $request)
    {
        return self::updateOptionToOptionName($this->OptionsNames['request'] . "_" . $userID, $request);
    }


    public function getProducerRequestLimit()
    {

        return self::selectOption($this->OptionsNames['requestLimit'])[$this->Rows[2]];
    }

    public function setProducerRequestLimit($producerRequestLimit)
    {
        return self::updateOptionToOptionName($this->OptionsNames['requestLimit'], $producerRequestLimit);
    }


    public function getProducerModelLimit()
    {
        return self::selectOption($this->OptionsNames['modelLimit'])[$this->Rows[2]];;
    }

    public function setProducerModelLimit($producerModelLimit)
    {
        return self::updateOptionToOptionName($this->OptionsNames['modelLimit'], $producerModelLimit);
    }

    public function getRequestTimeArea()
    {
        return self::updateOptionToOptionName($this->OptionsNames['requestTimeLimit'])[$this->Rows[2]];;
    }

    public function setRequestTimeArea($requestTimeArea)
    {
        return self::updateOptionToOptionName($this->OptionsNames['requestTimeLimit'], $requestTimeArea);
    }

    public function getCommissionArea()
    {
        return self::updateOptionToOptionName($this->OptionsNames['commission'])[$this->Rows[2]];;
    }

    public function setCommissionArea($commissionArea)
    {
        return self::updateOptionToOptionName($this->OptionsNames['commission'], $commissionArea);
    }


    private function selectOption($option_name)
    {
        if ($option_name) {
            return $this->select(
                array(
                    $this->Rows[1] => $option_name
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

    private function addOption($option_name, $options_value)
    {
        if ($option_name) {
            if (self::selectOption($option_name)) {
               return false;
            } else {
                return $this->insert(
                    array(
                        $this->Rows[1] => $option_name,
                        $this->Rows[2] => $options_value,
                        $this->Rows[3] => "yes"

                    )
                );
            }


        } else
            return false;
    }

    private function updateOptionToID($options_value, $option_id)
    {
        if ($option_id) {
            return $this->update(
                array(
                    $this->Rows[2] => $options_value,

                ),
                array(
                    $this->Rows[0] => $option_id
                )
            );


        } else
            return false;
    }


    private function updateOptionToOptionName($option_name, $option_value)
    {
        if ($option_name) {
            return $this->update(
                array(
                    $this->Rows[1] => $option_name,
                    $this->Rows[2] => $option_value,

                ),
                array(
                    $this->Rows[0] => $option_name
                )
            );


        } else
            return false;
    }

    public function addOptionPrual($array)
    {
        foreach ($array as $key => $value) {
            self::addOption($key, $value);
        }
    }


}