<?php defined('WOOD') or die('Access denied'); ?>
<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Номер</label>
		<div class="col-sm-9" >
			<input type="text" name="num" id="num" class="form-control"
			value=""/>
		</div>
	</div>				
	<input type="submit" name="edit_site" class="btn btn-primary btn-block" value="Найти" /> 
</form>
</br>

<?php
//Если была нажата кнопка найти
if ($_POST)  {

	//Приводим полученное значение к целому типу
	$num = (int)$_POST['num'];
	$query = "SELECT * FROM test WHERE num = $num";
	$res = mysql_query($query);
	if (mysql_num_rows($res)>0) {
		$items = array();
		while($row = mysql_fetch_assoc($res)){
			$items[] = $row;
		}
		if (count($items)>1){
			//Если получено больше одной записи, то выводим результаты для уточнения поиска
			show_brand($items);
		}else{
			//Если получена одна запись, то выводим результаты поиска
			get_resalt($items[0]['cross_group']);
		}
	}else{
		echo ("По данным критериям ничего не найдено");
	}
	return;
}

//Если была нажата ссылка по дополнительным критериям выборки
if ($_GET)  {
	if(isset($_GET['cross_group'])){
		$cross_group = (int)$_GET['cross_group'];
		get_resalt($cross_group);
	}else{
		echo ("По данным критериям ничего не найдено");
	}
}

function get_resalt($cross_group) {
	$query = "SELECT * FROM test WHERE cross_group = $cross_group";
	$res = mysql_query($query);
	
	if (mysql_num_rows($res)>0) {
		$count_field = mysql_num_fields($res); //Находим кол-во полей в запросе
		$html_res = '';
		$html_res .= '<table>';
		$html_res .= '<caption>Результат выборки</caption>';
		//Формирование заголовка таблицы
		$html_res .= '<tr>';
		for ($i=0; $i<$count_field; $i++){
			$html_res .= '<th>';
			$html_res .= mysql_field_name($res, $i);//Получение названия полей в запросе
			$html_res .= '</th>';
		}
		$html_res .= '</tr>';
 		while($row = mysql_fetch_row($res)){
			//Формирование строки таблицы и вывод занчений полей
			$html_res .= '<tr>';
			for ($i=0; $i<$count_field; $i++){
				$html_res .= '<td>';
				$html_res .= $row[$i];//Получение значения поля по строке
				$html_res .= '</td>';
			}
			$html_res .= '</tr>';
		}	
		$html_res .= '</table>';
		print($html_res);
	}
}


function show_brand($items) {
	$html_res = '';
	$html_res .= '<table>';
	$html_res .= '<caption>Уточните критерии поиска</caption>';
	//Формирование заголовка таблицы
	$html_res .= '<tr>';
	//Заголовок для brand
	$html_res .= '<th>';
	$html_res .= 'brand';
	$html_res .= '</th>';
	//Заголовок для num
	$html_res .= '<th>';
	$html_res .= 'num';
	$html_res .= '</th>';
	$html_res .= '</tr>';
	foreach ($items as $item) {
		//Формирование строки таблицы и вывод занчений полей
		$html_res .= '<tr>';
		$html_res .= '<td>';
		$html_res .= '<a href="?view=test&cross_group='.$item['cross_group'].'">';
		$html_res .= $item['brand'];
		$html_res .= '</a>';
		$html_res .= '</td>';
		$html_res .= '<td>';
		$html_res .= '<a href="?view=test&cross_group='.$item['cross_group'].'">';
		$html_res .= $item['num'];
		$html_res .= '</a>';
		$html_res .= '</td>';
		$html_res .= '</tr>';

	}	
	$html_res .= '</table>';
	print($html_res);
	
	
}

?>