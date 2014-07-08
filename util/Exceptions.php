<?php

namespace AROD;

abstract class APIException extends \Exception {}

class APICallNotFoundException extends APIException {}
class APIOperationNotPerformedException extends APIException {}
class APIValidationFailedException extends APIException {}
