
    <?php
		$patient_id = $param2;
        $this->db->where('patient_id', $patient_id);
        $patient = $this->db->get('patient')->result_array();
        foreach($patient as $row):
    ?>
        <div class="modal-content animated fadeInDown" style="border-radius:20px;">
	        <div class="modal-header" style="background-color:#fff;border-radius:20px;" >
    			<h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
			    <span style="vertical-align:-3px"><?php echo $this->accounts_model->get_name('patient',$patient_id);?> Historial Medico</span></h4>
			    <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			     <div class="modal-body" style="background-color:#f1f3f7;">
				 <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <span style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Alergias</span>
                            </div>
                             
                            <ul style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			            $this->db->order_by('allergie_id', 'desc');
        			            $this->db->where('patient_id',$patient_id);
        			            $allergies = $this->db->get('allergie')->result_array();
        			            foreach($allergies as $row):
        			            ?>
                                <li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <?php echo $row['name'];?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php if($this->crud_model->check_item('pathological') == 1) { ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <span style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes patológicos</span>
                            </div>
                            <ul style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			            $this->db->order_by('date', 'desc');
        			            $this->db->where('patient_id',$patient_id);
        			            $pathologicals = $this->db->get('pathological')->result_array();
        			            foreach($pathologicals as $row):
        			            ?>
                                <?php if($row['hospitalization'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Hospitalización previa |</b> <?php echo ucfirst($row['hospitalization_comment']);?><?php endif;?>
                                <?php if($row['surgeries'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Cirugías previas |</b> <?php echo ucfirst($row['surgeries_comment']);?></li> <?php endif; ?>
                                <?php if($row['diabetes'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Diabetes |</b> <?php echo ucfirst($row['diabetes_comment']);?></li><?php endif; ?>
                                <?php if($row['thyroid'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Enfermedades tiroideas |</b><?php echo ucfirst($row['thyroid_comment']);?></li><?php endif; ?>
                                <?php if($row['hypertension'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Hipertensión arterial |</b><?php echo ucfirst($row['hypertension_comment']);?></li><?php endif; ?>
                                <?php if($row['heart_disease'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Cardiopatias |</b><?php echo ucfirst($row['heart_disease_comment']);?></li><?php endif; ?>
                                <?php if($row['trauma'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Traumatismos |</b><?php echo ucfirst($row['trauma_comment']);?></li><?php endif; ?>
                                <?php if($row['cancer'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Cáncer |</b><?php echo ucfirst($row['cancer_comment']);?></li><?php endif; ?>
                                <?php if($row['tuberculosis'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Tuberculosis |</b><?php echo ucfirst($row['tuberculosis_comment']);?></li><?php endif; ?>
                                <?php if($row['transfusions'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Transfusiones |</b><?php echo ucfirst($row['transfusions_comment']);?></li><?php endif; ?>
                                <?php if($row['pathologies'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Patologías respiratorias |</b><?php echo ucfirst($row['pathologies_comment']);?></li><?php endif; ?>
                                <?php if($row['gastrointestinal'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Patologías gastrointestinales |</b><?php echo ucfirst($row['gastrointestinal_comment']);?></li><?php endif; ?>
                                <?php if($row['sexual'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Enfermedades de transmisión sexual |</b><?php echo ucfirst($row['sexual_comment']);?></li><?php endif; ?>
                                <?php if($row['others'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Otros |</b><?php echo ucfirst($row['others_comment']);?></li><?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div><?php }
                        if($this->crud_model->check_item('non_pathological') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <span style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes no patológicos</span>
                            </div>
                            <ul style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                 <?php 
        			                $this->db->order_by('date', 'desc');
        			                $this->db->where('patient_id', $patient_id);
        			                $no_pathologicals = $this->db->get('no_pathological')->result_array();
        			                foreach($no_pathologicals as $row):
        			            ?>
                                <?php if($row['activity'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Actividad física | </b><?php echo ucfirst($row['activity_comment']);?></li> <?php endif; ?>
                                <?php if($row['smoking'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Tabaquismo | </b><?php echo ucfirst($row['smoking_comment']);?></li><?php endif; ?>
                                <?php if($row['alcoholism'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Alcoholismo | </b><?php echo ucfirst($row['alcoholism_comment']);?></li><?php endif; ?>
                                <?php if($row['drugs'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Uso de otras sustancias (Drogas) | </b><?php echo ucfirst($row['drugs_comment']);?></li><?php endif; ?>
                                <?php if($row['vaccine'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Vacuna o inmunización reciente | </b><?php echo ucfirst($row['vaccine_comment']);?></li><?php endif; ?>
                                <?php if($row['others'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b>Otros | </b><?php echo ucfirst($row['others_comment']);?></li><?php endif; ?>

                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('hereditary') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <span style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes heredofamiliares</span>
                            </div>
                            <ul style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->order_by('date', 'desc');
        			                $this->db->where('patient_id',$patient_id);
        			                $heredos = $this->db->get('record_family')->result_array();
        			                foreach($heredos as $row):
        			            ?>
                                    <?php if($row['diabetes'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Diabetes | </b><?php echo ucfirst($row['diabetes_comment']);?></li> <?php endif; ?>
                                    <?php if($row['heart_disease'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Cardiopatías | </b><?php echo ucfirst($row['heart_disease_comment']);?></li> <?php endif; ?>
                                    <?php if($row['hypertension'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Hipertensión arterial | </b><?php echo ucfirst($row['hypertension_comment']);?></li> <?php endif; ?>
                                    <?php if($row['thyroid'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Enfermedades tiroideas | </b><?php echo ucfirst($row['thyroid_comment']);?></li> <?php endif; ?>
                                    <?php if($row['others'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Otros | </b><?php echo ucfirst($row['others_comment']);?></li> <?php endif; ?>
                                <?php endforeach; ?>
                               
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('psychiatric') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <span style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes psiquiátricos</span>
                            </div>
                            <ul style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                 <?php 
        			                $this->db->order_by('date', 'desc');
        			                $this->db->where('patient_id',$patient_id);
        			                $phys = $this->db->get('psychiatric')->result_array();
        			                foreach($phys as $row):
        			            ?>
        			                <?php if($row['family_record']!= ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Historia familiar | </b><?php echo ucfirst($row['family_record']);?></li> <?php endif; ?>
                                    <?php if($row['disease_awareness'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Conciencia de enfermedad | </b><?php echo ucfirst($row['disease_awareness_comment']);?></li> <?php endif; ?>
                                    <?php if($row['affected_areas'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Áreas afectadas por la enfermedad | </b><?php echo ucfirst($row['affected_areas']);?></li> <?php endif; ?>
                                    <?php if($row['past_treatments'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Tratamientos pasados y actuales | </b><?php echo ucfirst($row['past_treatments']);?></li> <?php endif; ?>
                                    <?php if($row['family_group_social'] == 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Apoyo del grupo familiar o social | </b><?php echo ucfirst($row['family_group_social_comment']);?></li> <?php endif; ?>
                                    <?php if($row['family_group'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Grupo familiar del paciente | </b><?php echo ucfirst($row['family_group']);?></li> <?php endif; ?>
                                    <?php if($row['aspects_social'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Aspectos de la vida social | </b><?php echo ucfirst($row['aspects_social']);?></li> <?php endif; ?>
                                    <?php if($row['aspects_work'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Aspectos de la vida laboral | </b><?php echo ucfirst($row['aspects_work']);?></li> <?php endif; ?>
                                    <?php if($row['authority'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Relación con la autoridad  | </b><?php echo ucfirst($row['authority']);?></li> <?php endif; ?>
                                    <?php if($row['impulse_control'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Control de impulsos | </b><?php echo ucfirst($row['impulse_control']);?></li> <?php endif; ?>
                                    <?php if($row['frustration'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Manejo de frustración en su vida | </b><?php echo ucfirst($row['frustration']);?></li> <?php endif; ?>


                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('diet') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <span style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Dieta</span>
                            </div>
                            <ul style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->where('patient_id',$patient_id);
        			                $nutri = $this->db->get('nutriological')->result_array();
        			                foreach($nutri as $row):
        			            ?>
                                <?php if($row['breakfast']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Desayuno | </b><?php echo ucfirst($row['breakfast_comment']);?></li> <?php endif; ?>
                                <?php if($row['snack']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Colación en la mañana | </b><?php echo ucfirst($row['snack_comment']);?></li> <?php endif; ?>
                                <?php if($row['food']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Comida | </b><?php echo ucfirst($row['food_comment']);?></li> <?php endif; ?>
                                <?php if($row['snack_afternoon']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Colación en la tarde | </b><?php echo ucfirst($row['snack_afternoon_comment']);?></li> <?php endif; ?>
                                <?php if($row['dinner']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Cena | </b><?php echo ucfirst($row['dinner_comment']);?></li> <?php endif; ?>
                                <?php if($row['food_home']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Alimentos preparados en casa | </b><?php echo ucfirst($row['food_home_comment']);?></li> <?php endif; ?>
                                <?php if($row['appetite'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Nivel de apetito | </b><?php if($row['appetite'] == 4) echo "Excesivo"; if($row['appetite'] == 3) echo "Bueno"; if($row['appetite'] == 2) echo "Regular"; if($row['appetite'] == 1) echo "Poco"; if($row['appetite'] == 5) echo "Nulo";?></li> <?php endif; ?>
                                <?php if($row['hunger_satiety']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Presencia de hambre-saciedad | </b><?php echo ucfirst($row['hunger_satiety_comment']);?></li> <?php endif; ?>
                                <?php if($row['glasses'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Vasos de agua al día | </b><?php if($row['glasses'] == 1) echo "1 ó menos"; if($row['glasses'] == 2) echo "2 a 3"; if($row['glasses'] == 3) echo "4 ó más";?></li> <?php endif; ?>
                                <?php if($row['food_preferences'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Preferencia de alimentos | </b><?php echo ucfirst($row['food_preferences']);?></li> <?php endif; ?>
                                <?php if($row['food_unrest']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Malestares por alimentos | </b><?php echo ucfirst($row['food_unrest_comment']);?></li> <?php endif; ?>
                                <?php if($row['supplements']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Medicamentos, complementos o suplementos | </b><?php echo ucfirst($row['supplements_comment']);?></li> <?php endif; ?>
                                <?php if($row['carried_out']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Otras dietas realizadas | </b><?php echo ucfirst($row['carried_out_comment']);?></li> <?php endif; ?>
                                <?php if($row['ideal_weight'] != ""): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Peso ideal | </b><?php echo ucfirst($row['ideal_weight']);?></li> <?php endif; ?>
                                <?php if($row['current_condition']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Padecimiento actual relacionado al peso | </b><?php echo ucfirst($row['current_condition_comment']);?></li> <?php endif; ?>
                                <?php if($row['personal_history']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Antecedentes personales relacionados al peso | </b><?php echo ucfirst($row['personal_history_comment']);?></li> <?php endif; ?>
                                <?php if($row['consumption']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Consumo de líquidos | </b><?php echo ucfirst($row['consumption_comment']);?></li> <?php endif; ?>
                                <?php if($row['nutrition_education']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Educación nutriológica | </b><?php echo ucfirst($row['nutrition_education_comment']);?></li> <?php endif; ?>
                                <?php if($row['others']== 1): ?><li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Otros | </b><?php echo ucfirst($row['others_comment']);?></li> <?php endif; ?>
                                <?php endforeach;?>
                            </ul>
					    </div>
					    <?php } ?>
					    
					    
					</div>
		        
				<div class="modal-footer">
				  <span style="visibility:hidden">histrial medico</span>
				</div>
		</div>
<?php endforeach;?>