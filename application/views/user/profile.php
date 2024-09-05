<?php  
//  date_default_timezone_set('Europe/London');
// $datetime = new DateTime(date('Y-m-d H:i:s'));
// echo $datetime->format('Y-m-d H:i:s');  ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendor/dropify/css/dropify.min.css">
<script src="<?=base_url()?>assets/vendor/dropify/js/dropify.min.js"></script>
<div class="card card-body account-right">
    <div class="widget">
        <div class="section-header">
            <h4 class="fw-500 mb-0" > 
            My Profile
            </h4>
        </div>
        <form action="<?= $edit_url ?>" class="profile-form" autocomplete="off">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">Profile <span class="required">*</span></label>
                        <input class="form-control border-form-control dropify" data-allowed-file-extensions="jpg png jpeg" data-default-file="<?= @$user->photo ? IMGS_URL.$user->photo : '' ?>" data-show-remove="false" name="photo" type="file" >
                        <input type="hidden" name="old_photo" value="<?= @$user->photo ?>" />
                        <input type="hidden" name="uid" value="<?= @$user->id ?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" value="<?= @$user->fname ?>" name="fname" class="form-control" placeholder="First Name">
                        <span class="fname text-danger" required></span>
                    </div>
                    
                </div>
                <div class="col-sm-6">
                     <div class="form-group">
                        <input type="text" value="<?= @$user->lname ?>" name="lname" class="form-control" placeholder="Last Name" required>
                        <span class="lname text-danger"></span>
                    </div>
                 </div>
            </div>
            <div class="row">
            <div class="col-sm-4">
                    <div class="form-group">
                        <input type="number" value="<?= @$user->mobile ?>" name="mobile" class="form-control" placeholder="Mobile" required>
                         <span class="mobile text-danger"></span>
                    </div>                   
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" value="<?= @$user->email ?>" name="email" class="form-control" placeholder="Email" required>
                         <span class="email text-danger"></span>
                    </div>                   
                </div>
                <div class="col-sm-4">
                    <div class="form-group">                        
                        <input type="date" value="<?= @date('Y-m-d', strtotime(@$user->dob)) ?>" name="dob" class="form-control" >
                         <span class="dob text-danger"></span>
                    </div>                   
                </div>
                
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        
                        <div class="d-flex justify-content-center">
                            <label class="<?= (@$user->gender == "Male") ? "active" : '' ?>">
                            <input type="radio" name="gender" value="Male" <?= (@$user->gender == "Male") ? "checked" : '' ?> id="male" /> Male
                            </label>
                            <label class="<?= (@$user->gender == "Female") ? "active" : '' ?>">
                            <input type="radio" name="gender" value="Female" <?= (@$user->gender == "Female") ? "checked" : '' ?> id="female" /> Female
                            </label>
                            <label class="<?= (@$user->gender == "Others") ? "active" : '' ?>">
                            <input type="radio" name="gender" value="Others" <?= (@$user->gender == "Others") ? "active" : '' ?> id="others" /> Others
                            </label>
                        </div>
                        <span class="gender text-danger"></span>
                   
                    </div>
                </div> -->
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-solid btn-fill-out btn-block hover-up"> Save </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
      $(".profile-form").validate({
            rules : {
                mobile :{
                    minlength: 10,
                    maxlength: 10,
                },
            },
            messages : {
                mobile:{
                    minlength: 'Number should be 10 digit.',
                    maxlength: 'Number should be 10 digit.',
                }
            }
        });
    $(document).ready(function(){
        $(".dropify").dropify();

        $('body').on('submit', '.profile-form', function(e){
            e.preventDefault();
            if( $('.profile-form').valid() )
            {
            let frm = $(this);

            let url = frm.attr('action');
            let btn = frm.find('button[type=submit]');
            let fname = frm.find('input[name=fname]').val();
            let lname = frm.find('input[name=lname]').val();
            let email = frm.find('input[name=email]').val();
            let dob = frm.find('input[name=dob]').val();
            let mobile = frm.find('input[name=mobile]').val();
            // let gender = frm.find('input[name=gender]:checked').val();
            let old_phto = frm.find('input[name=old_photo]').val();
            let uid = frm.find('input[name=uid]').val();

            if( !fname )
            {
                frm.find('span.fname').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter First Name');
                return false;
            }else{
                frm.find('span.fname').html('');
            }
            if( !lname )
            {
                frm.find('span.lname').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter Last Name');
                return false;
            }else{
                frm.find('span.lname').html('');
            }
            if( !email )
            {
                frm.find('span.email').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter Email');
                return false;
            }else{
                frm.find('span.email').html('');
            }            
            /*if( !dob )
            {
                frm.find('span.dob').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter Date of Birth');
                return false;
            }else{
                dob = new Date(dob);
                var today = new Date();
                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                if (age < 18) {
                    frm.find('span.dob').html('<i class="fa fa-times text-danger"></i>&nbsp; Member is not valid. Above 18 years age require.');
                    return false;
                }
                else{
                    frm.find('span.dob').html('');
                }                
            }*/
            // if( !gender )
            // {
            //     frm.find('span.gender').html('<i class="fas fa-times text-danger"></i>&nbsp; Please Select Gender');
            //     return false;
            // }else{
            //     frm.find('span.gender').html('');
            // }

            let formdata = new FormData(frm[0]);

            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                // dataType: 'json',
                beforeSend: function() {
                    btn.attr("disabled", true);
                    btn.text("Please wait...");
                }, 
                success: function(response) {
                    // console.log(response);
                    toastr.success('Profile Updated!');
                    window.location.reload();
                },
                error: function (response) {
                    btn.removeAttr("disabled");
                    btn.html("Save");
                    toastr.error('Please try again!');
                }
            });
        }
            return false;
        });
    });
</script>