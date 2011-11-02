<?php
require 'abstract_model_tests.php';

class Hotel_model_tests extends Abstract_model_tests {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('hotel_model', '', TRUE);
	}
	
	public function test(&$unit_test)
	{
		$this->test_add_del($unit_test);
	}
	
	
	public function test_add_del(&$unit_test)
	{
		// Добавление отеля в БД
		$hotel->city = 4; // id города
		$hotel->name = 'Мини-гостиница "Кристина"';
		$hotel->addres = "Адлер, ул.Б.Хмельницкого, д.31/2 ";
		$result = $this->hotel_model->add($hotel);
		$unit_test->run( $result, TRUE, "Добавление отеля в БД");
		
		
		
		
		return TRUE;
	}
}
/* End of file hotel_model_tests.php */
/* Location: ./application/models/unit_tests.php/hotel_model_tests.php */