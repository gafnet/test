$(document).ready(function() {
	var folder_upload = $("#folder_upload").val();
	$("#uploadify").uploadify({
		'uploader'       : 'uploads/scripts/uploadify.swf', // Относительный путь к файлу uploadify.swf. По умолчанию uploadify.swf
		'script'         : 'uploads/scripts/uploadify.php', // Относительный путь uploadify.php. По умолчанию uploadify.php. Это скрипт - загрузчик. Обязательно посмотрите его
		'cancelImg'      : 'uploads/scripts/cancel.png', // Относительный путь до картинки cancel.png. По умолчанию cancel.png
		'folder'         : folder_upload, // Путь к папке, в которой Вы хотите сохранять загружаемые файлы. 
                                      //Эту настройку можно опустить, тогда папку загрузки необходимо определить в uploadify.php
                                      //Помните! На большистве хостингов, папка, в которую Вы пытаетесь загрузить файлы должна быть доступна на запись, не забудьте выставить соответствующие права 
		'queueID'        : 'fileQueue', // ID элемента, в котором будет показываться очередь загрузки
        'queueSizeLimit' : '10', // Лимит очереди (максим. число загруж файлов). По умолчанию 999
		'auto'           : true, // Если истина, загрузка начнется сразу после выбора файлов
		'multi'          : true,  // Если истина, то разрешена загрузка нескольких файлов
        'fileDesc'       : 'только фотографии jpg', // Текст, который будет внизу появляющегося диалогового окна. Без этого параметра будет написано "Все файлы('.')"
        'fileExt'        : '*.jpg; *.jpeg; *.JPG; *.JPE; *.jpe', // разрешенные к загрузке файлы (остальные вдиалолговом окне будути скрыты)
        'sizeLimit'      : 1500000, // Макс. Размер файла для каждой загрузки (в байтах). Если не указываем, ограничено будет только настройками Вашего сервера
        'simUploadLimit' : 1, // Ограничение на кол-во одновременных закачек. По умолчанию 1. Если значение равно 1, то загружаться будет 1 файл, а остальные будут стоять за ним в очереди. Если 2 - два загружаются, остальные ждут их  и т.д
        'buttonText'     : 'File', // Текст на кнопке. По умолчанию BROWSE. К сожалению русскийтекст не поддрживается
        'buttonImg'      : 'uploads/scripts/btn.png', // Путь до картинки, которая будет служить кнопкой. Компенсирует недостаток предыдущей. Если эта настройка указана, предыдущая будет проигнорирована
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
                              
                              $('#info2').append('<br />Фаил ' + fileObj.name + ' загружен!<br />');                       
            
        },
        'onAllComplete' : function(event, data){ // Срабатывает когда все загрузки завершены
                          var string   = 'Загружено файлов: '                      + data.filesUploaded       +'\n';
                              string  += 'Ошибок: '                                + data.errors              +'\n';
                              string  += 'Всего загружено kбайт: '                 + data.allBytesLoaded/1024 +'\n';   
						  
                          
                              $('#info,#info2').fadeOut(5000, function() { $('#info,#info2').html('');}); // Плавно прячем информационные блоки и затем очищаем их           
        }

                
        
	});

    
});
