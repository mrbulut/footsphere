<?php

include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";


class Product implements IEntity{
    public $ID;
    public $PName;
    public $DescProduct;
    public $Price;
    public $Image;
    public $Image2;
    public $Image3;
    public $ProducerNO;
    public $BSNO;
    public $Features;
    public $Type;
    public $Status; //Approved,Waiting,NoApproved
    public $BaseMaterial;
    public $ClosureType;
    public $TopMeterial;
    public $liningMeterial;
    public $Season;
    public $InsideBaseType;
    public $InsideBaseMeterial;
    function ResetObject() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }
    /**
     * Product constructor.
     * @param $ID
     * @param $PName
     * @param $Desc
     * @param $Price
     * @param $Image
     * @param $Image2
     * @param $Image3
     * @param $ProducerNO
     * @param $BSNO
     * @param $Features
     * @param $Type
     * @param $Status
     * @param $BaseMaterial
     * @param $ClosureType
     * @param $TopMeterial
     * @param $liningMeterial
     * @param $Season
     * @param $InsideBaseType
     * @param $InsideBaseMeterial
     */
    public function __construct(){
    }



    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getPName()
    {
        return $this->PName;
    }

    /**
     * @param mixed $PName
     */
    public function setPName($PName)
    {
        $this->PName = $PName;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->Desc;
    }

    /**
     * @param mixed $Desc
     */
    public function setDesc($Desc)
    {
        $this->Desc = $Desc;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->Price;
    }

    /**
     * @param mixed $Price
     */
    public function setPrice($Price)
    {
        $this->Price = $Price;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * @param mixed $Image
     */
    public function setImage($Image)
    {
        $this->Image = $Image;
    }

    /**
     * @return mixed
     */
    public function getImage2()
    {
        return $this->Image2;
    }

    /**
     * @param mixed $Image2
     */
    public function setImage2($Image2)
    {
        $this->Image2 = $Image2;
    }

    /**
     * @return mixed
     */
    public function getImage3()
    {
        return $this->Image3;
    }

    /**
     * @param mixed $Image3
     */
    public function setImage3($Image3)
    {
        $this->Image3 = $Image3;
    }

    /**
     * @return mixed
     */
    public function getProducerNO()
    {
        return $this->ProducerNO;
    }

    /**
     * @param mixed $ProducerNO
     */
    public function setProducerNO($ProducerNO)
    {
        $this->ProducerNO = $ProducerNO;
    }

    /**
     * @return mixed
     */
    public function getBSNO()
    {
        return $this->BSNO;
    }

    /**
     * @param mixed $BSNO
     */
    public function setBSNO($BSNO)
    {
        $this->BSNO = $BSNO;
    }

    /**
     * @return mixed
     */
    public function getFeatures()
    {
        return $this->Features;
    }

    /**
     * @param mixed $Features
     */
    public function setFeatures($Features)
    {
        $this->Features = $Features;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type)
    {
        $this->Type = $Type;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param mixed $Status
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    /**
     * @return mixed
     */
    public function getBaseMaterial()
    {
        return $this->BaseMaterial;
    }

    /**
     * @param mixed $BaseMaterial
     */
    public function setBaseMaterial($BaseMaterial)
    {
        $this->BaseMaterial = $BaseMaterial;
    }

    /**
     * @return mixed
     */
    public function getClosureType()
    {
        return $this->ClosureType;
    }

    /**
     * @param mixed $ClosureType
     */
    public function setClosureType($ClosureType)
    {
        $this->ClosureType = $ClosureType;
    }

    /**
     * @return mixed
     */
    public function getTopMeterial()
    {
        return $this->TopMeterial;
    }

    /**
     * @param mixed $TopMeterial
     */
    public function setTopMeterial($TopMeterial)
    {
        $this->TopMeterial = $TopMeterial;
    }

    /**
     * @return mixed
     */
    public function getLiningMeterial()
    {
        return $this->liningMeterial;
    }

    /**
     * @param mixed $liningMeterial
     */
    public function setLiningMeterial($liningMeterial)
    {
        $this->liningMeterial = $liningMeterial;
    }

    /**
     * @return mixed
     */
    public function getSeason()
    {
        return $this->Season;
    }

    /**
     * @param mixed $Season
     */
    public function setSeason($Season)
    {
        $this->Season = $Season;
    }

    /**
     * @return mixed
     */
    public function getInsideBaseType()
    {
        return $this->InsideBaseType;
    }

    /**
     * @param mixed $InsideBaseType
     */
    public function setInsideBaseType($InsideBaseType)
    {
        $this->InsideBaseType = $InsideBaseType;
    }

    /**
     * @return mixed
     */
    public function getInsideBaseMeterial()
    {
        return $this->InsideBaseMeterial;
    }

    /**
     * @param mixed $InsideBaseMeterial
     */
    public function setInsideBaseMeterial($InsideBaseMeterial)
    {
        $this->InsideBaseMeterial = $InsideBaseMeterial;
    }
}