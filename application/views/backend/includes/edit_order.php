<?php  $medic_order = $this->db->get_where('medic_order',array('medic_order_id'=>$medic_order_id))->row(); ?>
<h5 class="panel-content-title">Order médica</h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-md-12">
        <div class="row" style="overflow-y:auto">
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <input type="datetime-local" class="form-control" name="order_date" id="order_date" placeholder="Fecha" value="<?php echo $medic_order->date;?>" onfocus="this.showPicker()">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <textarea type="text" class="form-control med" placeholder="Medicamento" autocomplete="off" id="order_med"><?php echo $medic_order->order;?></textarea>
                </div>
            </div>
            <hr>
        </div>
        <hr>
        <div class="col-sm-12" style="margin-top:10px;">
            <a class="btn btn-danger" style="margin-left:10px;" href="javascript:void(0)" onclick="load_view('patient_order','orders',{'patient_id':<?php echo $medic_order->patient_id;?>})">Terminar</a>
            <a class="btn btn-success float-right" style="margin-left:10px;" target="_blank" href="<?php echo base_url().$this->session->userdata('login_type');?>/appointment_details/order_details/<?php echo $medic_order_id;?>">Imprimir orden</a>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    if ($('#order_med').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.height = 500;
        var editor = CKEDITOR.replace('order_med', {
            extraPlugins: 'autogrow,justify'
        });
        editor.on('instanceReady', function() {
            this.document.on("keyup", function() {
                console.log(editor.getData())
                save_content({
                    'table': 'medic_order',
                    'code': '<?php echo base64_encode($medic_order_id); ?>',
                    'content': editor.getData(),
                    'date': $('input[name="order_date"]').val(),
                    'type': 0
                });
            });
        });

        $('input[name="order_date"]').on('change', function() {
            save_content({
                'table': 'medic_order',
                'code': '<?php echo $medic_order; ?>',
                'content': editor.getData(),
                'date': $('input[name="order_date"]').val(),
                'type': 0
            });
        });
    }
})
</script>