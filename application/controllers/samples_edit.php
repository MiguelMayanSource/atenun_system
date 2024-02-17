<?php $data_edit = $this->crud_samples->getSampleByID(base64_decode($ID))  ;?>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="widget-heading">
                    <h4> Editar muestra - <?php echo $data_edit->code; ?> </h4>
                </div>
                <form action="<?php echo base_url().'admin/samples/edit/'.$ID;?>" method="post" enctype="multipart/form-data" id='formAdd'>
                    <?php $paciente = $this->db->get_where('patient', array('patient_id'=>$data_edit->patient_id))->row();?>
                    <div class='row'>
                        <input type="hidden" class="form-control" name='patient_id' id='patient_id' value='<?php echo $data_edit->patient_id; ?>'>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3'>
                            <div class="form-group" id="buscarPaciente">
                                <label><span id='buscar'>Buscar</span> paciente<span style="color:red;">*</span></label>
                                <input autocomplete="off" class="form-control" name='name' value="<?php echo $paciente->name; ?>" required id='patient' onkeyUp="getPatients(this.value)" placeholder='Buscar paciente'>
                            </div>
                            <div id="class_loader" class="spinner-border text-primary" style="display:none;" role="status"><span class="sr-only">Loading...</span></div>
                            <table id='result' class='table'>

                            </table>
                        </div>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                            <div class="form-group">
                                <label>Médico referente</label>
                                <select name="doctors_id" class='form-control basic' required id='doctor_id'>
                                    <option value="">Seleccionar</option>
                                    <?php $this->db->order_by('name', 'asc'); $doctors = $this->db->get_where('doctor', array('status !='=>0))->result_array(); foreach($doctors as $doc):?>
                                    <option value="<?php echo $doc['doctor_id'];?>" <?php echo ($data_edit->doctors_id == $doc['doctor_id'] ) ? 'selected':''; ?>><?php echo $doc['name'].' '.$doc['last_name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Comentarios</label>
                                <textarea class='form-control' name="several_doctors" cols="30" rows="3" placeholder='Comentarios'><?php echo $data_edit->several_doctors?></textarea>
                            </div>
                        </div>
                        <div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <input type="date" name='birthday' id='birthday' class="form-control" onchange='getAge(this.value)' value='<?php echo $paciente->birthday;?>'>
                            </div>
                        </div>
                        <div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Edad</label>
                                <input type="number" min='0' class="form-control age" name='age' id='age' oninput="if(value.length>2)value=value.slice(0,2)" value='<?php echo $paciente->age;?>'>
                            </div>
                        </div>

                        <div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Género</label>
                                <select name="gender" class='form-control' id='gender'>
                                    <option value="Femenino" <?php echo ($paciente->gender == 'Femenino') ?'selected':''?>>Femenino</option>
                                    <option value="Masculino" <?php echo ($paciente->gender == 'Masculino') ?'selected':''?>>Masculino</option>
                                </select>
                            </div>
                        </div>
                        <div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="number" class="form-control" name='phone' id='phone' value='<?php echo $paciente->phone;?>'>
                            </div>
                        </div>

                        <div class='col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>NIT</label>
                                <input type="text" class="form-control" name='activities' id='activities' value='<?php echo $paciente->activities;?>'>
                            </div>
                        </div>

                        <div class='col-xl-3 col-lg-3 col-md-3  col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Fecha de procedimiento <span style="color:red;">*</span></label>
                                <input type="date" class="form-control" name='fecha_procedimiento' value='<?php echo $data_edit->process_date;?>'>
                            </div>
                        </div>

                        <div class='col-xl-3 col-lg-3 col-md-3  col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Fecha de recibido</label>
                                <input type="date" class="form-control" name='fecha_recibido' value='<?php echo $data_edit->received_date;?>'>
                            </div>
                        </div>
                        <div class='col-xl-3 col-lg-3 col-md-3  col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Prioridad:</label>
                                <select name="prioridad" class='form-control' onchange='price_priority(this.value)' id="priority" disabled>
                                    <option value="1" <?php echo ($data_edit->priority == '1') ?'selected':''?>>Normal</option>
                                    <option value="2" <?php echo ($data_edit->priority == '2') ?'selected':''?>>Prioridad</option>
                                    <option value="4" <?php echo ($data_edit->priority == '4') ?'selected':''?>>Urgencia</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <label>Tipo de precio:<span style="color:red;">*</span></label>
                            <select name="payment_type" class='form-control ' id="payment_type" onchange="getPrice2()">
                                <option value="0" <?php echo ($data_edit->payment_type == '0') ?'selected':''?>>Normal</option>
                                <option value="1" <?php echo ($data_edit->payment_type == '1') ?'selected':''?>>Especial</option>
                            </select>
                        </div>

                        <input type="hidden" class="form-control" name='category_id' value='<?php echo $data_edit->category_id;?>'>
                        <input type="hidden" class="form-control" name='financial_id' value='<?php echo $data_edit->financial_id;?>'>
                        <input type="hidden" class="form-control" name='code' value='<?php echo $data_edit->code;?>'>

                        <?php $piezas = $this->db->get_where('sample_piece',array('sample_id'=>$data_edit->sample_id))?>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row'>
                            <div class="table-responsive col-12 row">
                                <table class="table" style="margin: 20px;">
                                    <tbody id="piezas">
                                        <?php 
                                            $cont = 0; 
                                            foreach ($piezas->result_array() as $piesa): 
                                            $id = rand(0,1000);    
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="" style="width:150px;">
                                                    <label for="simpleinput">Categorias:</label>
                                                      <input type="hidden" name="piece[]" value="<?php echo  $piesa['sample_piece_id'];?>" />
                                                    <input type="hidden" name="cat[]" value="<?php echo  $id;?>" />
                                                    <select onchange="laboratoriesExamns(this.value,<?php echo $id; ?>)" class="form-control basic labs" name="laboratories[]" id="laboratories_<?php echo $id; ?>">
                                                        <option value="">Seleccionar</option>
                                                        <?php 
                                                            $this->db->where('status',1);
                                                            $this->db->where('clinic_id',$this->session->userdata('sucursal'));
                                                            $db = $this->db->get('laboratory')->result_array();
                                                            foreach($db as $info):
                                                        ?>
                                                        <option value="<?php echo $info['laboratory_id'];?>" <?php echo $piesa['laboratory_id']==$info['laboratory_id']?'selected':'';?>><?php echo $info['name']?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="" style="padding-top:23px;width:200px;">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Seleccione uno o más examenes:</label>
                                                        <select class="form-control basic exmas" multiple name="<?php echo $id; ?>_fields[]" id="examns_<?php echo $id; ?>" onchange="getPrice(this.value,<?php echo $id; ?>)">
                                                            <?php $exmas = $this->db->get_where('laboratory_template',array('laboratory_id'=>$piesa['laboratory_id']))->result_array();
                                                                      $exmans = json_decode($piesa['exams']);
                                                                    foreach($exmas as $ex):
                                                                    ?>
                                                            <option value="<?php echo $ex['laboratory_fields_id']?>" <?php if( in_array( $ex['laboratory_fields_id'], json_decode($piesa['exams']) )) echo 'selected'; ?>><?php echo $this->db->get_where('laboratory_fields',array('laboratory_fields_id'=>$ex['laboratory_fields_id']))->row()->name; ?></option>
                                                            <?php endforeach?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="white-space: nowrap">
                                                <div class="" style="width:200px;">
                                                    <label> Tipo de espécimen: <span style="color:red;">*</span></label>
                                                    <select name="estudio[]" class="form-control">
                                                        <option value="SANGRE COMPLETA" <?php echo $piesa['study']=="SANGRE COMPLETA"?'selected':'';?>>SANGRE COMPLETA</option>
                                                        <option value="SUERO" <?php echo $piesa['study']=="SUERO"?'selected':'';?>>SUERO</option>
                                                        <option value="PLASMA" <?php echo $piesa['study']=="PLASMA"?'selected':'';?>>PLASMA</option>
                                                        <option value="HECES" <?php echo $piesa['study']=="HECES"?'selected':'';?>>HECES</option>
                                                        <option value="ORINA" <?php echo $piesa['study']=="ORINA"?'selected':'';?>>ORINA</option>
                                                        <option value="OTRO" <?php echo $piesa['study']=="OTRO"?'selected':'';?>>OTRO</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="white-space: nowrap">
                                                <div class="" style="width:120px;">
                                                    <label>Precio:<span style="color:red;">*</span></label>
                                                    <input class='form-control total' type="number" min='0' value="<?php echo $piesa['price']?>" onchange="sum_total()" step="any" onkeyup="sum_total()" name='price[]' id='ttl-<?php echo $id; ?>'>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="" style="width:200px;">
                                                    <label>Observación</label>
                                                    <input class='form-control ' type="text" name='details[]' value="<?php echo $piesa['details']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-danger " onclick="deletePieza(this)">-</a>
                                            </td>

                                        </tr>
                                        <?php $cont++; endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row'>
                            <div class='col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3'>
                                <div class="form-group">
                                    <br>
                                    <a class="btn btn-success" onclick="addPieza()">
                                        +
                                    </a>
                                </div>
                            </div>
                            <div class='col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9' style='text-align:right'>
                                <br>
                                <br>
                                <input type='hidden' name="total" value="0" id="total" />
                                <h5>TOTAL Q.<span id="total_text"><?php echo $data_edit->total?></span></h5>
                            </div>
                        </div>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row' style='display:none' id="gineco">
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                                <h4> Antecedentes Gineco-obstétrico:</h4>
                                <hr>
                            </div>

                            <div class='col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Fecha de Manarquia:</label>
                                    <input type="date" class="form-control" name='fecha_manarquia' id='fecha_manarquia' value='<?php echo $data_edit->manarquia_date;?>'>
                                </div>
                            </div>

                            <div class='col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Fecha de Menopausia:</label>
                                    <input type="date" class="form-control" name='fecha_menopausia' id='fecha_menopausia' value='<?php echo $data_edit->menopause_date;?>'>
                                </div>
                            </div>

                            <div class='col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Ciclos Menstruales:</label>
                                    <input type="text" class="form-control" name='ciclos_menstruales' id='ciclos_menstruales' value='<?php echo $data_edit->menstrual_cycle;?>'>
                                </div>
                            </div>

                            <div class='col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>FUR:</label>
                                    <input type="text" class="form-control" name='FUR' id='FUR' value='<?php echo $data_edit->FUR;?>'>
                                </div>
                            </div>

                            <div class='col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Gestas:</label>
                                    <input type="text" class="form-control" name='gestas' id='gestas' value='<?php echo $data_edit->deeds;?>'>
                                </div>
                            </div>

                            <div class='col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Partos:</label>
                                    <input type="text" class="form-control" name='partos' id='partos' value='<?php echo $data_edit->birth;?>'>
                                </div>
                            </div>

                            <div class='col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Abortos:</label>
                                    <input type="text" class="form-control" name='abortos' id='abortos' value='<?php echo $data_edit->abortion;?>'>
                                </div>
                            </div>

                            <div class='col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Fecha de último parto:</label>
                                    <input type="date" class="form-control" name='fecha_ultimo_parto' id='fecha_ultimo_parto' value='<?php echo $data_edit->birth_date;?>'>
                                </div>
                            </div>

                            <div class='col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Utilización de DIU:</label>
                                    <input type="text" class="form-control" name='DIU' id='DIU' value='<?php echo $data_edit->DIU;?>'>
                                </div>
                            </div>

                            <div class='col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Tx hormonal:</label>
                                    <input type="text" class="form-control" name='tx_hormonal' id='tx_hormonal' value='<?php echo $data_edit->tx_hormonal;?>'>
                                </div>
                            </div>
                        </div>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Datos positivos:</label>
                                <textarea class='form-control' name='datos_positivos' id='datos_positivos'><?php echo $data_edit->positive_data; ?></textarea>
                            </div>
                        </div>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Diagnóstico previo:</label>
                                <textarea class="form-control" name='diagnostico' row='3' id='diagnostico'><?php echo $data_edit->diagnosis; ?></textarea>
                            </div>
                        </div>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Dirección de recibo:<span style="color:red;">*</span></label>
                                <textarea class="form-control" name='address' row='3'><?php echo $data_edit->address;?></textarea>
                            </div>
                        </div>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Clínica/Hospital:</label>
                                <select name="clinic_id" class='form-control  basic'>
                                    <option value="">Ninguna</option>
                                    <?php $this->db->order_by('name', 'asc'); $clinics = $this->db->get_where('clinic', array('status'=>1))->result_array(); foreach ($clinics as $clinic): ?>
                                    <option value="<?php echo $clinic['clinic_id']?>" <?php echo ($data_edit->clinic_id == $clinic['clinic_id']) ?'selected':''?>><?php echo $clinic['name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pago'>
                            <div class="form-group">
                                <div class="custom-file-container" data-upload-id="leaf">
                                    <label>Hoja de datos <a href="javascript:void(0)" class="custom-file-container__image-clear btn btn-danger btn-sm" title="Limpiar elementos">x</a></label>
                                    <label class="custom-file-container__custom-file">
                                        <input type="file" name='leaf' class="custom-file-container__custom-file__custom-file-input" accept="image/*, .pdf">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                            </div>
                        </div>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <div class="form-group">
                                <label>Crédito<span style="color:red;">*</span></label>
                                <select name="credito" class='form-control' onchange="getCredito(this.value)">
                                    <option value="0" <?php echo ($data_edit->credit == 0) ?'selected':''?>>No</option>
                                    <option value="1" <?php echo ($data_edit->credit == 1) ?'selected':''?>>Si</option>
                                </select>
                            </div>
                        </div>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ' id='bill'>
                            <div class="form-group">
                                <label>Cuentas:</label>
                                <select name="bill" class='form-control bill'>
                                    <option value="">Seleccionar</option>
                                    <?php $bills = $this->db->get_where('bill', array('status'=>1))->result_array(); foreach ($bills as $bill): ?>
                                    <option value="<?php echo $bill['bill_id']?>" <?php echo ($data_edit->bill_id == $bill['bill_id']) ?'selected':''?>><?php echo $bill['name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>


                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pago'>
                            <div class="form-group">
                                <label>Facturado:</label>
                                <select name="facturado" class='form-control' onchange="getFactura(this.value)">
                                    <option value="0" <?php echo ($data_edit->invoiced == 0) ?'selected':''?>>No</option>
                                    <option value="1" <?php echo ($data_edit->invoiced == 1) ?'selected':''?>>Si</option>
                                </select>
                            </div>

                            <div class="form-group" id='factura'>
                                <div class="custom-file-container" data-upload-id="factura">
                                    <label>Factura: <a href="javascript:void(0)" class="custom-file-container__image-clear btn btn-danger btn-sm" title="Limpiar elementos">x</a></label>
                                    <label class="custom-file-container__custom-file">
                                        <input type="file" name='factura' class="custom-file-container__custom-file__custom-file-input" accept="image/*, .pdf">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                            </div>

                        </div>

                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pago'>
                            <div class="form-group">
                                <label>Método:</label>
                                <select class="form-control" name="metodo" onchange="getMetodo(this.value)">
                                    <option value="1" <?php $method = $this->db->get_where('financial',array('sample_code'=>$data_edit->code))->row()->method; echo $method == 1? 'Selected':''; ?>>Efectivo</option>
                                    <option value="2" <?php echo $method == 2? 'Selected':''; ?>>Tarjeta</option>
                                    <option value="3" <?php echo $method == 3? 'Selected':''; ?>>Cheque</option>
                                    <option value="4" <?php echo $method == 4? 'Selected':''; ?>>Depósito</option>
                                    <option value="5" <?php echo $method == 5? 'Selected':''; ?>>Transferencia</option>
                                </select>
                            </div>

                            <div class="form-group referencia">
                                <label>No. referencia:</label>
                                <input type="text" class="form-control" name='referencia'>
                            </div>

                            <div class="form-group referencia">
                                <div class="custom-file-container" data-upload-id="documento">
                                    <label>Documento: <a href="javascript:void(0)" class="custom-file-container__image-clear btn btn-danger btn-sm" title="Limpiar elementos">x</a></label>
                                    <label class="custom-file-container__custom-file">
                                        <input type="file" name='documento' class="custom-file-container__custom-file__custom-file-input" accept="image/*, .pdf">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                            </div>
                        </div>


                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                            <div class="form-group">
                                <button style='Float:right;' type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('input[type="text"]').on('input', function() {

    this.value = this.value.toUpperCase()

})


$('#result').hide();
$('#bill').hide();



function getAge(fecha) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
    $(".age").val(edad);
}

function newPatient() {
    $('#patient_id').val(0);
    $('#result').hide(500);
    $('#buscar').html('Nuevo');
}

function getPatients(name) {

    $('#class_loader').show();
    if (name.length > 0) {
        $.ajax({
            url: "<?php echo base_url().'admin/patient/getPatients/';?>",
            type: "POST",
            data: {
                name: name,
            },
            success: function(response) {
                $('#class_loader').hide();
                $('#result').show();
                $('#result').html(response);
                // console.log(response);
            },
            error: function() {
                console.log("error");
            }
        });
    }
}

function paciente(paciente_id, doctor_id) {
    //console.log('paciente_id:' + paciente_id);
    //console.log('Doctor_id:' + doctor_id);
    $('#result').hide(500);
    $('#patient_id').val(paciente_id);
    $('#doctor_id').val(doctor_id).change();

    $('#buscar').html('Buscar');

    getDiagnostico(doctor_id);
}


function getDiagnostico(doctor_id) {
    var patient = $('#patient_id').val();

    $.ajax({
        url: "<?php echo base_url().'admin/getDiagnostico';?>",
        type: "POST",
        dataType: "json",
        data: {
            doctor_id: doctor_id,
            patient: patient,
        },
        success: function(response) {
            //console.log(response);
            if (response != 0) {

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Paciente Encontrado',
                    showConfirmButton: false,
                    timer: 1500
                })

                var patient = response[0][0];
                $("#birthday").val(patient.birthday);
                $('#age').val(patient.age);
                $('#phone').val(patient.phone);
                $("#gender").val(patient.gender).change();
                $("#activities").val(patient.activities);
                $("#patient_id").val(patient.patient_id);
                $("#patient").val(patient.name);


                var sample = response[1][0];

                $("#fecha_manarquia").val(sample.manarquia_date);
                $("#fecha_menopausia").val(sample.menopause_date);
                $("#ciclos_menstruales").val(sample.menstrual_cycle);
                $("#FUR").val(sample.FUR);
                $("#gestas").val(sample.deeds);
                $("#partos").val(sample.birth);
                $("#abortos").val(sample.abortion);
                $("#fecha_ultimo_parto").val(sample.birth_date);
                $("#DIU").val(sample.DIU);
                $("#tx_hormonal").val(sample.tx_hormonal);
                $("#datos_positivos").val(sample.positive_data);
                $("#previa").val('1').change();
                $("#diagnostico").val(sample.diagnosis);

                $('#table_patologia').removeAttr('hidden');
                $('#Anteriores').html(response[2])

                if (patient.gender == "Masculino") {
                    $('#gineco').hide(500);
                } else {
                    $('#gineco').show(500);

                }

            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Paciente No Encontrado',
                    showConfirmButton: false,
                    timer: 1500
                })
            }

        },
        error: function() {
            console.log("error");
        }

    });

}

