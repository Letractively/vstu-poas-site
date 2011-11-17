<?php
class Test_data_model extends CI_Model {
	
	function __construct() {
	}
	
	
	function load_city()
	{
		$city->name = 'Волгоград';
		$city->genitive = 'Волгограда'; 		// В родительном падеже
		$city->time = 0; 						// В Волгограде время совпадает с Москвовским
		return $this->city_model->add($city);	// Если база была пуста, то это будет город с id = 1
	}
	
	function load_cities()
	{
		// Добавляем первый город
		$this->load_city();
		
		// Добавляем ещё несколько
		$city->name = 'Ярославль';
		$city->genitive = 'Ярославля';
		$city->time = 0;
		if( !$this->city_model->add($city) )
		{
			return FALSE;
		}
		
		$city->name = 'Владивосток';
		$city->genitive = 'Владивостока';
		$city->time = 7; 						// Во Владивостоке время на 7 часов позже чем в Москве
		if( !$this->city_model->add($city) )
		{
			return FALSE;
		}
		
		$city->name = 'Новосибирск';
		$city->genitive = 'Новосибирска';
		$city->time = 3;
		if( !$this->city_model->add($city) )
		{
			return FALSE;
		}
		
		return TRUE;
	}
}