<style>
.icons_inventory:checked+label {
    background-color: #cc0000;
    border-radius: 50%;
}
</style>
<div class="modal-content animated fadeInDown" style="border-radius:20px;">
    <form action="<?php echo base_url();?>admin/membership_plans/edit/<?php echo $param2; ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-user-2-add"></i> Editar Plan</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <?php 
                    $memebership_plans = $this->db->get_where("plans",array("plans_id"=> base64_decode($param2)))->result_array();
                    foreach($memebership_plans as $row): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group date-time-picker m-b-15">
                            <label for="simpleinvput">Nombre del plan:<span style="color:red">*</span></label>
                            <input type="text" name="name" value="<?php echo $row["name"]; ?>" required="" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Descripción:<span style="color:red">*</span></label>
                            <textarea type="text" style="border: 1px solid #198cff8f;" name="description" class="form-control" required><?php echo $row["description"]; ?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Días:<span style="color:red">*</span></label>
                            <input type="number" name="days" value="<?php echo $row["days"]; ?>" required="" class="form-control">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Editar</button>
        </div>
    </form>
</div>
