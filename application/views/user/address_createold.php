<input type="hidden" name="id" value="<?= @$address->id ?>">
<p id="edit-error-msg"></p>
 <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Search Location</label>
            <input id="pac-input" type="text" name="address" value="<?= @$address->address; ?>" placeholder="Search Box" required>
            <div id="map" style="width: auto; height: 400px;display: none;"></div>  
        </div>
    </div>
    <div class="col-md-6 d-none">
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" id="longitude" name="longitude" value="<?= @$address->longitude; ?>" required readonly>
        </div>
    </div>

    <div class="col-md-6 d-none">
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" id="latitude" name="latitude" value="<?= @$address->latitude; ?>" required readonly>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label>Address Line 1<span class="required">*</span></label>
        <input type="text" name="house_no" value="<?= @$address->house_no; ?>" required placeholder="Address Line 1" />
    </div>    
    <div class="form-group col-md-6">
        <label>Address Line 2</label>
        <input type="text" name="address_l_2" value="<?= @$address->address_line_2; ?>" placeholder="Address Line 2" required="">
    </div>

    <div class="form-group col-sm-6">
        <label>Company</label>
        <input  type="text" name="floor" value="<?= @$address->floor ?>" placeholder="Company" />
    </div>

    <!-- <div class="form-group col-sm-6">
        <label>Apartment / Building Name</label>
        <input type="text" name="apartment_name" value="<?= @$address->apartment_name ?>" placeholder="Apartment / Building" />
    </div> -->

    <!-- <div class="form-group col-md-6">
        <label>Landmark</label>
        <input class="form-control border-form-control" type="text" name="landmark" value="<?= @$address->landmark ?>" placeholder="Landmark" />
    </div> -->

    <div class="form-group col-sm-6">
        <label>Name <span class="required">*</span></label>
        <input  type="text" name="contact_name" value="<?= @$address->contact_name ?>" required placeholder="Contact Person" />
    </div>
    <div class="form-group col-sm-6">
        <label class="control-label">Mobile Phone Number <span class="required">*</span></label>
        <input  type="number" name="contact" value="<?= @$address->contact ?>" required placeholder="Contact Number" />
    </div>
    
    <div class="form-group col-sm-6">
        <label>Town/City <span class="required">*</span></label>
        <input type="text" name="city" value="<?= @$address->city ?>" required>
        <!-- <select class="select2 form-control border-form-control city" name="city" required >
            <option value="<?= @$address->city ?>">
            <?= @$address->city ?>
            </option>
        </select> -->
    </div>
    <div class="form-group col-sm-6">
        <label>Postcode<span class="required">*</span></label>
        <input  type="text" name="pincode" value="<?= @$address->pincode ?>" required />
    </div>
    <div class="form-group col-sm-6">
        <label>Country<span class="required">*</span></label>
        <select id="country" name="country" class="select2 form-select border-form-control" onchange="fetch_state(this)" required>
                <option value="">Select Country</option>                
                <option value="United Kingdom" data-id="230">United Kingdom</option>               
                <?php //foreach ($country as $row) { ?>
                    <!-- <option value="<?//= $row->name ?>" <?php //if($row->name == @$address->country){echo "selected";} ?> data-id="<?//= $row->id ?>">
                        <?//= $row->name ?>
                    </option> -->
                <?php //} ?>               
            </select>
        <!-- <textarea class="form-control border-form-control" name="address" required ><?= @$address->address; ?></textarea> -->
    </div>
    <div class="form-group col-sm-6">
        <label>County <span class="required">*</span></label>
        <select class="select2 form-select border-form-control state" name="state" required >
            <option value="<?= @$address->state ?>"><?= @$address->state ?></option>            
        </select>
    </div>
    <!-- <div class="form-group col-sm-12">
        <label>Directions (Optional)</label>
        <input type="text" name="direction" value="<?= @$address->landmark ?>" placeholder="Directions" />
    </div> -->
    <!-- <div class="form-group mb-0 col-md-12">
        <label for="inputPassword4">Nickname <span class="required">*</span></label>
        <?php 
            $checked =  @$address->id ? '' : 'checked';
            $active =  @$address->id ? '' : 'active';
        ?>
        <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
            <label class="<?= (@$address->nickname == "HOME") ? "active" : $active ?>" for="home">
                <input type="radio" name="nickname" value="HOME" id="home" <?= (@$address->nickname == "HOME") ? "checked" : $checked ?>  required /> Home
            </label>
            <label class="<?= (@$address->nickname == "OFFICE") ? "active" : '' ?>" for="office">
                <input type="radio" name="nickname" value="OFFICE" id="office" <?= (@$address->nickname == "OFFICE") ? "checked" : 'checked' ?> required /> Office
            </label>
            <label class="<?= (@$address->nickname == "OTHERS") ? "active" : '' ?>" for="others">
                <input type="radio" name="nickname" value="OTHERS" id="others" <?= (@$address->nickname == "OTHERS") ? "checked" : '' ?> required /> Others
            </label>
        </div>
    </div> -->

</div>
<script src="https://maps.google.com/maps/api/js?key=<?= $shop_detail->google_map_key; ?>&libraries=places&callback=initAutocomplete" async defer></script>

<script>
    var markers = [];

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13,
      mapTypeId: 'roadmap'
    });

    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    //map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(171, 171),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            var  markers = new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location,
              draggable:true,
             title:"Drag me!"
            });

            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            $('[name=house_no]').val(place.name);
            $('[name=address_l_2]').val(place.name);

            google.maps.event.addListener(markers, 'dragend', function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                $('#latitude').val(lat);
                $('#longitude').val(lng);
            });

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
      map.fitBounds(bounds);
    });
}
</script>