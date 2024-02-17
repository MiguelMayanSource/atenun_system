                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="_body_l8wwyk--has-padding _body_l8wwyk">
                                            <div data-autoid="vital-signs-set-nutrition" id="ember2465" class="ember-view">
                                                <div class="_nutrition-elements_1yt0nq _ketosis-elements_gjvl06">
                                                    <?php      if ($this->crud_model->check_item('lost_weight') == 1):?>
                                                    <li id="ember2493" class="_vital-sign_8x0tfa ember-view">
                                                        <div class="_element_8x0tfa">
                                                            <div class="_field_8x0tfa">
                                                                <div class="_vital-sign-row_c5jvwj _vital-sign-row_184cp7 ">
                                                                    <img src="<?php echo base_url();?>public/uploads/appointment_details/peso.png" alt="Peso Perdido" class="_icon_c5jvwj">
                                                                    <div class="_vital-sign-name_c5jvwj _vital-sign-name_184cp7">
                                                                        Peso Perdido
                                                                    </div>
                                                                    <div class="_vital-sign-data_c5jvwj _vital-sign-data_184cp7">
                                                                        <div class="_vital-sign-data-value_c5jvwj _vital-sign-data-value_184cp7">
                                                                            <input readonly="" name="weight" type="number" id="ember2531" class="form-control ember-view" <?php if ($details['status'] == 4): ?>
                                                                            value="<?php echo $this->db->get_where('nutritional_history', array(  'appointment_id' => $appointment_id))->row()->weight; ?>" <?php endif;?> >
                                                                        </div>
                                                                        <div class="_vital-sign-data-unit_c5jvwj"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="_graph_8x0tfa"></div>
                                            </li>
                                            <? endif;    if ($this->crud_model->check_item('water') == 1): ?>
                                            <li id="ember2533" class="_vital-sign_8x0tfa ember-view">
                                                <div class="_element_8x0tfa">
                                                    <div class="_field_8x0tfa">
                                                        <div class="_vital-sign-row_c5jvwj _vital-sign-row_184cp7 ">
                                                            <img src="<?php echo base_url();?>public/uploads/appointment_details/agua.png" alt="Agua" class="_icon_c5jvwj">
                                                            <div class="_vital-sign-name_c5jvwj _vital-sign-name_184cp7">
                                                                Agua
                                                            </div>
                                                            <div class="_vital-sign-data_c5jvwj _vital-sign-data_184cp7">
                                                                <div class="_vital-sign-data-value_c5jvwj _vital-sign-data-value_184cp7">
                                                                    <input readonly="" name="water" type="number" id="ember2536" class="form-control ember-view" 
                                                                    <?php  if ($details['status'] == 4):?> value="<?php    echo $this->db->get_where('nutritional_history', array(  'appointment_id' => $appointment_id ))->row()->water;?>" 
                                                                    <?php endif; ?>>
                                                                </div>
                                                                <div class="_vital-sign-data-unit_c5jvwj"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="_graph_8x0tfa"></div>
                                            </li>
                                            <?php        endif;  if ($this->crud_model->check_item('grease') == 1):?>
                                            <li id="ember2538" class="_vital-sign_8x0tfa ember-view">
                                                <div class="_element_8x0tfa">
                                                    <div class="_field_8x0tfa">
                                                        <div class="_vital-sign-row_c5jvwj _vital-sign-row_184cp7 ">
                                                            <img src="<?php echo base_url();?>public/uploads/appointment_details/gordura.png" alt="Grasa" class="_icon_c5jvwj">
                                                            <div class="_vital-sign-name_c5jvwj _vital-sign-name_184cp7">
                                                                Grasa
                                                            </div>
                                                            <div class="_vital-sign-data_c5jvwj _vital-sign-data_184cp7">
                                                                <div class="_vital-sign-data-value_c5jvwj _vital-sign-data-value_184cp7">
                                                                    <input readonly="" name="grease" type="number" id="ember2541" class="form-control ember-view" 
                                                                    <?php    if ($details['status'] == 4):?> value="<?php  echo $this->db->get_where('nutritional_history', array(    'appointment_id' => $appointment_id   ))->row()->grease;?>" 
                                                                    <?php   endif;?>>
                                                                </div>
                                                                <div class="_vital-sign-data-unit_c5jvwj"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="_graph_8x0tfa"></div>
                                            </li>
                                            <?php  endif;  if ($this->crud_model->check_item('nutri_muscle') == 1):?>
                                            <li id="ember2543" class="_vital-sign_8x0tfa ember-view">
                                                <div class="_element_8x0tfa">
                                                    <div class="_field_8x0tfa">
                                                        <div class="_vital-sign-row_c5jvwj _vital-sign-row_184cp7 ">
                                                            <img src="<?php echo base_url();?>public/uploads/appointment_details/musculo.png" alt="Músculo" class="_icon_c5jvwj">
                                                            <div class="_vital-sign-name_c5jvwj _vital-sign-name_184cp7">
                                                                Músculo
                                                            </div>
                                                            <div class="_vital-sign-data_c5jvwj _vital-sign-data_184cp7">
                                                                <div class="_vital-sign-data-value_c5jvwj _vital-sign-data-value_184cp7">
                                                                    <input readonly="" name="muscle" type="number" id="ember2546" class="form-control ember-view" 
                                                                    <?php   if ($details['status'] == 4):?> value="<?php  echo $this->db->get_where('nutritional_history', array(     'appointment_id' => $appointment_id  ))->row()->muscle;?>" 
                                                                    <?php   endif;?>>
                                                                </div>
                                                                <div class="_vital-sign-data-unit_c5jvwj"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="_graph_8x0tfa"></div>
                                            </li>
                                            <?php   endif;  if ($this->crud_model->check_item('waist') == 1):?>
                                            <li id="ember2548" class="_vital-sign_8x0tfa ember-view">
                                                <div class="_element_8x0tfa">
                                                    <div class="_field_8x0tfa">
                                                        <div class="_vital-sign-row_c5jvwj _vital-sign-row_184cp7 ">
                                                            <img src="<?php echo base_url();?>public/uploads/appointment_details/cintura.png" alt="Cintura" class="_icon_c5jvwj">
                                                            <div class="_vital-sign-name_c5jvwj _vital-sign-name_184cp7">
                                                                Cintura
                                                            </div>
                                                            <div class="_vital-sign-data_c5jvwj _vital-sign-data_184cp7">
                                                                <div class="_vital-sign-data-value_c5jvwj _vital-sign-data-value_184cp7">
                                                                    <input readonly="" name="waist" type="number" id="ember2551" class="form-control ember-view" 
                                                                    <?php   if ($details['status'] == 4):?> value="<?php echo $this->db->get_where('nutritional_history', array(   'appointment_id' => $appointment_id  ))->row()->waist;?>" 
                                                                    <?php endif;?>>
                                                                </div>
                                                                <div class="_vital-sign-data-unit_c5jvwj"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="_graph_8x0tfa"></div>
                                            </li>
                                            <?php  endif; if ($this->crud_model->check_item('abdomen') == 1):?>
                                            <li id="ember2553" class="_vital-sign_8x0tfa ember-view">
                                                <div class="_element_8x0tfa">
                                                    <div class="_field_8x0tfa">
                                                        <div class="_vital-sign-row_c5jvwj _vital-sign-row_184cp7 ">
                                                            <img src="<?php echo base_url();?>public/uploads/appointment_details/abdomen.png" alt="Abdomen" class="_icon_c5jvwj">
                                                            <div class="_vital-sign-name_c5jvwj _vital-sign-name_184cp7">
                                                                Abdomen
                                                            </div>
                                                            <div class="_vital-sign-data_c5jvwj _vital-sign-data_184cp7">
                                                                <div class="_vital-sign-data-value_c5jvwj _vital-sign-data-value_184cp7">
                                                                    <input readonly="" name="abdomen" type="number" id="ember2556" class="form-control ember-view" 
                                                                    <?php  if ($details['status'] == 4):?> value="<?php  echo $this->db->get_where('nutritional_history', array(    'appointment_id' => $appointment_id ))->row()->abdomen;?>" 
                                                                    <?php  endif;?>>
                                                                </div>
                                                                <div class="_vital-sign-data-unit_c5jvwj"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="_graph_8x0tfa"></div>
                                            </li>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>