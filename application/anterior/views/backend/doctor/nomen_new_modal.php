<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>doctor/nomenclature/save/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Nuevo rubro</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Rubro: <small>(0.00.00.000)</small></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="code" id="code" required onblur="searchNomenNew(this.value)" pattern="[1-9]\.[0-9][0-9]\.[0-9][0-9]\.[0-9][0-9][0-9]" />
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-append" style="display: none;" id="divCode"><span class="input-group-text"><div class="text-primary m1" role="status" id="loadCode"><span class="sr-only"></span></div></span></span>
                                </div>
                                <small class="text-danger" id="msgCode"></small>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name" required />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="balance" id="checkBalance" value="1">
                                        <label class="form-check-label" for="checkBalance">
                                            Balance General
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="statement" id="checkEstado" value="1">
                                        <label class="form-check-label" for="checkEstado">
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
                                        <input class="form-check-input" type="checkbox" name="purchase" id="checkPurchase" value="1">
                                        <label class="form-check-label" for="checkPurchase">
                                            Compra
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="calculate_isr" id="checkCalculateISR" value="1">
                                        <label class="form-check-label" for="checkCalculateISR">
                                            Calularle isr
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="move_bank" class="col-form-label">Categoría en libro de bancos</label>
                                <select name="move_bank" id="move_bank" class="form-control">
                                    <option value="">Selecciona una opcion</option>
                                    <?php $moves = $this->crud_model->getMoveBanks();
                                        foreach($moves->result_array() as $mv):?>
                                    <option value="<?php echo $mv['type'];?>"><?php echo $mv['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-success mb-3">
                                        <input class="form-check-input" type="checkbox" name="ledger" id="checkLedger" value="1">
                                        <label class="form-check-label" for="checkLedger">
                                            Libro Mayor
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="col-form-label">Descripción:</label>
                                <textarea rows="3" cols="" class="form-control" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm" id="saveNomen">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var rubro = false;
    
    function verifyInfo() {
        if (rubro) {
            $("#saveNomen").attr("disabled", false);
        } else {
            $("#saveNomen").attr("disabled", true);
        }
    }
    
    function searchNomenNew(code) {
        if (code != ""){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/searchNomenNew/",
                data: {
                    code: code,
                },
                beforeSend: function () {
                    rubro = false;
                    $("#msgCode").text("");
                    $("#loadCode").addClass("spinner-border");
                    $("#divCode").show(300);
                    verifyInfo();
                },
                success: function (response) {
                    console.log(response);
                    if (response <= 0) {
                        rubro = true;
                        $("#msgCode").removeClass("text-danger");
                        $("#msgCode").addClass("text-success");
                        $("#msgCode").text("Código aún no utilizado");
                        $("#loadCode").removeClass("spinner-border");
                        $("#divCode").hide(300);
                    } else {
                        rubro = false;
                        $("#msgCode").removeClass("text-success");
                        $("#msgCode").addClass("text-danger");
                        $("#msgCode").text("Código ya registrado");
                        $("#loadCode").removeClass("spinner-border");
                        $("#divCode").hide(300);
                    }
                    verifyInfo();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    rubro = false;
                    $("#msgCode").removeClass("text-success");
                    $("#msgCode").addClass("text-danger");
                    $("#msgCode").text("Error al buscar");
                    $("#loadCode").removeClass("spinner-border");
                    $("#divCode").hide(300);
                    verifyInfo();
                }
            });
        } else {

        }
    }
</script>