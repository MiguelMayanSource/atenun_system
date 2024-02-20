    	    <style>
.table.table-padded {
    border-collapse: separate;
    border-spacing: 0 5px;
}

.table.table-padded thead tr th {
    border: none;
    font-size: 0.81rem;
    color: rgba(90, 99, 126, 0.49);
    letter-spacing: 1px;
    padding: 0.3rem 1.1rem;
}

.table.table-padded tbody tr {
    border-radius: 4px;
    -webkit-transition: all 0.1s ease;
    transition: all 0.1s ease;
}

.table.table-padded tbody tr:hover {

    -webkit-transform: translateY(-1px) scale(1.01);
    transform: translateY(-1px) scale(1.01);
}

.table.table-padded tbody td {
    padding: 0.9rem 1.1rem;
    background-color: #fff;
    border: none;
}

.table.table-padded tbody td.bolder {
    font-weight: 500;
    font-size: 0.99rem;
}

.table.table-padded tbody td img {
    display: inline-block;
    vertical-align: middle;
}

.table.table-padded tbody td img+span {
    display: inline-block;
    margin-left: 10px;
    vertical-align: middle;
}

.table.table-padded tbody td span+span {
    margin-left: 5px;
}

.table.table-padded tbody td .status-pill+span {
    margin-left: 10px;
}

.table.table-padded tbody td:first-child {
    border-radius: 14px 0px 0px 14px;
}

.table.table-padded tbody td:last-child {
    border-radius: 0px 14px 14px 0px;
    border-right: none;
}

.table.table-padded tbody tr:hover td {}

.table.table-padded tbody tr:hover i {}
    	    </style>
    	    <style>
.app-email-w a:focus,
.app-email-w a:hover {
    text-decoration: none;
}

.app-email-i {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    border-radius: 6px;
}

