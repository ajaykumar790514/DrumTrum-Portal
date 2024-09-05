<div class="card">
    <div class="card-header"><h5>Cahnge Password</h5></div>
    <div class="card-body">
        <form class="row" id="change-password">
            <p id="error-msg" class="text-danger"></p>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Old Password</label>                        
                    <input type="password" name="old_pwd" class="form-control" placeholder="Password">                        
                </div>                   
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>New Password</label>                        
                    <input type="password" name="new_pwd" class="form-control" placeholder="Password">                        
                </div>                   
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Confirm Password</label>                        
                    <input type="password" name="conf_pwd" class="form-control" placeholder="Password">                        
                </div>                   
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-solid btn-fill-out btn-block hover-up" onclick="change_password(this)"> Submit </button>
            </div>
        </form>
    </div>
</div>

<script>
    function change_password(btn)
    {
        $(btn).text("Please wait...").attr("disabled");
        let newp = $('input[name="new_pwd"]').val();
        let confp = $('input[name="conf_pwd"]').val();
        if (newp !=confp) {
            $('#error-msg').text("Your password not match.")
            $(btn).text("Submit").removeAttr("disabled");
        }
        let dataString = $("#change-password").serialize();
        $.ajax({
            url: "<?php echo base_url('user/users/update_password'); ?>",
            method: "POST",
            data: dataString,                
            success: function(data){
                $(btn).text("Submit").removeAttr("disabled");
                $('input[name="old_pwd"]').val('');
                $('input[name="new_pwd"]').val('');
                $('input[name="conf_pwd"]').val('');
                //// notification
                $.notify({
                    icon: 'fa fa-check',
                    title: 'Success!',
                    message: 'Password updated.'
                },{
                    element: 'body',
                    position: null,
                    type: "success",
                    allow_dismiss: true,
                    newest_on_top: false,
                    showProgressbar: true,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 5000,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    icon_type: 'class',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
                });
                //// notification end
            },
        });
    }
</script>