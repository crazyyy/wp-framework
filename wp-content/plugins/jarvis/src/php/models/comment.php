<?php

namespace Jarvis\Models;

class Comment extends Model {

	public function __construct( $comment ) {
		$comment = ( is_numeric( $comment ) ) ? get_comment( $comment_id ) : $comment;

		$this->id    = $comment->ID;
		$this->type  = 'Comment';
		// $this->title = $post->post_title;
		// $this->slug  = $post->post;
		$this->kind  = 'comment';
		$this->href  = admin_url( sprintf( 'post.php?post=%d&action=edit', $post->ID ) );
		// $this->source = 'recent';
		// $this->attributes  = array_unique( array_merge( $this->attributes, [ $post->post_type, 'Recent' ;
	}
}