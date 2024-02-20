<?php $inventory = $this->db->get_Where('inventory',array('inventory_id'=>base64_decode($param2)))->row_array();?>
<style>
.icons_inventory:checked+label {
    background-color: #cc0000;
    border-radius: 50%;
}
</style>
<div class="modal-content animated fadeInDown" style="border-radius:20px;">
    <form action="<?php echo base_url();?>admin/inventory/update_inventory/<?php echo $param2; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="category" value="<?php echo $param2; ?>">
        <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-user-2-add"></i> Agregar</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Nombre<span style="color:red">*</span></label>
                                <input type="text" name="name" required="" class="form-control" value="<?php echo $inventory['name'] ?>">
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Tipo:</label>
                                <div class="input-group">
                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                        <input <?php echo $inventory['type']==0?'checked':'';?> class="radiobutton" type="radio" name="type" id="radio3" value="0">
                                        <label class="radiobutton-label" for="radio3">Externo</label>
                                    </div>
                                    <div class="form-check" style="padding-left: 0px;">
                                        <input <?php echo $inventory['type']==1?'checked':'';?> class="radiobutton" type="radio" name="type" id="radio4" value="1">
                                        <label class="radiobutton-label" for="radio4">Interno</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input class="icons_inventory" type="radio" name="icono" id="icono1" <?php echo $inventory['icon']=='picons-thin-icon-thin-0820_medicine_drugs_ill_pill'?'checked':'';?> value="picons-thin-icon-thin-0820_medicine_drugs_ill_pill" hidden>
                            <label for="icono1" class="navWidget" style="font-size: 30px;    padding: 3px 0px 0px 10px;">
                                <i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i>
                            </label>
                            <input class="icons_inventory" type="radio" name="icono" id="icono2" <?php echo $inventory['icon']=='picons-thin-icon-thin-0811_medicine_health_injection_ill'?'checked':'';?> value="picons-thin-icon-thin-0811_medicine_health_injection_ill" hidden>
                            <label for="icono2" class="navWidget" style="font-size: 30px;    padding: 3px 0px 0px 10px;">
                                <i class="picons-thin-icon-thin-0811_medicine_health_injection_ill"></i>
                            </label>
                            <input class="icons_inventory" type="radio" name="icono" id="icono3" <?php echo $inventory['icon']=='picons-thin-icon-thin-0812_medicine_patch_injury'?'checked':'';?> value="picons-thin-icon-thin-0812_medicine_patch_injury" hidden>
                            <label for="icono3" class="navWidget" style="font-size: 30px;    padding: 3px 0px 0px 10px;">
                                <i class="picons-thin-icon-thin-0812_medicine_patch_injury"></i>
                            </label>
                            <input class="icons_inventory" type="radio" name="icono" id="icon4" <?php echo $inventory['icon']=='picons-thin-icon-thin-0816_microscope_laboratory'?'checked':'';?> value="picons-thin-icon-thin-0816_microscope_laboratory" hidden>
                            <label for="icon4" class="navWidget" style="font-size: 30px;    padding: 3px 0px 0px 10px;">
                                <i class="picons-thin-icon-thin-0816_microscope_laboratory"></i>
                            </label>
                            <input class="icons_inventory" type="radio" name="icono" id="icon5" <?php echo $inventory['icon']=='picons-thin-icon-thin-0817_tube_laboratory_chemistry'?'checked':'';?> value="picons-thin-icon-thin-0817_tube_laboratory_chemistry" hidden>
                            <label for="icon5" class="navWidget" style="font-size: 30px;    padding: 3px 0px 0px 10px;">
                                <i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i>
                            </label>
                            <input class="icons_inventory" type="radio" name="icono" id="icon6" <?php echo $inventory['icon']=='picons-thin-icon-thin-0810_heart_pulse_rate_health'?'checked':'';?> value="picons-thin-icon-thin-0810_heart_pulse_rate_health" hidden>
                            <label for="icon6" class="navWidget" style="font-size: 30px;    padding: 3px 0px 0px 10px;">
                                <i class="picons-thin-icon-thin-0810_heart_pulse_rate_health"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Enviar</button>
        </div>
    </form>
</div>