function getPrice(element, price_id) {

    const laboratory_id = $('#laboratories_' + price_id).val();
    const fields = $('#examns_' + price_id).select2("val");
    const payment_type = $('#payment_type').val();

    console.log(fields);

    $.ajax({
        url: "<?php echo base_url().'admin/getPrice/';?>",
        type: "POST",
        data: {
            laboratory_id: laboratory_id,
            fields: fields,
            payment_type: payment_type
        },
        success: function(response) {


            $("#ttl-" + price_id).val(response);
            sum_total()

        },
        error: function() {
            console.log("error");
        }

    });
}

function getPrice2() {
    var price_id = 0;
    $('.labs').each(function() {

        var fields = $('#examns_' + price_id).select2("val");
        var payment_type = $('#payment_type').val();

        $.ajax({
            url: "<?php echo base_url().'admin/getPrice/';?>",
            type: "POST",
            data: {
                fields: fields,
                payment_type: payment_type
            },
            success: function(response) {

                console.log(price_id);
                console.log(response);
                $("#ttl-" + price_id).val(response);
                sum_total()

            },
            complete: function() {
                price_id++;
            },
            error: function() {
                console.log("error");
            }

        });



    });


}

function getFactura(facturado) {
    if (facturado == '1') {
        $('#factura').show(500);
    } else {
        $('#factura').hide(500);
    }
}