.ae-side-menu {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 250px;
    flex: 0 0 160px;
    min-height: 100vh;
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.ae-side-menu .aem-head {
    padding: 10px 20px;
    height: 50px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    font-size: 10px;
}

.ae-side-menu .ae-main-menu {
    list-style: none;
    padding: 0px;
    margin: 0px;
}

.ae-side-menu .ae-main-menu li {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
}

.ae-side-menu .ae-main-menu li a {
    display: block;
    padding: 15px;
}

.ae-side-menu .ae-main-menu li a i {
    font-size: 20px;
    display: inline-block;
    vertical-align: middle;
    color: #000;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}

.ae-side-menu .ae-main-menu li a span {
    margin-left: 7px;
    display: inline-block;
    vertical-align: middle;
    color: #000;
    font-weight: 500;
}

.ae-side-menu .ae-main-menu li:after {
    content: "";
    position: absolute;
    right: 0px;
    top: -1px;
    bottom: -1px;
    width: 5px;
    opacity: 0;
    background-color: #047bf8;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.ae-side-menu .ae-main-menu li:hover a i {
    -webkit-transform: translateX(5px);
    transform: translateX(5px);
}

.ae-side-menu .ae-main-menu li:hover:after,
.ae-side-menu .ae-main-menu li.active:after {
    opacity: 1;
}

.ae-side-menu .ae-labels {
    margin-top: 20px;
}

.ae-side-menu .ae-labels .ae-labels-header {
    padding: 20px;
}

.ae-side-menu .ae-labels .ae-labels-header i {
    color: #000;
    font-size: 20px;
    vertical-align: middle;
    display: inline-block;
}

.ae-side-menu .ae-labels .ae-labels-header span {
    margin-left: 20px;
    font-weight: 500;
    vertical-align: middle;
    display: inline-block;
}

.ae-side-menu .ae-labels .ae-label {
    display: block;
    padding: 10px;
    padding-left: 30px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    color: #000;
    white-space: nowrap;
}

.ae-side-menu .ae-labels .ae-label .label-pin {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 10px;
    background-color: #047bf8;
    vertical-align: middle;
}

.ae-side-menu .ae-labels .ae-label .label-value {
    display: inline-block;
    vertical-align: middle;
    margin-left: 10px;
}

.ae-side-menu .ae-labels .ae-label:before {
    content: "";
    position: absolute;
    left: 10px;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}

.ae-side-menu .ae-labels .ae-label.ae-label-red .label-pin {
    background-color: #e65252;
}

.ae-side-menu .ae-labels .ae-label.ae-label-green .label-pin {
    background-color: #99bf2d;
}

.ae-side-menu .ae-labels .ae-label.ae-label-yellow .label-pin {
    background-color: #fbe4a0;
}

/* #7. FOLDED STYLES */
.app-email-w.compact-side-menu .ae-side-menu {
    -webkit-box-flex: 0;
    -ms-flex: 0 1 60px;
    flex: 0 1 60px;
    text-align: center;
}

.app-email-w.compact-side-menu .ae-side-menu .aem-head {
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-main-menu li a span {
    display: none;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-labels .ae-label {
    padding-left: 10px;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-labels .ae-label span.label-value {
    display: none;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-labels-header span {
    display: none;
}

.search_input {
    width: 230px;
    margin: 6px 20px 9px 10px;
    border-radius: 10px;
    border: 0;
    background: #f7f7f7;
    padding: 10px;
    outline: none;
}

.src i {
    position: absolute;
    font-size: 18px;
    top: 18px;
    left: 213px;
}

.icon_products {
    background: #ff5d81;
    padding: 5px;
    border-radius: 10px;
    color: #fff !important;
    text-align: center;
    height: 36px;
    font-size: 25px !important;
    width: 36px !important;
}

.icon_categories {
    background: #ffc55d;
    padding: 5px;
    text-align: center;
    border-radius: 10px;
    color: #fff !important;
    height: 36px;
    font-size: 25px !important;
    width: 36px !important;
}

.icon_sales {
    background: #ff905d;
    padding: 5px;
    text-align: center;
    height: 36px;
    border-radius: 10px;
    color: #fff !important;
    font-size: 25px !important;
    width: 36px !important;
}

.icon_new_sale {
    background: #667acd;
    padding: 5px;
    text-align: center;
    border-radius: 10px;
    height: 36px;
    color: #fff !important;
    font-size: 25px !important;
    width: 36px !important;
}

.ae-content-w {
    background-color: #f6f7f8;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    margin-right: 60px;
    margin-left: 60px;
    margin-top: 45px;
}

.badge_category {
    background: #5d63bb;
    color: #fff;
    font-size: 13px;
    font-weight: normal;
    border-radius: 10px;
    padding: 1px 10px 1px 10px;
}

.alerta {
    width: 11px;
    height: 11px;
    border-radius: 30px;
    background-color: #fbe4a0;
    display: inline-block;
    vertical-align: middle;
}

.agotado {
    width: 11px;
    height: 11px;
    border-radius: 30px;
    background-color: #e65252;
    display: inline-block;
    vertical-align: middle;
}

.disponible {
    width: 11px;
    height: 11px;
    border-radius: 30px;
    background-color: #99bf2d;
    display: inline-block;
    vertical-align: middle;
}

.precio-ingreso {
    text-align: center;

}
    	    </style>
    	    <div class="app-email-w compact-side-menu" style="background-color:#f6f7f8;">
    	        <div class="app-email-i">
    	            <div class="ae-side-menu">
    	                <div class="aem-head">
    	                    <a class="ae-side-menu-toggler" href="javascript:void(0);" style="color:#000;"><i class="os-icon picons-thin-icon-thin-0069a_menu_hambuger" style="font-size:20px;"></i></a>
    	                </div>
    	                <ul class="ae-main-menu">

    	                    <li data-toggle="tooltip" data-placement="right" title="Ingresos">
    	                        <a href="<?php echo base_url();?>staff/financial/">
    	                            <i class="icon_products os-icon picons-thin-icon-thin-0105_download_clipboard_box"></i><span> Ingresos</span>
    	                        </a>
    	                    </li>
    	                    <li class="active" data-toggle="tooltip" data-placement="right" title="Egresos">
    	                        <a href="<?php echo base_url();?>staff/expenses/">
    	                            <i class="icon_categories os-icon picons-thin-icon-thin-0104_load_upload_clipboard_box"></i><span> Egresos</span>
    	                        </a>
    	                    </li>
    	                    <li data-toggle="tooltip" data-placement="right" title="Categorías">
    	                        <a href="<?php echo base_url();?>staff/expense_category/">
    	                            <i class="icon_sales os-icon picons-thin-icon-thin-0106_clipboard_box_archive_documents"></i><span> Categorías</span>
    	                        </a>
    	                    </li>
    	                </ul>

    	            </div><br>


    	            <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    	            <div id="main-content">

    	                <div class="row">
    	                    <div class="col-md-12 m-b-30" style="margin-bottom: 38px;">
    	                        <div class="card-box" style="position: relative; top: auto;">
    	                            <div class="card-b">
    	                                <div class="row">
    	                                    <div class="view-project-info col-md-12 col-lg-6">
    	                                        <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo; ?>" alt="Logo Example" style="margin:10px 2px">
    	                                        <div class="view-project-details">
    	                                            <p class="view-project-name" style="margin:15px 2px"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name; ?></p>
    	                                            <p class="view-project-desc"><span>Estadísticas al <?php echo $this->crud_model->get_date(); ?>.</span></p>
    	                                        </div>
    	                                    </div>
    	                                    <div class="view-project-progress col-md-12 col-lg-6">
    	                                        <div class="view-project-date">Ingresos:

    	                                            <p class="v-project-e-budget">Q<?php   $this->db->select_sum('amount', 'total');
            								                                            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                                                                        $query = $this->db->get('income');
                                                                                        $resultado = $query->result();
                                                                                        $ingreso = $resultado[0]->total;
                                                                                        echo number_format($ingreso,'2','.',',');
            								                                     ?></p>

    	                                        </div>
    	                                        <div class="view-project-date">Egresos:
    	                                            <p class="v-project-e-date">Q<?php     $this->db->select_sum('amount', 'total');
            									                                        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                                                                        $query = $this->db->get('expense');
                                                                                        $resultado = $query->result();
                                                                                        $egreso = $resultado[0]->total;
                                                                                        echo number_format($egreso,'2','.',',');
            								                                     ?></p>
    	                                        </div>
    	                                        <div class="view-project-date">Saldo Actual:
    	                                            <p class="v-project-s-date">Q<?php $saldo = $ingreso-$egreso;
            									                                    echo number_format($saldo,'2','.',',')?></p>
    	                                        </div>
    	                                    </div>
    	                                </div>
    	                            </div>
    	                        </div>
    	                    </div>
    	                    <div class="main-table-card col-sm-12 m-b-30">
    	                        <form action="<?php echo base_url();?>staff/expenses" method="POST" id="filter_form">
    	                            <h3 style="font-family: 'Poppins'; font-weight:bold"> Egresos
    	                                <select class="form-control" style="float:right; width:170px; border-radius:115px" onChange="submitForm();" name="filtro">
    	                                    <option value="">Todos</option>
    	                                    <option value="1" <?php if($ingreso_hoy != '') echo 'selected';?>>Hoy</option>
    	                                    <option value="2" <?php if($semana != '') echo 'selected';?>>Última semana</option>
    	                                    <option value="3" <?php if($dias != '') echo 'selected';?>>Últimos 30 días</option>
    	                                </select>
    	                            </h3>
    	                        </form>

    	                        <div class="ae-content-w" style="background:#f6f7f8">
    	                            <div class="row">
    	                                <div class="col-md-12">
    	                                    <table class="table table-padded demo" id="mainTable">
    	                                        <thead>
    	                                            <th>ID</th>
    	                                            <th>Descripción</th>
    	                                            <th>Proveedor</th>
    	                                            <th>Monto</th>
    	                                            <th>No. de referencia</th>
    	                                            <th>Categoría</th>
    	                                            <th>Fecha</th>
    	                                            <th>Acciones</th>
    	                                        </thead>
    	                                        <tbody>
    	                                            <?php 
                    if($ingreso_hoy != '' || $semana != '' || $dias != '')
                    {
                        if($ingreso_hoy > 0){
            		        $expenses = $this->crud_model->expenses_today($this->session->userdata('current_clinic'),date('d/m/Y'));
            		    }
            		    
                        if($semana > 0){
                            $fecha_cambiada = mktime(0,0,0,date("m")+0,date("d")-7,date("Y")+0);
                            $fechaH = date("d/m/Y",$fecha_cambiada);
            		        $expenses = $this->crud_model->expenses_week($this->session->userdata('current_clinic'),$fechaH,date('d/m/Y'));
            		    }
            		    
            		    if($dias > 0){
            		        $fecha_cam = mktime(0,0,0,date("m")-1,date("d")+0,date("Y")+0);
                            $fechaM = date("d/m/Y",$fecha_cam);
            		        $expenses = $this->crud_model->expenses_last_days($this->session->userdata('current_clinic'),$fechaM,date('d/m/Y'));
            		    }
                    }
                    else
                    {
                        $this->db->order_by('date', 'desc');
                        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                        $expenses = $this->db->get('expense')->result_array();
                    }

			            foreach($expenses as $row):
			        ?>
    	                                            <tr style="font-family:'Poppins';font-size:14px;">
    	                                                <td>
    	                                                    <?php echo $row['expense_id'];?>
    	                                                </td>
    	                                                <td><?php echo $row['description'];?></td>
    	                                                <td class="precio-ingreso"><?php  if($row['provider'] == "") echo "n/d"; else echo $row['provider'];?></td>
    	                                                <td class="precio-ingreso">Q<?php echo number_format($row['amount'], 2, '.', ',');?></td>
    	                                                <td class="precio-ingreso"> <?php  if($row['reference'] == "") echo "n/d"; else echo $row['reference'];?></td>
    	                                                <td><span class=""><?php echo $this->db->get_where('expense_category', array('expense_category_id'=>$row['expense_category_id']))->row()->name;?></span></td>
    	                                                <td class="precio-ingreso"><?php echo $row['date'];?></td>
    	                                                <td>
    	                                                    <?php if($row['reference_file'] != ''):?>
    	                                                    <a href="<?php echo base_url();?>staff/expenses/reference/<?php echo $row['expense_id'];?>"><i class="picons-thin-icon-thin-0096_file_attachment" style="color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Comprobante"></i></a>
    	                                                    <?php endif;?>
    	                                                    <a href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_expense/<?php echo $row['expense_id'];?>');"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
    	                                                    <a href="javascript:void(0);" onclick="delete_expense('<?php echo $row['expense_id'];?>')"><i class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>
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
    	                <a href="javascript:void(0);" data-toggle="modal" data-target="#1new_expense">
    	                    <div class="floated-customizer-btn third-floated-btn" style="background:#ff5d81;">
    	                        <div class="icon-w">
    	                            Nuevo
    	                        </div>
    	                    </div>
    	                </a>


    	                <div class="modal" id="1new_expense">
    	                    <div class="modal-dialog modal-dialog-centered modal-lg">
    	                        <div class="modal-content animated fadeInDown" style="border-radius:20px;">
    	                            <form action="<?php echo base_url();?>staff/expenses/create" method="POST" enctype="multipart/form-data">
    	                                <div class="modal-header" style="background-color:#fff;border-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
    	                                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Agregar nuevo egreso.</span></h4>
    	                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
    	                                </div>

    	                                <div class="modal-body" style="background-color:#f1f3f7;">
    	                                    <div class="form-group">
    	                                        <div class="container">
    	                                            <div class="row">

    	                                                <div class="col-sm-12">
    	                                                    <div class="form-group m-b-15">
    	                                                        <label for="simpleinput">Descripción</label>
    	                                                        <input type="text" name="description" class="form-control">
    	                                                    </div>
    	                                                </div>

    	                                                <div class="col-sm-6">
    	                                                    <div class="form-group m-b-15">
    	                                                        <label for="simpleinput">Categoría</label>
    	                                                        <select class="itemName form-control" style="width:100%" name="expense_category_id">
    	                                                            <option value="">Seleccionar</option>
    	                                                            <?php 
            									        	$categories = $this->db->get('expense_category')->result_array();
            									        	foreach($categories as $cat):
            									    	?>
    	                                                            <option value="<?php echo $cat['expense_category_id'];?>"><?php echo $cat['name'];?></option>
    	                                                            <?php endforeach;?>
    	                                                        </select>
    	                                                    </div>
    	                                                </div>

    	                                                <div class="col-sm-6">
    	                                                    <div class="form-group m-b-15">
    	                                                        <label for="simpleinput">Monto</label>
    	                                                        <input type="number" name="amount" required="" class="form-control">
    	                                                    </div>
    	                                                </div>

    	                                                <div class="col-sm-6">
    	                                                    <div class="form-group m-b-15">
    	                                                        <label for="simpleinput">No. de referencia</label>
    	                                                        <div class="form-group">
    	                                                            <input type="text" name="reference" class="form-control">
    	                                                        </div>
    	                                                    </div>
    	                                                </div>
    	                                                <div class="col-sm-6">
    	                                                    <div class="form-group m-b-15">
    	                                                        <label for="simpleinput">Subir comprobante</label>
    	                                                        <input type="file" name="reference_file" class="form-control">
    	                                                    </div>
    	                                                </div>
    	                                                <div class="col-sm-12">
    	                                                    <div class="form-group m-b-15">
    	                                                        <label for="simpleinput">Proveedor</label>
    	                                                        <div class="form-group">
    	                                                            <input type="text" name="provider" class="form-control">
    	                                                        </div>
    	                                                    </div>
    	                                                </div>
    	                                            </div>
    	                                        </div>
    	                                    </div>
    	                                </div>

    	                                <div class="modal-footer" style="text-align:center; padding:20px;">
    	                                    <center>
    	                                        <button data-dismiss="modal" style="border:0px;background:#fff; border-radius:25px; padding:6px; -webkit-box-shadow: 0px 2px 4px rgba(40, 159, 255, 0.35); box-shadow: 0px 2px 4px rgba(40, 159, 255, 0.35); font-weight:bold; color:#565b6b;">Cancelar</button>
    	                                        <button type="submit" style="border:0px;background:#fff;border-radius:25px; padding:6px; -webkit-box-shadow: 0px 2px 4px rgba(40, 159, 255, 0.35); box-shadow: 0px 2px 4px rgba(40, 159, 255, 0.35); font-weight:bold;color:#289fff;">Guardar</button>
    	                                    </center>
    	                                </div>
    	                            </form>
    	                        </div>
    	                    </div>
    	                </div>
    	                <link href="<?php echo base_url();?>style/appointments/css/select2.css" rel="stylesheet" />


    	                <link href="https://anton.miaula.com.gt/assets/theme/input/jquery.fileuploader.min.css" media="all" rel="stylesheet">

    	                <link href="http://educaby.com/work/style/input/font-fileuploader.css" rel="stylesheet">
    	                <script src="http://educaby.com/work/style/input/jquery.fileuploader.min.js" type="text/javascript"></script>
    	                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    	                <script>
    	                function submitForm() {
    	                    var formObject = document.forms['filter_form'];
    	                    formObject.submit();
    	                }
    	                </script>


    	                <script>
    	                $(document).ready(function() {
    	                    $('input[name="reference_file"]').fileuploader({
    	                        theme: 'default',
    	                    });
    	                });
    	                </script>

    	                <script type="text/javascript">
    	                $('#fact').hide();
    	                $('#fact2').hide();

    	                $(function() {
    	                    $('[name="invoice"]').change(function() {
    	                        if ($(this).is(':checked')) {
    	                            $('#fact').show(500);
    	                            $('#fact2').show(500);
    	                        } else {
    	                            $('#fact').hide(500);
    	                            $('#fact2').hide(500);
    	                        };
    	                    });
    	                });
    	                </script>

    	                <script type="text/javascript">
    	                $('.itemName').select2();
    	                </script>

    	                <script>
    	                $('.ae-side-menu-toggler').on('click', function() {
    	                    $('.app-email-w').toggleClass('compact-side-menu');
    	                });
    	                if ($('.app-email-w').length) {
    	                    if (is_display_type('phone') || is_display_type('tablet')) {
    	                        $('.app-email-w').addClass('compact-side-menu');
    	                    }
    	                }
    	                </script>


    	                <script type="text/javascript">
    	                function delete_expense(expense_id) {
    	                    Swal.fire({
    	                        title: '¿Estás seguro?',
    	                        text: "También se eliminará toda la información asociada al producto.",
    	                        type: 'info',
    	                        showCancelButton: true,
    	                        confirmButtonColor: '#9fd13b',
    	                        cancelButtonColor: '#fd4f57',
    	                        confirmButtonText: 'Sí, eliminar',
    	                        cancelButtonText: 'Cancelar'
    	                    }).then((result) => {
    	                        if (result.value) {
    	                            location.href = "<?php echo base_url();?>staff/expenses/delete/" + expense_id;
    	                        }
    	                    })
    	                }
    	                </script>