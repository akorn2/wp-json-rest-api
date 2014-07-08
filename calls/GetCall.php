<?php

namespace AROD;

// Handle API responses and exceptions
abstract class GetCall extends APICall {

	public function httpStatus() {
		if (!$this->operationPerformed) {
			throw new APIOperationNotPerformedException();
		}

		return $this->status;
	}

	public function response() {
		if (!$this->operationPerformed) {
			throw new APIOperationNotPerformedException();
		}

		return $this->responseData();
	}
}