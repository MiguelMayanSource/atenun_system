<?php  $prescription_code = base64_encode($this->db->order_by('prescription_ref_id','DESC')->get('prescription_ref')->row()->prescription_ref_id+1); ?>
<h5 class="panel-content-title">Receta de medicamentos</h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-md-12">
        <div class="row" style="overflow-y:auto">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Medicamento</label>
                    <textarea type="text" class="form-control med" placeholder="Medicamento" autocomplete="off" id="med" rows="5" onkeyup="getSugest(this.value,'<?php echo $prescription_code?>')" onclick="getSugest(this.value,'<?php echo $prescription_code?>')"></textarea>
                    <input type="hidden" value="0" id="med_sugest">
                </div>
                <a href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_show_inventory')" class="btn btn-info" >inventario</a>
                <table class="table" id="results_med"></table>
            </div>
            <hr>
            <div class="col-sm-12">
                <div class="form-group">
                    <a class="btn btn-info" onclick="submit_recet('<?php echo $prescription_code?>')" href="javascript:void(0);">+</a>
                </div>
            </div>
            <div class="col-sm-12" id="table_results">
                <?php 
                    $refresh_query  = $this->db->get_where('prescription',array('code' => $prescription_code));
                    if($refresh_query->num_rows() > 0)
                    {
                        $html_table = '
                            <table class="table">
                                <tr style="background-color:#f9fbfc; color:#59636d">
                                    <th>Medicamento</th>';
            
                                if($status == 1 || $status == 0)
                                    $html_table .= '<th>-</th>';
                                    $html_table .= '</tr>';
                        foreach($refresh_query->result_array() as $row)
                        {
                            $html_table .= '
                                <tr>
                                    <td><pre>'.$row['medicine'].'</pre></td>';
            
                                    if($status == 1 || $status == 0)
                                    $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['prescription_id'].',\''.$prescription_code.'\')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                                    
                                    
                                    $html_table .= '</tr>';   
                        }
                        $html_table .='</table>';
                        
                        print_r($html_table);
                    }else{
                        echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay medicamentos prescritos</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
                    }
                ?>
            </div>
            <hr>
        </div>
        <hr>
        <div class="col-sm-12">
            <label><b>Observaciones:</b></label><small> (El sistema guardara automaticamente lo que se escriba, sino hay observaciones dejar en blanco.)</small>
            <textarea type="text" class="form-control " placeholder="" autocomplete="off" rows="5" onkeyup="addPrescriptionObservations(this.value,'<?php echo $prescription_code?>')" onclick="addPrescriptionObservations(this.value,'<?php echo $prescription_code?>')"><?php echo $details['prescription_observations']?></textarea>
        </div>
        <div class="col-sm-12" style="margin-top:10px;">
            <a class="btn btn-danger" style="margin-left:10px;" href="javascript:void(0)" onclick="load_view('patient_prescriptions','recetas',{'patient_id':patient_id})">Terminar</a>
            <a class="btn btn-success float-right" style="margin-left:10px;" target="_blank" href="<?php echo base_url().$this->session->userdata('login_type');?>/prescriptions/prescription_details/<?php echo $prescription_code;?>">Imprimir receta</a>
        </div>
    </div>
</div>