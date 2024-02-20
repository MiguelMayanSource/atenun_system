<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Importar productos desde excel</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>admin/inventory_products/product_import/<?php echo  $param2;?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="inventory_id" value="<?php echo $param2;?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <a class="btn btn-info text-white btn-lg" href="<?php echo base_url();?>admin/download_example/products" style="width:100%;"><i class="picons-thin-icon-thin-0123_download_cloud_file_sync"></i> Descargar formato</a>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="file" name="files" required="">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Importar</button>
        </div>
    </form>
</div>
