<?php
/*
Plugin Name: WP JSON REST API
Description: Implements a basic RESTful JSON API for viewing WP Posts via HTTP GET requests to the "/api/" endpoint. This plugin is written to be highly modular and allow for easy extension. Please feel free to use this code as a boiler plate for your own custom JSON APIs! Most of the error handling has already been written for you ;-)
Version: 1.0
Author: Alex Rodriguez
Author URI: http://twitter.com/arod2634
*/

function arod_api_url_handler($request) {

	// Get the parse_request argument and parse out for processing
	$path_comps = explode('/', $request->request);

	// If endpoint request if valid, load the classes required to process API requests and perform necessary operations
	if ($path_comps[0] === 'api' && !empty($path_comps[1]) && $_SERVER['REQUEST_METHOD'] === 'GET') {

		require_once('util/Exceptions.php');
		require_once('util/JSON.php');
		require_once('calls/APICall.php');
		require_once('calls/GetCall.php');
		require_once('calls/PostDetailCall.php');
		require_once('calls/BlogListingCall.php');
		require_once('calls/BlogDetailCall.php');
		require_once('calls/PageListingCall.php');
		require_once('calls/PageDetailCall.php');
		require_once('entities/ResponseEntity.php');
		require_once('entities/WordPressPost.php');

		// Rebuild the request call path
		$call_path = implode('/', array_slice($path_comps, 1));

		// Initialize the response object
		$response = ['status' => null, 'error' => null, 'data' => null];

		// Determine which call to process and start processing.
		// If an invalid call was made, perform error handling and return a response to the client!
		try {
			switch ($call_path) {
				case "blog/listing":
					$call = new \AROD\BlogListingCall($_GET);
					break;
				case "blog/detail":
					$call = new \AROD\BlogDetailCall($_GET);
					break;
				case "page/listing":
					$call = new \AROD\PageListingCall($_GET);
					break;
				case "page/detail":
					$call = new \AROD\PageDetailCall($_GET);
					break;
				default:
					throw new \AROD\APICallNotFoundException();
					break;
			}

			// Perform processing operations based on the call that was made from the client and set the response data
			$call->doOperation();
			$status = $call->httpStatus();
			$response['data'] = $call->response();
			$response['error'] = $call->errorString();

		} catch (\AROD\APICallNotFoundException $e) {
			$status = 400;
			$response['error'] = "API endpoint \"$call_path\" does not exist.";
		} catch (\AROD\APIValidationFailedException $e ) {
			$status = 400;
			$response['error'] = "Validation error: ".$e->getMessage();
		} catch(\Exception $e) {
			$status = 500;
			$response['error'] = "Uncaught Exception: ".$e->getMessage();
		}

		// Set the return HTTP status headers
		status_header($status);
		$response['status'] = $status;
		header("Content-type: application/json");
		header("Cache-Control: no-cache");

		// Display the return object
		echo json_encode($response);

		exit();

	}

}

add_action('parse_request', 'arod_api_url_handler');