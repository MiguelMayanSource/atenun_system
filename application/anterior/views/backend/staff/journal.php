<?php 
    $diario = $this->crud_model->getJournal($initial, $final, $nom_id);
    $rubros = $this->crud_model->getNomenclature();
    $debe = 0; $haber = 0;
?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .container-justify {
        display: flex;
        justify-content: space-between;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>staff/accounting/">Regresar</a>
                <a class="add-buton" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_books/')">Libros contables</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12 mb-2">
                            <div class="title-header">
                                <a class="" href="javascript:void(0);">Libro Diario</a>
                            </div>
                            <form class="repeater" action="<?php echo base_url();?>staff/journal/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="">Rubro</label>
                                        <select class="form-control select2-rubro" name="nomenclature_id" id="nomenclature_id" onchange="this.form.submit()">
                                            <option value="T" <?php if($nom_id == '' || $nom_id == 'T') echo "selected";?>>Todos</option>
                                            <?php foreach ($rubros->result_array() as $rb):?>
                                            <option value="<?php echo $rb['nomenclature_id'];?>" <?php if($rb['nomenclature_id'] == $nom_id) echo "selected";?>><?php echo $rb['code'].' '.$rb['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Fecha inicial</label>
                                        <input type="date" class="form-control" name="initial" id="initial" value="<?php echo $initial;?>" />
                                        <small class="text-danger" id="msgInicial"></small>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Fecha final</label>
                                        <input type="date" class="form-control" name="final" id="final" value="<?php echo $final;?>" />
                                        <small class="text-danger" id="msgFinal"></small>
                                    </div>
                                    <div class="col-lg-4">
                                        <br>
                                        <div class="">
                                            <button class="btn btn-info" type="submit">Ver</button>
                                            &nbsp;
                                            &nbsp;
                                            <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType('PDF')" />
                                            &nbsp;
                                            &nbsp;
                                            <input type="button" class="btn btn-success" value="EXCEL" onclick="submitFormType('EXCEL')" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%">#</th>
                                        <th class="text-center" style="width: 40%"></th>
                                        <th class="text-center" style="width: 25%">DEBE</th>
                                        <th class="text-center" style="width: 25%">HABER</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <?php foreach($diario->result_array() as $dr):?>
                        <div class="col-lg-12 mb-0">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%"><?php echo $dr['departure_id'];?></th>
                                        <th class="text-center" style="width: 40%"><?php echo date("d/m/Y", strtotime($dr['date']));?></th>
                                        <th class="text-center" style="width: 25%"></th>
                                        <th class="text-center" style="width: 25%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $detalles = $this->crud_model->getDetailsDeparture($dr['departure_id']);
                                        foreach ($detalles->result_array() as $dt): 
                                        $nomen_id = $dt['nomenclature_id']; $nom = $this->crud_model->nomenByID($nomen_id);?>
                                    <tr>
                                        <td></td>
                                        <td><b><?php echo $nom['code'].' '.$nom['name'];?></b></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b><?php if($dt['debit'] != '') echo 'Q';?><b></div>
                                                <div><b><?php if($dt['debit'] != '') echo number_format($dt['debit'],2,".",",");?><b></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b><?php if($dt['credit'] != '') echo 'Q';?><b></div>
                                                <div><b><?php if($dt['credit'] != '') echo number_format($dt['credit'],2,".",",");?><b></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $debe += $dt['debit']; $haber += $dt['credit']; endforeach;?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-center"><?php echo $dr['details'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b>Q<b></div>
                                                <div><b><u><?php echo number_format($dr['total'],2,".",",");?></u></b></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b>Q<b></div>
                                                <div><b><u><?php echo number_format($dr['total'],2,".",",");?></u><b></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php endforeach;?>
                        <div class="col-lg-12">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%"></th>
                                        <th style="width: 40%; text-align: right;"><u>TOTALES:</u></th>
                                        <th style="width: 25%;">
                                            <div class="container-justify">
                                                <div><b>Q<b></div>
                                                <div><b><u><?php echo number_format($debe,2,".",",");?></u><b></div>
                                            </div>
                                        </th>
                                        <th style="width: 25%;">
                                            <div class="container-justify">
                                                <div><b>Q<b></div>
                                                <div><b><u><?php echo number_format($haber,2,".",",");?></u><b></div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="<?php echo base_url();?>staff/printFormType/journal" id="frmJ" target="">
            <input type="hidden" name="nom_id" value="<?php echo $nom_id;?>" />
            <input type="hidden" name="initial" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" value="<?php echo $final;?>" />
            <input type="hidden" name="type" id="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.select2-rubro').select2({
        placeholder: "Escribe el código o nombre de algún rubro",
    });

    function submitFormType(type) {
        validateForm();
        $("#type").val(type);
        if (type == "PDF" || type == "PDFC") $("#frmJ").attr("target", "_blank");
        else $("#frmJ").attr("target", '');
        $("#frmJ").submit();
    }

    function validateForm() {
        var initial = $("#initial").val();
        var final = $("#final").val();

        if (initial == '') $("#msgInicial").text("La fecha inicial está vacía.");
        if (final == '') $("#msgFinal").text("La fecha final está vacía.");
    }
</script>