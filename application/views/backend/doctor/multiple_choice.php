<style>
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #0a1b43;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>
<?php if($codigo != ""): 
      
?>
<div id="main-content">
    <div class="card-widget">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url();?>doctor/question_board/<?php echo $codigo;?>/">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo base_url();?>doctor/questions/<?php echo $codigo;?>">Preguntas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url();?>doctor/survey_results/<?php echo $codigo;?>">Resultados</a>
            </li>
        </ul>
        <br>
        <div class="content-box">
            <div class="card-h">
                <h2 class="card-caption"> <a href="<?php echo base_url();?>doctor/surveys/questions/<?php echo $codigo?>"><i class="picons-thin-icon-thin-0159_arrow_back_left"></i></a>
                    <span> Pregunta de opción múltiple </span>
                </h2>
                <hr>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="<?php echo base_url();?>doctor/multiple_choice/create/<?php echo $codigo;?>" method="post">
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
                                            <input class="form-control" type="text" required="" name="question">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div id="student_entry">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <div class="form-group">
                                                    <label for="" id="option">Opción</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="picons-thin-icon-thin-0168_check_ok_yes_no"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control" type="text" required="" name="options[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a id="clone" class="btn btn-info savech text-right" style="margin:20px 10px;" href="javascript:void(0);">+</a>
                                <a style="margin:20px 0px;" class="btn btn-sm btn-danger text-center" href="javascript:void(0);" id="remove"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                <div class="col-sm-12">
                                    <hr>
                                    <input type="submit" name="submit" class="btn btn-outline-success btn-rounded" value="Guardar" />
                                    <input type="submit" name="submit" class="btn btn-outline-primary btn-rounded" value="Guardar y agregar nueva" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>

<script type="text/javascript">
var counter = 2;
$("#clone").click(function() {
    var originalDiv = $("div#student_entry");
    var cloneDiv = originalDiv.clone();
    cloneDiv.attr('id', 'newDiv' + counter);
    $("[name='id" + counter + "']", cloneDiv).val(+counter);
    $("[name='correct_answers[]']", cloneDiv).attr('value', counter);
    $("[name='options[]']", cloneDiv).val('');
    originalDiv.parent().append(cloneDiv);
    counter++;
});

$("#remove").click(function(e) {
    if (counter > 1) {
        $('#newDiv' + (counter - 1)).remove();
        counter--;
    }
});
</script>