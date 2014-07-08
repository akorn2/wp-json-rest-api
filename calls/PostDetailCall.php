<?php

namespace AROD;

abstract class PostDetailCall extends GetCall {

	protected $postID;
	protected $post;

	public function __construct($params) {
		parent::__construct($params);

		// Ensure postID query string argument is valid
		if (empty($this->params['postID']) || !is_numeric($this->params['postID'])){
			throw new APIValidationFailedException('Required param postID is not present or invalid.');
		}

		// Convert postID query string argument into an integer
		$this->postID = intval($this->params['postID']);
	}

	// Abstract out queries for multiple post types
	abstract protected function checkPostType($post);
	abstract protected function postTypeString();

	protected function performOperation() {
		$post = get_post($this->postID);

		// Perform postID validation and error handeling
		if (!$post) {
			$this->status = 404;
		} elseif (!$this->checkPostType($post)) {
			$this->status = 412;
		} elseif ($post->post_status !== "publish") {
			$this->status = 403;
		} elseif ($post) {
			$this->post = new WordPressPost($post);
			$this->status = 200;
		}
	}

	protected function responseData() {
		if ($this->post != null)
			return $this->post->getResponseObject();
		return null;
	}

	public function errorString() {
		$type = $this->postTypeString();

		// Add a useful error message for the client!
		if ($this->httpStatus() == 200) {
			return null;
		} elseif ($this->httpStatus() == 412) {
			return "Post with given postID is not a $type.";
		} elseif ($this->httpStatus() == 404) {
			return "Post not found.";
		} elseif ($this->httpStatus() == 403) {
			return "Post with given postID is not published.";
		}
	}

}