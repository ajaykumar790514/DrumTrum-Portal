<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
</header>
<!--section start-->
<section class="register-page section-b-space">
    <form method="POST" id="address-register-form">
    <div class="container personal-details">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="title pt-0">Personal Details</h3>                
                <ul id="error-register-form" class="text-danger"></ul>
                <div class="theme-card">
                    <!-- <form method="POST" class="theme-form" id="register-form"> -->
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="email">First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="First Name" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="review">Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Last Name" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="review">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" required="">
                            </div> 
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email" required="">
                            </div>

                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="password" class="form-control" name="pwd" id="password"  placeholder="Enter your password" required="">
                            </div> 

                            <div class="col-md-6">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_pwd"  placeholder="Enter your password" required="">
                            </div>                           
                        </div>
                    </div>
                    <!-- </form> -->

                                     
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5 address-details">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="title pt-0">Address Details</h3>                
                <div class="theme-card">
                    <!-- <form method="POST" class="theme-form" id="address-register-form"> -->
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Search Location</label>
                                    <input id="pac-input" class="form-control rounded-0" type="text" name="address" placeholder="Search Box" required>
                                    <div id="map" style="width: auto; height: 400px;display: none;"></div>  
                                </div>
                            </div>
                            <div class="col-md-6 d-none">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" id="longitude" class="form-control" name="longitude" readonly>
                                </div>
                            </div>

                            <div class="col-md-6 d-none">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" id="latitude" class="form-control" name="latitude" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Address Line 1</label>
                                <input type="text" class="form-control" name="house_no" placeholder="Address Line 1" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Address Line 2</label>
                                <input type="text" class="form-control" name="address_l_2" placeholder="Address Line 2" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Company (Optional)</label>
                                <input type="text" class="form-control" name="floor" placeholder="Company">
                            </div>
                            <!-- <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control" name="contact_name" placeholder="Name" required="">
                            </div>  -->
                            <div class="col-md-6">
                                <label>Mobile Phone Number</label>
                                <input type="number" class="form-control" name="contact" placeholder="Mobile Phone Number" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Town/City</label>
                                <input type="text" class="form-control" name="city" placeholder="Town/City" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Postcode</label>
                                <input type="text" class="form-control" name="pincode" placeholder="Postcode" required="">
                            </div>
                            <div class="col-md-6 select_input">
                                <label>Country</label>
                                <select id="country" name="country" class="form-select form-control" onchange="fetch_state(this);" required="">
                                    <option value="">Select Country</option>                
                                    <option value="United Kingdom" data-id="230">United Kingdom</option>                
                                    <?php //foreach ($country as $row) { ?>
                                        <!-- <option value="<?//= $row->name ?>" data-id="<?//= $row->id ?>">
                                            <?//= $row->name ?>
                                        </option> -->
                                    <?php //} ?>               
                                </select> 
                            </div>     
                            <div class="col-md-6 select_input">
                                <label>County</label>
                                <select class="form-select form-control state" name="state" required="">                                    
                                                
                                </select> 
                            </div> 
                            <!-- <div class="col-md-6">
                                <label>Directions (Optional)</label>
                                <input type="text" class="form-control" name="direction" placeholder="Directions (Optional)">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-2">Nickname</label><br>
                                <input type="radio" class="btn-check" name="nickname" id="home" value="HOME" autocomplete="off" checked>
                                <label class="btn btn-outline-warning" for="home">Home</label>

                                <input type="radio" class="btn-check" name="nickname" id="office" value="OFFICE" autocomplete="off">
                                <label class="btn btn-outline-warning" for="office">Office</label>

                                <input type="radio" class="btn-check" name="nickname" id="others" value="OTHERS" autocomplete="off">
                                <label class="btn btn-outline-warning" for="others">Others</label>
                            </div>   -->                
                        </div>
                        <div class="row">                            
                            <div class="col-md-12">
                                <input type="checkbox" name="newsletter" id="newsletter" value="1" class="mb-0">
                                <label for="newsletter">Sign up for our newsletter</label>
                                <p>Be the first to hear about new products, fantastic special offers, and vaping news. We value your privacy and promise to keep your details safe.</p>
                            </div> 

                            <div class="col-md-12">
                                <input type="checkbox" name="t_and_c" id="t_and_c" value="1" class="mb-0" required>
                                <label for="t_and_c"><a href="<?= POLICY_PATH.'policy/TermsConditions.pdf'; ?>" target="_blank">Terms & Conditions</a></label>
                                <p></p>
                            </div>                            
                            <button type="button" class="btn btn-solid w-auto" onclick="create_account(this)">create Account</button>
                        </div>
                    </div>
                    <!-- </form> -->
                    
                </div>
            </div>
        </div>
    </div>
    </form>
    <div class="container mt-5 otp-details" style="display: none;">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="title pt-0">OTP Details</h3>                
                <div class="theme-card">
                    <form method="POST" class="theme-form" id="register-form-otp">                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="alert alert-success" role="alert">
                                  Please check OTP on your email.
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <label>Enter OTP</label>
                                <input type="number" class="form-control" name="otp" placeholder="OTP" required="">
                                <input type="hidden" name="email" id="otp_email">
                            </div>  
                            <div class="col-md-12">                         
                                <button type="button" class="btn btn-solid w-auto" onclick="verify_otp(this)">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->

