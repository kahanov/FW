<?php

class TreeField extends Field {
	function constantProps(){
		/*
			свойства могут быть неизменяемыми, например у NullBooleanField свойство null=true
			чтобы установить такие свойства, вызываем ->constantProps()
		*/
		$this->type='int';
		$this->maxlength='';
		$this->default='0';
		$this->unsigned=true;
		$this->null=false;
	}

	function getFormFieldHTMLtag($params_arr){
		/*
			возвращает HTML-код поля формы в форме редактирования элемента модели

			$params_arr - массив значений всех свойств элемента модели
		*/
		//создаем объект модели
		$obj_model=gmo($this->model_name);
		//вытаскиваем рекурсивно дерево элементов
		$elements_tree=$this->getRecElementsTree($obj_model,$params_arr['id']);
		//подключаем файл с шаблоном
		include(FW_DIR.'/classes/templates/field/'.$this->__name__.'.php');
		//return 'поле формы со значением <pre>'.e5c($data).'</pre><br>';

		return $result;
	}

	function getRecElementsTree($obj_model,$stop_id=0,$parent=0){
		
		$elements=$obj_model->objects();
		$elements=$elements->filter($this->db_column.'='.$parent);
		//закомментил, потому что в структуре появлялись разделы из других языков
		//$elements=$elements->domain(false);
		$elements=$elements->_slice(0);
		if(is_array($elements)){
			foreach($elements as $elem){
				if($elem['id']==$stop_id){continue;}
				$result_elem['parent']=$elem[$this->db_column];
				$result_elem['value']=$elem['id'];
				$result_elem['text']=$obj_model->__str__($elem);
				$result_elem['__children__']=$this->getRecElementsTree($obj_model,$stop_id,$elem['id']);
				$result[]=$result_elem;
			}
		}
		return $result;
	}

	/*function getFormFieldHTMLError($error_bool){
		/*
			возвращает массив с классом и текстом ошибки

			$error_bool - true если поле было не заполнено, или заполнено с ошибкой
		* /
	}*/

	/*function getFormFieldHTMLth($error_arr){
		/*
			возвращает тег <th> заголовка колонки для режима core

			$error_arr - массив с классом и текстом ошибки
		* /
	}*/

	/*function getFormFieldHTMLWrap($input_tag,$error_arr){
		/*
			возвращает тег поля формы завернутый в <p> или <td>, в зависимости от $this->mode

			$input_tag - тег поля формы
			$error_arr - массив с классом и текстом ошибки
		* /
	}*/

	/*function getModelItemInitValue($model_item_init_values){
		/*
			переопределяемый в потомках метод, который возвращает 
			инициализирующее значение для данного поля на основе $model_item_init_values,
			для большинства полей это значение равно $model_item_init_values[$this->db_column]

			$model_item_init_values - инициализирующий массив всех значений элемента модели, 
			как правило, полученный из $_POST
		* /
	}*/

	/*function getSQLcreate(){
		/*
			возвращает фрагмент sql-запроса create table, 
			который отвечает за описание конкретного поля
		* /
	}*/

	/*function getDbColumnDefinition(){
		/*
			возвращает фрагмент sql-запроса с описанием конкретного поля 
			и является частью таких запросов как "create table", 
			"alter table add column", "alter table change column"
		* /
	}*/

	/*function getSQLupdate($model_item_value){
		/*
			возвращает фрагмент sql-запроса для внесения данных в БД

			$model_item_value - значение поля, которое нужно внести в БД
		* /
	}*/

	/*function getSQLselect(){
		/*
			возвращает sql-фрагмент для запроса данных из БД
		* /
	}*/

	/*function beforeDelete($params_arr){
		/*
			выполняет действие, 
			предшествующее удалению элемента

			$params_arr - массив значений из БД
		* /
	}*/
	
	/*function repareDbColumn($db_columns_info){
		/*
			каждое поле имеет описание в _models.php 
			и реализацию в таблице модели
			в зависимости от их соответствия данный метод инициализирует
			добавление, изменение, удаление столбца, 
			или ничего не делает, если соответствие является полным

			$db_columns_info - результат запроса "show columns from ..."
		* /
	}*/

	/*function performAlterTableAdd(){
		/*
			выполняем "alter table add column"
			возвращаем sql-запрос
		* /
	}*/

	/*function performAlterTableChange($db_column_name){
		/*
			выполняем "alter table change"
			возвращаем sql-запрос

			$db_column_name - $this->db_column ИЛИ $GLOBALS['db_column_bak']['old']
		* /
	}*/

	/*function performAlterTableDrop(){
		/*
			выполняем "alter table drop column" 
			ничего не возвращаем
		* /
	}*/

	/*function checkFieldInfoIsCorrect($db_columns_info,$db_column_name){
		/*
			каждое поле имеет описание в _models.php 
			и реализацию в таблице модели
			данный метод проверяет их соответствие

			$db_columns_info - результат запроса "show columns from ..."
			$db_column_name - $this->db_column ИЛИ $GLOBALS['db_column_bak']['old']
		* /
	}*/

	//-----------------------------------------------------------------
}

?>