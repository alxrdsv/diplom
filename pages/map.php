

<script src="https://api-maps.yandex.ru/2.1/?apikey=84314dca-6af9-430d-b2e5-1faac3126fa8&lang=ru_RU" type="text/javascript"></script>
<?php
    $mysqli = new mysqli("localhost", "root", "123", "bd");
?>

 
<!-- контейнер для карты -->
<div id="map" class="map"></div>
 

<!-- Создаём карту -->
<script type="text/javascript">

    // Функция ymaps.ready() будет вызвана, когда
    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);

    function init () {
    var map = new ymaps.Map('map', {
            center: [55.91, 37.81],
            zoom: 11,
            controls: []
        }),

        /////////////////// Создадим собственный макет выпадающего списка /////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ListBoxLayout = ymaps.templateLayoutFactory.createClass(
            "<button id='my-listbox-header' class='btn btn-success dropdown-toggle' data-toggle='dropdown'>" +
                "{{data.title}} <span class='caret'></span>" +
            "</button>" +
            // Этот элемент будет служить контейнером для элементов списка.
            // В зависимости от того, свернут или развернут список, этот контейнер будет
            // скрываться или показываться вместе с дочерними элементами.
            "<ul id='my-listbox'" +
                " class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu'" +
                " style='display: {% if state.expanded %}block{% else %}none{% endif %};'></ul>", {

            build: function() {
                // Вызываем метод build родительского класса перед выполнением
                // дополнительных действий.
                ListBoxLayout.superclass.build.call(this);

                this.childContainerElement = $('#my-listbox').get(0);
                // Генерируем специальное событие, оповещающее элемент управления
                // о смене контейнера дочерних элементов.
                this.events.fire('childcontainerchange', {
                    newChildContainerElement: this.childContainerElement,
                    oldChildContainerElement: null
                });
            },

            // Переопределяем интерфейсный метод, возвращающий ссылку на
            // контейнер дочерних элементов.
            getChildContainerElement: function () {
                return this.childContainerElement;
            },

            clear: function () {
                // Заставим элемент управления перед очисткой макета
                // откреплять дочерние элементы от родительского.
                // Это защитит нас от неожиданных ошибок,
                // связанных с уничтожением dom-элементов в ранних версиях ie.
                this.events.fire('childcontainerchange', {
                    newChildContainerElement: null,
                    oldChildContainerElement: this.childContainerElement
                });
                this.childContainerElement = null;
                // Вызываем метод clear родительского класса после выполнения
                // дополнительных действий.
                ListBoxLayout.superclass.clear.call(this);
            }
        }),

        // Также создадим макет для отдельного элемента списка.
        ListBoxItemLayout = ymaps.templateLayoutFactory.createClass(
            "<li><a>{{data.content}}</a></li>"
        ),

        // Создадим пункты выпадающего списка
        listBoxItems = [
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Ивантеевка',
                    center: [55.971718, 37.924338],
                    zoom: 14
                }
            }),
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Королев',
                    center: [55.922212, 37.854629],
                    zoom: 14
                }
            }),
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Монино',
                    center: [55.839289, 38.195342],
                    zoom: 14
                }
            }),
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Мытищи',
                    center: [55.910483, 37.736402],
                    zoom: 13
                }
            }),
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Пушкино',
                    center: [56.011182, 37.847047],
                    zoom: 14
                }
            }),
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Фрязево',
                    center: [55.733102, 38.465896],
                    zoom: 14
                }
            }),
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Фрязино',
                    center: [55.957938, 38.052339],
                    zoom: 14
                }
            }),
            new ymaps.control.ListBoxItem({
                data: {
                    content: 'Щелково',
                    center: [55.920875, 37.991622],
                    zoom: 14
                }
            }),  
        ],

        // Теперь создадим список, содержащий пункты
        listBox = new ymaps.control.ListBox({
                items: listBoxItems,
                data: {
                    title: 'Выберите город'
                },
                options: {
                    // С помощью опций можно задать как макет непосредственно для списка,
                    layout: ListBoxLayout,
                    // так и макет для дочерних элементов списка. Для задания опций дочерних
                    // элементов через родительский элемент необходимо добавлять префикс
                    // 'item' к названиям опций.
                    itemLayout: ListBoxItemLayout
                }
            });

        listBox.events.add('click', function (e) {
            // Получаем ссылку на объект, по которому кликнули.
            // События элементов списка пропагируются
            // и их можно слушать на родительском элементе.
            var item = e.get('target');
            // Клик на заголовке выпадающего списка обрабатывать не надо.
            if (item != listBox) {
                map.setCenter(
                    item.data.get('center'),
                    item.data.get('zoom')
                );
            }
        });

    map.controls.add(listBox, {float: 'left'});




    ////////////////////Создаем метки на карте////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //создание кластеров
    var clusterer = new ymaps.Clusterer({
            preset: 'islands#invertedVioletClusterIcons',
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        });

        //функция изменения цвета при наведении на метку или кластер
        clusterer.events
        // Можно слушать сразу несколько событий, указывая их имена в массиве.
        .add(['mouseenter', 'mouseleave'], function (e) {
            var target = e.get('target'),
                type = e.get('type');
            if (typeof target.getGeoObjects != 'undefined') {
                // Событие произошло на кластере.
                if (type == 'mouseenter') {
                    target.options.set('preset', 'islands#invertedPinkClusterIcons');
                } else {
                    target.options.set('preset', 'islands#invertedVioletClusterIcons');
                }
            } else {
                // Событие произошло на геообъекте.
                if (type == 'mouseenter') {
                    target.options.set('preset', 'islands#pinkIcon');
                } else {
                    target.options.set('preset', 'islands#violetIcon');
                }
            }
        });

        //создание массива гео-объектов
        geoObjects = [];
        <?php $result = $mysqli->query("SELECT * FROM precinct"); ?>

        var placemarks = [<?php while($row = $result->fetch_assoc()) {
        $lat = $row["lat"];
        $lon = $row["lon"];
        $id = $row["id"];
        $name = $row["name"];
        $address = "г. " . $row["town"] . ", ул. " . $row["street"] . ", д. " . $row["house"];
        echo "{ latitude: $lat, longitude: $lon, hintContent: '№ $id', balloonContent: '$name. Адрес: $address' },";
        } ?>];

        //обработчик гео-объектов
        for (var i=0; i < placemarks.length; i++) {
           geoObjects[i] = new ymaps.Placemark(
			[placemarks[i].latitude, placemarks[i].longitude],  {
				hintContent: placemarks[i].hintContent,
	    		balloonContent: placemarks[i].balloonContent
           },
           {preset: 'islands#violetIcon'});
       }


