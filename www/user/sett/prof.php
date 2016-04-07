<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">
	<?php if($_SESSION['auth']['user']): //Если вошел зарегистрированный пользователь?>
	<h2>Профиль пользовтеля</h2>
    <?php
    
    if(isset($_SESSION['answer'])){
        echo $_SESSION['answer'];
      }
    
    ?>
	

	<?php 
	if ($user) {?>
	<div class="panel panel-default">
		<div class="panel-heading">Мой профиль</div>
		<div class="panel-body">
			<form method="post" class="form-horizontal" enctype="multipart/form-data">
				<a href="/"><img class="logo" src="<?=$user['img']?>" alt="Фото мастера." /></a>
				<input type="file" name="baseimg" />
				<div class="form-group">
					<label for="login" class="col-sm-3 control-label">Логин</label>
					<div class="col-sm-9">
						<label class="control-label"><?=$user['login']?></label>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-3 control-label">*Имя</label>
					<div class="col-sm-9">
						<input type="text" name="name" class="form-control" placeholder="Введите имя" value="<?=$user['name']?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">*Е-mail</label>
					<div class="col-sm-9">
						<input type="text" name="email" class="form-control" placeholder="Введите Е-майл" value="<?=$user['email']?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="phone" class="col-sm-3 control-label">Телефон</label>
					<div class="col-sm-9">
						<input type="text" name="phone" class="form-control" placeholder="Введите телефон" value="<?=$user['phone']?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="address" class="col-sm-3 control-label">Адрес доставки</label>
					<div class="col-sm-9">
						<input id="autocomplete" type="text" name="address" class="form-control" placeholder="Введите адрес доставки" value="<?=$user['address']?>"/>
					</div>
				</div>
<!--     <div id="locationField">
      <input  placeholder="Enter your address"
             onFocus="geolocate()" type="text" value="Данковская ул., Елец, Липецкая обл., Россия, 399777"></input>
    </div>

    <table id="address">
      <tr>
        <td class="label">Street address</td>
        <td class="slimField"><input class="field" id="street_number"
              disabled="true"></input></td>
        <td class="wideField" colspan="2"><input class="field" id="route"
              disabled="true"></input></td>
      </tr>
      <tr>
        <td class="label">City</td>
        <td class="wideField" colspan="3"><input class="field" id="locality"
              disabled="true"></input></td>
      </tr>
      <tr>
        <td class="label">State</td>
        <td class="slimField"><input class="field"
              id="administrative_area_level_1" disabled="true"></input></td>
        <td class="label">Zip code</td>
        <td class="wideField"><input class="field" id="postal_code"
              disabled="true"></input></td>
      </tr>
      <tr>
        <td class="label">Country</td>
        <td class="wideField" colspan="3"><input class="field"
              id="country" disabled="true"></input></td>
      </tr>
    </table>
-->
    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        //autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
		console.log(place);
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

	<script src="https://maps.googleapis.com/maps/api/js?key=<?=API_KEY?>&libraries=places&callback=initAutocomplete"
        async defer></script>

		
				<input type="submit" name="btn_save" class="btn btn-primary btn-block" value="Сохранить" />
			</form>	
			<?php } else {?>
				Не получены данные о пользователе.
			<?php } ?>
		</div> <!-- .panel-body -->	 
	</div> 	<!-- .panel panel-default -->	

	
	<?php else: ?>
		<h3>Для просмотра данной страницы необходимо авторизоваться.</h3>
	<?php endif; ?>
	
	<?php
    
    if(isset($_SESSION['answer'])){
        unset($_SESSION['answer']);
    }
    
    ?>
</div> <!-- .content-txt -->