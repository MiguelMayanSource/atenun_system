<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/staff/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0094_file_table"></i>
                        </div>
                        <span>Equipo</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>doctor/entry/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div>
                        <span>Ingresos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="col-sm-12">
        <div class="title-header">
            <?php $running_year = date('Y');?>
            <?php echo form_open(base_url() . 'doctor/entry_staff/', array('class' => 'form m-b'));?>
            <div class="input-group mb-3">
                <h3 class="module-title">Fecha</h3>
                <input type='date' class="datepicker-here mr-5 ml-5" data-position="bottom left" data-language='en'
                    name="timestamp" value="<?php echo date('Y-m-d');?>" data-multiple-dates-separator="/" />
                <button class="btn btn-success" type="submit" style="float: right;"><span>Ver Asistencia</span></button>
                <input type="hidden" name="year" value="<?php echo $running_year;?>">
            </div>
            <?php echo form_close();?>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card-box">
            <center><br>
                <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Ingreo de colaboradores</h4>
                <br>
                <img src="<?php echo base_url();?>public/uploads/personal.svg" style="width:15%" />
            </center>
        </div>
    </div>
</div> -->
<?php $ingresos = $this->db->get_where('entry', array('date'=>$date));?>
<div id="main-content">
    <?php if($ingresos->num_rows() > 0):?>
    <div class="row">
        <div class="col-sm-12">
            <form id="filters" method="POST" action="<?php echo base_url();?>doctor/entry">
                <div class="form-group">
                    <label>Fecha:</label>
                    <input onchange="submit()" type="date" name="date" class="form-control" required step="any" min="0" value="<?php  $date != "" ? $date:$date = date('Y-m-d'); echo $date;?>">
                </div>
            </form>
        </div>
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Ingresos </h3>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card-box">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>COLABORADOR</th>
                            <th>FECHA</th>
                            <th>HORA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n = 1;
                        foreach($ingresos->result_array() as $row):?>
                        <tr>
                            <td><?php echo $n++;?></td>
                            <td><?php echo $this->crud_model->get_staff($row['staff_id']) ;?>
                            </td>
                            <td><span class="badge badge-info"><?php echo $row['date'];?></span></td>
                            <td><span class="badge badge-info"><?php echo $row['time'];?></span></td>

                        </tr>

                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else:?>
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Ingresos</h3>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card-box">
                <center>
                    <form id="filters" method="POST" action="<?php echo base_url();?>doctor/entry">
                        <div class="form-group"><br>
                            <label>Fecha:</label>
                            <input onchange="submit()" type="date" name="date" class="form-control" required step="any" min="0" value="<?php  $date != "" ? $date:$date = date('Y-m-d'); echo $date;?>">
                        </div>
                    </form>
                    <br>
                    <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no a ingresado ningun personal </h4>
                    <br>
                    <img src="<?php echo base_url();?>public/uploads/personal.svg" style="width:15%" />
                </center>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>