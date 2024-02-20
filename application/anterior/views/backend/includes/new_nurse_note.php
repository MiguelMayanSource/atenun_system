<h5 class="panel-content-title">Nueva nota de enfermeria</h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-md-12">
        <div class="row" style="overflow-y:auto">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="datetime-local" class="form-control" name="order_date" id="order_date" placeholder="Fecha" value="<?php echo date('Y-m-d\TH:i');?>" onfocus="this.showPicker()">
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="diet" id="diet" placeholder="Dieta" value="">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <textarea type="text" class="form-control med" placeholder="Observaciones" autocomplete="off" id="order_med"></textarea>
                </div>
            </div>
            <hr>
        </div>
        <hr>
        <div class="col-sm-12" style="margin-top:10px;">
            <a class="btn btn-danger " style="margin-left:10px;" href="javascript:void(0)" onclick="saveNote(this)">Terminar</a>
        </div>
    </div>
</div>
<script>
function saveNote(btn) {
    $(btn).html('Guardando.....')
    save_content({
        'table': 'nurse_note',
        'stabilitation_id': '<?php echo $stabilitation_id; ?>',
        'observations': $('#order_med').val(),
        'date': $('input[name="order_date"]').val(),
        'diet': $('input[name="diet"]').val(),
    });

    load_view('nurse_notes', 'nurse_notes', {
        'stabilitation_id': <?php echo $stabilitation_id?>
    });
}
</script>