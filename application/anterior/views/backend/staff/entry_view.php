<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/staff/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0094_file_table"></i>
                        </div>
                        <span>Equipo</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/entry/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div>
                        <span>Ingresos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<br><br>
<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget" style="padding:50px;background: #fff;">
            <?php $running_year = date('Y');?>
            <div class="content-w">
                <div class="conty">
                    <div class="content-i">
                        <div class="content-box">
                            <?php echo form_open(base_url() . 'staff/entry_staff/', array('class' => 'form m-b'));?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-3">
                                        <h3 class="module-title">Fecha</h3>
                                        <input type='date' class="datepicker-here mr-5 ml-5" data-position="bottom left" data-language='en' name="timestamp" value="<?php echo date('Y-m-d');?>" data-multiple-dates-separator="/" />
                                        <button class="btn btn-success" type="submit" style="float: right;"><span>Ver
                                                Asistencia</span></button>
                                        <input type="hidden" name="year" value="<?php echo $running_year;?>">
                                    </div>

                                </div>
                                <input type="hidden" name="year" value="<?php echo $running_year;?>">
                                <div class="col-sm-1">

                                </div>
                            </div>
                            <?php echo form_close();?>
                            <div class="ui-block">
                                <article class="hentry post thumb-full-width">
                                    <div class="post__author author vcard inline-items">
                                        <table class="table" style="color:black; width: 100%; ">
                                            <tr>
                                                <td>
                                                    <img src="<?php echo base_url();?>/assets/images/Recurso1.png" width="100" alt="">
                                                </td>
                                                <td style="word-break: break-all; text-align: left; font-family:  Times, serif;">
                                                    <img src="<?php echo base_url();?>/assets/images/Recurso2.png" width="150" alt="">
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="author-date">
                                            <a class="h6 post__author-name fn" href="javascript:void(0);">Asistencia
                                                <small>(<?php echo date("d/m/Y", $timestamp);?>)</small>.</a>
                                        </div>
                                    </div>
                                    <div class="edu-posts cta-with-media">
                                        <div class="table-responsive">
                                            <?php echo form_open(base_url() . 'staff/entry_staff_update/' . $timestamp); ?>
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="text-white" style="background: #1d71b8;">colaborador
                                                        </th>
                                                        <th class="text-white" style="text-align: center; background: #1d71b8;">
                                                            Estatus</th>
                                                        <th class="text-white" style="text-align: center; background: #1d71b8;">
                                                            Hora</th>
                                                        <th class="text-white" style="text-align: center; background: #1d71b8;">
                                                            Comentario</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                $count = 1;
                                                $select_id = 0;
                                                $attendance = $this->db->get_where('teacher_attendance', array('year' => $running_year, 'timestamp' => $timestamp))->result_array();
                                                foreach ($attendance as $row):
                                            ?>
                                                    <tr>
                                                        <td style="min-width:170px">
                                                            <?php $empleado = $this->db->get_where('staff', array("staff_id"=>$row['teacher_id']))->result_array(); foreach($empleado as $col): echo $col['first_name']." ".$col['last_name'];  endforeach;?>
                                                        </td>
                                                        <td style="text-align: center;" nowrap>
                                                            <center>
                                                                <div class="row">
                                                                    <div class="col-4"> <span class="radio">
                                                                            <h6 data-toggle="tooltip" data-placement="top" data-original-title="Presente">
                                                                                <label><input type="radio" onchange="show_motivo<?php echo $row['teacher_id']?>(this.value)" <?php if ($row['status'] == 1) echo 'checked'; ?> value="1" name="status_<?php echo $row['attendance_id']; ?>"><span class="circle"></span><span class="check"></span></label>
                                                                            </h6>
                                                                        </span></div>
                                                                    <div class="col-4"><span class="radio">
                                                                            <h6 data-toggle="tooltip" data-placement="top" data-original-title="Tarde">
                                                                                <label><input type="radio" onchange="show_motivo<?php echo $row['teacher_id']?>(this.value)" <?php if ($row['status'] == 3) echo 'checked'; ?> value="3" name="status_<?php echo $row['attendance_id']; ?>"><span class="circle"></span><span class="check"></span></label>
                                                                            </h6>
                                                                        </span></div>
                                                                    <div class="col-4"> <span class="radio">
                                                                            <h6 data-toggle="tooltip" data-placement="top" data-original-title="ausente">
                                                                                <label><input type="radio" value="2" onchange="show_motivo<?php echo $row['teacher_id']?>(this.value)" <?php if ($row['status'] == 2) echo 'checked'; ?> name="status_<?php echo $row['attendance_id']; ?>"><span class="circle"></span><span class="check"></span></label>
                                                                            </h6>
                                                                        </span></div>
                                                                </div>
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                <input type="time" require name="hora<?php echo $row['attendance_id']; ?>" value="<?php if ($row["hora"]==''): echo date("H:i"); else: echo $row['hora']; endif;?>">
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                <textarea name="motivo<?php echo $row['attendance_id']; ?>" id="motivo<?php echo $row['teacher_id']?>" cols="30" rows="2"><?php if ($row["motivo"]==''): echo ""; else: echo $row['motivo']; endif;?></textarea>
                                                            </center>
                                                        </td>

                                                    </tr>
                                                    <script type="text/javascript">
                                                    $('#motivo<?php echo $row['teacher_id']?>').show(500);

                                                    function show_motivo<?php echo $row['teacher_id']?>(value) {

                                                        if (value == 2 || value == 3) {
                                                            $('#motivo<?php echo $row['teacher_id']?>').show(500);
                                                        } else if (value == 1) {
                                                            $('#motivo<?php echo $row['teacher_id']?>').hide(500);
                                                        }
                                                    }
                                                    </script>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                            <div class="form-buttons-w">
                                                <button class="btn btn-success btn-rounded" type="submit">
                                                    Actualizar</button>
                                            </div>
                                            <?php echo form_close();?>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>