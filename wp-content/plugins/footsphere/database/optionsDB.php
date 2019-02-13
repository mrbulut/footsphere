<?php 
require_once("MysqliDb.php");
require_once ($_SERVER['DOCUMENT_ROOT']  . "/wp-content/plugins/footsphere/lib/config.php");

class optionsDB {
	private $database;
	private $tableName;
	private $rows,$bespokeRows;
	private $arrayValue = array(
        "footsphere_settings_komisyonArea",
        "footsphere_settings_requestTimeArea",
        "footsphere_settings_producerModelLimit",
        "footsphere_settings_producerRequestLimit"
	);
	private $komisyonArea;
    private $requestTimeArea;
    private $producerModelLimit;
    private $producerRequestLimit;

	function __construct(){

        $this->komisyonArea = $this->arrayValue[0];
        $this->requestTimeArea = $this->arrayValue[1];
        $this->producerModelLimit = $this->arrayValue[2];
		$this->producerRequestLimit = $this->arrayValue[3];
		
		$this->database = new MysqliDb();
		$this->tableName="wp_options";
		$this->rows=array("option_name","option_value","autoload");
		$this->bespokeRows=array("option_id","option_name","option_value","autoload");

		self::yetkileriTanimla(); // YETKİLER TANIMLANIYOR!!!.
	}
// GENERAL SETTİNGS ///
	public function getSettings()
    {
        return $this->database->get($this->tableName);
	}
	
	public function getSetting($option_name)
    {
        $this->database->where($this->bespokeRows[1], $option_name);
        return $this->database->get($this->tableName);
	}
	

    public function setSetting($option_name, $option_value)
    {

    
        $this->database->where($this->bespokeRows[1], $option_name);
    
        $id = $this->database->getOne($this->tableName)[$this->bespokeRows[0]];
        if ($id) {
			echo "iç.".$option_value;

         
            $result[$this->bespokeRows[1]] = $option_name;
            $result[$this->bespokeRows[2]] = $option_value;
            $this->database->where($this->bespokeRows[0], $id);
            $id = $this->database->update($this->tableName, $result);
            if ($id)
                return true;
            else
                return 'insert failed: ' . $this->database->getLastError();
        } else {
            $result[$this->bespokeRows[1]] = $option_name;
            $result[$this->bespokeRows[2]] = $option_value;
		// idyi geri döndürür.
            $id = $this->database->insert($this->tableName, $result);
            if ($id)
                return $id;
            else
                return 'insert failed: ' . $this->database->getLastError();
        }

    }

    public function setAllSettings($array)
    {

        for ($i = 0; $i < count($array); $i++) {

            self::setSetting($this->arrayValue[$i], $array[$i]);
        }
    }


    public function getProducerRequestLimit()
    {
        return self::getSetting($this->producerRequestLimit)[0][$this->bespokeRows[2]];
    }

    public function setProducerRequestLimit($producerRequestLimit)
    {
        return self::setSetting($this->producerRequestLimit, $producerRequestLimit);;
    }

    public function getProducerModelLimit()
    {
        return self::getSetting($this->producerModelLimit)[0][$this->bespokeRows[2]];
    }


    public function setProducerModelLimit($producerModelLimit)
    {
        return self::setSetting($this->producerModelLimit, $producerModelLimit);;

    }

    public function getRequestTimeArea()
    {
        return self::getSetting($this->requestTimeArea)[0][$this->bespokeRows[2]];

    }

    public function setRequestTimeArea($requestTimeArea)
    {
        return self::setSetting($this->requestTimeArea, $requestTimeArea);;

    }
    public function getKomisyonArea()
    {
        return self::getSetting($this->komisyonArea)[0][$this->bespokeRows[2]];

    }

    public function setKomisyonArea($komisyonArea)
    {
        return self::setSetting($this->komisyonArea, $komisyonArea);;

    }


	
// GENERAL SETTİNGS ///
// AAM AND PERMİSSİON SETTİNGS ///


	public function socialLoginKeys($dizi=array())

