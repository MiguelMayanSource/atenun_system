<div class="modal-content animated fadeInDown">
        <div class="modal-header" style="background-color:#fff;box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
                <span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i> Otros descuentos</span>
            </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="background-color:#fff;">
            <div class="col-xl-12 col-lg-12 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="row">
                <?php 
                    $status = $this->db->get_where('stabilitation_ref', array('stabilitation_ref_id'=>$param2))->row()->status;
                    if($status == 1 || $status == 0): 
                ?>
                    <div class="col-sm-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Q.</div>
                            </div>
                            <input style="border: 1px solid #198cff8f;" type="number" placeholder="Cantidad" id="amount_discount" class="form-control" >
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="picons-thin-icon-thin-0263_text_font_typography"></i></div>
                            </div>
                            <input style="border: 1px solid #198cff8f;" type="text" placeholder="Motivo del descuento" id="description_discount" class="form-control" >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <a class="btn btn-info" onclick="submit_discount('<?php echo $param2;?>')" href="javascript:void(0);">+</a>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-sm-12" id="table_discount">
                        <?php 
                            $refresh_query  = $this->db->get_where('stabilitation_discount',array('stabilitation_ref_id' => $param2));
                            if($refresh_query->num_rows() > 0)
                            {
                                $html_table = '
                                    <table class="table">
                                        <tr style="background-color:#f9fbfc; color:#59636d">
                                            <th style="text-align:left">Cantidad</th>
                                            <th style="text-align:left">Descripción</th>';
                                            
                                        if($status == 1 || $status == 0)
                                            $html_table .= '<th>-</th>';
                                            $html_table .= '</tr>';
                                foreach($refresh_query->result_array() as $row)
                                {
                                    $html_table .= '
                                        <tr>';
                                            
                                            $html_table .= '<td style="text-align:left">Q. '.number_format($row['amount'],2,'.',',').' </td>';
                                            $html_table .= '<td style="text-align:left"> '.$row['description'].' </td>';
                                            if( $status == 1 || $status == 0)
                                            {
                                                $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_discount('.$row['stabilitation_discount_id'].','.$param2.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                                            }

                                            $html_table .= '</tr>';   
                                }
                                $html_table .='</table>';
                                
                                echo $html_table;
                            }else
                            {
                                echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no se ha agregado descuentos.</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
                            }
                        ?>
                    </div>
                </div>
                
                
                <br>
            </div>
        </div>
</div>

