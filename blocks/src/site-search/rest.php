<?php

function bones_blocks_rest_endpoint() {
	register_rest_route( 'bones/v1', '/search', [
		'method' => 'GET',
		'callback' => 'bones_blocks_rest_route_small_search'
	] );
}

add_action( 'rest_api_init', 'bones_blocks_rest_endpoint' );

function bones_blocks_rest_route_small_search( WP_REST_Request $request ) {
	$s = $request->get_param( 'search' );

	$posts = new WP_Query([
		'post_type' => ['post', 'project', 'page'],
		'posts_per_page' => 3,
		's' => $s
	]);

	$posts_response = [];
	$post_count = 0;
	$total_results = 0;

	if ( $posts->have_posts() ) {
		$total_results = $posts->found_posts;
		$post_count = $posts->post_count;
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$post_type = get_post_type();
			if( $post_type === "page" ) {
				$ancestors = get_post_ancestors( get_the_ID() );
				// id: 13 is Products & Services
				// if ( get_post_parent( get_the_ID() ) === 13 || in_array( 13, $ancestors ) ) {
				// 	$post_type = "product";
				// }
			}

			array_push( $posts_response, [
				"id" => get_the_ID(),	
				"postType" => $post_type,
				"label" => html_entity_decode( get_the_title() ),
				"image" => get_the_post_thumbnail(get_the_ID(), 'thumbnail', ['loading' => false]),
				"url" => get_permalink()
			] );
		}	
	}
	// Restore original Post Data.
	wp_reset_postdata();

	return new WP_REST_Response( [
		"results" => $posts_response,
		"postCount" => $post_count,
		"totalResults" => $total_results
	], 200 );
}