	{ 
		$deger ="[aam]";

		if($dizi[0]!=''){
			$deger = $deger . '; Facebook social login setup 
			feature.socialLogin.providers.Facebook.enabled = true 
			feature.socialLogin.providers.Facebook.keys.id = '.'"'.$dizi[0].'"'.'
			feature.socialLogin.providers.Facebook.keys.secret = '.'"'.$dizi[1].'"'.'

			';
		}
		if($dizi[2]!=''){
			$deger = $deger . '; Twitter social login setup 
			feature.socialLogin.providers.Twitter.enabled = true  
			feature.socialLogin.providers.Twitter.keys.id = '.'"'.$dizi[2].'"'.'
			feature.socialLogin.providers.Twitter.keys.secret = '.'"'.$dizi[3].'"'.'

			';
		}
		if($dizi[4]!=''){
			$deger = $deger . '; Instagram social login setup 
			feature.socialLogin.providers.Instagram.enabled = true 
			feature.socialLogin.providers.Instagram.keys.id = '.'"'.$dizi[4].'" '.'
			feature.socialLogin.providers.Instagram.keys.secret = '.'"'.$dizi[5].'" '.'

			';
		}

		self::setAll(array("aam-configpress",$deger,"yes"));


	}

	public function yetkileriTanimla()
	{
		# abone - standart kullanici 

		$routessubscriber = 'a:1:{s:7:"restful";a:1:{s:1:"/";a:1:{s:3:"GET";s:1:"1";}}}';
		$frondendsubscriber ='
		a:2:{s:22:"frontend.redirect.type";s:7:"message";s:21:"backend.redirect.type";s:7:"message";}' ;
		$toolbarsubscriber = '
		a:6:{s:15:"toolbar-wp-logo";s:1:"1";s:5:"about";s:1:"1";s:5:"wporg";s:1:"1";s:13:"documentation";s:1:"1";s:14:"support-forums";s:1:"1";s:8:"feedback";s:1:"1";}';
		$menusubscriber = 'a:3:{s:13:"menu-edit.php";s:1:"1";s:8:"edit.php";s:1:"1";s:12:"post-new.php";s:1:"1";}';
		self::setAll(array("aam_route_role_subscriber",$routessubscriber,"yes"));
		self::setAll(array("aam_redirect_role_subscriber",$frondendsubscriber,"yes"));
		self::setAll(array("aam_toolbar_role_subscriber",$toolbarsubscriber,"yes"));
		self::setAll(array("aam_menu_role_subscriber",$menusubscriber,"yes"));

		# editor - üretici .

		$routeseditor= 'a:1:{s:7:"restful";a:1:{s:1:"/";a:1:{s:3:"GET";s:1:"1";}}}';

		$frondendeditor ='a:2:{s:22:"frontend.redirect.type";s:7:"message";s:21:"backend.redirect.type";s:7:"message";}' ;

		$toolbareditor = '
		a:16:{s:15:"toolbar-wp-logo";s:1:"1";s:5:"about";s:1:"1";s:5:"wporg";s:1:"1";s:13:"documentation";s:1:"1";s:14:"support-forums";s:1:"1";s:8:"feedback";s:1:"1";s:16:"toolbar-comments";s:1:"1";s:19:"toolbar-new-content";s:1:"1";s:8:"new-post";s:1:"1";s:9:"new-media";s:1:"1";s:8:"new-page";s:1:"1";s:8:"new-user";s:1:"1";s:10:"view-store";s:1:"1";s:15:"toolbar-updates";s:1:"1";s:12:"edit-profile";s:1:"1";s:9:"user-info";s:1:"1";}';

		$menueditor = '
		a:60:{s:13:"menu-edit.php";s:1:"1";s:8:"edit.php";s:1:"1";s:12:"post-new.php";s:1:"1";s:31:"edit-tags.php?taxonomy=category";s:1:"1";s:15:"menu-upload.php";s:1:"1";s:10:"upload.php";s:1:"1";s:13:"media-new.php";s:1:"1";s:28:"menu-edit.php?post_type=page";s:1:"1";s:23:"edit.php?post_type=page";s:1:"1";s:27:"post-new.php?post_type=page";s:1:"1";s:22:"menu-edit-comments.php";s:1:"1";s:15:"menu-themes.php";s:1:"1";s:10:"themes.php";s:1:"1";s:11:"widgets.php";s:1:"1";s:13:"nav-menus.php";s:1:"1";s:13:"customize.php";s:1:"1";s:13:"custom-header";s:1:"1";s:16:"theme-editor.php";s:1:"1";s:16:"menu-plugins.php";s:1:"1";s:11:"plugins.php";s:1:"1";s:18:"plugin-install.php";s:1:"1";s:17:"plugin-editor.php";s:1:"1";s:14:"menu-tools.php";s:1:"1";s:9:"tools.php";s:1:"1";s:10:"import.php";s:1:"1";s:10:"export.php";s:1:"1";s:24:"menu-options-general.php";s:1:"1";s:19:"options-general.php";s:1:"1";s:19:"options-writing.php";s:1:"1";s:19:"options-reading.php";s:1:"1";s:22:"options-discussion.php";s:1:"1";s:17:"options-media.php";s:1:"1";s:21:"options-permalink.php";s:1:"1";s:10:"menu-index";s:1:"1";s:5:"index";s:1:"1";s:9:"dashboard";s:1:"1";s:8:"settings";s:1:"1";s:17:"request_adminpage";s:1:"1";s:7:"contact";s:1:"1";s:8:"producer";s:1:"1";s:8:"products";s:1:"1";s:11:"profile.php";s:1:"1";s:14:"menu-users.php";s:1:"1";s:39:"menu-edit.php?post_type=isp_s_post_type";s:1:"1";s:34:"edit.php?post_type=isp_s_post_type";s:1:"1";s:38:"post-new.php?post_type=isp_s_post_type";s:1:"1";s:38:"menu-edit.php?post_type=rswp-shortcode";s:1:"1";s:33:"edit.php?post_type=rswp-shortcode";s:1:"1";s:37:"post-new.php?post_type=rswp-shortcode";s:1:"1";s:36:"menu-edit.php?post_type=testimonials";s:1:"1";s:31:"edit.php?post_type=testimonials";s:1:"1";s:35:"post-new.php?post_type=testimonials";s:1:"1";s:67:"edit-tags.php?taxonomy=testimonials_category&post_type=testimonials";s:1:"1";s:16:"menu-woocommerce";s:1:"1";s:9:"rule_list";s:1:"1";s:31:"menu-edit.php?post_type=product";s:1:"1";s:54:"edit-tags.php?taxonomy=product_brand&post_type=product";s:1:"1";s:15:"menu-vc-general";s:1:"1";s:31:"edit.php?post_type=vc_grid_item";s:1:"1";s:10:"vc-welcome";s:1:"1";}';

		$cache= 'a:1:{s:4:"post";a:12:{i:3;b:0;i:8;b:0;i:5;b:0;i:1;b:0;i:9;b:0;i:10;b:0;i:7;b:0;i:2;b:0;i:11;b:0;i:12;b:0;i:6;b:0;i:230;b:0;}}';

		$metaboxeditor = 'a:1:{s:4:"post";a:4:{i:3;b:0;i:8;b:0;i:5;b:0;i:1;b:0;}}';
		
		self::setAll(array("aam_metabox_role_editor",$metaboxeditor,"yes"));

		self::setAll(array("aam_route_role_editor",$routeseditor,"yes"));

		self::setAll(array("aam_redirect_role_editor",$frondendeditor,"yes"));

		self::setAll(array("aam_toolbar_role_editor",$toolbareditor,"yes"));

		self::setAll(array("aam_menu_role_editor",$menueditor,"yes"));

		self::setAll(array("aam_cache_role_editor",$cache,"yes"));

		# contributor- operasyon yöneticisi.


		$routescontributor= '
		a:1:{s:7:"restful";a:1:{s:1:"/";a:1:{s:3:"GET";s:1:"1";}}}
				';

		$frondendcontributor ='
		a:2:{s:22:"frontend.redirect.type";s:7:"message";s:21:"backend.redirect.type";s:7:"message";}
				' ;

		$toolbarcontributor = '
		a:12:{s:15:"toolbar-wp-logo";s:1:"1";s:5:"about";s:1:"1";s:5:"wporg";s:1:"1";s:13:"documentation";s:1:"1";s:14:"support-forums";s:1:"1";s:8:"feedback";s:1:"1";s:16:"toolbar-comments";s:1:"1";s:19:"toolbar-new-content";s:1:"1";s:8:"new-post";s:1:"1";s:9:"new-media";s:1:"1";s:8:"new-page";s:1:"1";s:8:"new-user";s:1:"1";}
				';

		$menucontributor = 'a:21:{s:31:"edit.php?post_type=vc_grid_item";s:1:"1";s:15:"menu-vc-general";s:1:"1";s:10:"vc-welcome";s:1:"1";s:14:"menu-tools.php";s:1:"1";s:9:"tools.php";s:1:"1";s:13:"menu-Producer";s:1:"1";s:8:"Producer";s:1:"1";s:16:"producer_request";s:1:"1";s:14:"producer_order";s:1:"1";s:17:"producer_products";s:1:"1";s:15:"producer_profil";s:1:"1";s:16:"producer_contact";s:1:"1";s:36:"menu-edit.php?post_type=testimonials";s:1:"1";s:31:"edit.php?post_type=testimonials";s:1:"1";s:35:"post-new.php?post_type=testimonials";s:1:"1";s:38:"menu-edit.php?post_type=rswp-shortcode";s:1:"1";s:33:"edit.php?post_type=rswp-shortcode";s:1:"1";s:37:"post-new.php?post_type=rswp-shortcode";s:1:"1";s:39:"menu-edit.php?post_type=isp_s_post_type";s:1:"1";s:34:"edit.php?post_type=isp_s_post_type";s:1:"1";s:38:"post-new.php?post_type=isp_s_post_type";s:1:"1";}';

		$cache= '
		a:1:{s:4:"post";a:20:{i:3;b:0;i:19;b:0;i:20;b:0;i:21;b:0;i:22;b:0;i:23;b:0;i:24;b:0;i:25;b:0;i:26;b:0;i:27;b:0;i:2;b:0;i:28;b:0;i:29;b:0;i:30;b:0;i:31;b:0;i:32;b:0;i:33;b:0;i:34;b:0;i:35;b:0;i:36;b:0;}}
		';


		self::setAll(array("aam_route_role_contributor",$routescontributor,"yes"));

		self::setAll(array("aam_redirect_role_contributor",$frondendcontributor,"yes"));

		self::setAll(array("aam_toolbar_role_contributor",$toolbarcontributor,"yes"));

		self::setAll(array("aam_menu_role_contributor",$menucontributor,"yes"));

		self::setAll(array("aam_cache_role_contributor",$cache,"yes"));



	}


	private function setAll($arrayvalue='')
	{
	    $this->database->where($this->rows[0], $arrayvalue[0]);
		if ($this->database->getOne($this->tableName)){

			for ($i=0; $i <count($arrayvalue) ; $i++) { 
				$result[$this->rows[$i]] =$arrayvalue[$i]; 

			}

			$this->database->where($this->rows[0], $arrayvalue[0]);
			$id= $this->database->update($this->tableName,$result);

			if ($id)
				return true;
			else
				return 'insert failed: ' . $this->database->getLastError();


		}else{
			for ($i=0; $i <count($arrayvalue) ; $i++) { 


				$result[$this->rows[$i]] =$arrayvalue[$i]; 

			}
		// idyi geri döndürür.
			$id= $this->database->insert($this->tableName,$result);

			if ($id)
				return $id;
			else
				return 'insert failed: ' . $this->database->getLastError();
		}

	}}


// AAM AND PERMİSSİON SETTİNGS ///
class bitti{

}

?>