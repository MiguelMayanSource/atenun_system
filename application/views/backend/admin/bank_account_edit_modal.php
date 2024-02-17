<?php 
    $bank_account_id = base64_decode($param2);
    $cta = $this->crud_model->getBankAccount($bank_account_id);
?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url().'admin/bank_accounts/edit/'.$param3;?>" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Nueva cuenta bancaria</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="bank_account_id" id="bank_account_id" value="<?php echo $bank_account_id;?>">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Número de cuenta:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="code" id="code" maxlength="100" value="<?php echo $cta['code'];?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $cta['name'];?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="property_edit" id="property1_edit" value="1" <?php if($cta['property'] == 1) echo "checked";?> />
                                            <label class="form-check-label" for="property1_edit">
                                                Propia
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="property_edit" id="property2_edit" value="2" <?php if($cta['property'] == 2) echo "checked";?> />
                                            <label class="form-check-label" for="property2_edit">
                                                Terceros
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3" id="divNomEdit" style="<?php if($cta['property'] != 1) echo "display:none;";?>">
                            <div class="form-group">
                                <label for="" class="col-form-label">Nomenclatura:</label>
                                <div class="input-group">
                                    <select name="nomenclature_id" id="nom_id" class="form-control" required onchange="buscarRubroEdit()">
                                        <option value="">Seleccione una moneda</option>
                                        <?php $nomen = $this->crud_model->getBanksNomen();
                                            foreach ($nomen->result_array() as $nm):?>
                                        <option value="<?php echo $nm['nomenclature_id'];?>" <?php if($nm['nomenclature_id'] == $cta['nomenclature_id']) echo "selected";?>><?php echo $nm['code']." - ".$nm['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <small class="text-danger" id="msgNomenM"></small>
                            </div>
                        </div>
                        <div class="col-sm-<?php if($cta['property'] == 1) echo "6"; elseif($cta['property'] == 2) echo "12";?> mb-3" id="divBancoEdit">
                            <div class="form-group">
                                <label for="" class="col-form-label">Banco:</label>
                                <div class="input-group">
                                    <select name="bank_id" id="" class="form-control" required>
                                        <option value="">Seleccione un banco</option>
                                        <?php $bancos = $this->crud_model->getBanksActive();
                                            foreach ($bancos->result_array() as $bc):?>
                                        <option value="<?php echo $bc['bank_id'];?>" <?php if($bc['bank_id'] == $cta['bank_id']) echo "selected";?>><?php echo $bc['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="" class="col-form-label">Tipo de cuenta:</label>
                                <div class="input-group">
                                    <select name="account_type_id" id="account_type_id_edit" class="form-control" required>
                                        <option value="">Seleccione un tipo de cuenta</option>
                                        <?php $tipos = $this->crud_model->getAccountTypesActive();
                                            foreach ($tipos->result_array() as $tp):?>
                                        <option value="<?php echo $tp['account_type_id'];?>" <?php if($tp['account_type_id'] == $cta['account_type_id']) echo "selected";?>><?php echo $tp['name'];?></option>
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
                                        <option value="<?php echo $mn['currency_id'];?>" <?php if($mn['currency_id'] == $cta['currency_id']) echo "selected";?>><?php echo $mn['symbol']." - ".$mn['name'];?></option>
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
            <button type="submit" class="button-confirm" id="editBankAccount">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var valNomenM = false;
    var searchNomenM = false;
    
    $('input[type=radio][name=property_edit]').change(function() {
        var val = this.value;
        if (val == 1) {
            $("#divNomEdit").show(300);
            $("#divBancoEdit").removeClass("col-sm-12");
            $("#divBancoEdit").addClass("col-sm-6");
            $("#account_type_id_edit").attr("required", true);
            buscarRubroEdit();
        } else if (val == 2) {
            $("#divNomEdit").hide(300);
            $("#divBancoEdit").removeClass("col-sm-6");
            $("#divBancoEdit").addClass("col-sm-12");
            $("#account_type_id_edit").attr("required", false);
            valNomenM = true;
            verificarDatosEdit();
        }
    });

    function buscarRubroEdit(){
        var id = $("#bank_account_id").val();
        var nom_id = $("#nom_id").val();
        if (nom_id != '' && searchNomenM == false) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/searchAccounByNomenExist/",
                data: {
                    id: id,
                    nom_id: nom_id,
                },
                beforeSend: function () {
                    searchNomenM = true;
                },
                success: function (response) {
                    console.log(response);
                    if (response > 0) {
                        $("#msgNomenM").text("Este rubro ya está vínculado a una cuenta bancaria");
                        valNomenM = false;
                    } else {
                        $("#msgNomenM").text('');
                        valNomenM = true;
                    }
                    searchNomenM = false;
                    verificarDatosEdit();
                }, 
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgNomenM").text("Error al buscar");
                    searchNomenM = false;
                    verificarDatosEdit();
                }
            });
        } else {
            $("#msgNomenM").text("Seleccione un rubro por favor");
            valNomenM = false;
            searchNomenM = false;
            verificarDatosEdit();
        }
    }

    function verificarDatosEdit() {
        if (valNomenM) {
            $("#editAccount").prop("disabled", false);
        } else {
            $("#editAccount").prop("disabled", true);
        }
    }
</script>