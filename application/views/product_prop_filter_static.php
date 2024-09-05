<?php
$i = 0;
foreach($props_id as $row):
    $tmp=array();
    if (!empty($row)):
        $i++;                             
?>
    <div class="form-group">
        <h6 class="product-title"><?= $row['name']; ?></h6>
        <div>
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
                <li onClick='loadPropsLevelSideBar(this, <?= $prods_all_id; ?>, "<?=$row2->select_id; ?>", <?= $props_all_id; ?>)' style="background-color:<?=$row2->colorcode?>" class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }
                        
                ?>"></li>
               
                <?php
                    else: ?>
                         <li style="background: none !important;" onClick='loadPropsLevelSideBar(this, <?= $prods_all_id; ?>, "<?=$row2->select_id; ?>", <?= $props_all_id; ?>)' class="<?php 
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
                <li onClick='loadPropsSecondLevelSideBar(this, <?= $row2->product_id; ?>)' style="background-color:<?=$row2->colorcode?>" class="<?php 
                        if ($row2->select_id == $row['value_id']) {
                            $selected_prop_value_id=$row['value_id'];
                            echo "active";
                        }
                        
                ?>"></li>
               
                <?php
                    else: ?>
                         <li style="background: none !important;" onClick='loadPropsSecondLevelSideBar(this, <?= $row2->product_id; ?>)' class="<?php 
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
            url:"<?= base_url('home/loadPropsSecondLevel'); ?>",
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
                $(".propsSecondLevelSideBar").html(data);
            }
        });
    //  $(".propsSecondLevel").load('<?=base_url()?>home/loadPropsSecondLevel/<?=$pid?>/<?=$selected_prop_value_id ?>/<?=$props_id_all[0]?>/<?=$props_id_all[1]?>');
    <?php
    }
    ?>
</script>




