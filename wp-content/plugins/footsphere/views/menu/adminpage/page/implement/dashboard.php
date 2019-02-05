<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");

/*
    $totalMessage = $contactDB->getTotalMessageLenght();
    $uyeSayisi = $bespokeDB->getTotalUser();
    $bespokeUye = $bespokeDB->getTotalBespokeUser();
    $bespokeUrun = $bespokeDB->getTotalBespokeProduct();
    $okunmamisMessage = $contactDB->getOkunmamisMessage();
    $urunBekleyen = $bespokeDB->getUrunBekleyen();
    $guncellemeBekleyen = $bespokeDB->getTotalGuncelleme();
*/


function getWoComenceStatus()
{
    return '
    
    <div id="woocommerce_dashboard_status" class="postbox">
<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Paneli aç/kapa: WooCommerce durumu</span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span>WooCommerce durumu</span></h2>
<div class="inside">
<ul class="wc_status_list">				<li class="sales-this-month">
				<a href="http://localhost/wp-admin/admin.php?page=wc-reports&amp;tab=orders&amp;range=month">
					<span class="wc_sparkline lines tips" data-color="#777" data-tip="Son 28 gün içinde ₺&nbsp;0,00 değerinde satış yapıldı" data-barwidth="57600000" data-sparkline="[[&quot;1541030400000&quot;,0],[&quot;1541116800000&quot;,0],[&quot;1541203200000&quot;,0],[&quot;1541289600000&quot;,0],[&quot;1541376000000&quot;,0],[&quot;1541462400000&quot;,0],[&quot;1541548800000&quot;,0],[&quot;1541635200000&quot;,0],[&quot;1541721600000&quot;,0],[&quot;1541808000000&quot;,0],[&quot;1541894400000&quot;,0],[&quot;1541980800000&quot;,0],[&quot;1542067200000&quot;,0],[&quot;1542153600000&quot;,0],[&quot;1542240000000&quot;,0],[&quot;1542326400000&quot;,0],[&quot;1542412800000&quot;,0],[&quot;1542499200000&quot;,0],[&quot;1542585600000&quot;,0],[&quot;1542672000000&quot;,0],[&quot;1542758400000&quot;,0],[&quot;1542844800000&quot;,0],[&quot;1542931200000&quot;,0],[&quot;1543017600000&quot;,0],[&quot;1543104000000&quot;,0],[&quot;1543190400000&quot;,0],[&quot;1543276800000&quot;,0],[&quot;1543363200000&quot;,0]]" style="padding: 0px;"><canvas class="flot-base" width="38" height="19" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 48px; height: 24px;"></canvas><canvas class="flot-overlay" width="38" height="19" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 48px; height: 24px;"></canvas></span>					Bu ayki net satışlar: <strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">₺</span>&nbsp;0,00</span></strong>					</a>
				</li>
							<li class="processing-orders">
			<a href="http://localhost/wp-admin/edit.php?post_status=wc-processing&amp;post_type=shop_order">
				<strong>0 sipariş</strong> işleme alınmayı bekliyor				</a>
			</li>
			<li class="on-hold-orders">
				<a href="http://localhost/wp-admin/edit.php?post_status=wc-on-hold&amp;post_type=shop_order">
				<strong>0 sipariş</strong> beklemede				</a>
			</li>
						<li class="low-in-stock">
			<a href="http://localhost/wp-admin/admin.php?page=wc-reports&amp;tab=stock&amp;report=low_in_stock">
				<strong>0 ürün</strong> düşük stoklu				</a>
			</li>
			<li class="out-of-stock">
				<a href="http://localhost/wp-admin/admin.php?page=wc-reports&amp;tab=stock&amp;report=out_of_stock">
				<strong>0 ürün</strong> stokta yok				</a>
			</li>
			</ul></div>
</div>
    
    
    ';
}


function getStatistics()
{

    $contactDB = new contactDB();
    $productDB = new productDB();
    $bespokeDB = new bespokeDB();

    $totalMessage = $contactDB->getTotalMessage();

    $uyeSayisi = count($bespokeDB->getTotalUser()[0]['id']);
    $bespokeUye = count($bespokeDB->getTotalBespokeUser()[0]['id']);
    $bespokeUrun = $bespokeDB->getTotalBespokeProduct();

    return '
    <div id="woocommerce_dashboard_status" class="postbox">
    <button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Paneli aç/kapa: Bespoke Genel istatistikler</span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span>Genel İstatiskler</span></h2>
    <div class="inside">
    <ul class="wc_status_list">		
    <li class="on-hold-orders">Toplam<strong> ' . $totalMessage . ' mesaj</strong> var.</li>
    <li class="on-hold-orders">Toplam<strong> ' . $uyeSayisi . ' normal </strong> üye var.</li>
    <li class="on-hold-orders">Toplam<strong> ' . $bespokeUye . ' bespoke </strong> üye var.</li>
    <li class="on-hold-orders">Toplam<strong> ' . $bespokeUrun . ' ürün var</strong> var.</li>
    <li class="on-hold-orders"><strong></strong> -</li>


    
    
    </ul></div>
    </div>
        
        
    ';
}

function getOnelook()
{
    $contactDB = new contactDB();
    $productDB = new productDB();
    $bespokeDB = new bespokeDB();

    $okunmamisMessage = $contactDB->getOkunmamisMessage();
    $urunBekleyen = count($bespokeDB->getUrunBekleyen());
    $guncellemeBekleyen = count($bespokeDB->getTotalGuncelleme());


    return '
    <div id="column3-sortables" class="meta-box-sortables ui-sortable" data-emptystring="Kutuları buraya sürükleyin">
    
    <div id="dashboard_right_now" class="postbox " style="display: block;">
<button type="button" class="handlediv" aria-expanded="true">
<span class="screen-reader-text">Paneli aç/kapa: Bir bakışta</span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span>Bir bakışta</span></h2>
<div class="inside">
	<div class="main">

    <ul><li class="comment-count red"><a href="admin.php?page=contact">'.$okunmamisMessage.' okunmamış mesaj bulunmakta.</a></li></ul>

    <ul><li class="comment"><a href="admin.php?page=order">'.$urunBekleyen.' Ürün eklenmesini bekleyen kullanıcı var.</a></li></ul>

    <ul><li class="comment"><a href="admin.php?page=order">'.$guncellemeBekleyen.' Ürün güncellemesini bekleyen kullanıcı var.</a></li></ul>

    </div>

    </div>

</div>	
    ';
}
?>