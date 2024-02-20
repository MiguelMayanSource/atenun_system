<html>

<head>
    <style>
    body {
        font-size: 16px;
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    b {
        font-weight: bolder;
    }

    small {
        font-size: 80%;
    }

    img {
        vertical-align: middle;
        border-style: none;
    }

    small {
        font-size: 80%;
        font-weight: 400;
    }

    @media print {

        *,
        ::after,
        ::before {
            text-shadow: none !important;
            box-shadow: none !important;
        }

        img {
            page-break-inside: avoid;
        }

        p {
            orphans: 3;
            widows: 3;
        }
    }

    ._print-content_ztkcf7 {
        width: 100%;
        color: #000;
        page-break-inside: avoid;
    }

    ._print-content_ztkcf7 p {
        margin: 0;
    }

    ._prescription-drug_6ovcpi {
        margin-bottom: 10px;
    }

    ._medical-instructions-title_6ovcpi {
        font-weight: 700;
    }

    ._header_ztkcf7 {
        display: flex;
        padding-bottom: 10px;
    }

    ._header_ztkcf7 img {
        margin: 0;
        padding: 0;
    }

    ._header-logo_ztkcf7,
    ._header-meta_ztkcf7 {
        width: 25%;
    }

    ._header-logo_ztkcf7 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
    }

    ._header-logo_ztkcf7 img {
        max-height: 100px;
    }

    ._header-meta_ztkcf7 {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: flex-end;
        font-size: 12px;
    }

    ._header-profile_ztkcf7 {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        width: 50%;
        align-items: center;
    }

    ._header-specialty_ztkcf7 {
        text-transform: uppercase;
        font-weight: 700;
    }

    ._header-specialty_ztkcf7 {
        font-size: 16px;
    }

    ._body_ztkcf7 {
        font-size: 13px;
    }

    ._body-bg-image_ztkcf7 {
        display: none;
    }

    ._body-person-info_ztkcf7 {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 8px 0;
        border-top: 2px solid #000;
        border-bottom: 2px solid #000;
    }

    ._body-person-info-date_ztkcf7 {
        display: none;
    }

    ._body-prescription-info_ztkcf7 {
        min-height: 150px;
    }

    ._body-signature_ztkcf7 {
        width: 33%;
        margin: 50px 0 30px auto;
        padding-top: 5px;
        border-top: 2px solid #000;
        text-align: center;
        font-size: 14px;
    }

    ._footer_ztkcf7 {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
        padding: 10px 0;
        border-top: 2px solid #000;
        font-size: 10px;
    }

    ._footer-app-branding_ztkcf7 {
        text-align: right;
    }

    ._is-subtitle_1cmxxr img {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
    }

    ._is-subtitle_1cmxxr {
        position: relative;
        float: none;
        margin: 0 0 10px;
        padding: 3px 8px 3px 10px;
        font-size: 13px;
        font-weight: 700;
        font-style: italic;
        z-index: 0;
    }
    </style>

    <head>
        <title><?php echo $page_title;?> | <?php echo $system_title;?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Mayan Source">
        <meta name="description" content="Medicaby - Soluciones médicas">
        <?php include 'home/cmhumbertomolina/application/views/backend/topcss.php';?>
        <?php include 'home/cmhumbertomolina/application/views/backend/top.php';?>
    </head>
</head>

