<?php 
    $bank_check_id = base64_decode($param2);
    $check = $this->crud_model->getBankCheck($bank_check_id);
    $nom = $this->crud_model->getNomen($check['nomenclature_id']);
?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>staff/bank_checks/edit/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Actualizar cheque</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="bank_check_id" id="bank_check_id" value="<?php echo $bank_check_id;?>">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Cuenta bancaria:</label>
                                <select class="form-control" name="bank_account_id" id="account_id_edit" required onchange="validarChequeEdit()">
                                    <option value="">Seleccione una cuenta bancaria</option>
                                    <?php $accs = $this->crud_model->getBankAccountsActive();
                                        foreach($accs->result_array() as $ac):
                                        $bank = $this->crud_model->getBank($ac['bank_id']);?>
                                    <option value="<?php echo $ac['bank_account_id'];?>" <?php if($ac['bank_account_id'] == $check['bank_account_id']) echo "selected";?>><?php echo $ac['code'].' '.$bank['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                                <small class="text-danger" id="msgAccountEdit"></small>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Cheque No:</label>
                                <input type="text" class="form-control" id="no_check_edit" name="no_check" value="<?php echo $check['no_check'];?>" required onchange="validarChequeEdit()" />
                                <small class="text-danger" id="msgNoCheckEdit"></small>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Lugar:</label>
                                <input type="text" class="form-control" name="place" value="<?php echo $check['place'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Fecha:</label>
                                <input type="date" class="form-control" name="date" value="<?php echo $check['date'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Total:</label>
                                <div class="input-group">
                                    <span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span>
                                    <input type="number" class="form-control" name="amount" value="<?php echo $check['amount'];?>" required min="0" step="0.01" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Páguese a:</label>
                                <input type="text" class="form-control" name="pay_to" value="<?php echo $check['pay_to'];?>" required/>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">La suma de:</label>
                                <input type="text" class="form-control" name="amount_letter" value="<?php echo $check['amount_letter'];?>" required/>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Referencia:</label>
                                <input type="text" class="form-control" name="reference" value="<?php echo $check['reference'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label"><b>Rubro a registrar:</b></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Buscar:</label>
                                <input type="text" class="form-control" name="search" id="search" value="" onblur="buscarRubros(this.value)" />
                                <small class="text-danger">Presione TAB o fuera del cuadro de texto para buscar coincidencias</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Referencia:</label>
                                <select class="form-control" name="nomenclature_id" id="nomenclature_id" required>
                                    <option value="">Busque primero un rubro</option>
                                    <option value="<?php echo $check['nomenclature_id'];?>" selected><?php echo $nom['code'].' - '.$nom['name'];?></option>
                                </select>
                                <small class="text-danger" id="msgSearch"></small>
                            </div>
                            <input type="hidden" id="nomen_id" value="<?php echo $check['nomenclature_id'];?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="editBankCheck">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var check = true;
    var rubro = true;

    function validarChequeEdit() {
        var id = $("#bank_check_id").val();
        var account_id = $("#account_id_edit").val();
        var no = $("#no_check_edit").val();
        if (id != '' && no != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/verifyNoCheckEdit/",
                data: {
                    id: id,
                    account_id: account_id,
                    no: no,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#msgAccountEdit").text("Buscando...");
                    $("#msgNoCheckEdit").text("Buscando...");
                    check = false;
                    verifyDataEdit();
                },
                success: function (data) {
                    console.log(data);
                    $("#msgAccountEdit").text('');
                    if (data.exist <= 0){
                        $("#msgNoCheckEdit").text('');
                        check = true;
                    } else {
                        $("#msgNoCheckEdit").text("El número de cheque ya esta registrado");
                        check = false;
                    }
                    verifyDataEdit();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgAccountEdit").text("Error al buscar");
                    $("#msgNoCheckEdit").text("Error al buscar");
                    check = false;
                    verifyDataEdit();
                }
            });
        }

        if (id == '') {
            check = false;
            $("#msgAccountEdit").text("Seleccione una cuenta bancaria");
        }
        if (no == '') {
            check = false;
            $("#msgNoCheckEdit").text("Digite un numero de cheque");
        }
    }
    
    function buscarRubros(buscar) {
        //var buscar = $("#search").val();
        console.log("Search:", buscar);
        if (buscar != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/searchNomenclatureSelect/",
                data: {
                    search: buscar,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#msgSearch").text("Buscando...");
                    rubro = false;
                    verifyDataEdit();
                },
                success: function (data) {
                    console.log(data);
                    $("#msgAccount").text('');
                    $("#nomenclature_id").html(data.select);
                    if (data.results > 0){
                        $("#msgSearch").text('');
                        rubro = true;
                    } else {
                        $("#msgSearch").text("Criterio no válido");
                        rubro = false;
                    }
                    verifyDataEdit();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgSearch").text("Error al buscar");
                    rubro = false;
                    verifyDataEdit();
                }
            });
        }
    }

    function verifyDataEdit() {
        console.log("Cheque:", check, "Rubro:", rubro);
        if (check && rubro) {
            $("#editBankCheck").prop("disabled", false);
        } else {
            $("#editBankCheck").prop("disabled", true);
        }
    }
</script>