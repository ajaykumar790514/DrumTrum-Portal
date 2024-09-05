
<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>Contact</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
</header>
<!--section start-->
<section class="contact-page section-b-space pb-0">
    <div class="container">
        <div class="row section-b-space">
            <div class="col-lg-7 map">
                <form class="theme-form" id="contact-form">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your name" required="">
                        </div>                        
                        <div class="col-md-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email"  placeholder="Email" required="">
                        </div>
                        <div class="col-md-12">
                            <label for="review">Phone number</label>
                            <input type="text" class="form-control" name="mob" id="mob"  placeholder="Enter your number">
                        </div>
                        <div class="col-md-12">
                            <label for="review">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject"  placeholder="Enter your subject" required="">
                        </div>
                        <div class="col-md-12">
                            <label for="review">Query</label>
                            <textarea class="form-control" name="msg" id="msg" placeholder="Write Your Message" id="exampleFormControlTextarea1" rows="6"></textarea>
                        </div>
                        <div class="g-recaptcha" data-sitekey="<?= $shop_detail->site_key; ?>"></div>
                        <div class="col-md-12 mt-2">
                            <button class="btn btn-solid" type="submit">Send Your Message</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="contact-right">
                    <ul>
<!--
                        <li>
                            <div class="contact-icon"><i class="fa fa-phone" aria-hidden="true"></i>
                                <h6>Contact Us</h6></div>
                            <div class="media-body">
                                <p><?= $shop_detail->contact; ?></p>
                            </div>
                        </li>
-->
                     <li>
                           
                            <div class="media-body">
                                <p><?= $shop_detail->business_name; ?></p>
                            </div>
                        </li>
                       <!--<li>-->
                       <!--     <div class="contact-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>-->
                       <!--         <h6>Reg. Address</h6></div>-->
                       <!--     <div class="media-body">-->
                       <!--         <p>42 Myrtle Drive, Sheffield</p>-->
                       <!--         <p>S2 3HG</p>-->
                       <!--     </div>-->
                       <!-- </li>-->
                        <li>
                            <div class="contact-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                <h6>Reg. Address</h6></div>
                            <div class="media-body">
                                <p><?= $shop_detail->address; ?>-<?= $shop_detail->pin_code; ?></p>
                             
                            </div>
                        </li>
                        <li>
                            <div class="contact-icon"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <h6>Email</h6></div>
                            <div class="media-body">
                                <p><?= $shop_detail->email; ?></p>
                            </div>
                        </li>     
                     <li>
                            <div class="contact-icon"><i class="fa fa-phone" aria-hidden="true"></i>
                                <h6>Phone</h6></div>
                            <div class="media-body">
                                <p>+91-<?= $shop_detail->alternate_contact; ?></p>
                            </div>
                        </li>     
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
    </div>
    <div class="container-fluid map px-0">
        <!--<div id="map" style="width:100%;height:400px;background:grey"></div>  -->
    </div>
</section>
<!--Section ends-->

<script>
    $('body').on('submit', '#contact-form', function(e){
        e.preventDefault();
        let btn = $('.btn');
        // let dataString = $("#contact-form").serialize();
        var name = $('#name').val();
        var email = $('#email').val();
        var mobile = $('#mob').val();
        var subject = $('#subject').val();
        var message = $('#msg').val();

        $(btn).html("Please Wait....");
        $(btn).prop('disabled', true);
         
        $.ajax({
            url:"<?=base_url('login/contact_submit')?>",
            method:"POST",
            data:{
                name: name,
                email: email,
                mob: mobile,
                subject: subject,
                msg: message,
                recaptcha:grecaptcha.getResponse(),
            },
            success:function(data){
                grecaptcha.reset();
                $('.alert').remove();
                if (data == 'SUCCESS') {
                    $("#contact-form input").val('');
                    $("#contact-form textarea").val('');
                    $("#contact-form").append('<div class="alert alert-success mt-3" role="alert">Your message sent successfully</div>');
                } else if (data == 'CAPTCHA_EMPTY') { 
                    $("#contact-form").append('<div class="alert alert-danger mt-3" role="alert">Please verify Recaptcha</div>');           
                } 
                else if (data == 'CAPTCHA_FAILED') {    
                    $("#contact-form").append('<div class="alert alert-danger mt-3" role="alert">Captcha Failed</div>');               
                }

                $(btn).html("Send Your Message");
                $(btn).prop('disabled', false);
            },
        });

    });

    
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!--<script>  -->
<!--function myMap() {  -->
<!--var mapOptions = {  -->
<!--    center: new google.maps.LatLng(<?= $shop_detail->latitude; ?>, <?= $shop_detail->longitude; ?>),  -->
<!--    zoom: 20,  -->
<!--    mapTypeId: google.maps.MapTypeId.ROADMAP  -->
<!--}  -->
<!--var map = new google.maps.Map(document.getElementById("map"), mapOptions);  -->
<!--}  -->
<!--</script>  -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=<?= $shop_detail->google_map_key; ?>&callback=myMap"></script>  -->