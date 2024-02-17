<?php 
    $dep = $this->crud_model->getDepartureByID($departure_id);
    $pols = $this->crud_model->getPolicyByDep($departure_id);
    $cont = 1;
?>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="card-b">
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-lg-6">
                                <div class="mb-3" style="float: right;">
                                    <div class="btn-group focus-btn-group">
                                        <a class="btn btn-info" href="<?php echo base_url();?>doctor/departures/">
                                            <i class="bx bx-arrow-back"></i> Ir a partidas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach($pols->result_array() as $pol):
                        $nom = $this->crud_model->getNomen($pol['nomenclature_id']);
                        $acc = $this->crud_model->getAccountByNomen($pol['nomenclature_id']);
                        $bank = $this->crud_model->getBank($acc['bank_id']);
                        $doc = ''; $reference = '';
                        if ($pol['reference_bank'] == 'bank_check') {
                            $doc = $this->crud_model->getBankCheck($pol['reference_id']);
                            $reference = $doc['no_check'];
                        } elseif ($pol['reference_bank'] == 'bank_transfer') {
                            $doc = $this->crud_model->getBankTransfer($pol['reference_id']);
                            $reference = $doc['code'];
                        }?>
                    <div class="mb-2">
                        <form action="<?php echo base_url();?>doctor/printPDF/policy/" method="POST" id="frmP" enctype="multipart/form-data" target="_blank">
                            <div class="row">
                                <input type="hidden" name="policy_id" id="policy_id_<?php echo $cont;?>" value="<?php echo $pol['policy_id'];?>">
                                <input type="hidden" name="departure_id" id="departure_id" value="<?php echo $pol['departure_id'];?>">
                                <div class="col-sm-12 mb-1">
                                    <h4 class="card-title">Rubro: <?php echo $nom['code']." - ".$nom['name'];?></h4>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label">No de póliza:</label>
                                        <input type="text" class="form-control" name="no_policy" value="<?php echo $pol['no_policy'];?>" required readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo de póliza:</label>
                                        <input type="text" class="form-control" name="type" value="<?php echo $pol['type'];?>" required />
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Concepto:</label>
                                        <input type="text" class="form-control" name="concept" value="<?php echo $pol['concept'];?>" />
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3" style="display:<?php if(count($acc) > 0) echo "block"; else echo "none";?>;">
                                    <div class="form-group">
                                        <div class="form-check form-switch form-switch-lg" dir="ltr">
                                            <input class="form-check-input" type="checkbox" name="bank" id="bank" value="1" <?php if(count($acc) > 0 && $pol['bank'] == 1) echo "checked";?> onclick="showBank(this, <?php echo $cont;?>)">
                                            <label class="form-check-label" for="bank">Banco</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3" id="divCheck_<?php echo $cont;?>" style="display:<?php if(count($acc) > 0 && $pol['bank'] == 1) echo "block"; else echo "none";?>;">
                                    <div class="row">
                                        <input type="hidden" name="reference_id" id="reference_id_<?php echo $cont;?>" value="<?php echo $pol['reference_id'];?>" />
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Tipo de documento</label>
                                                <select class="form-select" id="reference_bank_<?php echo $cont;?>" name="reference_bank" onchange="searchNoCheckEdit(<?php echo $cont;?>)" >
                                                    <option value="bank_check" <?php if($pol['reference_bank'] == "bank_check" || $pol['reference_bank'] == '') echo "selected";?>>Cheque</option>
                                                    <option value="bank_transfer" <?php if($pol['reference_bank'] == "bank_transfer") echo "selected";?>>Transferencia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="col-form-label">No/Código:</label>
                                                <input type="text" class="form-control" name="reference" id="reference_<?php echo $cont;?>" value="<?php echo $reference;?>" onchange="searchNoCheckEdit(<?php echo $cont;?>)" />
                                                <small class="text-success" id="msgRef_<?php echo $cont;?>"><?php if($pol['reference_id'] > 0) echo "Válido";?></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Cuenta Bancaria:</label>
                                                <input type="text" class="form-control" value="<?php echo $acc['code'].' '.$bank['name'];?>" readonly />
                                                <input type="hidden" name="account_id" id="account_id_<?php echo $cont;?>" value="<?php echo $acc['bank_account_id'];?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Aprueba:</label>
                                        <input type="text" class="form-control" name="approve_name" value="<?php echo $pol['approve_name'];?>" placeholder="Nombre" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="approve_charge" value="<?php echo $pol['approve_charge'];?>" placeholder="Cargo" />
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Realiza:</label>
                                        <input type="text" class="form-control" name="maker_name" value="<?php echo $pol['maker_name'];?>" placeholder="Nombre" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="maker_charge" value="<?php echo $pol['maker_charge'];?>" placeholder="Cargo" />
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <button type="submit" class="btn btn-info" id="printDocument_<?php echo $cont;?>">Imprimir documento</button>
                                </div>
                            </div>
                        </form>
                    </div><hr>
                    <?php $cont++; endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function showBank(check, i) {
        var checked = $(check).prop("checked");
        if(checked) $("#divCheck_"+i).show(300);
        else $("#divCheck_"+i).hide(300);
    }

    function searchNoCheckEdit(i) {
        var id = $("#policy_id_"+i).val();
        var reference = $("#reference_"+i).val();
        var type = $("#reference_bank_"+i).val();
        var account_id = $("#account_id_"+i).val();
        if (reference != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/searchNoCheckAccountEdit/",
                data: {
                    id: id,
                    reference: reference,
                    type: type,
                    bank_account_id: account_id,
                },
                dataType: "json",
                beforeSend: function () {
                    check_edit = false;
                    $("#msgRef_"+i).removeClass("text-success");
                    $("#msgRef_"+i).removeClass("text-danger");
                    $("#msgRef_"+i).addClass("text-info");
                    $("#msgRef_"+i).text("Buscando...");
                },
                success: function (data) {
                    console.log(data);
                    if (data.exist <= 0) {
                        $("#reference_id_"+i).val(data.reference_id);
                        $("#msgRef_"+i).removeClass("text-info");
                        $("#msgRef_"+i).removeClass("text-danger");
                        $("#msgRef_"+i).addClass("text-success");
                        $("#msgRef_"+i).text("Válido");
                        verifyData(i, true);
                    } else {
                        $("#msgRef_"+i).removeClass("text-success");
                        $("#msgRef_"+i).removeClass("text-info");
                        $("#msgRef_"+i).addClass("text-danger");
                        if (data.exist == 1) $("#msgRef_"+i).text("Esta registrado en otra póliza");
                        else if (data.exist == 2) $("#msgRef_"+i).text("Invalido o no encontrado");
                        verifyData(i, false);
                    }
                }, 
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgRef_"+i).removeClass("text-success");
                    $("#msgRef_"+i).removeClass("text-info");
                    $("#msgRef_"+i).addClass("text-danger");
                    $("#msgRef_"+i).text("Error al validar");
                    verifyData(i, false);
                }
            });
        }
    }

    function verifyData(i, check) {
        if (check) {
            $("#printDocument_"+i).prop("disabled", false);
        } else {
            $("#printDocument_"+i).prop("disabled", true);
        }
    }
</script>