function getCredito(credito) {
    if (credito == '1') {
        $('.pago').hide(500);
        $('#bill').show(500);
        $('.bill').attr('required', true);
    } else {
        $('.pago').show(500);
        $('#bill').hide(500);
        $('.bill').removeAttr('required');
    }
}

function getMetodo(metodo) {
    if (metodo == '1' || metodo == '') {
        $('.referencia').hide(500);
    } else {
        $('.referencia').show(500);
    }
}



function addPieza() {

    var id = $('.labs').length;
    var category_id = $('#category_id').val();
    $.ajax({
        url: "<?php echo base_url().'admin/getPieza';?>",
        type: "POST",
        data: {
            category: category_id,
            id: id,
        },
        success: function(response) {


            //console.log(response);
            $('#piezas').append(response);
            $(".basic2").select2({});
            $(".basic").select2();
        },
        error: function() {
            console.log("error");
        }
    });


}

function deletePieza(element) {
    element.parentElement.parentElement.remove();
    element.remove();
    sum_total();
}

function sum_total() {
    var total = 0;

    $('.total').each(function(i, val) {
        //console.log(i)
        total += parseFloat($(this).val());
    });
    var grand_total = parseFloat(total);

    $('#total_text').html(grand_total.toFixed(2));
    $('#total').val(grand_total.toFixed(2));
}



