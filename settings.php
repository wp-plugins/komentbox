<?php

    if (defined('ALLOW_INCLUDE') === false)
        die('no direct access');

?>

<div class="wrap">
   <a name="nlpcaptcha"></a>
   <h2><?php _e('KomentBox Options', 'komentbox'); ?></h2>
   <p><?php _e('NLPCaptcha is a free, accessible CAPTCHA service that helps to digitize books while blocking spam on your blog.', 'komentbox'); ?></p>
   
   <form method="post" action="options.php">
      <?php settings_fields('komentbox_options_group'); ?>

      <h3><?php _e('Authentication', 'komentbox'); ?></h3>
      <p><?php _e('These keys are required before you are able to do anything else.', 'komentbox'); ?> <?php _e('You can get the keys', 'komentbox'); ?> <a href="http://nlpcaptcha.in" title="<?php _e('Get your NLPCaptcha API Keys', 'nlpcaptcha'); ?>"><?php _e('here', 'nlpcaptcha'); ?></a>.</p>
      <p><?php _e('Be sure not to mix them up! The public and private keys are not interchangeable!'); ?></p>
      
      <table class="form-table">
         <tr valign="top">
            <th scope="row"><?php _e('Publisher Key', 'komentbox'); ?></th>
            <td>
               <input type="text" name="komentbox_options[publisherkey]" size="40" value="<?php echo $this->options['publisherkey']; ?>" />
            </td>
         </tr>
         <tr valign="top">
            <th scope="row"><?php _e('Validate Key', 'komentbox'); ?></th>
            <td>
               <input type="text" name="komentbox_options[validatekey]" size="40" value="<?php echo $this->options['validatekey']; ?>" />
            </td>
         </tr>
            <tr valign="top">
            <th scope="row"><?php _e('Private Key', 'komentbox'); ?></th>
            <td>
               <input type="text" name="komentbox_options[privatekey]" size="40" value="<?php echo $this->options['privatekey']; ?>" />
            </td>
         </tr>
      </table>
      
      <h3><?php _e('Comment Options', 'komentbox'); ?></h3>
      <table class="form-table">
         <tr valign="top">
            <th scope="row"><?php _e('Activation', 'komentbox'); ?></th>
            <td>
               <input type="checkbox" id ="komentbox_options[show_in_comments]" name="komentbox_options[show_in_comments]" value="1" <?php checked('1', $this->options['show_in_comments']); ?> />
               <label for="komentbox_options[show_in_comments]"><?php _e('Enable for comments form', 'komentbox'); ?></label>
            </td>
         </tr>
         
        
      </table>
      
      
      <p class="submit"><input type="submit" class="button-primary" title="<?php _e('Save Komentbox Options') ?>" value="<?php _e('Save Komentbox Changes') ?> &raquo;" /></p>
   </form>
   
   <?php do_settings_sections('komentbox_options_page'); ?>
</div>