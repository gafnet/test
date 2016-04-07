<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">	
    <h2>Регистрация</h2>
    <?php
    
    if(isset($_SESSION['reg']['res'])){
        echo $_SESSION['reg']['res'];
      }
    
    ?>
    <form method="post" action="<?=PATH?>" class="form-horizontal">
		<div class="form-group">
			<label for="login" class="col-sm-3 control-label">*Логин</label>
			<div class="col-sm-9">
				<input type="text" name="login" id="login" class="form-control" placeholder="Введите login" value="<?=htmlspecialchars($_SESSION['reg']['login'])?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="pass" class="col-sm-3 control-label">*Пароль</label>
			<div class="col-sm-9">
				<input type="password" name="pass" class="form-control" placeholder="Введите пароль" />
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label">*Имя</label>
			<div class="col-sm-9">
				<input type="text" name="name" class="form-control" placeholder="Введите имя" value="<?=htmlspecialchars($_SESSION['reg']['name'])?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-3 control-label">*Е-mail</label>
			<div class="col-sm-9">
				<input type="text" name="email" class="form-control" placeholder="Введите Е-майл" value="<?=htmlspecialchars($_SESSION['reg']['email'])?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="col-sm-3 control-label">Телефон</label>
			<div class="col-sm-9">
				<input type="text" name="phone" class="form-control" placeholder="Введите телефон" value="<?=htmlspecialchars($_SESSION['reg']['phone'])?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="col-sm-3 control-label">Адрес доставки</label>
			<div class="col-sm-9">
				<input type="text" id="address" name="address" class="form-control" placeholder="Введите адрес доставки" value="<?=htmlspecialchars($_SESSION['reg']['address'])?>"/>
			</div>
		</div>
				
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
            /** @type {!HTMLInputElement} */(document.getElementById('address')),
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
				
				

        <input type="submit" name="reg" class="btn btn-primary btn-block" value="Зарегистрироваться" />
    </form>	
	<br />
    <p>Поля, отмеченные * - обязательны для заполнения.</p>	
    <?php
    
    if(isset($_SESSION['reg']['res'])){
        unset($_SESSION['reg']);
    }
    
    ?>
    	
</div> <!-- .content-txt -->