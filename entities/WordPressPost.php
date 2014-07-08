<?php

namespace AROD;

class WordPressPost extends ResponseEntity {

	protected $wp_post;

	public function __construct($wp_post) {
		$this->wp_post = $wp_post;
	}

	protected function generateResponseObject() {

		// Extract WP Post data and package into the response object!
		$response = new \stdClass();

		// Get the post ID  and title
		$response->id = $this->wp_post->ID;
		$response->title = $this->wp_post->post_title;

		// Get a cleaned up version of the content data (strip all HTML and bad characters from the posts content)
		$response->content = self::htmlToPlaintext($this->wp_post->post_content);
		$response->excerpt = self::htmlToPlaintext($this->wp_post->post_excerpt);

		// Get the time and date of the posts creation
		$timestamp = strtotime($this->wp_post->post_date);
		$response->date = date('Y-m-d', $timestamp);
		$response->time = date('H:i:s', $timestamp);

		// Get the URL for the posts featured image
		$response->featured_image = get_the_post_thumbnail($this->wp_post->ID);

		return $response;

	}

}