<?php
function dashboard()
{
  require_once(__DIR__ . '/implement/dashboard.php');
  echo '
  

  <div id=rows >
  <div id="dashboard-widgets-wrap">
  <div id="dashboard-widgets" class="metabox-holder">
  
  <div id="postbox-container-1" class="postbox-container">'.getWoComenceStatus().'</div>
 <div id="postbox-container-2" class="postbox-container"> '.getStatistics().' </div>
  <div id="postbox-container-3" class="postbox-container">'.getOnelook().'</div>
	<div id="postbox-container-4" class="postbox-container">
	<div id="column4-sortables" class="meta-box-sortables ui-sortable" data-emptystring="Kutuları buraya sürükleyin"><div id="dashboard_activity" class="postbox closed" style="display: block;">
<button type="button" class="handlediv" aria-expanded="false"><span class="screen-reader-text">Paneli aç/kapa: Aktivite</span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span>Aktivite</span></h2>
<div class="inside">
<div id="activity-widget"><div id="published-posts" class="activity-block"><h3>Yeni yayımlanmış</h3><ul><li><span>16 Kas, 09:47</span> <a href="http://localhost/wp-admin/post.php?post=1&amp;action=edit" aria-label="“Merhaba dünya!” Düzenle">Merhaba dünya!</a></li></ul></div><div id="latest-comments" class="activity-block"><h3>Son Yorumlar</h3><ul id="the-comment-list" data-wp-lists="list:comment">
		<li id="comment-1" class="comment even thread-even depth-1 comment-item approved">

			<img alt="" src="http://1.gravatar.com/avatar/d7a973c7dab26985da5f961be7b74480?s=50&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/d7a973c7dab26985da5f961be7b74480?s=100&amp;d=mm&amp;r=g 2x" class="avatar avatar-50 photo" height="50" width="50">
			
			<div class="dashboard-comment-wrap has-row-actions">
			<p class="comment-meta">
			<a href="http://localhost/2018/11/16/merhaba-dunya/">Merhaba dünya!</a> <span class="approve">[Bekliyor]</span> için <cite class="comment-author"><a href="https://wordpress.org/" rel="external nofollow" class="url">Bir WordPress yorumcusu</a></cite> tarafından			</p>

						<blockquote><p>Merhaba, bu bir yorumdur. Yorum moderasyonuna başlamak, düzenlemek ve silmek için lütfen yönetim panelindeki yorumlar bölümünü ziyaret edin. Yorumcuların avatarları…</p></blockquote>
						<p class="row-actions"><span class="approve"><a href="comment.php?action=approvecomment&amp;p=1&amp;c=1&amp;_wpnonce=91c4fe25b9" data-wp-lists="dim:the-comment-list:comment-1:unapproved:e7e7d3:e7e7d3:new=approved" class="vim-a" aria-label="Bu yorumu onayla">Onayla</a></span><span class="unapprove"><a href="comment.php?action=unapprovecomment&amp;p=1&amp;c=1&amp;_wpnonce=91c4fe25b9" data-wp-lists="dim:the-comment-list:comment-1:unapproved:e7e7d3:e7e7d3:new=unapproved" class="vim-u" aria-label="Bu yorumun onayını geri al">Onayı kaldır</a></span><span class="reply hide-if-no-js"> | <a onclick="window.commentReply &amp;&amp; commentReply.open(1,1);return false;" class="vim-r hide-if-no-js" aria-label="Bu yorumu cevapla" href="#">Cevapla</a></span><span class="edit"> | <a href="comment.php?action=editcomment&amp;c=1" aria-label="Bu yorumu düzenle">Düzenle</a></span><span class="spam"> | <a href="comment.php?action=spamcomment&amp;p=1&amp;c=1&amp;_wpnonce=cf3419fac0" data-wp-lists="delete:the-comment-list:comment-1::spam=1" class="vim-s vim-destructive" aria-label="Bu yorumu istenmeyen olarak işaretle">İstenmeyen</a></span><span class="trash"> | <a href="comment.php?action=trashcomment&amp;p=1&amp;c=1&amp;_wpnonce=cf3419fac0" data-wp-lists="delete:the-comment-list:comment-1::trash=1" class="delete vim-d vim-destructive" aria-label="Bu yorumu çöpe taşı">Çöp</a></span><span class="view"> | <a class="comment-link" href="http://localhost/2018/11/16/merhaba-dunya/#comment-1" aria-label="Bu yorumu görüntüle">Görüntüle</a></span></p>
						</div>
		</li>
</ul><h3 class="screen-reader-text">Daha çok yorum görüntüle</h3><ul class="subsubsub">
	<li class="all"><a href="http://localhost/wp-admin/edit-comments.php?comment_status=all">Tümü <span class="count">(<span class="all-count">1</span>)</span></a> |</li>
	<li class="moderated"><a href="http://localhost/wp-admin/edit-comments.php?comment_status=moderated">Bekleyen <span class="count">(<span class="pending-count">0</span>)</span></a> |</li>
	<li class="approved"><a href="http://localhost/wp-admin/edit-comments.php?comment_status=approved">Onaylanmış <span class="count">(<span class="approved-count">1</span>)</span></a> |</li>
	<li class="spam"><a href="http://localhost/wp-admin/edit-comments.php?comment_status=spam">İstenmeyen <span class="count">(<span class="spam-count">0</span>)</span></a> |</li>
	<li class="trash"><a href="http://localhost/wp-admin/edit-comments.php?comment_status=trash">Çöp <span class="count">(<span class="trash-count">0</span>)</span></a></li>
</ul><form method="get">
<div id="com-reply" style="display:none;"><div id="replyrow" style="display:none;">
	<fieldset class="comment-reply">
	<legend>
		<span class="hidden" id="editlegend">Yorumu Düzenle</span>
		<span class="hidden" id="replyhead">Bu yorumu yanıtla</span>
		<span class="hidden" id="addhead">Yeni yorum ekle</span>
	</legend>

	<div id="replycontainer">
	<label for="replycontent" class="screen-reader-text">Yorum</label>
	<div id="wp-replycontent-wrap" class="wp-core-ui wp-editor-wrap html-active"><link rel="stylesheet" id="editor-buttons-css" href="http://localhost/wp-includes/css/editor.min.css?ver=4.9.8" type="text/css" media="all">
<div id="wp-replycontent-editor-container" class="wp-editor-container"><div id="qt_replycontent_toolbar" class="quicktags-toolbar"><input type="button" id="qt_replycontent_strong" class="ed_button button button-small" aria-label="Kalın" value="b"><input type="button" id="qt_replycontent_em" class="ed_button button button-small" aria-label="Eğik" value="i"><input type="button" id="qt_replycontent_link" class="ed_button button button-small" aria-label="Bağlantı ekle" value="link"><input type="button" id="qt_replycontent_block" class="ed_button button button-small" aria-label="Alıntı" value="b-quote"><input type="button" id="qt_replycontent_del" class="ed_button button button-small" aria-label="Silinmiş metin (üstü çizili)" value="del"><input type="button" id="qt_replycontent_ins" class="ed_button button button-small" aria-label="Eklenen metin" value="ins"><input type="button" id="qt_replycontent_img" class="ed_button button button-small" aria-label="Görsel ekle" value="img"><input type="button" id="qt_replycontent_ul" class="ed_button button button-small" aria-label="İmli liste" value="ul"><input type="button" id="qt_replycontent_ol" class="ed_button button button-small" aria-label="Numaralı liste" value="ol"><input type="button" id="qt_replycontent_li" class="ed_button button button-small" aria-label="Liste maddesi" value="li"><input type="button" id="qt_replycontent_code" class="ed_button button button-small" aria-label="Kod" value="code"><input type="button" id="qt_replycontent_close" class="ed_button button button-small" title="Tüm açık etiketleri kapat" value="etiketleri kapat"></div><textarea class="wp-editor-area" rows="20" cols="40" name="replycontent" id="replycontent"></textarea></div>
</div>

	</div>

	<div id="edithead" style="display:none;">
		<div class="inside">
		<label for="author-name">İsim</label>
		<input type="text" name="newcomment_author" size="50" value="" id="author-name">
		</div>

		<div class="inside">
		<label for="author-email">E-posta</label>
		<input type="text" name="newcomment_author_email" size="50" value="" id="author-email">
		</div>

		<div class="inside">
		<label for="author-url">URL</label>
		<input type="text" id="author-url" name="newcomment_author_url" class="code" size="103" value="">
		</div>
	</div>

	<div id="replysubmit" class="submit">
		<p>
			<a href="#comments-form" class="save button button-primary alignright">
				<span id="addbtn" style="display: none;">Yorum ekle</span>
				<span id="savebtn" style="display: none;">Yorumu güncelle</span>
				<span id="replybtn" style="display: none;">Yanıt gönder</span>
			</a>
			<a href="#comments-form" class="cancel button alignleft">Vazgeç</a>
			<span class="waiting spinner"></span>
		</p>
		<br class="clear">
		<div class="notice notice-error notice-alt inline hidden">
			<p class="error"></p>
		</div>
	</div>

	<input type="hidden" name="action" id="action" value="">
	<input type="hidden" name="comment_ID" id="comment_ID" value="">
	<input type="hidden" name="comment_post_ID" id="comment_post_ID" value="">
	<input type="hidden" name="status" id="status" value="">
	<input type="hidden" name="position" id="position" value="-1">
	<input type="hidden" name="checkbox" id="checkbox" value="0">
	<input type="hidden" name="mode" id="mode" value="dashboard">
	<input type="hidden" id="_ajax_nonce-replyto-comment" name="_ajax_nonce-replyto-comment" value="ee91c50baf"><input type="hidden" id="_wp_unfiltered_html_comment" name="_wp_unfiltered_html_comment" value="120b8c5f1d">	</fieldset>
</div></div>
</form>
<div class="hidden" id="trash-undo-holder">
	<div class="trash-undo-inside"><strong></strong> tarafından yapılan yorum çöp kutusuna taşındı. <span class="undo untrash"><a href="#">Geri al</a></span></div>
</div>
<div class="hidden" id="spam-undo-holder">
	<div class="spam-undo-inside"><strong></strong> tarafından yapılan yorum istenmeyen olarak işaretlendi. <span class="undo unspam"><a href="#">Geri al</a></span></div>
</div>
</div></div></div>
</div></div>	</div>
</div>

<input type="hidden" id="closedpostboxesnonce" name="closedpostboxesnonce" value="126a87e518"><input type="hidden" id="meta-box-order-nonce" name="meta-box-order-nonce" value="67db6bed46">	</div>


</div>

  ';
}
?>