function price_priority(value) {
    var total = 0;
    $('.basic2').each(function(i, val) {
        //console.log(i)
        //console.log(value, $(this).val(), i);
        getPrecio($(this).val(), i)
    });

}


$("#formSample").submit(function(e) {
    e.preventDefault();


    var total = $('#total').val();
    var priority = 0;
    $('.priority').each(function() {
        if ($(this).val() == 5)
            priority++;

    });

    if (total > 0 && priority == 0) {

        $('.submit').attr('disabled', 'disabled');
        $('.submit').html('Guardando....');
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("#addSample").attr('disabled', true);
            },
            success: function(response) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Muestra registrada',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('.submit').hide();
                $('.print_recipe').attr('onclick', `print("${response}")`);
                $('.print_recipe').show();
                $('.sample_new').show();
                console.log(response);



            },
            complete: function() {
                $("#addSample").removeAttr('disabled');
            },
            error: function() {
                console.log("error");
            }
        });
    } else if (total == 0 && priority > 0) {

        $('.submit').attr('disabled', 'disabled');
        $('.submit').html('Guardando....');
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("#addSample").attr('disabled', true);
            },
            success: function(response) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Muestra registrada',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('.submit').hide();
                $('.print_recipe').attr('onclick', `print("${response}")`);
                $('.print_recipe').show();
                console.log(response);



            },
            complete: function() {
                $("#addSample").removeAttr('disabled');
            },
            error: function() {
                console.log("error");
            }
        });
    } else {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Valor no puede ser 0',
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }



});



function print(code) {

    $.ajax({
        url: "<?php echo base_url().'admin/samples/get/';?>",
        type: 'post',
        data: {
            code: code
        },
        success: function(data) {
            //console.log(data);
            printJS({
                printable: data,
                type: "raw-html",
                css: ["<?php echo base_url().'public/assets/css/ticket.css' ;?>"],
            });

        },
        error: function(e) {
            console.log("ERROR : ", e);
        }

    });

}

function laboratoriesExamns(value, no) {

    $.ajax({
        url: '<?php echo base_url()?>admin/getExamns',
        type: 'POST',
        data: {
            laboratories: value,
        },
        success: function(result) {

            console.log(result);
            $('#examns_' + no).html(result);


            Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'success',
                title: 'Categoría seleccionada...'
            })
        },
        complete: function() {

            getPrice(0, no)
        }
    });
}
</script>