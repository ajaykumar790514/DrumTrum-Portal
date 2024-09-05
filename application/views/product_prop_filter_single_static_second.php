<?php
$i = 1;
foreach($props_id as $row):
    $tmp=array();
    if (!empty($row)):
     if($i==$level):                                
?>
    <div class="form-group">
        <h6 class="product-title"><?= $row['name']; ?></h6>
        <div>
       
            <ul>
                <?php 
                // print_r($props_master_id);            
                $flag=0;
                //print_r($product_selectable_props);
                foreach($dataPropsValueNext as $rowArr):
                    foreach($rowArr as $row2):
                    if ($row['id'] == $row2->props_id):
                 
                    $prod_id = json_encode($pid_all);
                    $props_all_id = json_encode($props_id_all);
                if(!in_array($row2->select_value,$tmp)):  
                    if($row2->qty>0):
                ?>
                <li class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }
                        
                ?>">
                <button type="button" class="prop_btn" onClick='loadPropsSecondLevel(this, <?= $row2->product_id; ?>)'><?= $row2->select_value; ?></button></li>
                <?php
                else: ?>
                <li class="inactive">
                <button type="button" class="prop_btn" style="border:none"><?= $row2->select_value; ?></button></li>
                <?php
                endif;    
                endif;
                array_push($tmp,$row2->select_value);
                $flag=1;
                endif;
                endforeach;
                endforeach;
                ?>
            </ul>
        </div>
    </div>
    
<?php
endif;
 $i++;
endif;
endforeach;
?>





