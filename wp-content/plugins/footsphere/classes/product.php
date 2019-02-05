<?php
require_once($_SERVER['DOCUMENT_ROOT']  . "/wp-content/plugins/footsphere/database/productDB.php");
require_once($_SERVER['DOCUMENT_ROOT']  . "/wp-content/plugins/footsphere/database/bsproductDB.php");
  

class product 
{

    private $bsproDB;
    private $proDB;

    private $urunAdi;
    private $urunAciklama;
    private $urunFiyati;
    private $urunResmi;
    private $producerNO;
    private $productNO;
    private $bsproductNO;
    private $urunOzellikleri;
    private $urunTuru;
    private $urunDurumu;
    private $urunTable;

    function __construct($bsproductNo = 0, $productNo=0,$tur='',$filtreler)
    {

        $this->bsproDB = new bsproductDB();
        $this->proDB = new productDB();
        $lang = new languages(0);


        if($bsproductNo!=0){
            $this->bsproductNO = $productNo;
            $this->productNO=0;
        }else{
            if($productNo!=0){
                $this->productNO=$productNo;
                $this->bsproductNO =$this->proDB->getBsProductNo($this->productNO);
                $this->urunFiyati= $lang->usdToLocal($this->proDB->getPrice($this->productNO));
            }
        }

        

        $this->urunTable = $this->bsproDB->getAllID($this->bsproductNO,$tur,$filtreler);
        $this->urunAdi =$this->urunTable['baslik'];
        $this->urunAciklama=$this->urunTable['aciklama'];
        $this->urunResmi=explode("+-+",$this->urunTable['image']);
        $this->urunTuru=$this->urunTable['turu'];
        $this->urunDurumu=$this->urunTable['baslik'];

        $i = 0;
       

     
       
        if($this->urunTable>0){
            foreach ($this->urunTable as $key => $value) {
                $i++;
                if($i>4 && $i<count($this->urunTable)-1){
                    $this->urunOzellikleri[$key] = $value;
                }
            }
        }
        
       
        
    }
    

    /**
     * Get the value of urunAdi
     */ 
    public function getUrunAdi()
    {
        return $this->urunAdi;
    }

    /**
     * Set the value of urunAdi
     *
     * @return  self
     */ 
    public function setUrunAdi($urunAdi)
    {
        $this->urunAdi = $urunAdi;

        return $this;
    }

    /**
     * Get the value of urunAciklama
     */ 
    public function getUrunAciklama()
    {
        return $this->urunAciklama;
    }

    /**
     * Set the value of urunAciklama
     *
     * @return  self
     */ 
    public function setUrunAciklama($urunAciklama)
    {
        $this->urunAciklama = $urunAciklama;

        return $this;
    }

    /**
     * Get the value of urunFiyati
     */ 
    public function getUrunFiyati()
    {
        return $this->urunFiyati;
    }

    /**
     * Set the value of urunFiyati
     *
     * @return  self
     */ 
    public function setUrunFiyati($urunFiyati)
    {
        $this->urunFiyati = $urunFiyati;

        return $this;
    }

    /**
     * Get the value of urunResmi
     */ 
    public function getUrunResmi()
    {
        return $this->urunResmi;
    }

    /**
     * Set the value of urunResmi
     *
     * @return  self
     */ 
    public function setUrunResmi($urunResmi)
    {
        $this->urunResmi = $urunResmi;

        return $this;
    }

    /**
     * Get the value of producerNO
     */ 
    public function getProducerNO()
    {
        return $this->producerNO;
    }

    /**
     * Set the value of producerNO
     *
     * @return  self
     */ 
    public function setProducerNO($producerNO)
    {
        $this->producerNO = $producerNO;

        return $this;
    }

    /**
     * Get the value of productNO
     */ 
    public function getProductNO()
    {
        return $this->productNO;
    }

    /**
     * Set the value of productNO
     *
     * @return  self
     */ 
    public function setProductNO($productNO)
    {
        $this->productNO = $productNO;

        return $this;
    }

    /**
     * Get the value of bsproductNO
     */ 
    public function getBsproductNO()
    {
        return $this->bsproductNO;
    }

    /**
     * Set the value of bsproductNO
     *
     * @return  self
     */ 
    public function setBsproductNO($bsproductNO)
    {
        $this->bsproductNO = $bsproductNO;

        return $this;
    }

    /**
     * Get the value of urunOzellikleri
     */ 
    public function getUrunOzellikleri()
    {
        return $this->urunOzellikleri;
    }

    /**
     * Set the value of urunOzellikleri
     *
     * @return  self
     */ 
    public function setUrunOzellikleri($urunOzellikleri)
    {
        $this->urunOzellikleri = $urunOzellikleri;

        return $this;
    }

    /**
     * Get the value of urunTuru
     */ 
    public function getUrunTuru()
    {
        return $this->urunTuru;
    }

    /**
     * Set the value of urunTuru
     *
     * @return  self
     */ 
    public function setUrunTuru($urunTuru)
    {
        $this->urunTuru = $urunTuru;

        return $this;
    }

    /**
     * Get the value of urunDurumu
     */ 
    public function getUrunDurumu()
    {
        return $this->urunDurumu;
    }

    /**
     * Set the value of urunDurumu
     *
     * @return  self
     */ 
    public function setUrunDurumu($urunDurumu)
    {
        $this->urunDurumu = $urunDurumu;

        return $this;
    }
}


?>