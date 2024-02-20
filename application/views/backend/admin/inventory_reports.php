    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link " href="<?php echo base_url();?>doctor/appointment_reports/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i></div> <span>Citas</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>doctor/inventory_reports/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div><span>Inventario</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>doctor/reports/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0386_graph_line_chart_statistics"></i></div><span>Actividad</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">
		<div class="row">
		    <div class="col-sm-12">
		        <div class="row">
		            <div class="col-sm-8">
		                	
                <div  class="row">
		            <div class="col-md-3 col-lg-12 col-xl-3">
		                <a class="element-box el-tablo centered trend-in-corner smaller" onclick="total_table()" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Total de productos
                            </div>
                            <div class="value">
                                <?php echo $this->crud_model->count_cost()->num_rows(); ?>
                            </div>
                        </a>
			        </div>
			        
			        <div class="col-md-3 col-lg-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" onclick="vencido_table()" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Productos vencidos
                            </div>
                            <div class="value">
                                <?php echo count($this->crud_model->product_expiration($this->session->userdata('current_clinic'),'01/01/2010',date('d/m/Y')));?>
                            </div>
                        </a>
			        </div>
			        <div class="col-md-3 col-lg-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" onclick="vencer_table()" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Productos por vence
                            </div>
                            <div class="value">
                                <?php $fecha_cambiada = mktime(0,0,0,date("m")+0,date("d")+30,date("Y")+0);
                                          $fecha = date("d/m/Y",$fecha_cambiada);
                                          echo count($this->crud_model->product_expiration($this->session->userdata('current_clinic'),date('d/m/Y'),$fecha));?>
                            </div>
                        </a>
			        </div>
			        <div class="col-md-3 col-lg-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" onclick="agotado_table()" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Productos agotados
                            </div>
                            <div class="value">
                                <?php echo count($this->db->get_where('product', array('stock' => 0, 'clinic_id' => $this->session->userdata('current_clinic')))->result_array());?>
                            </div>
                        </a>
			        </div>
			            <a class="btn btn-info" style="margin: 15px;" href="<?php echo base_url().'doctor/printInventori'?>"> Descargar Excel</a>
	 <br>
			    </div>
			 
		                    <div class="card-widget">
                                <h4 class="panel-content-title">Todos los productos</h4>
                                <span class="app-divider2"></span>
                                <div id="table_ajax" class="table-responsive"><hr>
		                </div>
                            </div>
		    
		            </div>
		            <div class="col-sm-4">
		                <div class="card-widget">
		                <h4 class="panel-content-title">Productos recientes</h4>
                            <span class="app-divider2"></span>
		                    <ul class="services_more">
		                      <?php 
		                            $prod = $this->crud_model->leading_product();
		                            $arr = array();
		                            foreach($prod as $row)
		                            {
		                                array_push($arr,['prod'=>$row['product_id']]);
		                            } 
    		                        $result = array();
                                    foreach ($arr as $key => $value)
                                    {
                                        if(!in_array($value,$result))
                                        $result[$key]=$value;
                                    }
                                    foreach($result as $res):?>
		                            <li><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> <?php echo $this->db->get_where('product',array('product_id'=>$res['prod']))->row()->name;?></li>
		                        <?php endforeach;?>
		                    </ul>
                        </div>
		            </div>
		        </div>
		    </div>
		     
		</div>
	</div>

    <script>
        $(document).ready(function(){
            total_table();
        });
    </script>

    <script>
        function total_table() {
        $.ajax({
            url: '<?php   echo base_url();?>doctor/total_inventario/',
            success: function(response){
                jQuery('#table_ajax').html(response);
                $('#mainTable').DataTable();
                
            }
        });
        }
        
        function vencido_table(){
           
           $.ajax({
            url: '<?php   echo base_url();?>doctor/vencido_inventario/',
            success: function(response){
                jQuery('#table_ajax').html(response);
                 $('#mainTable').DataTable();
                
            }
        });
        }
        
        function vencer_table(){
             $.ajax({
            url: '<?php   echo base_url();?>doctor/vencer_inventario/',
            success: function(response){
                jQuery('#table_ajax').html(response);
                 $('#mainTable').DataTable();
            }
        });
        }
        
        function agotado_table(){
             $.ajax({
            url: '<?php   echo base_url();?>doctor/agotado_inventario/',
            success: function(response){
                jQuery('#table_ajax').html(response);
                $('#mainTable').DataTable(); 
            }
        });
        }
        
        

	</script>