<div class="row">
<?php 
foreach($addresses as $address){ 
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
<div class="col-lg-12 mt-2" id="<?=$address->id?>">
    <div class="card mb-lg-0">
        <div class="card-header">
        <div class="row">
             <div class="col-7">
            <h5 class="mb-0"><?= $address->contact_name; ?></h5>
             </div>
             <div class="col-5">
            <button onclick="closeAddress()" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="btn mb-2 btn-solid2 <?= ($address->is_default==1) ? 'btn-success' : 'bg-dark text-white' ?> delivery-btn" value="<?= $address->id ?>" style="cursor: pointer; padding: 4px 7px;font-size: 0.5rem;float-right">Deliver Here</button>
            <div class="mr-4"><?= $address->nickname; ?><?= $nickname_icon; ?></div>
             </div>
        </div>
        </div>

        <div class="card-body">
           <address><?= $address->house_no.' '.$address->address_line_2.' '.$address->address_line_3.' '.$address->city.' '.$states->name.' '.$address->country.' , '.$address->pincode ; ?></address>
            <p><span class="text-dark">Landmark: </span><?= $address->landmark ?></p>
            <p><span class="text-dark">Phone: </span><?= $address->contact; ?></p>
             <a data-bs-toggle="modal" data-bs-target="#add-address-modal" data-whatever="Edit Delievery Address" href="javascript:void(0)" data-url="<?=$edit_addr_url?><?=$address->id?>" class="btn-small text-danger mr-4 "><i class="fi-rs-edit"></i> Edit</a>
            <hr>
           
        </div>
    </div>
</div>
<?php } ?>
<div class="col-lg-12 pb-4 mt-2">
    <a data-bs-toggle="modal" data-bs-target="#add-address-modal" data-bs-whatever="Add Delievery Address" data-url="<?=$edit_addr_url?>" href="javascript:void(0);" >
        <div class="bg-light border rounded  mb-3  shadow-sm text-center h-100 d-flex align-items-center">
            <h6 class="text-center m-0 w-100"><i class="fi-rs-add mb-5"></i><br><br>Add New Address</h6>
        </div>
    </a>
</div>
</div>