////////////////////Выводим список меток////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       /* menu = $('<ul class="menu"/>');

        for (var i = 0, l = placemarks.length; i < l; i++) {
            createMenu(placemarks[i]);
        }

        function createMenu (listmenu) {
            // Пункт меню.
            var menuItem = $('<li><a href="#">' + <?php echo '{№ $id($town)}' ?>+ '</a></li>'),
            // Коллекция для геообъектов группы.
            collection = new ymaps.GeoObjectCollection(null, { preset: group.style });

            // Добавляем коллекцию на карту.
            myMap.geoObjects.add(collection);

            // При клике по пункту подменю открываем/закрываем баллун у метки.
                .find('a')
                .bind('click', function () {
                    if (!placemark.balloon.isOpen()) {
                        placemark.balloon.open();
                    } else {
                        placemark.balloon.close();
                    }
                    return false;
                });
        };

        menu.appendTo($('body'));*/

        //вывод меток и кластеров на карту
        map.geoObjects.add(clusterer); 
        clusterer.add(geoObjects);
}	
</script>

<div id="maplist">

    <?php
		$sql = mysqli_query($link, 'SELECT `id` FROM `precinct`');
		while ($result = mysqli_fetch_array($sql)) {
            echo "<ul>
            <li>{$result['id']} 
            </li>
        	</ul>";}

    ?>
              
</div>