<?php $financial  = $this->db->get_where('financial', array('financial_id' => $param2))->row();?>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">No. <?php echo $financial->invoice_code;?></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="col-sm-12" style="text-align:center">

        <img src="<?php echo base_url();?>public/uploads/income_image/<?php echo $financial->invoice_file;?>" alt="" style="border:5px solid black; max-width: 50%;max-height:80%; margin:10px;">

    </div>
</div>