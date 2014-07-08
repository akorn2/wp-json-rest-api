<?php

namespace AROD;

class BlogDetailCall extends PostDetailCall {

  // Specify the specefic post type to use for this call
	protected function checkPostType($post) {
		return $post->post_type === 'post';
	}

  // Plain text used in error message to describe the post type
	protected function postTypeString() {
		return 'blog post';
	}

}