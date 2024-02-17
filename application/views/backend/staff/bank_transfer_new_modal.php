<?php $cuentas = $this->crud_model->getBankAccountsActive();?> 
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>staff/bank_transfers/new/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Nueva transferencia</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label class="col-form-label">Cuenta de origen:</label>
                                <div class="input-group">
                                    <select class="form-control" name="source_account" id="source_account" onchange="otherAccounts()" required>
                                        <option value="">Selecciona una cuenta</option>
                                        <?php foreach($cuentas->result_array() as $ct):?>
                                        <option value="<?php echo $ct['bank_account_id'];?>" <?php if($ct['bank_account_id'] == $account_id) echo "selected";?>><?php echo $ct['code'].' '.$ct['name'];?></option>
                                        <?php endforeach;?> 
                                    </select>
                                </div>
                                <small class="text-danger" id="msgAccount"></small>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="" class="col-form-label">Fecha:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="date" id="date" value="<?php echo $hoy;?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="col-form-lable">Monto a transferir:</label>
                                <div class="input-group">
                                    <span class="input-group-addon input-group-prepend">
                                        <span class="input-group-text">Q</span>
                                    </span>
                                    <input type="number" class="form-control" name="amount" id="amount" step="0.01" min="0" max="" value="0.00" onblur="checkBalance()" required />
                                </div>
                                <small class="text-danger" id="msgAmount"></small>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <label class="col-form-label">Cuenta de destino:</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="property" id="property1" value="1" checked onclick="otherAccounts()" />
                                            <label class="form-check-label" for="property1">
                                                Propia
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="property" id="property2" value="2" onclick="otherAccounts()" />
                                            <label class="form-check-label" for="property2">
                                                Terceros
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 mt-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control" name="destiny_account" id="destiny_account" onchange="verifySelect()" disabled required>
                                        <option value="">Selecciona una cuenta</option>
                                        <?php foreach($cuentas->result_array() as $ct):?>
                                        <option value="<?php echo $ct['bank_account_id'];?>" <?php if($ct['bank_account_id'] == $account_id) echo "selected";?>><?php echo $ct['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <small class="text-danger" id="msgOther"></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="col-form-label">Descripción</label>
                                <textarea name="description" id="" cols="" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="saveBankTransfer">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var chAmount = false;
    
    $(document).ready(function () {
        verifyData();
    });

    function otherAccounts() {
        var id = $("#source_account").val();
        var property = $("input[type='radio']:checked").val();
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/getOtherBankAccounts/",
                data: {
                    id: id,
                    property: property,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#msgOther").text("Buscando");
                },
                success: function (data) {
                    console.log(data);
                    $("#destiny_account").html(data.select);
                    $("#destiny_account").prop("disabled", false);
                    $("#msgAccount").text('');
                    $("#msgOther").text("Seleccione una cuenta diferente");
                    checkBalance();
                }, 
                error: function (e) {
                    console.error("Error: ", e);
                    $("#msgAccount").text("Error al buscar las demás cuentas");
                }
            });
        } else {
            $("#msgAccount").text("Seleccione una cuenta por favor");
        }
    }

    function verifySelect() {
        var id = $("#destiny_account").val();
        if (id == '') $("#msgOther").text("Seleccione una cuenta diferente");
        else $("#msgOther").text('');
    }

    function checkBalance() {
        var id = $("#source_account").val();
        var amount = $("#amount").val();
        if (id != '' && amount != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/checkBalanceBankAccount/",
                data: {
                    id: id,
                    amount: amount,
                },
                dataType: "json",
                beforeSend: function() {
                    $("#msgAmount").removeClass("text-danger");
                    $("#msgAmount").removeClass("text-success");
                    $("#msgAmount").addClass("text-info");
                    $("#msgAmount").text("Buscando");
                },
                success: function (data) {
                    console.log(data);
                    if (data.check == 1) {
                        $("#msgAmount").removeClass("text-danger");
                        $("#msgAmount").removeClass("text-info");
                        $("#msgAmount").addClass("text-success");
                        $("#msgAmount").text("Saldo de la cuenta: "+data.balance);
                        chAmount = true;
                    } else {
                        $("#msgAmount").removeClass("text-success");
                        $("#msgAmount").removeClass("text-info");
                        $("#msgAmount").addClass("text-danger");
                        $("#msgAmount").text("El saldo de la cuenta no es suficiente para realizar la transferencia: "+data.balance);
                        chAmount = false;
                    }
                    verifyData();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgAmount").removeClass("text-success");
                    $("#msgAmount").removeClass("text-info");
                    $("#msgAmount").addClass("text-danger");
                    $("#msgAmount").text("Error al verificar el saldo");
                }
            });
        }

        if (id == '') $("#msgAccount").text("Seleccione una cuenta por favor");
        if (amount == '') {
            $("#msgAmount").removeClass("text-success");
            $("#msgAmount").removeClass("text-info");
            $("#msgAmount").addClass("text-danger");
            $("#msgAmount").text("Debe ingresar una cantidad");
        }
    }

    function verifyData() {
        /* if (chAmount) $("#saveTransfer").prop("disabled", false);
        else $("#saveTransfer").prop("disabled", true); */
    }
</script>