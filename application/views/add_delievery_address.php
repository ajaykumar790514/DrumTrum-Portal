<?php 
foreach($addresses as $address){ 
    if ($address->is_default==1) {
       $states =  $this->home_model->getRow('states',['id'=>$address->state]);
    if($address->nickname == 'HOME')
    {   
        $nickname_icon = '<i class="icofont-ui-home icofont-3x"></i>';
    }else if($address->nickname == 'OFFICE'){
        $nickname_icon = '<i class="icofont-briefcase icofont-3x"></i>';
    }else{
        $nickname_icon = '<i class="icofont-location-pin icofont-3x"></i>';
    }
?>
<div class="col-lg-6 mt-2" id="<?=$address->id?>">
    <div class="card mb-lg-0">
        <div class="card-header">
        <div class="row">
           <div class="col-md-8">
           <h5 class="mb-0 mt-2 fname"><b><?= $address->contact_name; ?></b></h5>
           </div>
           <div class="col-md-4">
           <button type="button" onclick="openAddress()" class="btn btn-sm btn-solid text-center text-white bg-success" style="padding: 6px 8px;font-size:0.8rem"><b>Change</b></button>
           </div>
       </div>
        </div>

        <div class="card-body">
           <span class="del-address"><?= $address->house_no.' '.$address->address_line_2.' '.$address->address_line_3.' '.$address->city.' '.$states->name.' '.$address->country.' , '.$address->pincode ; ?></span>
           <address  style="color: #999999 !important;">Landmark: <span class=" del-landmark text-dark"><?= $address->landmark ?> </span></address>
           <address style="color: #999999 !important;">Phone: <span class="del-phone text-dark"><?= $address->contact; ?> </span></address>
              
       </div>
    </div>
</div>
<?php } } ?>