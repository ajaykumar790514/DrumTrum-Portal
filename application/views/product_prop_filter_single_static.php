<?php
//one thing remainig if qty is 0 in color code for single level then color needs to be disable
$i = 0;
$selected_prop_value_id="";
foreach($props_id as $row):
    $tmp=array();
    if (!empty($row)):
        $i++;                             
?>
    <div class="form-group">
        <h6 class="product-title"><?= $row['name']; ?></h6>
        <div>
            <?php if($row['view_type']=='color'): ?>
            <ul class="color-variant">
                <?php 
                // print_r($props_master_id);            
                $flag=0;
                //print_r($product_selectable_props);
                foreach($product_selectable_props as $rowArr):
                    foreach($rowArr as $row2):
                    if ($row['id'] == $row2->props_id):
                 
                    $prods_all_id = json_encode($pid_all);
                    $props_all_id = json_encode($props_id_all);
                    
                if(!in_array($row2->select_value,$tmp)):    
                   if(count($props_id)>1):
                    if($row2->colorcode!=""):
                        
                ?>
                <li onClick='loadPropsLevel(this, <?= $prods_all_id; ?>, "<?=$row2->select_id; ?>", <?= $props_all_id; ?>)' style="background-color:<?=$row2->colorcode?>" class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }
                        
                ?>"></li>
               
                <?php
                    else: ?>
                         <li style="background: none !important;" onClick='loadPropsLevel(this, <?= $prods_all_id; ?>, "<?=$row2->select_id; ?>", <?= $props_all_id; ?>)' class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }
                        
                ?>">
                       <span style="padding:5px"><?= $row2->select_value; ?></span>
                         </li>
                <?php
                endif; 
                else:
                if($row2->colorcode!=""):
                        
                ?>
                <li onClick='loadPropsSecondLevel(this, <?= $row2->product_id; ?>)' style="background-color:<?=$row2->colorcode?>" class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }
                        
                ?>"></li>
               
                <?php
                    else: ?>
                         <li style="background: none !important;" onClick='loadPropsSecondLevel(this, <?= $row2->product_id; ?>)' class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }
                        
                ?>">
                       <span style="padding:5px"><?= $row2->select_value; ?></span>
                         </li>
                <?php
                endif; 
                endif;
                endif;
                array_push($tmp,$row2->select_value);
                $flag=1;
                endif;
                endforeach;
                endforeach;
                ?>
            </ul>
            <?php
            else:
            ?>
            
            <ul>
                <?php 
                // print_r($props_master_id);            
                $flag=0;
                //print_r($product_selectable_props);
                foreach($product_selectable_props as $rowArr):
                     foreach($rowArr as $row2):
                    if ($row['id'] == $row2->props_id):
                 
                    $prods_all_id = json_encode($pid_all);
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
                            <?php
                             if(count($props_id)>1):
                                 ?>
                                    <button type="button" class="prop_btn" onClick='loadPropsLevel(this, <?= $prods_all_id; ?>, "<?=$row2->select_id; ?>", <?= $props_all_id; ?>)'><?= $row2->select_value; ?></button></li>
                                    <?php
                            else: ?>
                                    <button type="button" class="prop_btn" onClick='loadPropsSecondLevel(this, <?= $row2->product_id; ?>)'><?= $row2->select_value; ?></button></li>
                                    <?php
                            endif;    
                else:
                if(count($props_id)>1):
                ?>
                        <li class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }?>
                         <button type="button" class="prop_btn" onClick='loadPropsLevel(this, <?= $prods_all_id; ?>, "<?=$row2->select_id; ?>", <?= $props_all_id; ?>)'><?= $row2->select_value; ?></button></li>
                    
                <?php
                else:?>
                        <li class="inactive">
                        <button type="button" class="prop_btn" style="border:none"><?= $row2->select_value; ?></button></li>
                <?php
                endif;
                endif;    
                endif;
                array_push($tmp,$row2->select_value);
                $flag=1;
                endif;
                endforeach;
                endforeach;
                ?>
            </ul>
            <?php
            endif;
            ?>
        </div>
    </div>
    
<?php
break;
endif;
endforeach;
?>

<!--for second property loading based on first-->
<script>
 <?php if(count($props_id)>1)
    { 
    ?>
     $.ajax({
            url:"<?= base_url('home/loadPropsSecondLevel/single_page'); ?>",
            method:"POST",
            data:{
                pid:<?=$pid?>,
                pidAll:<?= $prods_all_id; ?>,
                propsIdAll:<?=$props_all_id ?>,
                selected_prop_value_id:<?=$selected_prop_value_id ?>
            },
            //dataType:"JSON",
            success:function(data){
                //alert(data);
                $(".propsSecondLevel").html(data);
            }
        });
       //$(".propsSecondLevel").load('<?=base_url()?>home/loadPropsSecondLevel/<?=$pid?>/<?=$selected_prop_value_id ?>/<?=$props_id_all[0]?>/<?=$props_id_all[1]?>');
    <?php
    }
    ?>
</script>



