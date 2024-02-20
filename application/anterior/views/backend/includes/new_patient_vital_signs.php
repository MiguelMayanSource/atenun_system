<?php  $vs = $this->db->get('vital_sign')->num_rows()+1;?>
<h5 class="panel-content-title">Registrar signos vitales<a href="javascript:void(0)" onclick="load_view('new_nurse_note','nurse_notes',{'stabilitation_id':stabilitation_id})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Nueva nota</a></h5>
<span class="app-divider2"></span>
<div class="row" style="    font-size: 12px;">

    <div class="col-sm-12">
        <div class="form-group">
            <b>Peso:(lbs)</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('w','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <b>Altura:(cm)</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('t','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <b>IMC:</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('imc','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <b>Temp:</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('temp','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <b>FR:</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('fr','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <b>FC:</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('fc','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <b>PA:</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('pa','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <b>SO2:</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('so2','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <b>Glucometría:</b>
            <input class="form-control" type="number" step="any" onchange="updateConsulta('gl','<?php echo  $vs; ?>',this.value)"></input>
        </div>
    </div>
    <a class="btn btn-danger" style="margin-left:10px;" href="javascript:void(0)" onclick="load_view('patient_vital_signs','vitals',{'patient_id':patient_id})">Terminar</a>
</div>

<script>
function updateConsulta(cl, _id, text) {
    console.log(cl);
    console.log(_id);
    console.log(text);
    $.ajax({
        url: "<?php echo base_url(); ?>admin/patient_app",
        type: "post",
        data: {
            'cl': cl,
            'id': <?php echo $vs; ?>,
            'patient_id': <?php echo $patient_id; ?>,
            'value': text,
        },
        success: function(response) {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'success',
                title: 'Guardado'
            })
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}
</script>