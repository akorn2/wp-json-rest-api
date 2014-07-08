<?php

namespace AROD;

class BlogListingCall extends GetCall {

	protected $posts = [];

	protected function performOperation() {

		// Standard WP Query for all posts
		$query = new \WP_Query([
			'post_type' => 'post',
			'posts_per_page' => -1
		]);

		$posts = $query->get_posts();

		// Get the post data for each post
		foreach ($posts as $post) {
			$this->posts[] = new WordPressPost($post);
		}

		$this->status = 200;
	}

	protected function responseData() {
		$response = [];

		// Put all post data into the response
		foreach ($this->posts as $post) {
			$response[] = $post->getResponseObject();
		}

		return $response;
	}

}