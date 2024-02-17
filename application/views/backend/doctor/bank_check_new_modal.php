<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>doctor/bank_checks/new/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Nuevo cheque</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Cuenta bancaria:</label>
                                <select class="form-control" name="bank_account_id" id="bank_account_id" required onchange="validarCheque()">
                                    <option value="">Seleccione una cuenta bancaria</option>
                                    <?php $accs = $this->crud_model->getBankAccountsActive();
                                        foreach($accs->result_array() as $ac):
                                        $bank = $this->crud_model->getBank($ac['bank_id']);?>
                                    <option value="<?php echo $ac['bank_account_id'];?>"><?php echo $ac['code'].' '.$bank['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                                <small class="text-danger" id="msgAccount"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Cheque No:</label>
                                <input type="text" class="form-control" name="no_check" id="no_check" required onchange="validarCheque()" />
                                <small class="text-danger" id="msgNoCheck"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Lugar:</label>
                                <input type="text" class="form-control" name="place" value="" required/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Fecha:</label>
                                <input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d");?>" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Total:</label>
                                <div class="input-group">
                                    <span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span>
                                    <input type="number" class="form-control" name="amount" value="" required min="0" step="0.01" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Páguese a:</label>
                                <input type="text" class="form-control" name="pay_to" value="" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">La suma de:</label>
                                <input type="text" class="form-control" name="amount_letter" value="" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Referencia:</label>
                                <input type="text" class="form-control" name="reference" value="" required />
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
                                </select>
                                <small class="text-danger" id="msgSearch"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="saveBankCheck">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var check = false;
    var rubro = false;

    function validarCheque() {
        var id = $("#bank_account_id").val();
        var no = $("#no_check").val();
        if (id != '' && no != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/verifyNoCheck/",
                data: {
                    id: id,
                    no: no,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#msgAccount").text("Buscando...");
                    $("#msgNoCheck").text("Buscando...");
                    check = false;
                    verifyData();
                },
                success: function (data) {
                    console.log(data);
                    $("#msgAccount").text('');
                    if (data.exist <= 0){
                        $("#msgNoCheck").text('');
                        check = true;
                    } else {
                        $("#msgNoCheck").text("El número de cheque ya esta registrado");
                        check = false;
                    }
                    verifyData();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgAccount").text("Error al buscar");
                    $("#msgNoCheck").text("Error al buscar");
                    check = false;
                    verifyData();
                }
            });
        }

        if (id == '') {
            check = false;
            $("#msgAccount").text("Seleccione una cuenta bancaria");
        }
        if (no == '') {
            check = false;
            $("#msgNoCheck").text("Digite un numero de cheque");
        }
    }
    
    function buscarRubros(buscar) {
        //var buscar = $("#search").val();
        console.log("Search:", buscar);
        if (buscar != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/searchNomenclatureSelect/",
                data: {
                    search: buscar,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#msgSearch").text("Buscando...");
                    rubro = false;
                    verifyData();
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
                    verifyData();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgSearch").text("Error al buscar");
                    rubro = false;
                    verifyData();
                }
            });
        }
    }

    function verifyData() {
        if (check && rubro) {
            $("#saveBankCheck").prop("disabled", false);
        } else {
            $("#saveBankCheck").prop("disabled", true);
        }
    }
</script>