<?php
  $settings = \Roots\ShareButtons\Admin\get_settings();
  global $post;
  if (empty($url)) $url = get_permalink();
  $thumb_id = get_post_thumbnail_id($post->ID);
  if (empty($title)) $title = get_the_title();
?>

<div class="entry-share btn-group btn-group-justified">
    <?php
      foreach($settings['button_order'] as $setting) {
        switch($setting) {
          case 'twitter':
            if (in_array('twitter', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')); ?>&amp;url=<?php echo urlencode($url); ?>" title="<?php _e('Share on Twitter', 'roots_share_buttons'); ?>" target="_blank">
                  <div>
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('Tweet', 'roots_share_buttons'); ?></span>
                </div>
                </a>
            <?php endif;
            break;
          case 'facebook':
            if (in_array('facebook', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" title="<?php _e('Share on Facebook', 'roots_share_buttons'); ?>" target="_blank">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('Share', 'roots_share_buttons'); ?></span>
                </a>
            <?php endif;
            break;
          case 'google_plus':
            if (in_array('google_plus', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="https://plus.google.com/share?url=<?php echo urlencode($url); ?>" title="<?php _e('Share on Google+', 'roots_share_buttons'); ?>" target="_blank">
                  <i class="fa fa-google-plus" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('Google+', 'roots_share_buttons'); ?></span>
                </a>
            <?php endif;
            break;
          case 'linkedin':
            if (in_array('linkedin', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($url); ?>&amp;summary=" title="<?php _e('Share on LinkedIn', 'roots_share_buttons'); ?>" target="_blank">
                  <i class="fa fa-linkedin" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('LinkedIn', 'roots_share_buttons'); ?></span>
                </a>
              </li>
            <?php endif;
            break;
          case 'pinterest':
            // Don't show 'Pin It' button if post doesn't have a thumbnail
            if (empty($thumb_id)) break;
            // Get thumbnail URL
            $thumb = wp_get_attachment_image_src($thumb_id, 'thumbnail_size');
            $thumb_src = (isset($thumb[0])) ? $thumb[0] : null;
            $thumb_alt = get_post_meta($thumb_id , '_wp_attachment_image_alt', true);
            // Make sure thumbnail URL isn't relative
            $thumb_src = phpUri::parse(network_site_url())->join($thumb_src);
            // Fallback to post title as a description if the post thumbnail doesn't have one
            $description = (!empty($thumb_alt)) ? $thumb_alt : $title;
            if (in_array('pinterest', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>&amp;media=<?php echo urlencode($thumb_src); ?>&amp;description=<?php echo urlencode($description); ?>" title="<?php _e('Share on Pinterest', 'roots_share_buttons'); ?>" target="_blank">
                  <i class="fa fa-pinterest" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('Pinterest', 'roots_share_buttons'); ?></span>
                </a>
            <?php endif;
            break;
        }
      }
    ?>
  </ul>
</div>