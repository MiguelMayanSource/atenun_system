<?php
    $hoy = date("Y-m-d");
    $totalIngresos = 0;
    $totalEgresos = 0;
    $ventas = 0;
    $mercaderias = 0;
    $compras = 0;
    $operacion = 0;
    $margen = 0;
    $admin = 0;
    $financieros = 0;
    $productos = 0;
    $gastos = 0;
    $restante = 0;
    setlocale(LC_TIME,"es_ES");
?>
<style type="text/css">
    .top-edge { 
        border-top-width: 1.5px !important; 
        border-top-color: #000 !important;
    }

    .bottom-edge { 
        border-bottom-width: 1.5px !important; 
        border-bottom-color: #000 !important;
    }

    .bottom-edge-double {
        border-bottom-style: double !important; 
        border-bottom-width: 4.5px !important; 
        border-bottom-color: #000 !important;
    }
    
    .container-justify {
        display: flex;
        justify-content: space-between; /* Can be changed in the live sample */
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>doctor/accounting/">Regresar</a>
                <a class="add-buton" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_books/')">Libros contables</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="title-header">
                                <h4 class="card-title text-center">ESTADO DE RESULTADOS</h4>
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("description");?></h4>
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("system_name");?></h4>
                            </div>
                            <form class="repeater" action="<?php echo base_url();?>doctor/statement/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="initial" value="<?php echo $initial;?>" required />
                                                <input type="date" class="form-control" name="final" value="<?php echo $final;?>" required />
                                                <button class="btn btn-info" type="submit">Ver</button>
                                            </div>
                                            <small class="text-danger" id="msgDates"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-3"></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 15%">Rubro</th>
                                        <th class="text-center" style="width: 40%"></th>
                                        <th class="text-center" style="width: 15%"></th>
                                        <th class="text-center" style="width: 15%"></th>
                                        <th class="text-center" style="width: 15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $group = $this->crud_model->getGroupByCode("4.01.01");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo $group['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("4.02.01.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
                                        $ventas += $total;
                                        $totalIngresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("4.01.01.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4, 1);
                                        $ventas += $total;
                                        $totalIngresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("4.01.01.002");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
                                        $ventas += $total;
                                        $totalIngresos += $total; ?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Ventas Netas</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($totalIngresos < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($totalIngresos),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>menos</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCode("5.01.01");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo $group['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.01.01.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $mercaderias += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.01.01.002");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $compras += $total;
                                        $mercaderias += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.01.01.003");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $compras += $total;
                                        $mercaderias += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.01.01.006");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $compras += $total;
                                        $mercaderias += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($compras < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($compras),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.01.01.007");?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($mercaderias < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($mercaderias),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.01.01.008");
                                        $total = 0;
                                        /*if (strtotime($final) < strtotime($hoy)) $total = $this->crud_model->getTotalInventory($final);
                                        else $total = $this->crud_model->getTotalInventory();*/
                                        if ($mercaderias > $total) $totalMerc = $mercaderias - $total;
                                        else $totalMerc = $total - $mercaderias;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($totalMerc < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($totalMerc),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.01.01.009");
                                        $total = $totalIngresos - $totalMerc;
                                        $totalEgresos += $totalMerc;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCode("5.02.01");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo $group['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.001");?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.002");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.003");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.004");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.005");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.006");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.007");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.008");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.009");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.010");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.011");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.012");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.013");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.014");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.015");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.016");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.017");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.018");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.019");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.020");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.021");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $operacion += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="bottom-edge"></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($operacion < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($operacion),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.022");
                                        $margen = $totalIngresos - $totalEgresos;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($margen < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($margen),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.023");?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.024");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $admin += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.025");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $admin += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.026");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $admin += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.027");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $admin += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.028");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $admin += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="bottom-edge"></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($admin < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($admin),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.02.01.034"); 
                                        $margen = $totalIngresos - $totalEgresos;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($margen < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($margen),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCode("5.03.01");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo $group['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.03.01.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $financieros += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.03.01.002");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $financieros += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.03.01.003");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $financieros += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.03.01.004");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $financieros += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.03.01.005");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $financieros += $total;
                                        $totalEgresos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($financieros < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($financieros),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCode("5.04.01");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo $group['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.04.01.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $productos += $total;
                                        $totalEgresos -= $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("5.04.01.002");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                                        $productos += $total;
                                        $totalEgresos -= $total;
                                        $gastos = $financieros - $productos;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($productos < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($productos),2,".",",");?></div>
                                            </div>
                                        </td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($gastos < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($gastos),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $head = $this->crud_model->getHeadByCode("3.02");
                                        $restante = $totalIngresos - $totalEgresos;?>
                                    <tr>
                                        <td><?php echo $head['code'];?></td>
                                        <td><?php echo $head['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php if ($restante >= 0):
                                        $utilidad = $this->crud_model->getGroupEquityLike("ganancia", $head['heading_id']);?>
                                    <?php foreach($utilidad->result_array() as $ut):?>
                                    <tr>
                                        <td><?php echo $ut['code'];?></td>
                                        <td><?php echo $ut['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $cuentas = $this->crud_model->getNomenLikeStatement("del periodo", $ut['heading_type_id'], $ut['heading_id'], $ut['group_account_id']);
                                        foreach($cuentas->result_array() as $ct):?>
                                    <tr>
                                        <td><?php echo $ct['code'];?></td>
                                        <td><?php echo $ct['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div>Q</div>
                                                <div><?php echo number_format(abs($restante),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; endforeach; else: 
                                        $perdida = $this->crud_model->getGroupEquityLike("perdida", $head['heading_id']);?>
                                    <?php foreach($perdida->result_array() as $pd):?>
                                    <tr>
                                        <td><?php echo $pd['code'];?></td>
                                        <td><?php echo $pd['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; endif;
                                        if ($restante > 0):?>
                                    <?php $head = $this->crud_model->getHeadByCode("3.01");
                                        $reserva = $this->crud_model->getGroupEquityLike("reserva", $head['heading_id']);?>
                                    <?php foreach($reserva->result_array() as $rs):?>
                                    <tr>
                                        <td><?php echo $rs['code'];?></td>
                                        <td><?php echo $rs['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $cuentas = $this->crud_model->getNomenGeneral($rs['heading_type_id'], $rs['heading_id'], $rs['group_account_id']);
                                        $legal = $restante * 0.05;
                                        foreach($cuentas->result_array() as $ct):?>
                                    <tr>
                                        <td><?php echo $ct['code'];?></td>
                                        <td><?php echo $ct['name'];?></td>
                                        <td></td>
                                        <td class="bottom-edge"></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($legal < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($legal),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; endforeach; $restante -= $legal; endif;
                                        $head = $this->crud_model->getHeadByCode("3.02");
                                        if ($restante >= 0) $neta = $this->crud_model->getGroupEquityLike("ganancia", $head['heading_id']);
                                        else $neta = $this->crud_model->getGroupEquityLike("perdida", $head['heading_id']);
                                    ?>
                                    <?php foreach($neta->result_array() as $nt):
                                        $cuentas = $this->crud_model->getNomenLikeStatement("neta del ejercicio", $nt['heading_type_id'], $nt['heading_id'], $nt['group_account_id']);?>
                                    <?php foreach($cuentas->result_array() as $ct):?>
                                    <tr>
                                        <td><?php echo $ct['code'];?></td>
                                        <td><?php echo $ct['name'];?></td>
                                        <td></td>
                                        <td class="bottom-edge-double"></td>
                                        <td class="bottom-edge-double">
                                            <div class="container-justify">
                                                <div><?php if($restante < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($restante),2,".",",");?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <textarea rows="5" cols="" class="form-control" name="description">El infrainscrito contador registrado ante la superintendencia de administración tributaria bajo el numero de registro 12345 CERTIFICA que el presente Estado de Resultados presenta razonablemente la sutación económica de la empresa de conformidad con los Principios de Contabilidad Generalmente aceptados por el periodo dado</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("address").' '.strftime("%d de %B del %Y")?></h4>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div>
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="legal_name" id="legal_name" value="" placeholder="Nombre" required />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="legal_charge" id="legal_charge" value="Representante legal" placeholder="Cargo" required />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div>
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="account_name" id="account_name" value="" placeholder="Nombre" required />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="account_charge" id="account_charge" value="Contador" placeholder="Cargo" required />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType('PDF')" />
                            &nbsp;&nbsp;
                            <input type="button" class="btn btn-success" value="Excel" onclick="submitFormType('EXCEL')" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="<?php echo base_url();?>doctor/printFormType/statement/" id="frmS" target="">
            <input type="hidden" name="initial" id="initial_hidden" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" id="final_hidden" value="<?php echo $final;?>" />
            <input type="hidden" name="description" id="description_hidden" value="El infrainscrito contador registrado ante la superintendencia de administración tributaria bajo el numero de registro 12345 CERTIFICA que el presente Estado de Resultados presenta razonablemente la sutación económica de la empresa de conformidad con los Principios de Contabilidad Generalmente aceptados por el periodo dado" />
            <input type="hidden" name="legal_name" id="legal_name_hidden" />
            <input type="hidden" name="legal_charge" id="legal_charge_hidden" value="Representante legal" />
            <input type="hidden" name="account_name" id="account_name_hidden" />
            <input type="hidden" name="account_charge" id="account_charge_hidden" value="Contador" />
            <input type="hidden" name="type" id="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    function submitFormType(type) {
        $("#type").val(type);
        if (type == "PDF") $("#frmS").attr("target", "_blank");
        else $("#frmS").attr("target", '');
        validateForm();
        $("#frmS").submit();
    }
    
    function validateForm() {
        var initial = $("#initial").val();
        var final = $("#final").val();
        var description = $("#description").val();
        var legal_name = $("#legal_name").val();
        var legal_charge = $("#legal_charge").val();
        var account_name = $("#account_name").val();
        var account_charge = $("#account_charge").val();

        if (initial == '' || final == '') $("#msgDates").text("La fecha inicial o final está vacía.");
        if (description == '') $("#msgDescription").text("Ingrese una descripción.");
        if (legal_name == '') $("#msgLegalName").text("Ingrese un nombre.");
        if (legal_charge == '') $("#msgLegalCharge").text("Ingrese un cargo.");
        if (account_name == '') $("#msgAccountName").text("Ingrese un nombre.");
        if (account_charge == '') $("#msgAccountCharge").text("Ingrese un cargo.");
    }

    $("#description").on("change keyup paste", function () {
        var desc = $(this).val();
        if (desc != '') $("#msgDescription").text('');
        else $("#msgDescription").text("Ingrese una descripción.");
        $("#description_hidden").val(desc);
    });

    $("#legal_name").on("input", function () {
        var name = $(this).val();
        $("#legal_name_hidden").val(name);
    });

    $("#legal_charge").on("input", function () {
        var charge = $(this).val();
        if (charge != '') $("#msgLegalCharge").text('');
        else $("#msgLegalCharge").text("Ingrese un cargo.");
        $("#legal_charge_hidden").val(charge);
    });
    
    $("#account_name").on("input", function () {
        var name = $(this).val();
        $("#account_name_hidden").val(name);
    });

    $("#account_charge").on("input", function () {
        var charge = $(this).val();
        if (charge != '') $("#msgAccountCharge").text('');
        else $("#msgAccountCharge").text("Ingrese un cargo.");
        $("#account_charge_hidden").val(charge);
    });
</script>