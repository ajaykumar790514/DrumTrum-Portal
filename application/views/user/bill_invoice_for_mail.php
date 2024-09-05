<!DOCTYPE html>
<html>
    
    <body style="font-size:10px">
    <table align="center" style="height: 90px; width: 50%; border-collapse: collapse; border-style: solid;" border="1">
  <tbody>
    <tr style="height: 18px;">
      <td colspan="2" style="width: 100%; height: 18px;text-align:center"><b>INVOICE</b></td>
     
    </tr>
    <tr style="height: 18px;">
      <td style="width: 50%; height: 18px;"><img width="150px" id="image" src="<?= IMGS_URL.$invoice->logo; ?>" alt="logo"/></td>
      <td style="width: 50%; height: 18px;">
      
      <div>
      <p class="copy">
                INVOICE NO.: <?= $invoice->orderid ?>
            	</p>
            	<p class="copy">
                DATE: <?= uk_date($invoice->order_date); ?>
            	</p>
            	<p class="copy">
                TIME: <?= uk_time($invoice->order_date); ?>
            	</p>
                </div>
                </td>
      
    </tr>
    <tr style="height: 18px;">
      <td  style="width: 100%; height: 18px;text-align:center" colspan="2"><b><?=$invoice->shop_name;?></b></td>
     
    </tr>
    <tr style="height: 18px;">
      <td colspan="2" style="width: 100%; height: 18px;text-align:center"><p><b>Contact:</b> <?= $invoice->alternate_contact; ?> | <b>Email:</b> <?=$invoice->email; ?></p>
      <p><b>Website:</b> www.30minutesvape.co.uk</p>
      </td>
        
    </tr>
    <tr style="height: 18px;">
      <td colspan="2" style="width: 100%; height: 18px;">
      <div>
          <?php 
            $address = $invoice->cust_house_no.'  '.$invoice->address2.'  '.$invoice->address3.' '.$invoice->cust_state.'  '.$invoice->cust_city.'  '.$invoice->cust_pincode;
            $name = $invoice->contact_name;
            
             if(!empty($invoice->cust_contact))
            {
            	$mobile = $invoice->cust_contact;
            }else{
            	$mobile="NA";
            }
            if(!empty($invoice->instructions))
            {
            	$instructions = $invoice->instructions;
            }else{
            	$instructions="NA";
            }
        
         $billing_address = $invoice->billing_house_no.'  '.$invoice->billing_address_line_2.'  '.$invoice->billing_address_line_3.' '.$invoice->billing_state.'  '.$invoice->billing_city.'  '.$invoice->billing_pincode;
       
        ?>
      <p id="customer-name"><strong>Name - <?= $name; ?></strong></p>
                    <p id="customer-text">Billing Address - <?= $billing_address; ?></p>
                    <p id="customer-text">Delivery Address - <?= $address; ?></p>
                    <p id="customer-text">Phone - <?=$mobile; ?></p>
                    <p id="customer-text">Instructions - <?=$instructions; ?></p>
                    </div>
      </td>
     
    </tr>
    
  </tbody>
</table>
<table style="border-collapse: collapse; width: 50%; height: 36px;" align="center" border="1">
  <tbody>
  <tr style="height: 18px;">
      <th style="width: 40%; height: 18px;">Particular(s)</th>
  
      <th style="width: 15%; height: 18px;">Rate</th>
      <th style="width: 10%; height: 18px;">Qty</th>
      <th style="width: 5%; height: 18px;">Discount</th>
      <th style="width: 25%; height: 18px;">Amount</th>
     
    </tr>
    	<?php 
			$subtotal=$selling_rate = 0;
			foreach($invoice_details as $details):
        if($details->discount_type==1)
        {
          $amount = ($details->selling_rate-$details->offer_applied);
          $discount = $details->selling_rate-$amount;
        }elseif($details->discount_type==0)
        {
            $per = ($details->selling_rate*$details->offer_applied)/100;
             $amount = $details->selling_rate-$per; 
            $discount = $details->offer_applied;
        }
				$selling_rate = $details->total_price;
                $subtotal = $subtotal+$selling_rate;
                $rs = $this->product_model->get_value($details->product_id);

           $inclusive_tax = $details->total_value - ($details->total_value * (100/ (100 + $details->tax_value)));   
            $rate =($details->total_value/$details->item_qty) - $inclusive_tax;
        ?>
          <?php 
           if($invoice->cust_state != $invoice->state_name)
           {
               $igst = $invoice->order_tax;
               $cgst = '0';
               $sgst = '0';
               $igst_per = $invoice->tax_value;
               $cgst_per = '0';
               $sgst_per = '0';
           }
           else
           {
               $igst = '0';
               $cgst = ($invoice->order_tax)/2;
               $sgst = ($invoice->order_tax)/2;
               $igst_per = '0';
               $cgst_per = ($invoice->tax_value)/2;
               $sgst_per = ($invoice->tax_value)/2;
           } 
         
           ?>
        <?php
					$vat_per = $sgst_per + $cgst_per;
					$vat = $sgst + $cgst;
				?>
            <tr align="center" style="height: 18px;">
                <td style="width: 40%; height: 18px;"><?= $details->product_name; ?>  <br>( <span style="color:red"><?php if(!empty($details->flavour)){ echo @$details->flavour.' , ';} ?> <?=@$rs->value;?></span> )</td>
                <td style="width: 15%; height: 18px;"><?= $invoice->currency; ?><?=bcdiv($details->purchase_rate, 1, 2);?></td>
                <td style="width: 10%; height: 18px;"><?= $details->item_qty; ?></td>
                <td style="width: 10%; height: 18px;"><?=round(($discount),2)?><?php if($details->discount_type==1){echo " OFF";}elseif($details->discount_type==0){echo "%";}?></td>
                <td style="width: 25%; height: 18px;"><?= $invoice->currency; ?><?=bcdiv(($selling_rate), 1, 2);?></td>
            </tr>
		  <?php endforeach;?>
   
  </tbody>
</table>
<table style="border-collapse: collapse; width: 50%;" align="center" border="1">
  <tbody>
    <tr>
      <td style="width: 100%;">&nbsp;</td>
    </tr>
  </tbody>
</table>
<table style="border-collapse: collapse; width: 50%; height: 36px;" align="center" border="1">
  <tbody>
  <!-- <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:right"><b> Freight Charges</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?>0.00</td>
    </tr> -->
    <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:center"><b> Delivery Charges</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?>0.00</td>
    </tr>
    <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:center"><b>Total Taxable Value</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?><?=$invoice->total_value-$invoice->order_tax;?></td>
    </tr>
    <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:center"><b>CGST ( @ <?=$cgst_per;?>% )</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?><?=$cgst;?></td>
    </tr>
    <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:center"><b>SGST ( @ <?=$sgst_per;?>% )</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?><?=$sgst;?></td>
    </tr>
    <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:center"><b>IGST ( @ <?=$igst_per;?>% )</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?><?=$igst;?></td>
    </tr>
    
  <!-- <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:right"><b>Total</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?><?=bcdiv(($subtotal), 1, 2);?></td>
      
     
    </tr> -->
   <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:center"><b>Total Savings</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?><?=bcdiv(($invoice->total_savings), 1, 2);?></td>
     
     
    </tr>
    <tr style="height: 18px;">
      <td style="width: 65%; height: 18px;text-align:center"><b>Grand Total (Rounded Off)</b></td>
  
      <td style="width: 35%; height: 18px;text-align:center"><?= $invoice->currency; ?><?=bcdiv($subtotal, 1, 2);?></td>
     
     
    </tr>
   
  </tbody>
</table>
</body>
</html>
