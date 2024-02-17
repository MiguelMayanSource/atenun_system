<style>
.icons_inventory:checked+label {
    background-color: #cc0000;
    border-radius: 50%;
}
</style>
<div class="modal-content animated fadeInDown" style="border-radius:20px;">
    <form action="<?php echo base_url();?>admin/memberships/create_membership" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="category" value="<?php echo $param2; ?>">
        <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-user-2-add"></i> Agregar membresia</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Nombre<span style="color:red">*</span></label>
                                <input type="text" name="name" required="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Descripcion<span style="color:red">*</span></label>
                                <textarea type="text" name="description" required="" class="form-control"></textarea>
                            </div>
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
<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

</script>