<?php

namespace AROD;

// Basic structure and initialization for API call
abstract class APICall {

	protected $params = array();
	protected $status = 200;
	protected $operationPerformed = false;

	public function __construct($params) {
		$this->params = $params;
	}

	public final function doOperation() {
		if (!$this->operationPerformed) {
			$this->performOperation();
		}
		$this->operationPerformed = true;
	}

	public function errorString() {
		return null;
	}

	public function response() {
		return $this-responseData();
	}

	abstract protected function performOperation();
	abstract protected function responseData();
	abstract public function httpStatus();

}