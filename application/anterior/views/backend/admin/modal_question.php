    <?php
        $this->db->where('question_id', $param2);
        $questions = $this->db->get('question')->result_array();
        foreach($questions as $row):
    ?>
    <div class="modal-content animated fadeInDown" style="border-radius:20px;">
        <form action="<?php echo base_url();?>admin/questions/update/<?php echo $param2;?>" method="post">
            <div class="modal-header" style="background-color:#fff;border-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-bullhorn"></i> Actualiza tu pregunta.</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="background-color:#f1f3f7;">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="question" class="form-control"><?php echo $row['question'];?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="button-confirm">Actualizar</button>
            </div>
        </form>
    </div>

    <?php endforeach;?>