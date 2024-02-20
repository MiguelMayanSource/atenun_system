<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
    $point_value = $this->db->get_where('settings',array('type'=>'point_value'))->row()->description;
?>

<div id="main-content">
    <?php $insurance = $this->db->get_where('insurance',array('status'=>1,'clinic_id'=>$this->session->userdata('current_clinic')))->result_array();?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card-widget">
                <h4 class="panel-content-title"> Puntos </h4>
                <span class="app-divider2"></span>
                <form action="<?php echo base_url(); ?>admin/points" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">De</label>
                                <div class="input-group date datepicker" id="DoctorPicker12">
                                    <input type="text" name="fecha1" value="01/06/2023" required="" autocomplete="off" class="form-control"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">A</label>
                                <div class="input-group date datepicker" id="DocPicker">
                                    <input type="text" name="fecha2" value="30/06/2023" required="" autocomplete="off" class="form-control"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                            <button style="float:right;" type="submit" class="btn btn-info">Aplicar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-3 col-sm-12 col-lg-3 col-xl-3">

            <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                <div class="label">
                    Puntos utilizados
                </div>
                <div class="label">
                    <?php echo $points = $this->db->query("SELECT SUM(points) as total FROM `patient_points` where type = 0")->row()->total; ?>
                </div>
                <div class="value">Q<?php echo number_format($points * $point_value,2,'.',','); ?></div>
            </a>
        </div>
        <div class="col-3 col-sm-12 col-lg-3 col-xl-3 ">
            <form class=" element-box el-tablo centered trend-in-corner smaller" action="<?php echo base_url(); ?>admin/points/set" method="POST">
               
                    <div class="label">
                        Valor del punto (Q)
                    </div>

                    <div class="value"> <input type="text" name="value" class="form-control" value="<?php echo $point_value ?>"></div>
                    <button style="float:right;" type="submit" class="btn btn-info">Aplicar</button>
                    <div class="label">
                        <br>
                    </div>

               
            </form>
        </div>
        <div class="col-sm-12">
            <div class="card-widget">
                <h4 class="panel-content-title">Movimientos recientes</h4>
                <span class="app-divider2"></span>
                <div class="table-responsive">
                    <table class="table table-padded" id="user_data">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Descripcion</th>
                                <th>Paciente</th>
                                <th>Tipo</th>
                                <th>Puntos</th>
                                <th>Valor</th>
                                <th class="text-right" style="width:200px">Monto
                                    (<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $points = $this->db->get_where('patient_points',array(''))->result_array(); 
                            foreach ($points as $row):
                            ?>
                            <tr>
                                <td><?php echo $row['date'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td>
                                 
                                <?php echo '<div class="user-with-avatar">
                                                <img alt="" src="'.$this->accounts_model->get_photo('patient',$row['patient_id']).'"><span class="smaller lighter">'.$this->accounts_model->short_name('patient',$row['patient_id']).'</span>
                                            </div>';?></td>
                                <td><?php echo $row['type']== 0 ? '<div class="patient-gender-female">Egreso</div>':'<div class="patient-gender-male">Ingreso</div>';?></td>
                                <td><?php echo $row['points']?></td>
                                <td><?php echo $row['value'];?></td>
                                <td class="text-right" style="width:200px">
                                <?php echo number_format($row['points']*$row['value'],2,'.',',');?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

function delete_insurance(insurance_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no puede deshacerse. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/insurance/delete/" + insurance_id;
        }
    })
}
</script>