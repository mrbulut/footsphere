<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");

abstract class page extends component
{
    private $header;
    private $footer;
    private $rows;
    private $resultPage;
    private $baslik;
    private $jsCode;

    public function __construct()
    {
       

    }

    public function addjscode($js)
    {
        wp_enqueue_script($js);
    }

    public function addcsscode($css)
    {
        wp_enqueue_style($css);
    }

    /**
     * Get the value of rows
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Set the value of rows
     *
     * @return  self
     */
    public function setRows($rows)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Get the value of footer
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set the value of footer
     *
     * @return  self
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get the value of header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set the value of header
     *
     * @return  self
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get the value of resultPage
     */ 
    public function getResultPage()
    {
        return ' 
        <div class="wrap">
        <h1 class="wp-heading-inline">'.$this->baslik.'</h1>
        '.$this->jsCode.'
        <div id="dashboard-widgets">
        '.$this->header . $this->rows . $this->footer.'   </div>';
    }

    /**
     * Get the value of baslik
     */ 
    public function getBaslik()
    {
        return $this->baslik;
    }

    /**
     * Set the value of baslik
     *
     * @return  self
     */ 
    public function setBaslik($baslik)
    {
        $this->baslik = $baslik;

        return $this;
    }

    /**
     * Get the value of jsCode
     */ 
    public function getJsCode()
    {
        return $this->jsCode;
    }

    /**
     * Set the value of jsCode
     *
     * @return  self
     */ 
    public function setJsCode($jsCode)
    {
        $this->jsCode = $jsCode;

        return $this;
    }
}

?>