<style>
span.error {
    font-size: 12px;
    position: absolute;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    top: -20px;
    right: -15px;
    z-index: 2;
    height: 25px;
    line-height: 1;
    background-color: #e34f4f;
    color: #fff;
    font-weight: normal;
    display: inline-block;
    padding: 6px 8px;
}

span.error:after {
    content: '';
    position: absolute;
    border-style: solid;
    border-width: 0 6px 6px 0;
    border-color: transparent #e34f4f;
    display: block;
    width: 0;
    z-index: 1;
    bottom: -6px;
    left: 20%;
}

#formValidate .wizard>.content {
    min-height: 25em;
}

#example-vertical.wizard>.content {
    min-height: 24.5em;
}

.image_galery {
    position: relative;
    box-sizing: border-box;
    transition: all 0.2s ease;
    border-radius: 6px;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    float: left;
    margin: 1.858736%;
    width: 29.615861214%;
    height: 150px;
    box-shadow: 0 4px 10px 0 rgb(51 51 51 / 25%);
}


.file_control_custom {
    box-sizing: border-box;
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 5;
    height: auto;
    overflow: hidden;
    line-height: 1.5;
    user-select: none;
    background-clip: padding-box;
    border-radius: 0.25rem;
    height: auto;
    border: 1px solid #f1f2f3;
    color: #3b3f5c;
    font-size: 15px;
    padding: 8px 10px;
    letter-spacing: 1px;
    background-color: #f1f2f3;
    cursor: pointer;
    margin: 30px;
}


.custom-file-container input[type=file] {
    position: absolute;
    top: 0;
    min-width: 100%;
    min-height: auto;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
    z-index: 1000;
    cursor: pointer;
}

.circle.wizard>.steps .current:not(.done) a .number,
.circle.wizard>.steps .current:not(.done) a:hover .number,
.circle.wizard>.steps .current:not(.done) a:active .number {
    border-color: #0e1726;
    background-color: #0e1726;
    color: #fff;
}

.circle.wizard>.steps .done a .number {
    border-color: #0e1726;
}

.circle.wizard>.steps ul li.done::after,
.circle.wizard>.steps ul li.done::before {
    background-color: #0e1726;
}

.wizard>.actions a {
    background-color: #0e1726;

}

.input[type="radio"] {
    display: none !important;
}

.custom-file-container__custom-file__custom-file-control {
    background: #fff !important;
}

.close1:before {
    content: '✕';
    top: 0px;
    position: absolute;
    right: 3px;
    font-weight: bold;
    color: white;
}

.close1 {
    position: absolute;
    top: -10px;
    right: -10px;
    background: red;
    padding: 10px;
    box-sizing: border-box;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    cursor: pointer;
}

label {
    color: black !important;
}

.back12 {
    background: #f1f2f3;
    margin-top: 27px;
    width: auto;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    padding: 20px 20px 0px 20px
}
</style>
<div id="main-content">
    <link href="<?php echo base_url();?>public/super/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <div class="col-xl-12  col-lg-12 col-sm-12  layout-spacing card-widget">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-heading">
                <h4> <a href="#" onclick="history.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke:currentColor;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 8 8 12 12 16"></polyline>
                            <line x1="16" y1="12" x2="8" y2="12"></line>
                        </svg>
                    </a><?php echo 'Ingreso de resultados para la muestra <b>'.$this->db->get_where('sample_piece',array('sample_id'=>base64_decode($ID)))->row()->code;;  ?></b></h4>
            </div>
            <div class="">
                <form action="<?php echo base_url();?>staff/laboratory_results/save" method='POST'>
                    <input type="hidden" name="sample_id" value="<?php echo $ID; ?>" />
                    <div class="widget-heading">
                        <h4> </h4>
                    </div>
                    <?php    
                        $cont1 = 0;
                        $laboratories = $this->db->group_by('laboratory_id')->get_where('sample_piece',array('sample_id'=>base64_decode($ID)))->result_array(); 
                        
                        foreach($laboratories as $exm):?>

                    <h3><?php echo $this->db->get_where("subcategory",array("id"=>$exm['laboratory_id']))->row()->name;  ?></h3>   
                    <?php   
                        $exmans = $this->db->get_where('sample_piece',array('sample_id'=>base64_decode($ID),'laboratory_id'=>$exm['laboratory_id']))->result_array(); 
                        foreach($exmans as $laboratory):
                    ?>
                    <br>
                    <h3><?php echo $this->db->get_where("product",array("product_id"=>$laboratory['exams']))->row()->name;  ?></h3>   
                    <div class="table-responsive">
                        <table class="table table-bordered mb-10">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>-</th>
                                <th>Unidad</th>
                                <th>Referencia</th>
                            </tr>
                            <tbody class="row_position">
                                <?php 
                                    if($laboratory['results']== ""):
                                        $fields =  $this->db->query("SELECT * FROM `laboratory_template` WHERE laboratory_id = ".$laboratory['exams']." AND status = 1")->result_array();
                                        $cont = 1;
                                        foreach($fields as $field_detail):
                                        $field =  $this->db->query("SELECT * FROM `laboratory_fields` WHERE laboratory_fields_id = ".$field_detail['laboratory_fields_id'])->row_array();
                                ?>
                                <tr class="rows" id="<?php echo $field['laboratory_fields_id']?>">
                                    <td class="indice" style="white-space:nowrap;width:50px"><?php echo $cont++?></td>
                                    <td style="white-space:nowrap;width:250px"><?php echo $field['name']?></td>
                                    <td style="white-space:nowrap;width:200px">
                                        <input type="text" class="form-control" autocomplete="off" name="<?php echo $field['laboratory_fields_id'].'_'.$cont1++; ?>">
                                    </td>
                                    <td style="white-space:nowrap;width:200px"><?php echo $field['unity']?></td>
                                    <td style="white-space:nowrap;width:200px"><?php echo $field['reference']?></td>
                                </tr>
                                <?php endforeach;
                                    else:
                                         
                                        $fields = json_decode($laboratory['results'],true);
                                        $cont = 1;
                                        foreach($fields as $results):
                                        $field =  $this->db->query("SELECT * FROM `laboratory_fields` WHERE laboratory_fields_id = ".array_keys($results)[0])->row_array();
                                 
                                    
                                    ?>
                                <tr class="rows" id="<?php echo $field['laboratory_fields_id']?>">
                                    <td class="indice" style="white-space:nowrap;width:50px"><?php echo $cont++?></td>
                                    <td style="white-space:nowrap;width:250px"><?php echo $field['name']?></td>
                                    <td style="white-space:nowrap;">
                                        <input type="text" class="form-control" style="width:150px" autocomplete="off" name="<?php echo $field['laboratory_fields_id'].'_'.$cont1++;?>" value="<?php echo array_values($results)[0]?>">
                                    </td>
                                    <td style="white-space:nowrap;width:200px"><?php echo $field['unity']?></td>
                                    <td style="white-space:nowrap;width:200px"><?php echo $field['reference']?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                        <br>
                    </div>
                    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary ">Guardar</button>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>