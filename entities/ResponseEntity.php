<?php

namespace AROD;

abstract class ResponseEntity {

	abstract protected function generateResponseObject();

	public function getResponseObject() {
		$obj = $this->generateResponseObject();
		return $obj;
	}

	// Clean up HTML and bad characters from the input string
	protected static function htmlToPlaintext($str) {
		return html_entity_decode(strip_tags(self::normalize($str)));
	}

	protected static function normalize($str) {
		// Normalize line endings
		// Convert all line-endings to UNIX format
		$str = str_replace("\r\n", "\n", $str);
		$str = str_replace("\r", "\n", $str);
		// Don't allow out-of-control blank lines
		$str = preg_replace("/\n{2,}/", "\n\n", $str);
		return $str;
	}

}