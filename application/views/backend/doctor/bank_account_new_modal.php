<?php $property = $param2; ?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url().'doctor/bank_accounts/new/'.$property;?>" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Nueva cuenta bancaria</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Número de cuenta:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="code" id="code" maxlength="100" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="name" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="property" id="property1" value="1" <?php if($property == 1) echo "checked";?> />
                                            <label class="form-check-label" for="property1">
                                                Propia
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="property" id="property2" value="2" <?php if($property == 2) echo "checked";?> />
                                            <label class="form-check-label" for="property2">
                                                Terceros
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3" id="divNom" style="<?php if($property != 1) echo "display:none;";?>">
                            <div class="form-group">
                                <label for="" class="col-form-label">Nomenclatura:</label>
                                <div class="input-group">
                                    <select name="nomenclature_id" id="nomenclature_id" class="form-control" onchange="buscarRubro()">
                                        <option value="">Seleccione un rubro</option>
                                        <?php $nomen = $this->crud_model->getBanksNomen();
                                            foreach ($nomen->result_array() as $nm):?>
                                        <option value="<?php echo $nm['nomenclature_id'];?>"><?php echo $nm['code']." - ".$nm['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <small class="text-danger" id="msgNomen"></small>
                            </div>
                        </div>
                        <div class="col-sm-<?php if($property == 1) echo "6"; elseif($property == 2) echo "12";?> mb-3" id="divBanco">
                            <div class="form-group">
                                <label for="" class="col-form-label">Banco:</label>
                                <div class="input-group">
                                    <select name="bank_id" id="" class="form-control" required>
                                        <option value="">Seleccione un banco</option>
                                        <?php $bancos = $this->crud_model->getBanksActive();
                                            foreach ($bancos->result_array() as $bc):?>
                                        <option value="<?php echo $bc['bank_id'];?>"><?php echo $bc['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="" class="col-form-label">Tipo de cuenta:</label>
                                <div class="input-group">
                                    <select name="account_type_id" id="account_type_id" class="form-control" required>
                                        <option value="">Seleccione un tipo de cuenta</option>
                                        <?php $tipos = $this->crud_model->getAccountTypesActive();
                                            foreach ($tipos->result_array() as $tp):?>
                                        <option value="<?php echo $tp['account_type_id'];?>"><?php echo $tp['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="" class="col-form-label">Moneda:</label>
                                <div class="input-group">
                                    <select name="currency_id" id="currency_id" class="form-control" required>
                                        <option value="">Seleccione una moneda</option>
                                        <?php $monedas = $this->crud_model->getCurrenciesActive();
                                            foreach ($monedas->result_array() as $mn):?>
                                        <option value="<?php echo $mn['currency_id'];?>"><?php echo $mn['symbol']." - ".$mn['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="saveBankAccount">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var valNomen = false;
    var searchNomen = false;

    $('input[type=radio][name=property]').change(function() {
        var val = this.value;
        if (val == 1) {
            $("#divNom").show(300);
            $("#divBanco").removeClass("col-sm-12");
            $("#divBanco").addClass("col-sm-6");
            $("#account_type_id").attr("required", true);
            buscarRubro();
        } else if (val == 2) {
            $("#divNom").hide(300);
            $("#divBanco").removeClass("col-sm-6");
            $("#divBanco").addClass("col-sm-12");
            $("#account_type_id").attr("required", false);
            valNomen = true;
            verificarDatos();
        }
    });

    function buscarRubro(){
        var nom_id = $("#nomenclature_id").val();
        if (nom_id != '' && searchNomen == false) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/searchAccounByNomen/",
                data: {
                    id: nom_id,
                },
                beforeSend: function () {
                    searchNomen = true;
                },
                success: function (response) {
                    console.log(response);
                    if (response > 0) {
                        $("#msgNomen").text("Este rubro ya está vínculado a una cuenta bancaria");
                        valNomen = false;
                    } else {
                        $("#msgNomen").text('');
                        valNomen = true;
                    }
                    searchNomen = false;
                    verificarDatos();
                }, 
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgNomen").text("Error al buscar");
                    searchNomen = false;
                    verificarDatos();
                }
            });
        } else {
            $("#msgNomen").text("Seleccione un rubro por favor");
            valNomen = false;
            searchNomen = false;
            verificarDatos();
        }
    }

    function verificarDatos() {
        if (valNomen) {
            $("#saveBankAccount").prop("disabled", false);
        } else {
            $("#saveBankAccount").prop("disabled", true);
        }
    }
</script>