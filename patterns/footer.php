<?php
/**
 * Title: footer
 * Slug: /footer
 * Inserter: no
 */
?>
<!-- wp:group {"metadata":{"patternName":"/footer","name":"footer"},"style":{"spacing":{"blockGap":"0"},"color":{"background":"#f0f0f0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="background-color:#f0f0f0"><!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:image {"width":"120px","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-placeholder.png" alt="" style="width:120px"/></figure>
<!-- /wp:image -->

<!-- wp:social-links {"iconBackgroundColor":"custom-charcoal","iconBackgroundColorValue":"#63666b"} -->
<ul class="wp-block-social-links has-icon-background-color"><!-- wp:social-link {"url":"#","service":"instagram"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)"><!-- wp:paragraph -->
<p>Copyright {YEAR}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center">Website Credit</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->