<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package RedRaven
 */

if ( ! function_exists( 'redraven_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function redraven_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Published on %s', 'post date', 'redraven' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Written by %s', 'post author', 'redraven' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
		if (  ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo ' <span class="comments-link"><span class="extra">Discussion</span>';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'redraven' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'redraven' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			' <span class="edit-link"><span class="extre">Admin </span>',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'redraven_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function redraven_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {



			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'redraven' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'redraven' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

	}
endif;

function redraven_categories_list(){
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( '  ', 'redraven' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'redraven' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
		return $categories_list;
}

/**
 * Post navigation (previous / next post) for single posts.
 */
function redraven_post_navigation() {
	the_post_navigation( array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post >>', 'redraven' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Next post:', 'redraven' ) . '</span> ',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '<< Previous Post', 'redraven' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Previous post:', 'redraven' ) . '</span> ',
	) );
}

function redraven_excerpt_more($more){
	return "...";
}
add_filter('excerpt_more','redraven_excerpt_more');
