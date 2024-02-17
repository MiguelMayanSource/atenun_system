<style>
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #0a1b43;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>
<?php if($codigo != ""): 
    $questions = $this->db->get_where('question', array('question_id' => $codigo))->result_array();
    foreach($questions as $row): 
        if ($row['options'] != "" || $row['options'] != null) {
                $options = json_decode($row['options']);
            } else {
                $options = array();
            }?>

<<div id="main-content">
    <div class="card-widget">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url();?>staff/question_board/<?php echo $codigo;?>/">Detalles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo base_url();?>staff/questions/<?php echo $codigo;?>">Preguntas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url();?>staff/survey_results/<?php echo $codigo;?>">Resultados</a>
            </li>
        </ul>
        <br>


        <div class="content-box">

            <div class="card-h">
                <h2 class="card-caption"> <a href="<?php echo base_url();?>staff/surveys/questions/<?php echo $codigo?>"><i class="picons-thin-icon-thin-0159_arrow_back_left"></i></a>
                    <span> Pregunta de opción múltiple </span>
                </h2>
                <hr>
            </div>


            <div class="tasks-list-w">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="<?php echo base_url();?>staff/update_multiple/update/<?php echo $codigo;?>" method="post">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <label for="">Pregunta</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="picons-thin-icon-thin-0004_pencil_ruler_drawing"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control" type="text" required="" value="<?php echo $row['question']?>" name="question">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div id="student_entry">
                                            <div class="row">
                                                <?php for ($i = 0; $i < $row['number_of_options']; $i++):?>
                                                <div class="col-sm-11">
                                                    <div class="form-group">
                                                        <label for="" id="option">Opción</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="picons-thin-icon-thin-0168_check_ok_yes_no"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" type="text" required="" name="options[]" value="<?php echo $options[$i]; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endfor;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <hr>
                                        <input type="submit" name="submit" class="btn btn-outline-success btn-rounded" value="Actualizar" />
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    <?php endforeach;?>
    <?php endif;?>