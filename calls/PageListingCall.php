<?php

namespace AROD;

class PageListingCall extends GetCall {

	protected $posts = [];

	protected function performOperation() {

		// Standard WP Query for all pages
		$query = new \WP_Query([
			'post_type' => 'page',
			'posts_per_page' => -1
		]);

		$posts = $query->get_posts();

		// Get the post data for each page
		foreach ($posts as $post) {
			$this->posts[] = new WordPressPost($post);
		}

		$this->status = 200;
	}

	protected function responseData() {
		$response = [];

		// Put all page data into the response
		foreach ($this->posts as $post) {
			$response[] = $post->getResponseObject();
		}

		return $response;
	}

}