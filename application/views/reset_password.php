<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>forget password</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">forget password</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
</header>
<!-- breadcrumb End -->
<main class="main">

    <!--section start-->
    <section class="pwd-page section-b-space ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 pt-5 ">
                    <form class="theme-form" id="forget_form"  id="contact-form">
                        <?php //echo $token ;?>
                        <input type="hidden" name="token" id="token" value="<?php echo $token;?>">
                        <div class="row">
                        <div class="alert alert-success1 alert-success" role="alert" id="show-msg"  style="display: none;">
                        </div>
                        <div class="alert alert-danger" role="alert" id="show-msg"  style="display: none;">
                                </div>
                            <div class="col-md-12">
                                <input type="password" name="newpass" class="form-control"  placeholder="Enter New Password" required>
                            </div>
                            <div class="col-md-12">
                                <input type="password" name="cpass" class="form-control"  placeholder="Enter Confirm Password" required>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-solid" onclick="send_otp(this)">Submit</a>
                        </div>
                    </form>
                    <div id="success-msg" style="display:none;">
                        <h4>Password reset successfully.</h4>
                        <h3>Password send on your email.</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
</main>
<script>
    
    function send_otp(btn) {
        let dataString = $("#forget_form").serialize();
        if( $('#forget_form').valid() ){
            $.ajax({
                url:'<?= base_url() ?>/login/newpass',
                method:'POST',
                data:dataString,
                beforeSend:function(){
                    $(btn).attr("disabled", true).text('Process...');
                },
                success:function(data){
                    if(data ==0){
                    $(btn).removeAttr("disabled").text('Submit');
                    $('.alert-success').fadeIn().html("Password Changed Successfully.");
				     setTimeout(function() {
					$('.alert-success').fadeOut("slow");
				}, 5000 );
                setTimeout(function(){
               $('.alert-success').slideUp('slow').fadeOut(function() {
                  window.location.href = '<?=base_url();?>';
                   });
               }, 2000);
            }else if(data==1)
            {
                  $('.alert-danger').fadeIn().html("Sorry !! invalid url");
				     setTimeout(function() {
					$('.alert-danger').fadeOut("slow");
				}, 5000 );
            }else if(data==2)
            {
                $('.alert-danger').fadeIn().html("Sorry !! Password & Confirm Password Doesn't match.");
				     setTimeout(function() {
					$('.alert-danger').fadeOut("slow");
				}, 5000 );
            }
            else
            {
                $('.alert-danger').fadeIn().html("Sorry !! invalid url.");
				     setTimeout(function() {
					$('.alert-danger').fadeOut("slow");
				}, 5000 );
            }

                }

            });
        }
    }
</script>