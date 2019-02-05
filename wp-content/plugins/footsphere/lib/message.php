<?php

/**
 *
 */
class shortMessage
{

  public function success($msg) {
    _e( '<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated">
<p><strong>'.$msg.'</strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', 'te-editor');
}
  /* Error Message */
  public function error($msg) {
    _e( '<div class="error settings-error notice is-dismissible" id="setting-error-settings_updated">
<p><strong>'.$msg.'</strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', 'te-editor');
}
}

 ?>
