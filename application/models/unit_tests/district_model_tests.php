<?php
require_once 'abstract_model_tests.php';

class District_model_tests extends Abstract_model_tests {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('city_model', '', TRUE);
		$this->load->model('site_model', '', TRUE);
		$this->load->model('district_model', '', TRUE);
		$this->load->model('unit_tests/test_data_model', '', TRUE);
	}
	
	public function test(&$unit_test)
	{
		$this->test_data_model->load_cities();	// Заполним БД городами
		
		// Добавление районов Волгограда в БД
		$city = $this->city_model->get_by_url('volgograd');
		$unit_test->run( $city && $city->name === 'Волгоград' && $city->time == 0 && $city->genitive === 'Волгограда', TRUE, 
			'Получение города из БД по url');
		
		if( ! $city )
		{
			return FALSE;
		}
		
		$district1->name = 'Тракторозаводский';				// Название района
		$district1->city = $city->id;
		$result1 = $this->district_model->add($district1);	// Район с id = 1
	
		$district2->name = 'Ворошиловский';
		$district2->city = $city->id;
		$result2 = $this->district_model->add($district2); // Район с id = 2
		
		$district3->name = 'Михайловка';
		$district3->type = DISTRICT_TYPE_SUBURB;
		$district3->city = $city->id;
		$result3 = $this->district_model->add($district3); // Район с id = 3
		
		$unit_test->run( $result1 && $result2 && $result3, TRUE, 
			'Добавление райнонов в БД');
		
		// Получение районов из БД разными способами
		$districts = $this->district_model->get($city->id);
		
		$unit_test->run( count($districts), 3,
			'Получение всех районов города из БД, по id города');
		//var_dump($districts);
		
		$districts = $this->district_model->get($city->id, DISTRICT_TYPE_USUAL);
		$unit_test->run( count($districts), 2,
			'Получение всех обычных районов города из БД, по id города');
		
		$districts = $this->district_model->get($city->id, DISTRICT_TYPE_SUBURB);
		$unit_test->run( count($districts) == 1 && $districts[0]->name === "Михайловка" && $districts[0]->url === "mihaylovka", TRUE,
			'Получение всех обычных районов города из БД, по id города');
		
		
		// Обновление информации о районе
		// Переделаем Ворошиловский район в центральный без изменения его URL
		$district_old = $this->district_model->get_by_name($city->id, 'Ворошиловский');
		$district_update->id = $district_old->id;	// Идентификатор обновляемого города (обязательно для заполнения)
		$district_update->name = 'Центральный';		// Обновляемое поле
		$district_update->url = URL_NOT_CHANGE;		// User-frendly url оставим старый.
													// Чтобы он обновился согласно имени района автоматически, пропустить это поле.
													// Чтобы указать свой url, заполните данное поле строкой с ним
		$district_update->type = DISTRICT_TYPE_USUAL;
		$result = $this->district_model->update($district_update);
		$unit_test->run( $result, TRUE, "Обновление данных о районе в БД без изменения url");
		
		
		// Проверка обновленной информации о районе
		$district = $this->district_model->get_by_url($district_old->url); // url-адрес не поменялся
		$unit_test->run(	$district && $district->name === 'Центральный' && 
							$district->type == DISTRICT_TYPE_USUAL && 
							$district->city === $city->id &&
							$district->url != "",
							TRUE,
			'Проверка данных в БД после обновления информации о районе без изменения url');
							
		// А теперь проделаем тоже самое, но с изменением url
		unset($district_update->url);
		$result = $this->district_model->update($district_update);
		$unit_test->run( $result, TRUE, "Обновление данных о районе в БД с автоматическим изменением url");
		
		$district = $this->district_model->get_by_url($this->site_model->str_to_url("Центральный")); // url-адрес поменялся
		$unit_test->run(	$district && $district->name === 'Центральный' && 
							$district->type == DISTRICT_TYPE_USUAL && 
							$district->city === $city->id &&
							$district->url != "",
							TRUE,
			'Проверка данных в БД после обновления информации о районе с изменением url');
		
		
		$district = $this->district_model->get_by_name($city->id, 'Ленинский');
		$unit_test->run( $district === FALSE, TRUE, 
			'Попытка получить несуществующие данные о районе по имени');
		
		$unit_test->run( $this->district_model->delete(1), TRUE, 
			'Удаление района из БД');
		
		$unit_test->run( $this->district_model->get_by_id(1) === FALSE, TRUE, 
			'Проверка, что район действительно удалён');
	}
}		
/* End of file district_model_tests.php */
/* Location: ./application/models/unit_tests.php/ditrict_model_tests.php */