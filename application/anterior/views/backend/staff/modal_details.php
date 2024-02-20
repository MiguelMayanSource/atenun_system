<?php $info = $this->db->get_where('appointment', array('appointment_id' => $param2))->result_array();foreach($info as $row):?>

<div class="modal-content animated fadeInDown">
    <div class="modal-body" style="background-color:#6badff; margin-top: -20px; border-top-right-radius:15px;border-top-left-radius:20px;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff">&times;</button>
    </div>
    <div class="modal-footer" style="text-align:justify;padding:25px;">
        <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-heart-full"></i>
            <?php echo $row['practice'];?>
        </p>
        <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-alarm-clock"></i> <?php echo date("g:i A", strtotime($row['time']));?>.</p>
        <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-alarm-clock"></i> <?php echo $row['date'];?>.</p>
        <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-quill"></i> <?php echo $row['comment'];?></p>
        <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-document-add"></i>
            <?php echo $this->db->get_where('surgery_room', array('surgery_room_id'=>$row['surgery_room_id']))->row()->name;?>
        </p>
        <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-document-add"></i>
            <?php echo $this->db->get_where('room',array('room_id'=> $row['room_id']))->row()->name;?>
        </p>


        <br>
        <a class="btn btn-success" href="<?php echo base_url();?>staff/appointment/finish/<?php echo base64_encode($row['appointment_id']);?>"><i class="picons-thin-icon-thin-0133_arrow_right_next"></i> Finalizar cirugía </a>
    </div>
</div>
<?php endforeach;?>

<script>
function deleteEvent() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminara el evento de la agenda.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>staff/appointments/delete_calendar/" +
                <?php echo $param2?>;
        }
    })
}
</script>