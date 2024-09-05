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
                <div class="col-lg-6 ">
                    <h2></h2>
                    <form class="theme-form" id="forget_form">
                        <div class="row">
                        <div class="alert alert-success1 alert-success" role="alert" id="show-msg"  style="display: none;">
                                </div>
                                <div class="alert alert-danger" role="alert" id="show-msg"  style="display: none;">
                                </div>
                            <div class="col-md-12">
                                <input type="email" name="email" class="form-control"  placeholder="Enter your email for password recovery" required>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-solid" onclick="send_otp(this)">Submit</a>
                        </div>
                    </form>

                    <form class="theme-form" id="forget_form_otp" style="display:none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                  Please check OTP on your email.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="otp" class="form-control"  placeholder="Enter Your OTP" required="">
                            </div>
                            <a href="javascript:void(0)" class="btn btn-solid otp_submit_btn">Submit</a>
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
                url:'<?= base_url() ?>/login/send_reset_link',
                method:'POST',
                data:dataString,
                beforeSend:function(){
                    $(btn).attr("disabled", true).text('Process...');
                },
                success:function(data){
                    if(data=='success'){
                    $(btn).removeAttr("disabled").text('Submit');
                    $('.alert-success1').fadeIn().html("  Password reset link has been sent to your email.");
                     setTimeout(function() {
                    $('.alert-success1').fadeOut("slow");
                }, 5000 );
                setTimeout(function(){
               $('.alert-success').slideUp('slow').fadeOut(function() {
                 });
                }, 5000);
            }else
            {
                $(btn).removeAttr("disabled").text('Submit');
                    $('.alert-danger').fadeIn().html("Sorry!! email dose not exist.");
                     setTimeout(function() {
                    $('.alert-danger').fadeOut("slow");
                }, 5000 );
            }

                }
            });
        }
    }
</script>
<!-- 
<script>
    
    function send_otp(btn) {
        let dataString = $("#forget_form").serialize();
        if( $('#forget_form').valid() ){
            $.ajax({
                url:'<?= base_url() ?>/login/forget_otp',
                method:'POST',
                data:dataString,
                beforeSend:function(){
                    $(btn).attr("disabled", true).text('Process...');
                },
                success:function(data){
                    // console.log(data);
                    let email = data;
                    $(btn).removeAttr("disabled").text('Submit');
                    $("#forget_form").hide();
                    $("#forget_form_otp").show();

                    $(".otp_submit_btn").click(function(){
                        let otp = $("input[name='otp']").val();
                        let btn = $(".otp_submit_btn");
                        $.ajax({
                            url:'<?= base_url() ?>/login/forget_otp_verify',
                            method:'POST',
                            data:{
                                email:email,
                                otp:otp
                            },
                            beforeSend:function(){
                                btn.attr("disabled", true).text('Process...');
                            },
                            success:function(data){
                                console.log(data);
                                if (data == 'success') {
                                    $("#forget_form_otp").hide();
                                    $("#success-msg").show();
                                }else{
                                    $(".alert").removeClass("alert-success").addClass("alert-danger").text("OTP is invalid.");
                                    btn.removeAttr("disabled").text('Submit');
                                }                                                             
                            }
                        });
                    });
                }
            });
        }
    }
</script> -->