<?php
abstract class Abstract_model_tests extends CI_Model {
	
	function __construct() {
	}
	
	abstract public function test(&$unit_test);
	
	function print_results() {
		
	}
}