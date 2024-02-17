<?php 
    $cuentas = $this->crud_model->getLedger($initial, $final, $nomenclature_id);
    $rubros = $this->crud_model->getNomenclature();
    $totalDebe = 0; $totalHaber = 0; $count = 1; $signo = '';
?>
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
                        <div class="col-lg-12">
                            <div class="title-header">
                                <a class="" href="javascript:void(0);">Libro mayor</a>
                            </div>
                            <form class="repeater" action="<?php echo base_url();?>staff/ledger/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="">Rubro</label>
                                        <select class="form-control select2-rubro" name="nomenclature_id" id="nomenclature_id" onchange="this.form.submit()">
                                            <option value="T" <?php if($nomenclature_id == '' || $nomenclature_id == 'T') echo "selected";?>>Todos</option>
                                            <?php foreach ($rubros->result_array() as $rb):?>
                                            <option value="<?php echo $rb['nomenclature_id'];?>" <?php if($rb['nomenclature_id'] == $nomenclature_id) echo "selected";?>><?php echo $rb['code'].' '.$rb['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Fecha inicial</label>
                                        <input type="date" class="form-control" name="initial" value="<?php echo $initial;?>" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Fecha final</label>
                                        <input type="date" class="form-control" name="final" value="<?php echo $final;?>" />
                                    </div>
                                    <div class="col-lg-6">
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
                        <div class="col-lg-9">
                            
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Buscar</label>
                                <input type="search" class="form-control" name="search" id="search" value="" onkeyup="searchValues(this.value)" />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table class="table mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 10%">#</th>
                                        <th class="text-center" style="width: 40%">CUENTA</th>
                                        <th class="text-center" style="width: 25%">DEBE</th>
                                        <th class="text-center" style="width: 25%">HABER</th>
                                    </tr>
                                </thead>
                                <?php foreach($cuentas->result_array() as $ct): 
                                    $exNom = explode('.', $ct['code']);
                                    $tipo = $exNom[0];
                                    $debe = 0; $haber = 0; $restante = 0;
                                ?>
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 10%"><?php echo $count++;?></th>
                                        <th class="text-center" style="width: 40%"><?php echo $ct['code'].' '.$ct['name'];?></th>
                                        <th class="text-center" style="width: 25%"></th>
                                        <th class="text-center" style="width: 25%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $detalles = $this->crud_model->getDetailLedger($ct['nomenclature_id'], $initial, $final);
                                        foreach ($detalles->result_array() as $dt):?>
                                    <tr>
                                        <td><?php echo date("d/m/Y", strtotime($dt['date']));?></td>
                                        <td><a href="<?php echo base_url().'staff/departure_edit/'.base64_encode($dt['departure_id']);?>"><?php echo $dt['details'];?></a></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b><?php if($dt['debit'] != '') echo 'Q';?></b></div>
                                                <div><b><?php if($dt['debit'] != '') echo number_format($dt['debit'],2,".",",");?></b></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b><?php if($dt['credit'] != '') echo 'Q';?></b></div>
                                                <div><b><?php if($dt['credit'] != '') echo number_format($dt['credit'],2,".",",");?></b></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $debe += $dt['debit']; $haber += $dt['credit']; endforeach;?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b>Q</b></div>
                                                <div><b><u><?php echo number_format($debe,2,".",",");?></u></b></div>
                                            </div>
                                        <td>
                                            <div class="container-justify">
                                                <div><b>Q</b></div>
                                                <div><b><u>Q.<?php echo number_format($haber,2,".",",");?></u></b></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php if($tipo == 1 || $tipo == 5) $restante = $debe - $haber; if($tipo == 2 || $tipo == 3 || $tipo == 4) $restante = $haber - $debe;
                                        if($restante < 0) $signo = '-'; else $signo = '';?>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: right;"><b>SALDO:</b></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b><?php if($tipo == 1 || $tipo == 5) echo $signo.'Q';?></b></div>
                                                <div><b><u><?php if($tipo == 1 || $tipo == 5) echo number_format(abs($restante),2,".",",");?></u></b></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <div><b><?php if($tipo == 2 || $tipo == 3 || $tipo == 4) echo $signo.'Q';?></b></div>
                                                <div><b><u><?php if($tipo == 2 || $tipo == 3 || $tipo == 4) echo number_format(abs($restante),2,".",",");?></u></b></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php endforeach;?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="<?php echo base_url();?>staff/printFormType/ledger/" id="frmL" target="">
            <input type="hidden" name="initial" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" value="<?php echo $final;?>" />
            <input type="hidden" name="nomenclature_id" value="<?php echo $nomenclature_id;?>" />
            <input type="hidden" name="type" id="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.select2-rubro').select2({
        placeholder: "Escribe el código o nombre de algún rubro",
    });

    $(document).ready(function () {
        /* $('#datatable').DataTable({
            "aaSorting": [],
            'bPaginate': false
        }); */
    });

    function submitFormType(type) {
        validateForm();
        $("#type").val(type);
        if (type == "PDF" || type == "PDFC") $("#frmL").attr("target", "_blank");
        else $("#frmL").attr("target", '');
        $("#frmL").submit();
    }

    function validateForm() {
        var initial = $("#initial").val();
        var final = $("#final").val();

        if (initial == '') $("#msgInicial").text("La fecha inicial está vacía.");
        if (final == '') $("#msgFinal").text("La fecha final está vacía.");
    }
    
    function searchValues(value) {
        console.log("Value search:", value);
        var text = value.toLowerCase();
        console.log("Text search:", text);
        $("#datatable tbody tr").filter(function() {
            /* var index = $(this).text().toLowerCase();
            console.log("Text value:", index); */
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    }
</script>