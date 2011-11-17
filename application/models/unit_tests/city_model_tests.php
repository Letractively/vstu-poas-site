<?php
require_once 'abstract_model_tests.php';

class City_model_tests extends Abstract_model_tests {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('city_model', '', TRUE);
	}
	
	public function test(&$unit_test)
	{
		// Добавление городов в БД
		$city->name = 'Владивосток';
		$city->genitive = 'Владивостока'; 	// В родительном падеже
		$city->time = 7; 					// Во Владивостоке время на 7 часов позже чем в Москве
		$result = $this->city_model->add($city);	// Город с id = 1
	
		$city1->name = 'Волгоград';
		$city1->genitive = 'Волгограда';
		$city1->time = 0;
		$result1 = $this->city_model->add($city1); // Город с id = 2
	
		$unit_test->run( $result && $result1, TRUE, 
			'Добавление города в БД');
		
		// Получение города из БД разными способами
		$city = $this->city_model->get_by_url('volgograd');
		$unit_test->run( $city && $city->name === 'Волгоград' && $city->genitive === 'Волгограда', TRUE, 
			'Получение города из БД по url');
		
		$city = $this->city_model->get_by_name('Владивосток');
		$unit_test->run( $city && $city->name === 'Владивосток' && $city->genitive === 'Владивостока' && $city->time == 7, TRUE, 
			'Получение города из БД по названию');
		
		$city = $this->city_model->get_by_id(2);
		$unit_test->run( $city && $city->name === 'Волгоград' && $city->genitive === 'Волгограда', TRUE, 
			'Получение города из БД по идентификатору');
		
		// Обновление информации о городе без изменения url
		$city_update->id = 1;	// Идентификатор обновляемого города (обязательно для заполнения)
		$city_update->name = 'Владивосточег';	// Обновляемое поле
		$city_update->url = URL_NOT_CHANGE;
		$result = $this->city_model->update($city_update);
		$unit_test->run( $result, TRUE, "Обновление данных о городе в БД без изменения url");
		
		// Проверка обновленной информации о городе
		$city = $this->city_model->get_by_url('Vladivostok'); // url-адрес не поменялся
		$unit_test->run( $city && $city->name === 'Владивосточег' && $city->genitive === 'Владивостока' && $city->time == 7, TRUE, 
			'Проверка данных в БД после обновления информации о городе');
		
		// Обновление информации о городе с изменением url
		unset($city_update->url);
		$result = $this->city_model->update($city_update);
		$unit_test->run( $result, TRUE, "Обновление данных о городе в БД с изменением url");
		
		// Проверка обновленной информации о городе с изменённым url
		$city = $this->city_model->get_by_url('Vladivostocheg'); // url-адрес поменялся
		$unit_test->run( $city && $city->name === 'Владивосточег' && $city->genitive === 'Владивостока' && $city->time == 7, TRUE, 
			'Проверка данных в БД после обновления информации о городе с изменением url');
		
		$city = $this->city_model->get_by_name('Тольятти');
		$unit_test->run( $city === FALSE, TRUE, 
			'Попытка получить несуществующие данные по имени');
		
		$unit_test->run( $this->city_model->delete(1), TRUE, 
			'Удаление города из БД');
		
		$unit_test->run( $this->city_model->get_by_id(1) === FALSE, TRUE, 
			'Удостоверяемся, что город действительно удалён');
	}
}		
/* End of file city_model_tests.php */
/* Location: ./application/models/unit_tests.php/city_model_tests.php */