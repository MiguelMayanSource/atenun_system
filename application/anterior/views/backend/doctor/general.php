<?php 
    $hoy = date("Y-m-d");
    $tipos = $this->crud_model->getHeadsTypesGeneral();
    $val = $this->crud_model->getUtilityGeneral($initial, $final);
    $cashes = $this->crud_model->getCashNomen();
    $cash = 0;
    $pettyCash = $this->crud_model->getPettyCash();
    $cash_petty = 0;
    $activo = 0; $act_corriente = 0; $act_no_corriente = 0;
    $pasivo = 0; $pas_corriente = 0; $pas_no_corriente = 0;
    $patrimonio = 0; $capital = 0; $utilidad = 0;
    $reserva = $val['legal']; $bruta = $val['gross']; $neta = $val['net'];
    $bancos = 0; $cuentas_cobrar = 0; $deprec = 0;
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

    .bottom-double-edge {
        border-bottom-style: double !important; 
        border-bottom-width: 4.5px !important; 
        border-bottom-color: #000 !important;
    }
    
    .container-justify {
        display: flex;
        justify-content: space-between;
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
                        <div class="col-lg-12">
                            <div class="title-header">
                                <h4 class="card-title text-center">BALANCE GENERAL</h4>
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("description");?></h4>
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("system_name");?></h4>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6 mb-3">
                            <form class="repeater" action="<?php echo base_url();?>doctor/general/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="initial" id="initial" value="<?php echo $initial;?>" required />
                                                <input type="date" class="form-control" name="final" id="final" value="<?php echo $final;?>" required />
                                                <button class="btn btn-info" type="submit">Ver</button>
                                            </div>
                                            <small class="text-danger" id="msgDates"></small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-3"></div>
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
                                    <?php $type = $this->crud_model->getHeadTypeByCode("1");?>
                                    <tr>
                                        <td><?php echo $type['code'];?></td>
                                        <td class="text-center"><?php echo $type['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $head = $this->crud_model->getHeadByCode("1.01");?>
                                    <tr>
                                        <td><?php echo $head['code'];?></td>
                                        <td><?php echo strtoupper($head['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nCash = 1; foreach ($cashes->result_array() as $ch):
                                        $total = $this->crud_model->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
                                        $activo += $total; $act_corriente += $total; $cash += $total;?>
                                    <tr>
                                        <td><?php echo $ch['code'];?></td>
                                        <td><?php echo $ch['name'];?></td>
                                        <td>
                                            <?php if($cashes->num_rows() > 1):?>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <?php if($cashes->num_rows() == 1):?>
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                                <?php endif;?>
                                                <?php if($cashes->num_rows() > 1 && $cashes->num_rows() == $nCash):?>
                                                <div><?php if($cash < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($cash),2,'.',',');?></div>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nCash++; endforeach;?>
                                    <?php $nPetCash = 1; foreach ($pettyCash->result_array() as $ch):
                                        $total = $this->crud_model->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
                                        $activo += $total; $act_corriente += $total; $petty_cash += $total;?>
                                    <tr>
                                        <td><?php echo $ch['code'];?></td>
                                        <td><?php echo $ch['name'];?></td>
                                        <td>
                                            <?php if($pettyCash->num_rows() > 1):?>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <?php if($pettyCash->num_rows() == 1):?>
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                                <?php endif;?>
                                                <?php if($pettyCash->num_rows() > 1 && $pettyCash->num_rows() == $nPetCash):?>
                                                <div><?php if($petty_cash < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($petty_cash),2,'.',',');?></div>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nPetCash++; endforeach;?>
                                    <?php for ($i=1; $i <= 6; $i++):?>
                                    <?php $nom = $this->crud_model->getNomenByCode("1.01.02.00$i");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                                        $activo += $total; $act_corriente += $total; $bancos += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endfor;?>
                                    <?php $group = $this->crud_model->getGroupByCode("1.01.02");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo $group['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($bancos < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($bancos),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCode("1.01.03");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo strtoupper($group['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("1.01.03.001");
                                        $total = 0; 
                                        /*if (strtotime($final) < strtotime($hoy)) $total = $this->crud_model->getTotalInventory($final);
                                        else $total = $this->crud_model->getTotalInventory();*/
                                        $activo += $total; $act_corriente += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCode("1.01.04");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo strtoupper($group['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("1.01.04.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                                        $activo += $total; $act_corriente += $total; $cuentas_cobrar += $total; ?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("1.01.04.002");
                                        $total = $total * 0.03; $activo -= $total; $act_corriente -= $total; $cuentas_cobrar -= $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($cuentas_cobrar < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($cuentas_cobrar),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("1.01.05.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                                        $activo += $total; $act_corriente += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($act_corriente < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($act_corriente),2,'.',',');?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $head = $this->crud_model->getHeadByCode("1.02");?>
                                    <tr>
                                        <td><?php echo $head['code'];?></td>
                                        <td><?php echo strtoupper($head['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php for ($i=1; $i <= 9; $i++):?>
                                    <?php $nom = $this->crud_model->getNomenByCode("1.02.01.00$i");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                                        $activo += $total; $act_no_corriente += $total; $depreciacion += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td class="<?php if(($i % 2) == 0) echo "bottom-edge";?>">
                                            <div class="container-justify">
                                                <div>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if(($i % 2) == 0):?>
                                            <div class="container-justify">
                                                <div><?php if($depreciacion < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($depreciacion),2,'.',',');?></div>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php if(($i % 2) == 0) $depreciacion = 0; endfor;?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="bottom-edge"></td>
                                        <td class="bottom-edge">
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
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
                                                <div><?php if($act_no_corriente < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($act_no_corriente),2,'.',',');?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>TOTAL DEL ACTIVO</td>
                                        <td></td>
                                        <td class="bottom-double-edge"></td>
                                        <td class="bottom-double-edge">
                                            <div class="container-justify">
                                                <div><?php if($activo < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($activo),2,'.',',');?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $type = $this->crud_model->getHeadTypeByCode("2");?>
                                    <tr>
                                        <td><?php echo $type['code'];?></td>
                                        <td class="text-center"><?php echo strtoupper($type['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $head = $this->crud_model->getHeadByCode("2.01");?>
                                    <tr>
                                        <td><?php echo $head['code'];?></td>
                                        <td><?php echo strtoupper($head['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php for ($i=1; $i <= 5; $i++):?>
                                    <?php $nom = $this->crud_model->getNomenByCode("2.01.01.00$i");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
                                        $pasivo += $total; $pas_corriente += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php endfor;?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($pas_corriente < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($pas_corriente),2,'.',',');?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $head = $this->crud_model->getHeadByCode("2.02");?>
                                    <tr>
                                        <td><?php echo $head['code'];?></td>
                                        <td><?php echo strtoupper($head['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("2.02.01.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
                                        $pasivo += $total; $pas_no_corriente += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($pas_no_corriente < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($pas_no_corriente),2,'.',',');?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $head = $this->crud_model->getHeadByCode("3.01");?>
                                    <tr>
                                        <td><?php echo $head['code'];?></td>
                                        <td><?php echo strtoupper($head['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCode("3.01.01");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo strtoupper($group['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("3.01.01.001");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 3);
                                        $patrimonio += $total; $capital += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("3.01.01.002");
                                        $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                                        $patrimonio -= $total; $capital -= $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($total < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($total),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($capital < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($capital),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $group = $this->crud_model->getGroupByCodeName("3.02.01", "reserva");?>
                                    <tr>
                                        <td><?php echo $group['code'];?></td>
                                        <td><?php echo strtoupper($group['name']);?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCodeName("3.02.01.001", "reserva");
                                        $patrimonio += $reserva;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($reserva < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($reserva),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("3.02.01.003");
                                        $total = $activo - $pasivo - $capital - $reserva - $neta;
                                        $patrimonio += $total;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <!-- <td><?php /* if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",","); */?></td> -->
                                        <td>
                                            <div class="container-justify">
                                                <div>Q</div>
                                                <div><?php echo number_format($total,2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $nom = $this->crud_model->getNomenByCode("3.02.01.002");
                                        $patrimonio += $neta; $utilidad += $total + $neta;?>
                                    <tr>
                                        <td><?php echo $nom['code'];?></td>
                                        <td><?php echo $nom['name'];?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($neta < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($neta),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($utilidad < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($utilidad),2,'.',',');?></div>
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
                                                <div><?php if($patrimonio < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($patrimonio),2,'.',',');?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $patrimonio += $pasivo;?>
                                    <tr>
                                        <td>3.02.02.003</td>
                                        <td>TOTAL DE PASIVO Y CAPITAL</td>
                                        <td></td>
                                        <td class="bottom-double-edge"></td>
                                        <td class="bottom-double-edge">
                                            <div class="container-justify">
                                                <div><?php if($patrimonio < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($patrimonio),2,'.',',');?></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <textarea rows="5" cols="" class="form-control" name="description" id="description">El infrainscrito contador registrado ante la superintendencia de administración tributaria bajo el numero de registro 12345 CERTIFICA que el presente Balance General presenta razonablemente la sutación económica de la empresa de conformidad con los Principios de Contabilidad Generalmente aceptados por el periodo dado</textarea>
                                <small class="text-danger" id="msgDescription"></small>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("address").' '.strftime("%d de %B del %Y", strtotime($hoy));?></h4>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div>
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-center" name="legal_name" id="legal_name" value="" placeholder="Nombre" />
                                                <small class="text-danger" id="msgLegalName"></small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-center" name="legal_charge" id="legal_charge" value="Representante legal" placeholder="Cargo" />
                                                <small class="text-danger" id="msgLegalCharge"></small>
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
                                                <input type="text" class="form-control text-center" name="account_name" id="account_name" value="" placeholder="Nombre" />
                                                <small class="text-danger" id="msgAccountName"></small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-center" name="account_charge" id="account_charge" value="Contador" placeholder="Cargo" />
                                                <small class="text-danger" id="msgAccountCharge"></small>
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
        <form method="post" action="<?php echo base_url();?>doctor/printFormType/general/" id="frmG" target="">
            <input type="hidden" name="initial" id="initial_hidden" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" id="final_hidden" value="<?php echo $final;?>" />
            <input type="hidden" name="description" id="description_hidden" value="El infrainscrito contador registrado ante la superintendencia de administración tributaria bajo el numero de registro 12345 CERTIFICA que el presente Balance General presenta razonablemente la sutación económica de la empresa de conformidad con los Principios de Contabilidad Generalmente aceptados por el periodo dado" />
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
        if (type == "PDF") $("#frmG").attr("target", "_blank");
        else $("#frmG").attr("target", '');
        validateForm();
        $("#frmG").submit();
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