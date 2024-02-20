<style>
    input[type="radio"] 
        {
            width: 25px;
            height: 25px;
            border-radius: 15px;
            border: 2px solid #0844e98a;
            background-color: white;
            -webkit-appearance: none; /*to disable the default appearance of radio button*/
            -moz-appearance: none;
        }
        input[type="radio"]:focus { /*no need, if you don't disable default appearance*/
            outline: none; /*to remove the square border on focus*/
        }
        input[type="radio"]:checked { /*no need, if you don't disable default appearance*/
            background-color: #0844e98a;
        }
        input[type="radio"]:checked ~ span:first-of-type {
            color: white;
        }
        label span:first-of-type {
            position: relative;
            left: -21px;
            font-size: 13px;
            top: -7px;
            font-weight: 700;
            color: #0844e98a;
        }
        label span {
            position: relative;
            top: -10px;
        }
        .lbl{
            margin-right: -10px;
            margin-bottom:0px!important;
        }
</style><?php  $cetox = $this->db->get_where('cetosis_history', array( 'appointment_id' => $appointment_id)); ?>
<div class="col-sm-12 m-b-30">
                            <div style="" class="_body_l8wwyk--has-padding  _body_l8wwyk">
                                <div data-autoid="vital-signs-set-ketosis" id="ember3414" class="ember-view">
                                    <div class="ketosis _ketosis-elements_gjvl06">
                                        <?php  if ($this->crud_model->check_item('satiety') == 1): ?>
                                        <li id="ember3442" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😤 Saciedad
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                                <div>
                                                                    <?php     
                                                                        if($cetox->num_rows()>0)
                                                                            $ceto = $cetox->row()->satiety;
                                                                        else
                                                                            $ceto = ""; 
                                                                    ?>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="satiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="satiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="satiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="satiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('halitosis') == 1):
?>
                                        <li id="ember3470" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😷 Halitosis
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                        if($cetox->num_rows()>0)
                                                                            $ceto = $cetox->row()->halitosis;
                                                                        else
                                                                            $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="halitosis" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="halitosis" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="halitosis" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="halitosis" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('cramps') == 1):
?>
                                        <li id="ember3478" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            ⚡️ Calambres
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->cramps;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="cramps" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="cramps" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="cramps" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="cramps" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('hungry') == 1):
?>
                                        <li id="ember3486" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            🌮 Hambre
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->hunger;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="hunger" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="hunger" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="hunger" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="hunger" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('diarrhea') == 1):
?>
                                        <li id="ember3494" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            💩 Diarrea
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->diarrhea;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="diarrhea" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="diarrhea" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="diarrhea" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="diarrhea" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('sleeping') == 1):
?>
                                        <li id="ember3502" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😴 Problemas de sueño
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->sleep_problems;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="sleep_problems" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="sleep_problems" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="sleep_problems" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="sleep_problems" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('depressed') == 1):
?>
                                        <li id="ember3510" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            ☹️ Deprimido
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                              <?php     
                                                                        if($cetox->num_rows()>0)
                                                                            $ceto = $cetox->row()->depressed;
                                                                        else
                                                                            $ceto = ""; 
                                                                    ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="depressed" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="depressed" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="depressed" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="depressed" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('impatient') == 1):
?>
                                        <li id="ember3518" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            🙄 Impaciente
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->impatient;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="impatient" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="impatient" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="impatient" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="impatient" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?php endif;?>
                                        <?php
        if ($this->crud_model->check_item('tolerance') == 1):
?>
                                        <li id="ember3526" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😒 Tolerancia
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->tolerance;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="tolerance" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="tolerance" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="tolerance" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="tolerance" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?  endif; ?>
                                        <?php if ($this->crud_model->check_item('estimulantes') == 1):
