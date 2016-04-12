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
        header: 'h4'
	});
	jQuery("#accordion h4").click(function(){
		jQuery.cookie("openItem", jQuery("#accordion").accordion("option", "active"), {path: '/'});
	});	
	jQuery("#accordion > li").click(function(){
		jQuery.cookie("openItem", null, {path: '/'});
        var link = jQuery(this).find('a').attr('href');
        window.location = link;
	});
 /*===Аккордеон=== */
    
    /* ===Переключатель вида=== */
    if($.cookie("display") == null){
        $.cookie("display", "grid", {path: '/'});
    }
    
    $(".grid_list").click(function(){
        var display = $(this).attr("id"); // получаем значение переключателя вида
        display = (display == "grid") ? "grid" : "list"; // допустимые значения
        if(display == $.cookie("display")){
            // если значение совпадает с кукой - ничего не делаем
            return false;   
        }else{
            // иначе - установим куку с новым значением вида
            $.cookie("display", display, {path: '/'});
            window.location = location.href;
            return false;
        }
    });
    /* ===Переключатель вида=== */
    
    /* ===Сортировка=== */
    $("#param_order").toggle(
        function(){
            $(".sort-wrap").css({'visibility': 'visible'});
        },
        function(){
            $(".sort-wrap").css({'visibility': 'hidden'});
        }
    );
    /* ===Сортировка=== */
      $( "#enter" ).dialog({
      autoOpen: false,
	  modal: true,
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
	$( "#in_site" ).click(function() {
      $( "#enter" ).dialog( "open" );
    });
	
    /* ===Авторизация=== */
    $("#auth1").click(function(e){
        e.preventDefault();
        var login = $("#login_auth").val();
        var pass = $("#pass").val();
        var auth = $("#auth").val();
        $.ajax({
           url: path,
           type: 'POST',
           data: {auth: auth, login: login, pass: pass},
           success: function(res){
                if(res != 'Поля логин/пароль должны быть заполнены!' && res != 'Логин/пароль введены неверно!'){
                    // если пользователь успешно авторизован
					$( "#enter" ).dialog( "close" );
                    $(".auth_form").hide().fadeIn(500).html('<div id="user_auth">Вы вошли как <strong>'+ login +'</strong> <a href="' +path+ '?do=logout">Выход</a>');
                    // удаляем лишние поля заказа
                    //$(".notauth").fadeOut(500);
                    //setTimeout(function(){
                    //    $(".notauth").remove();
                    //}, 500);
                }else{
                    // если авторизация неудачна
                    $(".error").remove();
                    $(".auth_form").append('<div class="error"></div>');
                    $(".error").hide().fadeIn(500).html(res);
                }
           },
           error: function(){
                alert("Error!");
           }
        });
    });
    /* ===Авторизация=== */
    
    /* ===Клавиша ENTER при пересчете=== */
    $(".kolvo").keypress(function(e){
        if(e.which == 13){
            return false;
        }
    });
    /* ===Клавиша ENTER при пересчете=== */
    
    /* ===Пересчет товаров в корзине=== */
    $(".kolvo").each(function(){
       var qty_start = $(this).val(); // кол-во до изменения
       
       $(this).change(function(){
           var qty = $(this).val(); // кол-во перед пересчетом
           var res = confirm("Пересчитать корзину?");
           if(res){
                var id = $(this).attr("id");
                id = id.substr(2);
                if(!parseInt(qty)){
                    qty = qty_start;
                }
                // передаем параметры
                window.location = path + "cart/qty=" + qty + "/id=" + id;
           }else{
                // если отменен пересчет корзины
                $(this).val(qty_start);
           }
       }); 
    });
	
	//Получение данных для списка строк goods_catid при смене раздела
	//Используется для вида add_product.php, edit_product.php
	$('#parent_id').change( function(){
		var options = '';
		var parent_id = $(this).val();
		var goods_catid = $('#goods_catid').val();
		if (parent_id==0){
            $('#goods_catid').html('<option>Выбирете раздел</option>');
            $('#goods_catid').attr('disabled', true);
            return(false);
		}else {
			$(".load_sp").fadeIn(300);
				$.ajax({
					url: 'user/functions/categorys_get.php ',
					type: 'POST',
					data: {ajax:'ajax', parent_id:parent_id},
					error: function(){
					console.log("error")
					},
					success: function(data){
						var res = JSON.parse(data);
						if(res.answer == "OK"){
							var mass = res.mass;
							i=0;
							while (i < mass.length){
								var m_sel="";
								if (goods_catid==mass[i].cat_id) {m_sel=" selected "}
								options += '<option value="' + mass[i].cat_id + '" '+m_sel+'>' + mass[i].cat_name + '</option>';
								i++;
							}
							$('#goods_catid').html(options);
							$('#goods_catid').attr('disabled', false);
						}else{
							alert(res.answer);
						}
		
					}
				}); //Конец ajax
			}
			$(".load_sp").fadeOut(300);
		});

	//При открытии edit_category.php вызываем событие change для определения списка для row_id
	$('#parent_id').trigger('change');	
		
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
	

    /* ===Пересчет товаров в корзине=== */
    
    /* ===Галерея товаров=== 
    $("a[rel=gallery]").fancybox({
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic',
        'speedIn'       : 500,
        'speedOut'      : 500
    });
	*/
    /*var ImgArr, ImgLen;
    //Предварительная загрузка
    function Preload (url)
    {
       if (!ImgArr){
           ImgArr=new Array();
           ImgLen=0;
       }
       ImgArr[ImgLen]=new Image();
       ImgArr[ImgLen].src=url;
       ImgLen++;
    }
    $('.item_thumbs a').each(function(){
       Preload( $(this).attr('href') );
    })


    //обвес клика по превью
    $('.item_thumbs a').click(function(e){
       e.preventDefault();
       if(!$(this).hasClass('active')){
           var target = $(this).attr('href');

           $('.item_thumbs a').removeClass('active');
           $(this).addClass('active');

           $('.item_img img').fadeOut('fast', function(){
               $(this).attr('src', target).load(function(){
                   $(this).fadeIn();
               })
           })
       }
    });
    $('.item_thumbs a:first').trigger('click');*/
    /* ===Галерея товаров=== */
    
	/* ===Отображение информации на картинках, с областью area=== 
$( "#div_area_1" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		},
		{
			text: "Cancel",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
	]
}); 
$( "#div_area_2" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		},
		{
			text: "Cancel",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
	]
}); 

 $("area").each(function(){
       var area_id ="#div_" + $(this).attr("id");
       $(this).click(function(){
		$( area_id ).dialog( "open" );
       }); 
    });

	
	 ===Отображение информации на картинках, с областью area=== */
    
    //Используется для загрузки изображений в 
	//edit_product и add_product
function preview(img, selection) {
    var scaleX = 140 / (selection.width );
    var scaleY = 140 / (selection.height);
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}	
    
//Блок переключения отметки главной картинки
 $(".cont_img").on("change", "input:checkbox[name=glav]", function(){
 var group = ":checkbox[name='glav']";
   if($(this).is(':checked')){

     $(group).not($(this)).attr("checked",false);
   }
});


	$('#btnSave').click(function (e){
		startLoadingAnimation();
		e.preventDefault();
		var save_goods = false;
		var save_goods_pic = false;
		//Сохраняем основные данные по товару	
		var goods_id = $('#goods_id').text();
		var name = $('#name').val();
		var price = $('#price').val();
		var keywords = $('#keywords').val();
		var description = $('#description').val();
		var parent_id = $('#parent_id').val();
		var goods_catid = $('#goods_catid').val();
		var anons = $('#editor1').val();
		var content = $('#editor2').val();
		var visible = $('input[name=visible]:checked').val();
		var m_new = 0;
		if($('#new').is(":checked")){m_new = 1;};
		var hits = 0;
		if($('#hits').is(":checked")){hits = 1;};
		var sale = 0;
		if($('#sale').is(":checked")){sale = 1;};
		//Сохраняем значения основной записи товара
		$.ajax({
			url: path,
			type: 'POST',
			data: {ajax:'ajax', edit_product:'edit_product', goods_id: goods_id, name: name, price: price, keywords: keywords
					, description: description, goods_catid: goods_catid, anons: anons, content: content 
					, visible: visible, m_new: m_new, hits: hits, sale: sale},
			error: function(){
			alert('Error при сохранении основной записи товара');
			},
			success: function(data){
				var res = JSON.parse(data);
				if(res.answer != "OK"){
					save_goods = false;
					alert(res.answer);
				}else{
					save_goods = true;
					console.log('Сохранена главная запись товара\r\n');
					//Если добавляем новую запись, то в goods_id кладем ид новой записи.
					if ($('#goods_id').text()==0) {
						$('#goods_id').text(res.goods_id);
					}
					//Получаем в набор все изображения товара
					var i = 0;
					var count_img = $('.cont_img img').size();
					console.log('Кол-во картинок - ' + count_img + '\r\n');
					if (count_img>0){
						$('.cont_img img').each(function() {
							if ($(this).attr('rel')!='pic_new') {
								var picID = $(this).attr('id').replace(/[^-0-9]/gim,'');
							}else{
								var picID = $(this).attr('id')
							}
							var goods_id = $('#goods_id').text();
							var x1 = $('#x1_' + picID).val();
							var x2 = $('#x2_' + picID).val();
							var y1 = $('#y1_' + picID).val();
							var y2 = $('#y2_' + picID).val();
							var pic_path = $(this).attr('src');
							var name = $('#name_' + picID).val();
							var glav = 0; 
							if($('#glav_' + picID).is(":checked")){glav = 1;}
							var del = 0;
							if($('#del_' + picID).is(":checked")){del = 1;}
							$.ajax({
								url: path,
								type: 'POST',
								data: {ajax:'ajax', pic_id: picID, goods_id: goods_id, x1: x1, y1: y1, x2: x2, y2: y2, name: name, pic_path: pic_path, glav: glav, del: del},
								error: function(){
								alert('Error1');
								return(false);
								},
								success: function(data){
									var res = JSON.parse(data);
									if(res.answer != "OK"){
										stopLoadingAnimation();
										alert(res.answer);
										return(false);
									}
									i=i+1;
									console.log('Сохранена картинка № - ' + i + '\r\n');
									if (i==count_img) { 
									console.log('Сохраненo все');
									stopLoadingAnimation();
									window.location = '?view=user/shop/shop';
									}
								}
							}); //Конец ajax
						}); //.cont_img img 
					}else{
						stopLoadingAnimation();
						window.location = '?view=user/shop/shop';
					}


				}//
			}
		}); //Конец ajax
		


		if (save_goods) {
			alert('2');
			//window.location = '?view=user/shop/shop';
		}
	});  //#btnSave

	//Закрепление строки меню при прокрутке страницы
	var $menu = $("#menu");
	$(window).scroll(function(){
		if ( $(this).scrollTop() > 117 && $menu.hasClass("default") ){
			var menu_width = $menu.width();
			$menu.fadeOut('fast',function(){
				$(this).removeClass("default")
					   .addClass("fixed transbg")
					   .width(menu_width)
					   .fadeIn('fast');
			});
		} else if($(this).scrollTop() <= 117 && $menu.hasClass("fixed")) {
			$menu.fadeOut('fast',function(){
				$(this).removeClass("fixed transbg")
					   .addClass("default")
					   .fadeIn('fast');
			});
		}
	});//scroll	
	//Закрепление строки меню при прокрутке страницы (конец)
	
    $('.cont_img img').each(function() {
		var picID = $(this).attr('id').replace(/[^-0-9]/gim,'');
		var x1 = $('#x1_' + picID).val();
		var x2 = $('#x2_' + picID).attr('value');
		var y1 = $('#y1_' + picID).attr('value');
		var y2 = $('#y2_' + picID).attr('value');
		$(this).imgAreaSelect({ aspectRatio: '1:1', x1: x1, y1: y1, x2: x2, y2: y2, handles: true, 
		onSelectEnd: function (img, selection) {
            $('#x1_' + picID).val(selection.x1);
            $('#x2_' + picID).val(selection.x2);
            $('#y1_' + picID).val(selection.y1);
            $('#y2_' + picID).val(selection.y2);
		}
		});
	});
	
	$("#uploadify").uploadify({
		'uploader'       : path + 'lib/Uploader/scripts/uploadify.swf', // Относительный путь к файлу uploadify.swf. По умолчанию uploadify.swf
		'script'         : path + 'lib/Uploader/scripts/uploadify.php', // Относительный путь uploadify.php. По умолчанию uploadify.php. Это скрипт - загрузчик. Обязательно посмотрите его
		'cancelImg'      : path + 'lib/Uploader/scripts/cancel.png', // Относительный путь до картинки cancel.png. По умолчанию cancel.png
		'folder'         : userfiles + 'tmp/', // Путь к папке, в которой Вы хотите сохранять загружаемые файлы. 
                                      //Эту настройку можно опустить, тогда папку загрузки необходимо определить в uploadify.php
                                      //Помните! На большистве хостингов, папка, в которую Вы пытаетесь загрузить файлы должна быть доступна на запись, не забудьте выставить соответствующие права 
		'queueID'        : 'fileQueue', // ID элемента, в котором будет показываться очередь загрузки
        'queueSizeLimit' : '3', // Лимит очереди (максим. число загруж файлов). По умолчанию 999
		'auto'           : true, // Если истина, загрузка начнется сразу после выбора файлов
		'multi'          : true,  // Если истина, то разрешена загрузка нескольких файлов
        'fileDesc'       : 'только фотографии jpg', // Текст, который будет внизу появляющегося диалогового окна. Без этого параметра будет написано "Все файлы('.')"
        'fileExt'        : '*.jpg; *.jpeg; *.JPG; *.JPE; *.jpe', // разрешенные к загрузке файлы (остальные вдиалолговом окне будути скрыты)
        'sizeLimit'      : 1500000, // Макс. Размер файла для каждой загрузки (в байтах). Если не указываем, ограничено будет только настройками Вашего сервера
        'simUploadLimit' : 1, // Ограничение на кол-во одновременных закачек. По умолчанию 1. Если значение равно 1, то загружаться будет 1 файл, а остальные будут стоять за ним в очереди. Если 2 - два загружаются, остальные ждут их  и т.д
        'buttonText'     : 'File', // Текст на кнопке. По умолчанию BROWSE. К сожалению русскийтекст не поддрживается
        'buttonImg'      : path + 'lib/Uploader/scripts/btn.png', // Путь до картинки, которая будет служить кнопкой. Компенсирует недостаток предыдущей. Если эта настройка указана, предыдущая будет проигнорирована
      'width' : 255,
	  'height' : 87,
	  // 'onInit'        : alert('Скрипт готов!'),// Функция, которая срабатывает, когда скрипт будет загружен. По умолчанию обработчик событий скрывает целевой элемент на странице и заменяет его с флэш-файл, затем создает очереди контейнера после него.
        /*
        'onSelect'       : function(event, queueID, fileObj){ // Функция, которая сработает, при выборе каждого файла. Пример:
                            var string =  'Имя фала: '     + fileObj.name  +'\n';
                                string += 'Размер файла: ' + fileObj.size  + 'байт\n';
                                string += 'Тип: '          + fileObj.type  + '\n';  
                                string += 'ID в очереди: ' + queueID       +'\n'; // уникальный ID файла, генерируется скриптом
                            alert(string)
                         },
        'onSelectOnce'  : function(event, data){   //Функция, которая вызывается один раз для каждой операции выбора.
                            var string  = 'Файлов в очереди: '                  + data.fileCount      +'\n';
                                string += 'Было выбрано файлов: '               + data.filesSelected  +'\n';
                                string += 'Заменено файлов в очереди: '         + data.filesReplaced  +'\n';
                                string += 'Итоговый вес файлов в очереди: '    + data.allBytesTotal  +'\n';
                            alert(string); 
        },
        */
        'onProgress'    : function(event, queueID, fileObj, data){  // Срабатываети каждый раз в ходе изменений во време загрузки
                          var string   = 'Загружаем: '                             + fileObj.name            +'<br />';
                              string  += 'Размер: '                                + fileObj.size            +'<br />';
                              string  += 'Тип: '                                   + fileObj.type            +'<br />';
                              string  += 'загрузка текущего файла: '               + data.percentage         +'%<br />';
                              string  += 'загружено байт текущего файла: '         + data.bytesLoaded        +'<br />';
                              string  += 'загружено байт всей очереди: '           + data.allBytesLoaded     +'<br />';
                              string  += 'скорость загрузки, KB/s: '               + data.speed              +'<br />';
                              $('#info,#info2').show();
                              $('#info').html(string);
        },
        'onComplete'    : function(event, queueID, fileObj, response, data){ // Срабатывает когда файл загружен на сервер. По умолчанию файл удаляется из очереди, но мы можем и добваить свои какие-либо действия
                          var string   = 'Загружен файл: '                         + fileObj.name            +'<br />';
                              string  += 'Путь до файла: '                         + fileObj.filePath        +'<br />';
                              string  += 'Размер, байт: '                          + fileObj.size            +'<br />';
                              string  += 'Тип: '                                   + fileObj.type            +'<br />';
                              string  += 'Пришел ответ от сервера: '               + response                +'<br />';
                              string  += 'Файлов в очереди: '                      + data.fileCount          +'<br />';
                              string  += 'скорость загрузки, KB/s: '               + data.speed              +'<br />'; 
                              
                              $('#info2').append('<br />Фаил ' + string + ' загружен!<br />');
							  //$("#pic_g img").remove();
							var res = JSON.parse(response);	
							
							var count_new_images = $('.cont_img img[rel=pic_new]').size();
							var count_images = $('.cont_img img').size();
							var pic  = '<div class = "pic_content">';
								pic += '<div class = "pic_img">';
								pic += '<img id="new_' + count_new_images + '" rel="pic_new" src="' + path + userfiles + 'tmp/' + res.file + '" />';
								pic += '</div>';
								pic += '<div class = "pic_dop">';
								pic += '<textarea name="name"></textarea>';
								if (count_images==0) {
									pic += '<input type="checkbox" name="glav" checked="" id ="glav_new_' + count_new_images + '"  />Главное изображение<br />';
								}else {
									pic += '<input type="checkbox" name="glav" id ="glav_new_' + count_new_images + '"  />Главное изображение<br />';
								}
								pic += '<input type="checkbox" id ="del_new_' + count_new_images + '"  />Отметить к удалению<br />';
								pic += '<input type="hidden" name="x1" value="' + res.x1 + '" id="x1_new_' + count_new_images + '" />';
								pic += '<input type="hidden" name="y1" value="' + res.y1 + '" id="y1_new_' + count_new_images + '" />';
								pic += '<input type="hidden" name="x2" value="' + res.x2 + '" id="x2_new_' + count_new_images + '" />';
								pic += '<input type="hidden" name="y2" value="' + res.y2 + '" id="y2_new_' + count_new_images + '" />';
								pic += '</div>';								
								pic += '</div>';
							  $(".cont_img").append(pic);	
							//Вделяем координаты блока для маленькой картинки
							var x1 = res.x1;
							var x2 = res.x2;
							var y1 = res.y1;
							var y2 = res.y2;
							$('#new_' + count_new_images).imgAreaSelect({ aspectRatio: '1:1', x1: x1, y1: y1, x2: x2, y2: y2, handles: true, 
							onSelectEnd: function (img, selection) {
								$('#x1_new_' + count_new_images).val(selection.x1);
								$('#x2_new_' + count_new_images).val(selection.x2);
								$('#y1_new_' + count_new_images).val(selection.y1);
								$('#y2_new_' + count_new_images).val(selection.y2);
							}
							});							
            
        },
        'onAllComplete' : function(event, data){ // Срабатывает когда все загрузки завершены
                          var string   = 'Загружено файлов: '                      + data.filesUploaded       +'\n';
                              string  += 'Ошибок: '                                + data.errors              +'\n';
                              string  += 'Всего загружено kбайт: '                 + data.allBytesLoaded/1024 +'\n';   
                          
                              $('#info,#info2').fadeOut(5000, function() { $('#info,#info2').html('');});  //Плавно прячем информационные блоки и затем очищаем их           
        }

                
        
	});
    //Удаление изображений
	
	$('.cont_img :button[id^=del]').click(function (){
		//Получаем див, в котором была нажата кнопка удалить
		var div_s = $(this).parent().parent();
		//Находим изображение, в полученном диве, и добавляем атрибут rel = 'del'
		$('img', div_s ).attr('rel', 'del');
		$(div_s).remove();
	});
    //Используется для загрузки изображений в 
	//edit_product и add_product    (Конец блока)
    
    
function startLoadingAnimation() // - функция запуска анимации
{
  // найдем элемент с изображением загрузки и уберем невидимость:
  var imgObj = $(".load");
  imgObj.show();
 
  // вычислим в какие координаты нужно поместить изображение загрузки,
  // чтобы оно оказалось в серидине страницы:
  var centerY = $(window).scrollTop() + ($(window).height() + imgObj.height())/2;
  var centerX = $(window).scrollLeft() + ($(window).width() + imgObj.width())/2;
 
  // поменяем координаты изображения на нужные:
  imgObj.offset({top:centerY, left:centerX});
}
 
function stopLoadingAnimation() // - функция останавливающая анимацию
{
  $(".load").hide();
}    
 
// Удаление товара 
$(".del_tovar").click(function (e){
	var res = confirm("Подтвердите удаление работы?");
	if(!res) return false;
	
	startLoadingAnimation();
	
	var goods_id = $(this).attr("rel"); // получаем id удаляемой записи
	
	$.ajax({
		url: "./",
		type: "POST",
		data: {ajax:'ajax', del_product:'del_product', goods_id: goods_id},
		success: function(data){
			var res = JSON.parse(data);
			if(res.answer != "OK"){
				stopLoadingAnimation();
				alert(res.answer);
				return(false);
			} else {
				//Если удаление успешо, скрываем строку таблицы
				$("#tr_" + goods_id).remove();
			}

			stopLoadingAnimation();
		},
		error: function(){
			alert("Error");
		}
	});	
	
	
	}
)

//Для главной страницы устанавливаем высоту блоков по васоте работы с наименованиями.
var height_title_block = $(".div_g").height();
$(".div_title_p").height(height_title_block);
$(".div_title_r").height(height_title_block);
    
    
    
    
    
    
    
    
});