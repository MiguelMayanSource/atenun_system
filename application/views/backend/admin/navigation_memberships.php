<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "memberships") echo 'current'; ?>" href="<?php echo base_url();?>admin/memberships">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i></div> <span>Membresias</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "membership_plans" || $page_name == "membership_plans_details" || $page_name == "membership_plans_add") echo 'current'; ?>" href="<?php echo base_url();?>admin/membership_plans">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i></div> <span>Planes</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>