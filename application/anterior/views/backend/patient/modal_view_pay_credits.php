    <div class="modal-content animated fadeInDown" style="border-radius:20px;">
	    <div class="modal-header" style="background-color:#fff;border-radius:20px;" >
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
	            <span style="vertical-align:-3px"> Pagos abonados en este tratamiento</span></h4>
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
		    <?php $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency; ?>
		        <div class="modal-content animated fadeInDown" style="border-radius:5px; ">
                    <div class="modal-body" style="background-color:#f1f3f7;">
				            <div class="table-responsive">
                                <table class="table table-padded">
                                                        <tr style="color:#59636d">
                                    				        <th>ID</th>
                                    				        <th>Fecha</th>
                                            	   	        <th>Hora</th>
                                    			            <th>Ingresado por</th>
                                        		            <th>Cantidad</th>
                                                            <th>Detalles</th>
                                                		</tr>
                                                		<?php 
                                                		    $total = 0;
                                                		    $refresh_query = $this->db->get_where('payment_credit', array('patient_id' => $param3, 'tooth_treatment_id' => $param2))->result_array();
                                                		    foreach($refresh_query as $tr):
                                                            $total +=  $tr['amount'];
                                                        ?>
                                                        <tr style="font-size:14px"> 
                                                            <td><?php echo  $tr['payment_credit_id'];?> </td>
                                                            <td><span class="smaller lighter"><?php echo date('d/m/Y', strtotime($tr['date']));?></span></td>
                                                            <td><span class="smaller lighter"><?php echo $tr['time'];?></span></td>
                                                            <?php if($tr['user_type'] == 'doctor'):?>
                                                                <td><span class="smaller lighter"><?php echo $this->accounts_model->short_name('admin', $tr['user_id']);?></span></td>
                                                            <?php else:?>
                                                                <td><span class="smaller lighter"><?php echo $this->accounts_model->short_name($tr['user_type'],$tr['user_id']);?></span></td>
                                                            <?php endif;?>
                                                            <td> <span class="smaller lighter"><?php echo $currency.'. '.number_format($tr['amount'],'2', '.', ',');?></span></td>
                                                           
                                                            <td> <span class="smaller lighter"><?php echo $tr['details'];?></span></td>
                                                        </tr>
                                            	    <?php endforeach;?>
                                            	    
                                            	    <tr style="font-size:14px"> 
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><span class="smaller lighter">Total</span></td>
                                                        
                                                        <td> <span class="smaller lighter"><?php echo $currency.'. '.number_format($total,'2', '.', ',');?></span></td>
                                                       
                                                        <td> <span class="smaller lighter"></span></td>
                                                    </tr>
                                                </table>
                                            </div>
		                                </div>
		                            <div class="modal-footer" style="text-align:center;">
				                    <center>
				                        <button data-dismiss="modal" style="border:0px;background:#fff; border-radius:25px; padding:6px; -webkit-box-shadow: 0px 2px 4px rgba(40, 159, 255, 0.35); box-shadow: 0px 2px 4px rgba(40, 159, 255, 0.35); font-weight:bold; color:#565b6b;">Cerrar</button>
            			        </center>
		        		    </div>
        		        </div>
		            </div>
        
        
        