?>
                                        <li id="ember3534" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            ☕️ Necesidad de Estimulantes
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->stimulants;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="stimulants" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="stimulants" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="stimulants" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="stimulants" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('constipation') == 1):
?>
                                        <li id="ember3542" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😣 Estreñimiento
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                                <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->constipation;
                                                                else
                                                                    $ceto = ""; 
                                                                ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="constipation" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="constipation" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="constipation" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="constipation" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('migraine') == 1):
?>
                                        <li id="ember3550" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            🤕 Migraña o Cefalea
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->migraine;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="migraine" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="migraine" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="migraine" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="migraine" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('vertigo') == 1):
?>
                                        <li id="ember3558" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            🌪 Vértigo
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->vertigo;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="vertigo" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="vertigo" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="vertigo" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="vertigo" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('fatigue') == 1):
?>
                                        <li id="ember3566" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😓 Cansancio
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->tiredness;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="tiredness" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="tiredness" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="tiredness" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="tiredness" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('anxiety') == 1):
?>
                                        <li id="ember3574" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😬 Ansiedad
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                if($cetox->num_rows()>0)
                                                                    $ceto = $cetox->row()->anxiety;
                                                                else
                                                                    $ceto = ""; 
                                                            ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="anxiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="anxiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="anxiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="anxiety" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('concentration') == 1):
?>
                                        <li id="ember3582" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            🤔 Concentración
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                                <div>
                                                                <?php     
                                                                    if($cetox->num_rows()>0)
                                                                        $ceto = $cetox->row()->concentration;
                                                                    else
                                                                        $ceto = ""; 
                                                                ?>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="concentration" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="concentration" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="concentration" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="concentration" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('irritability') == 1):
?>
                                        <li id="ember3590" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            😠 Irritabilidad
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                    if($cetox->num_rows()>0)
                                                                        $ceto = $cetox->row()->irritability;
                                                                    else
                                                                        $ceto = ""; 
                                                                ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="irritability" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="irritability" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="irritability" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="irritability" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <?
        endif;
?>
                                        <?php
        if ($this->crud_model->check_item('aggressiveness') == 1):
?>
                                        <li id="ember3598" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            👊 Agresividad
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                                <div>
                                                                <?php     
                                                                    if($cetox->num_rows()>0)
                                                                        $ceto = $cetox->row()->aggression;
                                                                    else
                                                                        $ceto = ""; 
                                                                ?>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="0" name="aggression" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="aggression" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="aggression" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="aggression" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="_graph_8x0tfa"></div>
                                        </li>
                                        <? endif;?>
                                        <?php  if ($this->crud_model->check_item('impulse') == 1): ?>
                                        <li id="ember3606" class="_vital-sign_8x0tfa ember-view">
                                            <div class="_element_8x0tfa">
                                                <div class="_field_8x0tfa">
                                                    <div class="_vital-sign-row_184cp7">
                                                        <div data-autoid="vital-sign-name" class="_vital-sign-name_184cp7">
                                                            🤐 Control de Impulsos
                                                        </div>
                                                        <div class="_vital-sign-data_184cp7">
                                                            <div>
                                                            <?php     
                                                                    if($cetox->num_rows()>0)
                                                                        $ceto = $cetox->row()->impulse;
                                                                    else
                                                                        $ceto = ""; 
                                                                ?>
                                                                <div>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="impulse" <?php if($details['status'] == 4): ?> <?php if($ceto == 0): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>0</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="1" name="impulse" <?php if($details['status'] == 4): ?> <?php if($ceto == 1): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="2" name="impulse" <?php if($details['status'] == 4): ?> <?php if($ceto == 2): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label class="lbl">
                                                                        <input type="radio" value="3" name="impulse" <?php if($details['status'] == 4): ?> <?php if($ceto == 3): ?> checked <?php endif;?> <?php endif;?>/>
                                                                        <span>3</span>
                                                        </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_graph_8x0tfa"></div>
                        </li>
                <?endif; ?>
                </div>
            </div>
        </div>
        <br>
    </div>