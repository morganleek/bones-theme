<?php
	return array(
		'title'      => __( 'Grid of Morgan', 'twentytwentytwo' ),
		'categories' => array( 'query' ),
		'blockTypes' => array( 'core/query' ),
		'content'    => '<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","categoryIds":[],"tagIds":[],"order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
						<div class="wp-block-query"><!-- wp:post-template -->
						<!-- wp:group -->
						<div class="wp-block-group"><!-- wp:post-featured-image /-->

						<!-- wp:post-title {"isLink":true} /--></div>
						<!-- /wp:group -->

						<!-- wp:paragraph -->
						<p>MORGAN MORGAN MORGAN</p>
						<!-- /wp:paragraph -->
						<!-- /wp:post-template -->

						<!-- wp:query-pagination -->
						<!-- wp:query-pagination-previous /-->

						<!-- wp:query-pagination-numbers /-->

						<!-- wp:query-pagination-next /-->
						<!-- /wp:query-pagination --></div>
						<!-- /wp:query -->',
	);