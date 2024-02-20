	<div class="modal-content animated fadeInDown" style="border-radius:20px;">
	    <div class="modal-header" style="background-color:#fff;border-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Ajustes de seguridad</span></h4>
	        <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
	    </div>
	    <div class="modal-body" style="background-color:#f1f3f7;">
	        <div class="form-group">
	            <div class="container">
	                <div class="row">
	                    <div class="col-sm-12 text-center">
	                        <h6>Escanea el siguiente código QR con tu aplicación <b>Autenticador de Google</b>.</h6><br>
	                        <?php $response = $this->security_model->getGoogleAuthQR();?>
	                        <img src="<?php echo $response['qr'];?>" /><br><br>
	                        <center><span class="app-divider2"></span></center>
	                        <a class="btn btn-primary" href="<?php echo base_url();?>admin/doctors/doctor_auth_link/<?php echo base64_encode($response['secret']);?>">Listo, continuar.</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal-footer" style="text-align:center; padding:20px;"></div>
	</div>