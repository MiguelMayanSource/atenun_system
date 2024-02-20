<?php
    $nomen_id = base64_decode($param2);
    $nomen = $this->crud_model->nomenByID($nomen_id);
?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>staff/nomenclature/edit_nomen/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Actualizar rubro</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="nomenclature_id" id="nomen_id" value="<?php echo $nomen_id;?>">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Rubro: <small>(0.00.00.000)</small></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="code" value="<?php echo $nomen['code'];?>" pattern="[1-9]\.[0-9][0-9]\.[0-9][0-9]\.[0-9][0-9][0-9]" required onblur="searchNomenEdit(this.value)" />
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-append" style="display: none;" id="divCodeM"><span class="input-group-text"><div class="text-primary m1" role="status" id="loadCodeM"><span class="sr-only"></span></div></span></span>
                                </div>
                                <small class="text-danger" id="msgCodeM"></small>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $nomen['name'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="balance" id="checkBalanceM" value="1" <?php if($nomen['balance'] == 1) echo "checked";?>>
                                        <label class="form-check-label" for="checkBalanceM">
                                            Balance General
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="statement" id="checkEstadoM" value="1"  <?php if($nomen['statement'] == 1) echo "checked";?>>
                                        <label class="form-check-label" for="checkEstadoM">
                                            Estado de Resultados
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="purchase" id="checkPurchaseM" value="1" <?php if($nomen['purchase'] == 1) echo "checked";?>>
                                        <label class="form-check-label" for="checkPurchaseM">
                                            Compra
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="calculate_isr" id="checkCalculateISRM" value="1" <?php if($nomen['calculate_isr'] == 1) echo "checked";?>>
                                        <label class="form-check-label" for="checkCalculateISRM">
                                            Calcularle isr
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="move_bank_edit" class="col-form-label">Categoría en libro de bancos</label>
                                <select id="move_bank_edit" name="move_bank" class="form-select">
                                    <option value="">Selecciona una opcion</option>
                                    <?php $moves = $this->crud_model->getMoveBanks();
                                        foreach($moves->result_array() as $mv):?>
                                    <option value="<?php echo $mv['type'];?>" <?php if($mv['type'] == $nomen['move_bank']) echo "selected";?>><?php echo $mv['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="ledger" id="checkLedgerM" value="1" <?php if($nomen['ledger'] == 1) echo "checked";?>>
                                        <label class="form-check-label" for="checkLedgerM">
                                            Libro Mayor
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="col-form-label">Descripción:</label>
                                <textarea rows="3" cols="" class="form-control" name="description"><?php echo $nomen['description'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="editNomen">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var codigo = '<?php echo $nomen['code'];?>';
    var rubroM = true;
    
    $(document).ready(function () {
        verifyInfoM();
    });

    function verifyInfoM() {
        if (rubroM) {
            $("#editNomen").attr("disabled", false);
        } else {
            $("#editNomen").attr("disabled", true);
        }
    }
    
    function searchNomenEdit(code) {
        if (code != "" && code != codigo){
            var id = $("#nomen_id").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/searchNomenEdit/",
                data: {
                    id: id,
                    code: code,
                },
                beforeSend: function () {
                    rubroM = false;
                    $("#msgCodeM").text("");
                    $("#loadCodeM").addClass("spinner-border");
                    $("#divCodeM").show(300);
                    verifyInfoM();
                },
                success: function (response) {
                    console.log(response);
                    if (response <= 0) {
                        rubroM = true;
                        $("#msgCodeM").removeClass("text-danger");
                        $("#msgCodeM").addClass("text-success");
                        $("#msgCodeM").text("Código válido");
                        $("#loadCodeM").removeClass("spinner-border");
                        $("#divCodeM").hide(300);
                    } else {
                        rubroM = false;
                        $("#msgCodeM").removeClass("text-success");
                        $("#msgCodeM").addClass("text-danger");
                        $("#msgCodeM").text("Código ya registrado");
                        $("#loadCodeM").removeClass("spinner-border");
                        $("#divCodeM").hide(300);
                    }
                    verifyInfoM();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    rubroM = false;
                    $("#msgCodeM").removeClass("text-success");
                    $("#msgCodeM").addClass("text-danger");
                    $("#msgCodeM").text("Error al buscar");
                    $("#loadCodeM").removeClass("spinner-border");
                    $("#divCodeM").hide(300);
                    verifyInfoM();
                }
            });
        }
        
        if(code == codigo){
            rubroM = true;
            $("#msgCodeM").text("");
            $("#divCodeM").hide(300);
            verifyInfoM();
        }
    }
</script>