<script src="https://maps.google.com/maps/api/js?key=<?= $shop_detail->google_map_key; ?>&libraries=places&callback=initAutocomplete" async defer></script>

<script>
    function fetch_state(elem)
    {
        let country = $('option:selected', elem).attr('data-id');
        $.ajax({
            url: "<?= base_url('login/fetch_state'); ?>",
            method: "POST",
            data: {
                country:country
            },
            success: function(response){
                // console.log(response);
                $("#address-register-form .state").html(response);
            }
        });
        return false;
    }

    $.validator.addMethod("minAge", function(value, element, min) {
        var today = new Date();
        var birthDate = new Date(value);
        var age = today.getFullYear() - birthDate.getFullYear();
     
        if (age > min+1) {
            return true;
        }
     
        var m = today.getMonth() - birthDate.getMonth();
     
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
     
        return age >= min;
    }, "You are not old enough!");

    $("#address-register-form").validate({
        rules : {
            dob: {
                required: true,
                minAge: 18
            },
            email: {
                required: true,
                email: true,
                remote:"<?=$remote?>/email"         
            },
            contact :{
                minlength: 10,
                maxlength: 11
            },
            pwd: {
                required: true,
                minlength: 8,
            },
            confirm_pwd: {
                required: true,
                equalTo: "#password"
            }
        },
        messages : {
            email: {
                remote : "Email already exists!"       
            },
            contact:{
                minlength: 'Number should be 10 digit.',
                maxlength: 'Number should be 11 digit.'
            },
            dob: {
                minAge: "You must be at least 18 years old!"
            } 
        }
    });

    function create_account(btn){
        if( $('#address-register-form').valid() )
        {
            dataString = $("#address-register-form").serialize();
            $.ajax({
                type: "POST",
                url: base_url+"login/generate_otp",
                data: dataString,
                dataType: 'json',
                beforeSend: function() {
                    $(btn).attr("disabled", true);
                    $(btn).text("Generating...");
                },
                success: function(data){ 
                // console.log(data); 
                window.scrollTo(0, 0);            
                  if (data.status == false) {
                    $(btn).text("Create Account").removeAttr("disabled");
                    $("#error-register-form").html('');
                    $("#error-register-form").html(data.error);
                  }

                  if (data.status == true) {
                    $("#error-register-form").html('');
                    $(".personal-details").hide();
                    $(".address-details").hide();
                    $(".otp-details").show();
                    $("#otp_email").val(data.email);               
                  }
                }
            });
        }
        return false;  //stop the actual form post !important!
    }

    function verify_otp(btn){
        dataString = $("#register-form-otp").serialize();
        $.ajax({
            type: "POST",
            url: base_url+"login/verify_otp",
            data: dataString,
            dataType: 'json',
            beforeSend: function() {
                $(btn).attr("disabled", true);
                $(btn).text("Process...");
            },
            success: function(data){ 
            console.log(data);             
              if (data.status == false) {
                $(btn).text("Submit").removeAttr("disabled");
                $("#register-form-otp .alert").removeClass('alert-success').addClass('alert-danger').text('OTP is invalid');
              }

              if (data.status == true) {
                window.location.href = base_url+'profile';                      
              }
            }
        });
        return false;  //stop the actual form post !important!
    }

    var markers = [];

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 55.00002, lng: -2.69752},
      zoom: 7,
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