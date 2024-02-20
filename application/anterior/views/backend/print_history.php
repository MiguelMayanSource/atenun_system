<html>

    <head>
        <style>
        @page {
            margin-top: 0;
            margin-bottom: 0;
        }

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
            <title>Imprimir kardex de productos</title>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="Mayan Source">
            <meta name="description" content="Medicaby - Soluciones médicas">
            <?php include 'topcss.php';?>
        </head>
    </head>

    <body onload="window.print()">
        <div class=" wrapper">
            <?php $product = $this->db->get_where('product',array('product_id'=>$ID));?>
            <div id="main-content" onload="window.print()">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="title-header"><br>
                            <center>
                                <h3 class="module-title"> INVENTARIO CENTRO MEDICO HUMBERTO MOLINA</h3>
                            </center>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card-widget">
                            <h4 class="panel-content-title">Detalles de medicamentos
                            </h4>
                            <span class="app-divider2"></span>

                            <div class="row">
                                <div class="col-sm-4">
                                    <p> <b> Nombre: </b> <?php echo $product->row()->name;?> </p>
                                </div>

                                <div class="col-sm-4">
                                    <p> <b> Existencias: </b> <?php echo $this->inventory_model->get_stock($ID);?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card-widget">
                            <h4 class="panel-content-title">Movimientos del producto</h4>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">

                                        <table class="table dt-table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-right">No.</th>
                                                    <th>FECHA</th>
                                                    <th>ENTRADA / SALIDA</th>
                                                    <th>FACTURA</th>
                                                    <th>CANTIDAD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $n = 1;
                                                    $clientes = $this->db->get_where('product_move',array('product_id'=> $ID))->result_array();
                                                    foreach($clientes as $row):
                                                ?>
                                                <tr>
                                                    <td><span class="smaller lighter">CRT-<?php echo $n++?></span></td>
                                                    <td><span class="smaller lighter"><?php echo $row['date'] ;?> </span></td>
                                                    <?php if($row['status_mov'] == 1):?>
                                                    <td><span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                            ----</span>
                                                    </td>
                                                    <?php else:?>
                                                    <td><span style="color:red;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                            Salida</span>
                                                    </td>
                                                    <?php endif;?>

                                                    <?php if($row['status_mov'] == 1):?>
                                                    <td><span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                            <?php echo $row['factura'];?></span>
                                                    </td>
                                                    <?php else:?>
                                                    <td><span style="color:red;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                            <?php echo $row['invoice'];?></span>
                                                    </td>
                                                    <?php endif;?>
                                                    <td><span class="smaller lighter"><?php echo $row['amount'].' '.$row['unity'];?></span></td>
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
                        url: "<?php echo base_url() . 'doctor/getTable/history/'; ?>",
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
                        <form action="<?php echo base_url();?>doctor/history/add_medicamento/<?php echo $ID ;?>" method="POST" enctype="multipart/form-data">
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
        include 'modal.php';
        include 'scripts.php';
    ?>

</html>
