<link href="<?php echo base_url(); ?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<?php include "navigation_memberships.php"; ?>

<div id="main-content">
    <div class="todo-content conts">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <h4 class="todo-content-header">
                        <i class="batch-icon-arrow-right"></i><span> Registrar Nuevo Plan: <?php echo $this->db->get_where("category_entity",array("category_entity_id"=>$type))->row()->name; ?></span>
                    </h4>
                </div>
            </div>
        </div><br>
        <form action="<?php echo base_url();?>admin/membership_plans/create" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Nombre del plan:<span style="color:red">*</span></label>
                                    <input type="text" name="name" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Descripción:<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="description" class="form-control" required></textarea>
                                </div>
                            </div>
                            <?php if($membership_id == ""): ?>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Seleccione membrecía:<span style="color:red">*</span></label>
                                    <select class="itemName form-control select2 " style="border: 1px solid #198cff8f; width:100%; " id="membership_id" name="membership_id" >
                                        <option value="">Seleccionar</option>
                                        <?php                                                
                                        $membership = $this->db->get("membership")->result_array();
                                        foreach($membership as $in): ?>
                                        <option value="<?php echo $in['membership_id'];?>"><?php echo $in['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <?php else: ?>
                                <input type="hidden" value="<?php echo $membership_id?>" name="membership_id">
                            <?php endif; ?>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Días:<span style="color:red">*</span></label>
                                    <input type="text" name="days" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Precio:<span style="color:red">*</span></label>
                                    <input type="text" name="price" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                <button class="btn btn-primary" >Registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

$(function() {
    'use strict';
    $('.itemName').select2();
    $('.select22').select2();
    $("#applyDate").trigger("change");
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});

</script>