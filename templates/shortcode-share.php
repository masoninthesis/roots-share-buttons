<?php
  $settings = \Roots\ShareButtons\Admin\get_settings();

  global $post;
  $shares = '';
  if (empty($url)) $url = get_permalink();

  $thumb_id = get_post_thumbnail_id($post->ID);

  if (empty($title)) $title = get_the_title();

  if (in_array('enabled', $settings['share_count'])) {
    $shares           = new \Roots\ShareButtons\ShareCount\shareCount($url);
    $shares_fb        = $shares->get_fb();
    $shares_gplus     = $shares->get_plusones();
    $shares_linkedin  = $shares->get_linkedin();
    $shares_pinterest = $shares->get_pinterest();
  }
?>

<div class="entry-share btn-group btn-group-justified">
    <?php
      foreach($settings['button_order'] as $setting) {
        switch($setting) {
          case 'twitter':
            if (in_array('twitter', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')); ?>&amp;url=<?php echo urlencode($url); ?>" title="<?php _e('Share on Twitter', 'roots_share_buttons'); ?>">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('Tweet', 'roots_share_buttons'); ?></span>
                </a>
            <?php endif;
            break;
          case 'facebook':
            if (in_array('facebook', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" title="<?php _e('Share on Facebook', 'roots_share_buttons'); ?>">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('Share', 'roots_share_buttons'); ?></span>
                  <?php if ($shares) : ?>
                    <span class="count"><?php echo $shares_fb; ?></span>
                  <?php endif; ?>
                </a>
            <?php endif;
            break;
          case 'google_plus':
            if (in_array('google_plus', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="https://plus.google.com/share?url=<?php echo urlencode($url); ?>" title="<?php _e('Share on Google+', 'roots_share_buttons'); ?>">
                  <i class="fa fa-google-plus" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('+1', 'roots_share_buttons'); ?></span>
                  <?php if ($shares) : ?>
                    <span class="count"><?php echo $shares_gplus; ?></span>
                  <?php endif; ?>
                </a>
              </li>
            <?php endif;
            break;
          case 'linkedin':
            if (in_array('linkedin', $settings['buttons'])) : ?>
                <a class="btn btn-default" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($url); ?>&amp;summary=" title="<?php _e('Share on LinkedIn', 'roots_share_buttons'); ?>">
                  <i class="fa fa-linkedin" aria-hidden="true"></i>
                  <span class="hidden-xs hidden-sm"><?php _e('Share', 'roots_share_buttons'); ?></span>
                  <?php if ($shares) : ?>
                    <span class="count"><?php echo $shares_linkedin; ?></span>
                  <?php endif; ?>
                </a>
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
              <li class="entry-share-btn entry-share-btn-pinterest">
                <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>&amp;media=<?php echo urlencode($thumb_src); ?>&amp;description=<?php echo urlencode($description); ?>" title="<?php _e('Share on Pinterest', 'roots_share_buttons'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64"><path d="M32 0C14.327 0 0 14.327 0 32c0 13.557 8.434 25.135 20.338 29.798-.28-2.532-.532-6.415.11-9.18.582-2.497 3.754-15.906 3.754-15.906s-.957-1.916-.957-4.75c0-4.45 2.58-7.77 5.79-7.77 2.73 0 4.05 2.05 4.05 4.507 0 2.744-1.75 6.85-2.65 10.653-.755 3.186 1.596 5.784 4.737 5.784 5.688 0 10.06-5.998 10.06-14.654 0-7.662-5.505-13.02-13.367-13.02-9.105 0-14.45 6.83-14.45 13.888 0 2.75 1.06 5.7 2.382 7.304.26.317.3.595.222.917-.244 1.012-.784 3.186-.89 3.63-.14.587-.464.71-1.07.43-3.997-1.862-6.495-7.705-6.495-12.398 0-10.094 7.334-19.365 21.143-19.365 11.1 0 19.727 7.91 19.727 18.482 0 11.028-6.953 19.903-16.605 19.903-3.243 0-6.29-1.685-7.334-3.675 0 0-1.605 6.11-1.993 7.607-.723 2.78-2.673 6.264-3.978 8.39C25.52 63.5 28.7 64 32 64c17.673 0 32-14.326 32-32S49.673 0 32 0z" fill="#fff"></path></svg>
                  <b><?php _e('Pin it', 'roots_share_buttons'); ?></b>
                  <?php if ($shares) : ?>
                    <span class="count"><?php echo $shares_pinterest; ?></span>
                  <?php endif; ?>
                </a>
              </li>
            <?php endif;
            break;
        }
      }
    ?>
</div>
