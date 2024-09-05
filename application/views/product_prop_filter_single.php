<?php
$i = 0;
foreach($props_master_id as $row):
    $tmp=array();
    if (!empty($row)):
        $i++;
        if ($row[0]->display_type !=1) {
                                                                   
?>
    <div class="form-group">
        <h6 class="product-title"><?= $row[0]->name; ?></h6>
        <div class="size-box <?= $i == 1 ? 'prop-box'.$row[0]->id : 'prop-box'.$row[0]->id; ?>">
            <ul>
                <?php 
                // print_r($props_master_id);            
                $flag=0;
                //print_r($product_selectable_props);
                foreach($product_selectable_props as $rowArr):
                    foreach($rowArr as $row2):
                    if ($row[0]->id == $row2->props_id):
                    
                    $prod_id = json_encode($pid_all);
                    $props_all_id = json_encode($props_id_all);
                if(!in_array($row2->select_value,$tmp)):    
                ?>
                <li class="prop-option-<?= $row2->value; ?> <?php 
                foreach($default_prop as $default_prop_row){ 
                    foreach($default_prop_row as $de_row){ 
                        if ($row2->select_id == $de_row->value_id) {
                            echo "active";
                        }
                    }                        
                }
               
                ?>">
                    <button type="button" class="prop_btn" onclick='select_props_single(this, <?= $prod_id; ?>, "<?= $row2->select_id; ?>", <?= $props_all_id; ?>)'><?= $row2->select_value; ?></button></li>
                <?php
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
}else{
?>
    <div class="form-group">
        <h6 class="product-title"><?= $row[0]->name; ?></h6>
        <div class="size-box <?= $i == 1 ? 'prop-box'.$row[0]->id : 'prop-box'.$row[0]->id; ?>">
            <?php
                $prod_id = json_encode($pid_all);
                $props_all_id = json_encode($props_id_all);
            ?>
            <select class="form-control  form-select" onchange='select_props_single_dropdown(this, <?= $prod_id; ?>, <?= $props_all_id; ?>)'>
                <?php 
                // print_r($props_master_id);            
                $flag=0;
                foreach($product_selectable_props as $rowArr):
                    foreach($rowArr as $row2):
                    if ($row[0]->id == $row2->props_id):
                    
                ?>
                    <option  <?php 
                foreach($default_prop as $default_prop_row){ 
                    foreach($default_prop_row as $de_row){ 
                        if ($row2->select_id == $de_row->value_id) {
                            echo "selected";
                        }
                    }                        
                }
                ?> data-selectid="<?= $row2->select_id; ?>"><?= $row2->select_value; ?></option>

                <?php
                $flag=1;
                endif;
                endforeach;
                endforeach;
                ?>
            </select>
        </div>
    </div>
<?php
}
endif;

endforeach;
?>
