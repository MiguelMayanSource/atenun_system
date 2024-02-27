<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "patients") echo 'current'; ?>" href="<?php echo base_url();?>admin/patients/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i></div> <span>Seguros</span>
                    </a>
                </li>
                <?php 
                $CategoryEntity = $this->db->get("category_entity")->result_array();
                foreach($CategoryEntity as $row): if($row['status'] == 1): ?>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "entity" && $id_category == $row["category_entity_id"]) echo 'current'; ?>" href="<?php echo base_url();?>admin/entity/<?php echo base64_encode($row["category_entity_id"]); ?>">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div> <span><?php echo $row["name"]; ?></span>
                    </a>
                </li>
                <?php endif; endforeach; ?>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "doctors") echo 'current'; ?>" href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>Modal/popup/modal_entity_add');">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0706_user_profile_add_new"></i></div> <span>Agregar</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>