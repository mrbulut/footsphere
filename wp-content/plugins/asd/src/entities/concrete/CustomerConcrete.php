<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 12:17
 */
include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";

class Customer extends User implements IEntity
{
    // WP USER //
    public $ID;
    public $UserId;



    public $Length;
    public $Weight;
    public $Age;
    public $FootSize;
    public $FootsphereFilePath;
    public $ExtraFilePath;  // File1,File2,...
    public $CanUseProducts;
    public $BespokeStatus; // NoCompolete, Compolete, Waiting, Fix
    public $ExtraInfo;
    public $FootImage;
    public $FootImage2;
    public $FootImage3;
    public $Language;

    function ResetObject() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }
    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * @param mixed $UserId
     */
    public function setUserId($UserId)
    {
        $this->UserId = $UserId;
    }


    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->Language;
    }

    /**
     * @param mixed $Language
     */
    public function setLanguage($Language)
    {
        $this->Language = $Language;
    }
    /**
     * Customer constructor.
     * @param $Length
     * @param $Weight
     * @param $Age
     * @param $FootSize
     * @param $FootsphereFilePath
     * @param $ExtraFilePath
     * @param $CanUseProducts
     * @param $BespokeStatus
     * @param $ExtraInfo
     * @param $FootImage
     * @param $FootImage2
     * @param $FootImage3
     */


    public function __construct(){

    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->Length;
    }

    /**
     * @param mixed $Length
     */
    public function setLength($Length)
    {
        $this->Length = $Length;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->Weight;
    }

    /**
     * @param mixed $Weight
     */
    public function setWeight($Weight)
    {
        $this->Weight = $Weight;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->Age;
    }

    /**
     * @param mixed $Age
     */
    public function setAge($Age)
    {
        $this->Age = $Age;
    }

    /**
     * @return mixed
     */
    public function getFootSize()
    {
        return $this->FootSize;
    }

    /**
     * @param mixed $FootSize
     */
    public function setFootSize($FootSize)
    {
        $this->FootSize = $FootSize;
    }

    /**
     * @return mixed
     */
    public function getFootsphereFilePath()
    {
        return $this->FootsphereFilePath;
    }

    /**
     * @param mixed $FootsphereFilePath
     */
    public function setFootsphereFilePath($FootsphereFilePath)
    {
        $this->FootsphereFilePath = $FootsphereFilePath;
    }

    /**
     * @return mixed
     */
    public function getExtraFilePath()
    {
        return $this->ExtraFilePath;
    }

    /**
     * @param mixed $ExtraFilePath
     */
    public function setExtraFilePath($ExtraFilePath)
    {
        $this->ExtraFilePath = $ExtraFilePath;
    }

    /**
     * @return mixed
     */
    public function getCanUseProducts()
    {
        return $this->CanUseProducts;
    }

    /**
     * @param mixed $CanUseProducts
     */
    public function setCanUseProducts($CanUseProducts)
    {
        $this->CanUseProducts = $CanUseProducts;
    }

    /**
     * @return mixed
     */
    public function getBespokeStatus()
    {
        return $this->BespokeStatus;
    }

    /**
     * @param mixed $BespokeStatus
     */
    public function setBespokeStatus($BespokeStatus)
    {
        $this->BespokeStatus = $BespokeStatus;
    }

    /**
     * @return mixed
     */
    public function getExtraInfo()
    {
        return $this->ExtraInfo;
    }

    /**
     * @param mixed $ExtraInfo
     */
    public function setExtraInfo($ExtraInfo)
    {
        $this->ExtraInfo = $ExtraInfo;
    }

    /**
     * @return mixed
     */
    public function getFootImage()
    {
        return $this->FootImage;
    }

    /**
     * @param mixed $FootImage
     */
    public function setFootImage($FootImage)
    {
        $this->FootImage = $FootImage;
    }

    /**
     * @return mixed
     */
    public function getFootImage2()
    {
        return $this->FootImage2;
    }

    /**
     * @param mixed $FootImage2
     */
    public function setFootImage2($FootImage2)
    {
        $this->FootImage2 = $FootImage2;
    }

    /**
     * @return mixed
     */
    public function getFootImage3()
    {
        return $this->FootImage3;
    }

    /**
     * @param mixed $FootImage3
     */
    public function setFootImage3($FootImage3)
    {
        $this->FootImage3 = $FootImage3;
    }

}