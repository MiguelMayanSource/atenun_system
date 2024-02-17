<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Exportar productos a excel</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>admin/inventory_products/product_export/<?php echo  $param2;?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="inventory_id" value="<?php echo $param2;?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label> Categoría </label>
                        <select class="form-control select2" name="category_id" required="" style="width:100%;" onchange="getSubcategory(this.value);">
                            <option value="">Seleccionar categoría</option>
                            <option value="T">Todos</option>
                            <?php 
                            $categories = $this->db->get_where('category',array('status'=>1))->result_array();
                            foreach($categories as $category):?>
                                <option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label> Subcategoria </label>
                        <select class="form-control select2" name="subcategory_id" required="" id="subcategory_id" style="width:100%;">
                            <option value="">Seleccionar categoría</option>
                            <option value="T">Todos</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Exportar</button>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {
    $('.select2').select2();
})

function getSubcategory(id){
    $.ajax({
        url: '<?php echo base_url();?>admin/get_subcategories/'+id,
        type: 'POST',
        success: function(data){
            options = '<option value="T">Todos</option>'+data;
            $('#subcategory_id').html(options);
        },
        error: function(){
            alert('Error');
        }
    })
}
</script>