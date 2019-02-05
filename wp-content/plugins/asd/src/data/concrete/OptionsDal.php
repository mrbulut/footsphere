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
        "langueages" => "footsphere_lang",
        "subscriber" => array(
            "route" => "aam_route_role_subscriber",
            "redirect" => "aam_redirect_role_subscriber",
            "toolbar" => "aam_toolbar_role_subscriber",
            "menu" => "aam_menu_role_subscriber"
        ),
        // editor == Producer
        "editor" => array(
            "route" => "aam_metabox_role_editor",
            "redirect" => "aam_redirect_role_editor",
            "toolbar" => "aam_toolbar_role_editor",
            "menu" => "aam_menu_role_editor",
            "metabox" => "aam_metabox_role_editor",
            "cache" => "aam_cache_role_editor"
        ),
        // contributor == CallCenter
        "contributor" => array(
            "route" => "aam_metabox_role_contributor",
            "redirect" => "aam_redirect_role_contributor",
            "toolbar" => "aam_toolbar_role_contributor",
            "menu" => "aam_menu_role_contributor",
            "metabox" => "aam_metabox_role_contributor",
            "cache" => "aam_cache_role_contributor"
        ),

    );


    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Options()), "wp_options");
        self::defineCaps();
        self::defineSettings();

    }

    private function defineSettings()
    {
        self::addOption($this->OptionsNames['requestTimeLimit'], $this->requestTimeLimit);
        self::addOption($this->OptionsNames['modelLimit'], $this->modelLimit);
        self::addOption($this->OptionsNames['requestLimit'], $this->requestLimit);
        self::addOption($this->OptionsNames['commission'], $this->commission);

    }

    private function defineCaps()
    {
        // subscriber-  Abone Yetkileri
        $array = array(
            $this->OptionsNames['subscriber']['route'] => 'a:1:{s:7:"restful";a:1:{s:1:"/";a:1:{s:3:"GET";s:1:"1";}}}',
            $this->OptionsNames['subscriber']['redirect'] => 'a:2:{s:22:"frontend.redirect.type";s:7:"message";s:21:"backend.redirect.type";s:7:"message";}',
            $this->OptionsNames['subscriber']['toolbar'] => 'a:6:{s:15:"toolbar-wp-logo";s:1:"1";s:5:"about";s:1:"1";s:5:"wporg";s:1:"1";s:13:"documentation";s:1:"1";s:14:"support-forums";s:1:"1";s:8:"feedback";s:1:"1";}',
            $this->OptionsNames['subscriber']['menu'] => 'a:3:{s:13:"menu-edit.php";s:1:"1";s:8:"edit.php";s:1:"1";s:12:"post-new.php";s:1:"1";}'
        );
        self::addOptionPrual($array);
        // editor-  Operasyon Yetkileri

        $array = array(
            $this->OptionsNames['editor']['route'] => 'a:1:{s:7:"restful";a:1:{s:1:"/";a:1:{s:3:"GET";s:1:"1";}}}',
            $this->OptionsNames['editor']['redirect'] => 'a:2:{s:22:"frontend.redirect.type";s:7:"message";s:21:"backend.redirect.type";s:7:"message";}',
            $this->OptionsNames['editor']['toolbar'] => 'a:16:{s:15:"toolbar-wp-logo";s:1:"1";s:5:"about";s:1:"1";s:5:"wporg";s:1:"1";s:13:"documentation";s:1:"1";s:14:"support-forums";s:1:"1";s:8:"feedback";s:1:"1";s:16:"toolbar-comments";s:1:"1";s:19:"toolbar-new-content";s:1:"1";s:8:"new-post";s:1:"1";s:9:"new-media";s:1:"1";s:8:"new-page";s:1:"1";s:8:"new-user";s:1:"1";s:10:"view-store";s:1:"1";s:15:"toolbar-updates";s:1:"1";s:12:"edit-profile";s:1:"1";s:9:"user-info";s:1:"1";}',
            $this->OptionsNames['editor']['menu'] => 'a:60:{s:13:"menu-edit.php";s:1:"1";s:8:"edit.php";s:1:"1";s:12:"post-new.php";s:1:"1";s:31:"edit-tags.php?taxonomy=category";s:1:"1";s:15:"menu-upload.php";s:1:"1";s:10:"upload.php";s:1:"1";s:13:"media-new.php";s:1:"1";s:28:"menu-edit.php?post_type=page";s:1:"1";s:23:"edit.php?post_type=page";s:1:"1";s:27:"post-new.php?post_type=page";s:1:"1";s:22:"menu-edit-comments.php";s:1:"1";s:15:"menu-themes.php";s:1:"1";s:10:"themes.php";s:1:"1";s:11:"widgets.php";s:1:"1";s:13:"nav-menus.php";s:1:"1";s:13:"customize.php";s:1:"1";s:13:"custom-header";s:1:"1";s:16:"theme-editor.php";s:1:"1";s:16:"menu-plugins.php";s:1:"1";s:11:"plugins.php";s:1:"1";s:18:"plugin-install.php";s:1:"1";s:17:"plugin-editor.php";s:1:"1";s:14:"menu-tools.php";s:1:"1";s:9:"tools.php";s:1:"1";s:10:"import.php";s:1:"1";s:10:"export.php";s:1:"1";s:24:"menu-options-general.php";s:1:"1";s:19:"options-general.php";s:1:"1";s:19:"options-writing.php";s:1:"1";s:19:"options-reading.php";s:1:"1";s:22:"options-discussion.php";s:1:"1";s:17:"options-media.php";s:1:"1";s:21:"options-permalink.php";s:1:"1";s:10:"menu-index";s:1:"1";s:5:"index";s:1:"1";s:9:"dashboard";s:1:"1";s:8:"settings";s:1:"1";s:17:"request_adminpage";s:1:"1";s:7:"contact";s:1:"1";s:8:"producer";s:1:"1";s:8:"products";s:1:"1";s:11:"profile.php";s:1:"1";s:14:"menu-users.php";s:1:"1";s:39:"menu-edit.php?post_type=isp_s_post_type";s:1:"1";s:34:"edit.php?post_type=isp_s_post_type";s:1:"1";s:38:"post-new.php?post_type=isp_s_post_type";s:1:"1";s:38:"menu-edit.php?post_type=rswp-shortcode";s:1:"1";s:33:"edit.php?post_type=rswp-shortcode";s:1:"1";s:37:"post-new.php?post_type=rswp-shortcode";s:1:"1";s:36:"menu-edit.php?post_type=testimonials";s:1:"1";s:31:"edit.php?post_type=testimonials";s:1:"1";s:35:"post-new.php?post_type=testimonials";s:1:"1";s:67:"edit-tags.php?taxonomy=testimonials_category&post_type=testimonials";s:1:"1";s:16:"menu-woocommerce";s:1:"1";s:9:"rule_list";s:1:"1";s:31:"menu-edit.php?post_type=product";s:1:"1";s:54:"edit-tags.php?taxonomy=product_brand&post_type=product";s:1:"1";s:15:"menu-vc-general";s:1:"1";s:31:"edit.php?post_type=vc_grid_item";s:1:"1";s:10:"vc-welcome";s:1:"1";}',
            $this->OptionsNames['editor']['metabox'] => 'a:1:{s:4:"post";a:4:{i:3;b:0;i:8;b:0;i:5;b:0;i:1;b:0;}}',
            $this->OptionsNames['editor']['cache'] => 'a:1:{s:4:"post";a:12:{i:3;b:0;i:8;b:0;i:5;b:0;i:1;b:0;i:9;b:0;i:10;b:0;i:7;b:0;i:2;b:0;i:11;b:0;i:12;b:0;i:6;b:0;i:230;b:0;}}'
        );
        self::addOptionPrual($array);
        // contributor-  Üretici Yetkileri

        $array = array(
            $this->OptionsNames['contributor']['route'] => 'a:1:{s:7:"restful";a:1:{s:1:"/";a:1:{s:3:"GET";s:1:"1";}}}',
            $this->OptionsNames['contributor']['redirect'] => 'a:2:{s:22:"frontend.redirect.type";s:7:"message";s:21:"backend.redirect.type";s:7:"message";}',
            $this->OptionsNames['contributor']['toolbar'] => 'a:12:{s:15:"toolbar-wp-logo";s:1:"1";s:5:"about";s:1:"1";s:5:"wporg";s:1:"1";s:13:"documentation";s:1:"1";s:14:"support-forums";s:1:"1";s:8:"feedback";s:1:"1";s:16:"toolbar-comments";s:1:"1";s:19:"toolbar-new-content";s:1:"1";s:8:"new-post";s:1:"1";s:9:"new-media";s:1:"1";s:8:"new-page";s:1:"1";s:8:"new-user";s:1:"1";}',
            $this->OptionsNames['contributor']['menu'] => 'a:21:{s:31:"edit.php?post_type=vc_grid_item";s:1:"1";s:15:"menu-vc-general";s:1:"1";s:10:"vc-welcome";s:1:"1";s:14:"menu-tools.php";s:1:"1";s:9:"tools.php";s:1:"1";s:13:"menu-Producer";s:1:"1";s:8:"Producer";s:1:"1";s:16:"producer_request";s:1:"1";s:14:"producer_order";s:1:"1";s:17:"producer_products";s:1:"1";s:15:"producer_profil";s:1:"1";s:16:"producer_contact";s:1:"1";s:36:"menu-edit.php?post_type=testimonials";s:1:"1";s:31:"edit.php?post_type=testimonials";s:1:"1";s:35:"post-new.php?post_type=testimonials";s:1:"1";s:38:"menu-edit.php?post_type=rswp-shortcode";s:1:"1";s:33:"edit.php?post_type=rswp-shortcode";s:1:"1";s:37:"post-new.php?post_type=rswp-shortcode";s:1:"1";s:39:"menu-edit.php?post_type=isp_s_post_type";s:1:"1";s:34:"edit.php?post_type=isp_s_post_type";s:1:"1";s:38:"post-new.php?post_type=isp_s_post_type";s:1:"1";}',
            $this->OptionsNames['contributor']['cache'] => 'a:1:{s:4:"post";a:20:{i:3;b:0;i:19;b:0;i:20;b:0;i:21;b:0;i:22;b:0;i:23;b:0;i:24;b:0;i:25;b:0;i:26;b:0;i:27;b:0;i:2;b:0;i:28;b:0;i:29;b:0;i:30;b:0;i:31;b:0;i:32;b:0;i:33;b:0;i:34;b:0;i:35;b:0;i:36;b:0;}}'
        );
        self::addOptionPrual($array);

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

    private function updateOptionToID($option_name, $options_value, $option_id)
    {
        if ($option_id) {
            return $this->update(
                array(
                    $this->Rows[1] => $option_name,
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

    private function addOptionPrual($array)
    {
        foreach ($array as $key => $value) {
            self::addOption($key, $value);
        }
    }


}