<body>
    <div class=" wrapper">
        <?php $product = $this->db->get_where('product',array('product_id'=>$ID));?>
        <div class="white-box" id="toRender">
            <div class="os-tabs-w">
                <div class="os-tabs-controls">
                    <ul class="navx nav-tabs">
                        <li class="nav-item text-center">
                            <a class="nav-link current " href="<?php echo base_url();?>staff/inventory/">
                                <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                                <span>Inventario</span>
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="<?php echo base_url();?>staff/categories/">
                                <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div>
                                <span>Categorías</span>
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="<?php echo base_url();?>staff/services/">
                                <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div>
                                <span>Servicios</span>
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="<?php echo base_url();?>staff/equipment/">
                                <div class="navWidget"><i class="picons-thin-icon-thin-0053_settings_tools_pipe"></i></div>
                                <span>Equipo</span>
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="<?php echo base_url();?>staff/supplies/">
                                <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div>
                                <span>Suministros</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main-content" onload="window.print()">
            <div class="row">
                <div class="col-sm-12">
                    <div class="title-header"><br>
                        <center>
                            <h3 class="module-title"> INVENTARIO CENTRO MEDICO HUMBERTO MOLINA
                                <?php if( $this->crud_model->get_inventory($ID) <= $product->row()->amount_alert):?>
                                <a class="add-buton pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#1new_product">+ Agregar
                                    medicamento</a>
                                <?php endif;?>
                            </h3>
                        </center>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Historial de medicamentos
                        </h4>
                        <span class="app-divider2"></span>

                        <div class="row">
                            <div class="col-sm-4">
                                <p> <b> Nombre: </b> <?php echo $product->row()->name;?> </p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Existencias: </b> <?php echo $this->crud_model->get_inventory($ID);?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Componente: </b> <?php echo $product->row()->componente;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Concentración : </b> <?php echo $product->row()->concentracion;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Presentación: </b> <?php echo $product->row()->presentation;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Máxima cantidad a pedir: </b> <?php echo $product->row()->amount_maxima;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Minima cantidad a pedir: </b> <?php echo $product->row()->amount_alert;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Ubicacción del medicamento: </b> <?php echo $product->row()->ubication;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Cantidad en presentación: </b> <?php echo $product->row()->amount_presentation;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Tipo de almacenaje: </b> <?php echo $product->row()->storage;?></p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> Marjen de ganancia: </b> <?php echo $product->row()->margin;?>%</p>
                            </div>

                            <div class="col-sm-4">
                                <p> <b> inventario Inicial: </b> <?php echo $product->row()->initial_inventory;?></p>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Movimientos del producto</h4>
                        <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>staff/print_kardex/<?php echo base64_encode($ID);?>">IMPRIMIR</a>
                        <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>staff/excel/<?php echo base64_encode($ID);?>">EXCEL</a>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">

                                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-right">No.</th>
                                                <th>FECHA DE INGRESO</th>
                                                <th>FECHA DE VENCIMIENTO</th>
                                                <th>NOMBRE DEL PACIENTE</th>
                                                <th>NO. EXPEDIENTE</th>
                                                <th>PROVEEDOR</th>
                                                <th>NO. FACTURA</th>
                                                <th>ENTRADA / SALIDA</th>
                                                <th>EXISTENCIA</th>
                                                <th>OBSERVACIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                            $n = 1;
                            $clientes = $this->db->order_by('history_id', 'DESC')->get_where('history',array('producto_id'=> $ID))->result_array();
                            foreach($clientes as $row):?>

                                            <tr>
                                                <td><span class="smaller lighter">CRT-<?php echo $n++?></span></td>
                                                <td><span class="smaller lighter"><?php echo $row['date'] ;?> </span></td>
                                                <td><span class="smaller lighter"><?php  echo $row['expiration'];?></span></td>

                                                <?php if($row['status_mov'] == 1):?>
                                                <td><span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                        ----</span>
                                                </td>
                                                <?php else:?>
                                                <td>
                                                    <span class="smaller lighter">
                                                        <?php echo $this->accounts_model->get_name('patient', $row['paciente_id']);?></span>
                                                </td>
                                                <?php endif;?>

                                                <?php if($row['status_mov'] == 1):?>
                                                <td><span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                        ----</span>
                                                </td>
                                                <?php else:?>
                                                <td><span style="color:red;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                        Salida</span>
                                                </td>
                                                <?php endif;?>
                                                <td><span class="smaller lighter"><?php echo $row['proveedor'];?></span></td>

                                                <?php if($row['status_mov'] == 1):?>
                                                <td><span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                        <?php echo $row['factura'];?></span>
                                                </td>
                                                <?php else:?>
                                                <td><span style="color:red;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                        Salida</span>
                                                </td>
                                                <?php endif;?>
                                                <?php if($row['status_mov'] == 1):?>
                                                <td><span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                        Entrada</span>
                                                </td>
                                                <?php else:?>
                                                <td><span style="color:red;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                        Salida</span>
                                                </td>
                                                <?php endif;?>
                                                <td><span class="smaller lighter"><?php echo $row['cantidad'];?></span></td>
                                                <td>
                                                    <span class="smaller lighter"><?php echo $row['obs'];?></span>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            var dataTable = $('#user_data').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url() . 'staff/getTable/history/'; ?>",
                    type: "POST"
                },

                "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                }, ],
                fixedColumns: true,
            });
        });
        </script>



        <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
        <div class="modal" id="1new_product">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content animated fadeInDown">
                    <form action="<?php echo base_url();?>staff/history/add_medicamento/<?php echo $ID ;?>" method="POST" enctype="multipart/form-data">
                        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">
                                    <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Agregar a
                                    inventario.</span></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="container">
                                    <div class="row">

                                        <input type="hidden" name="code" value='<?php echo $product->row()->code;?>'>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Fecha de Ingreso</label>
                                                <input type="date" name="date" required="" class="form-control" value='<?php echo date('Y-m-d');?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Fecha de Vecimiento</label>
                                                <input type="date" name="expiration" required="" class="form-control" value='<?php echo date('Y-m-d');?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Cantidad</label>
                                                <input type="number" name="cantidad" required="" class="form-control" min='0' max='<?php echo $product->row()->amount_maxima - $this->db->get_where('product_lote',array('product_id'=> $ID, 'status'=>1))->row()->cantidad ;?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Factura</label>
                                                <input type="text" name="factura" required="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Proveedor</label>
                                                <input type="text" name="proveedor" required="" class="form-control" value='<?php echo $product->row()->provider;?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre</label>
                                                <input type="text" name="name" required="" class="form-control" value='<?php echo $product->row()->name ;?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Costo unitario</label>
                                                <input type="number" step="any" name="cost" required="" class="form-control" min='0' value='<?php echo $product->row()->cost ;?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Precio de venta </label>
                                                <input type="number" step="any" name="price" required="" class="form-control" min='0' value='<?php echo $product->row()->price ;?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Observación </label>
                                                <textarea name="obs" cols="30" rows="3" class='form-control'></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="button-confirm">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
        include 'home/cmhumbertomolina/application/views/backend/modal.php';
        include 'home/cmhumbertomolina/application/views/backend/scripts.php';
    ?>

</html>