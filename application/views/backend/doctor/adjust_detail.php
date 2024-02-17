<?php 
    $close = $this->crud_model->getClosingById($closing_id); 
    $dep = $this->crud_model->getDepByACR("closing", $closing_id); 
    $det = $this->crud_model->getDetailsDeparture($dep['departure_id']);
    $l = 4; if ($close['type'] == "month") $l = 3;
    $debit = 0; $credit = 0;
?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<style type="text/css">
    .btn-toolbar {
        display: none !important;
    }

    .container-justify {
        display: flex;
        justify-content: space-between;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title mb-4">Inicio de partida</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3" style="float: right;">
                                <div class="btn-group focus-btn-group">
                                    <a class="btn btn-info" href="<?php echo base_url();?>doctor/adjust/">
                                        <i class="bx bx-arrow-back"></i> Ir a ajustes
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="row">
                                        <div class="col-lg-<?php echo $l;?> mb-3">
                                            <h5 class="mb-3">Categoría</h5>
                                            <h4>
                                                <?php if($close['category'] == "furnit_equip") echo "Dep. Mobiliario y equipo";
                                                    elseif($close['category'] == "computer_equip") echo "Dep. Equipo de Computación";
                                                    elseif($close['category'] == "machinery") echo "Dep. Maquinaria";
                                                    elseif($close['category'] == "buildings") echo "Dep. Edificios";
                                                    elseif($close['category'] == "bank_loans") echo "Prestamos bancarios";
                                                    elseif($close['category'] == "other") echo "Otro";?>
                                            </h4>
                                        </div>
                                        <div class="col-lg-<?php echo $l;?>">
                                            <h5 class="mb-3">Tipo</h5>
                                            <h4><?php if($close['type'] == "year") echo "Anual"; elseif($close['type'] == "month") echo "Mensual";?></h4>
                                        </div>
                                        <div class="col-lg-<?php echo $l;?>">
                                            <h5 class="mb-3">Período</h5>
                                            <h4><?php echo $close['period'];?></h4>
                                        </div>
                                        <?php if($close['type'] == "month"):?>
                                        <div class="col-lg-3" id="divMonth" style="display:none;">
                                            <h5 class="mb-3">Mes</h5>
                                            <h4><?php echo $close['period']; if($close['type'] == "mont") echo ucfirst(strftime("%B", strtotime($close['period'].'-'.$close['month']."-01")));?></h4>
                                        </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="divDeparture">
                                    <div class="">
                                        <table class="table table-bordered mb-3">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width:20%"></th>
                                                    <th style="width:25%"></th>
                                                    <th style="width:25%"></th>
                                                    <th style="width:15%">Debe</th>
                                                    <th style="width:15%">Haber</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($det->result_array() as $dt):
                                                    if ($dt['type'] == 'nomenclature') $nom = $this->crud_model->getNomen($dt['nomenclature_id']);
                                                    elseif ($dt['type'] == 'group_account') $nom = $this->crud_model->getGroup($dt['nomenclature_id']);?>
                                                <tr>
                                                    <td><?php echo $nom['code'];?></td>
                                                    <td><?php if($dt['debit'] != '' || $dt['position'] == 'D') echo $nom['name'];?></td>
                                                    <td><?php if($dt['credit'] != '' || $dt['position'] == 'C') echo $nom['name'];?></td>
                                                    <td>
                                                        <?php if($dt['debit'] != ''):?>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><?php echo number_format($dt['debit'],2,'.',',');?></div>
                                                        </div>
                                                        <?php endif;?>
                                                    </td>
                                                    <td>
                                                        <?php if($dt['credit'] != ''):?>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><?php echo number_format($dt['credit'],2,'.',',');?></div>
                                                        </div>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                                <?php $debit += $dt['debit']; $credit += $dt['credit']; endforeach;?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3"><?php echo $dep['details'];?></th>
                                                    <th>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><?php echo number_format($debit,2,'.',',');?></div>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><?php echo number_format($credit,2,'.',',');?></div>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
</script>