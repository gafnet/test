$(document).ready(function(){
	
	/* ===Аккордеон=== */
    var openItem = false;
	if(jQuery.cookie("openItem") && jQuery.cookie("openItem") != 'false'){
		openItem = parseInt(jQuery.cookie("openItem"));
	}	
	jQuery("#accordion").accordion({
		active: openItem,
		collapsible: true,
        autoHeight: false,
        header: 'h3'
	});
	jQuery("#accordion h3").click(function(){
		jQuery.cookie("openItem", jQuery("#accordion").accordion("option", "active"));
	});	
	jQuery("#accordion > li").click(function(){
		jQuery.cookie("openItem", null);
        var link = jQuery(this).find('a').attr('href');
        window.location = link;
	});
    /* ===Аккордеон=== */
    
    // удаление
    $(".del").click(function(){
        var res = confirm("Подтвердите удаление");
        if(!res) return false;
    });
    // удаление
    
    // слайд информеров
    $(".toggle").click(function(){
        $(this).parent().next().slideToggle(500);
        
        if($(this).parent().attr("class") == "inf-down"){
            $(this).parent().removeClass("inf-down");
            $(this).parent().addClass("inf-up");
        }else{
            $(this).parent().removeClass("inf-up");
            $(this).parent().addClass("inf-down");
        }
    });
    // слайд информеров
    
    // поля картинок галереи
    var max = 5;
    var min = 1;
    $("#del").attr("disabled", true);
    $("#add").click(function(){
        var total = $("input[name='galleryimg[]']").length;
        if(total < max){
            $("#btnimg").append('<div><input type="file" name="galleryimg[]" /></div>');
            if(max == total + 1){
                $("#add").attr("disabled", true);
            }
            $("#del").removeAttr("disabled");
        }
    });
    $("#del").click(function(){
        var total = $("input[name='galleryimg[]']").length;
        if(total > min){
           $("#btnimg div:last-child").remove();
           if(min == total - 1){
                $("#del").attr("disabled", true);
           }
           $("#add").removeAttr("disabled");
        }
    });
    // поля картинок галереи
    
    // удаление картинок
    $(".delimg").on("click", function(){
        var res = confirm("Подтвердите удаление");
        if(!res) return false;
        
        var img = $(this).attr("alt"); // имя картинки
        var rel = $(this).attr("rel"); // 0 - базовая картинка, 1 - картинка галереи
        var goods_id = $("#goods_id").text(); // ID товара
        $.ajax({
            url: "./",
            type: "POST",
            data: {img: img, rel: rel, goods_id: goods_id},
            success: function(res){
                if(rel == 0){
                    // базовая картинка
                    $(".baseimg").fadeOut(500, function(){
                        $(".baseimg").empty().fadeIn(500).html(res);
                    });
                }else{
                    // картинка галереи
                    $(".slideimg").find("img[alt='" + img + "']").hide(500);
                }
            },
            error: function(){
                alert("Error");
            }
        });
    });
    // удаление картинок
    
    //сортировка страниц
	//применяем метод sortable
    $( "#sort tbody" ).sortable({
		//стиль для пустого места - куда можно перемещать объект при сортировке.
    	placeholder: "ui-state-highlight",
		//исключяаем элементы которые не нужно сортировать - хедер таблицы страниц
		items: "tr:not(.no_sort)",
		//перемещение объектов только по вертикали
		axis: "y",
		//прозрачность элементов при перетаскивании
		opacity: 0.5,
		//окончание перемещения
		stop: function(){
			//получаем массив идентификаторов страниц - в новом порядке, для каждой строки таблицы был добавлен атрибут id
			var id_s = $('#sort tbody').sortable("toArray");
			//показ блока с вращающимся изображением - начало сортировки
			$(".load").fadeIn(300);
			//применяем аякс и отправляем массив идентификаторов методом ПОСТ в файл index.php
			$.ajax({
				url: 'index.php',
				type: 'POST',
				data: {sortable:id_s},
				error: function(){
					//если ошибка то показываем блок  с соответстующим сообщением
					$(".load").fadeOut(200);
					$('#res').text("Ошибка!").fadeIn(300);
				},
				//если все хорошо
				success: function(html){
					//плавно скрываем вращающиеся изображение и...
					$(".load").fadeOut(200,function () {
						//проверяем что вернулось нам в качестве ответа, если вернулся массив
						if(html) {
						///
							//то сохраняем этот массив в переменную arr
							var arr = JSON.parse(html);
							// в цикле проходимся по массиву и записываем новые значения позиций страниц в соответствующий столбец таблицы
							for(var i = 0; i < arr.length; i++) {
								var p = "#"+arr[i]['page_id']+ ">.position";
								$(p).text(arr[i]['position']);
							}
						///
							//Показываем блок с сообщением об успешности выполнения сортировки.
							$(".res").text("Изменения сохранены").stop(true, true).fadeIn(300).fadeOut(2000);
						}
						if(!html){
						//если ЛОЖЬ то выводим сообщение о ошибке
							$(".res").text("Ошибка").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
						}	
					});	
				}
			});
		} 
   	});
	//запрет выделения
    $( "#sort tbody" ).disableSelection();
	//сортировка страниц
    
    //сортировка ссылок - аналогично страницам, только передаем в файл index.php кроме идентификаторов,идентификатор информера к которому принадлежат ссылки
	$(".inf-page tbody").sortable({
		axis: "y",
		opacity: 0.5,
		placeholder: "ui-state-highlight1",
		items: "tr:not(.no_sort)",
		stop: function(){
			// идентификаторы ссылок после перемещения
			var id_s = $(this).sortable("toArray");
			//идентификатор родительского информера
			var parent = $(this).parent().attr('id');
			$(".load").fadeIn(300);
			
			$.ajax({
				url: 'index.php',
				type: 'POST',
				data: {sort_link:id_s,parent:parent},
				error: function(){
					$(".load").fadeOut(200);
					$('#res').text("Ошибка!").fadeIn(300);
				},
				success: function(html){
					$(".load").fadeOut(200,function () {
						if(html) {
							var arr1 = JSON.parse(html);
							for(var i = 0; i < arr1.length; i++) {
								
								var p = ".inf-page>table#"+parent+" #"+arr1[i]['link_id']+ " .position";
								$(p).text(arr1[i]['links_position']);
							}
						///
							$(".res").text("Изменения сохранены").stop(true, true).fadeIn(300).fadeOut(2000);
						}
						if(!html){
							$(".res").text("Ошибка").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
						}
					
					});
					
				}
			
			});
		}
   	});
	//сортировка информеров - аналогично страницам
	$("#sotr_inf").sortable({
		axis: "y",
		opacity: 0.5,
		placeholder: "ui-state-highlight2",
		delay: 200,
		stop: function(){
			var id_s = $(this).sortable("toArray");
			$(".load").fadeIn(300);
			
			$.ajax({
				url: 'index.php',
				type: 'POST',
				data: {sort_inf:id_s},
				error: function(){
					$(".load").fadeOut(200);
					$('#res').text("Ошибка!").fadeIn(300);
				},
				success: function(html){
					$(".load").fadeOut(200,function () {
						if(html) {
						///
							$(".res").text("Изменения сохранены").stop(true, true).fadeIn(300).fadeOut(2000);
						}
						if(!html){
							$(".res").text("Ошибка").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
						}
					
					});
					
				}
			
			});
		}	
		
	});
	//сортировка информеров

	//Получение данных для списка строк, в зависимости от источника 
	//Используется для вида edit_category.php
	


	$('#tabl_nam').change( function(){
		var options = '';
		var tabl_nam = $(this).val();
		var row_id = $('#row_id').val();
		if (tabl_nam==0){
            $('#row_id').html('<option>Без ссылки</option>');
            $('#row_id').attr('disabled', true);
            return(false);
		}else {
			$(".load_sp").fadeIn(300);
			switch(tabl_nam){
				case('page'):
					$.ajax({
						url: 'functions/pages_get.php ',
						type: 'POST',
						data: {ajax:'agax', tabl_nam:tabl_nam},
						error: function(){
						console.log("error")
						},
						success: function(data){
							var mass = JSON.parse ( data );
							i=0;
							while (i < mass.length){
								var m_sel="";
								if (row_id==mass[i].page_id) {m_sel=" selected "}
								options += '<option value="' + mass[i].page_id + '" '+m_sel+'>' + mass[i].title + '</option>';
								i++;
							}
							$('#row_id').html('<option value="0">Без ссылки</option>'+options);
							$('#row_id').attr('disabled', false);
			
						}
					});
				break;   
				case('galery'):
					$.ajax({
						url: 'functions/galerys_get.php ',
						type: 'POST',
						data: {ajax:'agax', tabl_nam:tabl_nam},
						error: function(){
							$(".load_sp").fadeOut(200);
							$('#res').text("Ошибка!").fadeIn(300);
						},
						success: function(response){
							var res = JSON.parse(response);
							if(res.answer == "OK"){
								var mass = res.mass;
								i=0;
								while (i < mass.length){
									var m_sel="";
									if (row_id==mass[i].galery_id) {m_sel=" selected "}
									options += '<option value="' + mass[i].galery_id + '"'+m_sel+'>' + mass[i].galery_nam + '</option>';
									i++;
								}
								$('#row_id').html('<option value="0">Без ссылки</option>'+options);
								$('#row_id').attr('disabled', false);
							}else{
								alert(res.answer);
							}
			
						}
					});
				break;   
			}
			$(".load_sp").fadeOut(300);
		}
		
	});
	//При открытии edit_category.php вызываем событие change для определения списка для row_id
	$('#tabl_nam').trigger('change');	
	
	//При смене значения в комвобоксе перезапрашиваем данные для categorys.php
	$('#group_id').change( function(){
		var group_id = $(this).val();
		$.cookie("group_id", group_id, {path: '/'});
		window.location = location.href;
		return false;	
	});
	
	
	//Получение данных для списка строк goods_catid при смене раздела
	//Используется для вида add_product.php, edit_product.php
	$('#parent_id').change( function(){
		var options = '';
		var parent_id = $(this).val();
		console.log("parent_id")
		if (parent_id==0){
            $('#goods_catid').html('<option>Выбирете раздел</option>');
            $('#goods_catid').attr('disabled', true);
            return(false);
		}else {
			$(".load_sp").fadeIn(300);
				$.ajax({
					url: 'users/functions/categorys_get.php ',
					type: 'POST',
					data: {ajax:'agax', parent_id:parent_id},
					error: function(){
					console.log("error")
					},
					success: function(data){
						var res = JSON.parse(response);
						if(res.answer == "OK"){
							var mass = res.mass;
							i=0;
							alert(mass.length);
							while (i < mass.length){
								var m_sel="";
								//if (row_id==mass[i].cat_id) {m_sel=" selected "}
								options += '<option value="' + mass[i].cat_id + '" '+m_sel+'>' + mass[i].cat_name + '</option>';
								i++;
							}
							$('#goods_catid').html('<option value="0">Без ссылки</option>'+options);
							$('#goods_catid').attr('disabled', false);
						}else{
							alert(res.answer);
						}
		
					}
				});
			
			$(".load_sp").fadeOut(300);
		}
		
	});
	
});