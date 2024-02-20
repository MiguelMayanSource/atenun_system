    <div class="col-sm-12" id="odonto">
            
                <div style="text-align:center;">
                    <div class="btn-grou p" data-toggle="buttons" style="background:transparent;">
                        <label class="btn btn-primary form-check-label" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                        <input class="form-check-input" type="radio" name="options" id="option1" autocomplete="off" checked style="opacity: 0;">
                        <a id='ocultar-mostrar'> Adultos </a>
                                            </label>
                                            <label class="btn btn-primary form-check-label">
                                                <input class="form-check-input" type="radio" name="options" id="option2" autocomplete="off" style="opacity: 0;" > 
                                                <a   id='ocultar-mostrar-ninos'> Niños </a>
                                            </label>
                                            <label class="btn btn-primary form-check-label" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                                <input class="form-check-input" type="radio" name="options" id="option3" autocomplete="off" style="opacity: 0;" >
                                                <a   id='ocultar-mostrar-mixto'> Mixtos </a>
                                            </label>
                                        </div>
                                    </div>    
                                <br>
                                <div id='ocultar-y-mostrar'>
                                    <div  class="row">
                                        <div  class="col-sm-12">
                                    <div class="table-responsive" >
                                        <table style="text-align:center;display:none; width: 100%;" id="adultos">
                                    <tbody>
                                        <tr>
                                            
                                            <td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="1">
        								        <img src="<?php echo base_url();?>public/assets/back/images/odonto/1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="1">1</button>
        									</td>
        									
                                            <td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="2">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="2">2</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="3">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="3">3</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="4">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="4">4</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="5">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="5">5</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="5">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/6.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>');" data-whatever="6">6</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/7.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7">7</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/8.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8">8</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/9/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="9">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/9.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/9/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="9">9</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/10/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="10">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/10.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/10/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="10">10</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/11/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="11">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/11.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"> </a><br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/11/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="11">11</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/12/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="12">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/12.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/12/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="12">12</button>
        								    </td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/13/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="13">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/13.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/13/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="13">13</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/14/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="14">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/14.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/14/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="14">14</button>
        								    </td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/15/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="15">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/15.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/15/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="15">15</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/16/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="16">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/16.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/16/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="16">16</button>
        									</td>
                                        </tr>
                                        
                                        
                                        <tr>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/32/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="32">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/32.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/32/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="32">32</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/31/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="31">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/31.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/31/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="31">31</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/30/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="30">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/30.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/30/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="30">30</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/29/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="29">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/29.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/29/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="29">29</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/28/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="28">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/28.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/28/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="28">28</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/27/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="27">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/27.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/27/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="27">27</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/26/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="26">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/26.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/26/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="26">26</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/25/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="25">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/25.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/25/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="25">25</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/24/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="24">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/24.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/24/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="24">24</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/23/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="23">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/23.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/23/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="23">23</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/22/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="22">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/22.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/22/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="22">22</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/21/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="21">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/21.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/21/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="21">21</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/20/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="20">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/20.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/20/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="20">20</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/19/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="19">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/19.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/19/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="19">19</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/18/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="18">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/18.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/18/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="18">18</button>
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/17/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="17">
        									    <img src="<?php echo base_url();?>public/assets/back/images/odonto/17.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
        										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/17/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="17">17</button>
        									</td>
        								</tr>
                                    </tbody>
                                </table>
                                        
                                    </div>
                                    </div>
                                    </div>
                                    
                                    
                                   </div>
                                <script>
                                
                                
                                $('#ocultar-mostrar').click(function(e) {
                                    $('#ninos').hide(500);
                                    $('#mixto').hide(500);
                                    $('#adultos').show(500);
                                    });
                                </script>
                                    <div class="table-responsive">
                                        
                                        <!--NIÑOS -->
                                
                                <table style="text-align:center; display: none;width: 100%;" id="ninos">
                                    <tbody>
                                        <tr>
                                            <td style="padding-right:0;padding-left:0;">
        									</td>
        									<td style="padding-right:0;padding-left:0;">
        									</td>
        									<td style="padding-right:0;padding-left:0;">
        									</td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.5">
    									        <img src="<?php echo base_url();?>public/assets/back/images/infantil/5.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    										    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.5">5.5</button>
    									    </td>
        									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.4">
									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/5.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.4">5.4</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.3">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/5.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.3">5.3</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.2">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/5.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.2">5.2</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.1">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/5.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.1">5.1</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.1">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/6.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.1">6.1</button>
    								    </td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.2">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/6.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.2">6.2</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.3">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/6.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.3">6.3</button>
    								    </td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.4">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/6.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.4">6.4</button>
    								    </td>
    									<td style="padding-right:0;padding-left:0;" ><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.5">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/6.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.5">6.5</button>
    								    </td>
    									<td style="padding-right:0;padding-left:0;"></td>
    									<td style="padding-right:0;padding-left:0;"></td>
    									<td style="padding-right:0;padding-left:0;"></td>
    							    </tr>
    								<tr>
    								    <td style="padding-right:0;padding-left:0;"></td>
    									<td style="padding-right:0;padding-left:0;"></td>
    									<td style="padding-right:0;padding-left:0;"></td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.5">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/8.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
    										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.5">8.5</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.4">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/8.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"> </a><br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.4">8.4</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.3">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/8.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"> </a><br>
    										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.3">8.3</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.2">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/8.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"> </a><br>
    										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.2">8.2</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.1">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/8.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.1">8.1</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.1">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/7.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"> </a><br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.1">7.1</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.2">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/7.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"> </a><br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.2">7.2</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.3">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/7.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.3">7.3</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.4">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/7.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.4/<?php echo $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.4">7.4</button>
    								    </td>
    									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.5">
    									    <img src="<?php echo base_url();?>public/assets/back/images/infantil/7.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
    									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.5">7.5</button>
    									</td>
    									<td style="padding-right:0;padding-left:0;"></td>
    									<td style="padding-right:0;padding-left:0;"></td>
    									<td style="padding-right:0;padding-left:0;"></td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <script>
                                    $('#ocultar-mostrar-ninos').click(function(e) {
  
                                      $('#ninos').show(500);
                                    $('#mixto').hide(500);
                                    $('#adultos').hide(500);
                                    });
                                </script>
                                        
                                        
                                    </div>
                                
                                
                            
                                <div class="table-responsive">
                                    
                                    <!--- MIXTO --->
                                    
                                    <table style="text-align:center; display: none;width: 100%;" id="mixto">
						    <tbody>
							    <tr>
								    <td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="1">
								        <img src="<?php echo base_url();?>public/assets/back/images/mixto/1.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="1">1</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="2">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/2.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="2">2</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="3">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/3.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="3">3</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="4">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/4.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="4">4</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/5.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5">5</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.0/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/6.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6">6</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/7.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7">7</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/8.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8">8</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/9/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="9">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/9.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/9/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="9">9</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/10/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="10">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/10.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/10/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="10">10</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/11/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="11">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/11.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"> </a><br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/11/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="11">11</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/12/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="12">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/12.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/12/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="12">12</button>
								    </td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/13/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="13">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/13.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/13/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="13">13</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/14/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="14">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/14.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/14/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="14">14</button>
								    </td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/15/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="15">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/15.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/15/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="15">15</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/16/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="16">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/16.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/16/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="16">16</button>
									</td>
							    </tr>
								<tr>
								    <td style="padding-right:0;padding-left:0;">
									</td>
									<td style="padding-right:0;padding-left:0;">
									</td>
									<td style="padding-right:0;padding-left:0;">
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.5">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/5.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.5">5.5</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.4">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/5.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.4">5.4</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.3">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/5.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.3">5.3</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.2">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/5.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.2">5.2</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.1">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/5.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/5.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.1">5.1</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.1">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/6.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.1">6.1</button>
								    </td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.2">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/6.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.2">6.2</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.3">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/6.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.3">6.3</button>
								    </td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.4">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/6.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.4">6.4</button>
								    </td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.5">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/6.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/6.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="6.5">6.5</button>
								    </td>
									<td style="padding-right:0;padding-left:0;"></td>
									<td style="padding-right:0;padding-left:0;"></td>
									<td style="padding-right:0;padding-left:0;"></td>
							    </tr>
								<tr>
								    <td style="padding-right:0;padding-left:0;"></td>
									<td style="padding-right:0;padding-left:0;"></td>
									<td style="padding-right:0;padding-left:0;"></td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.5">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/8.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.5">8.5</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.4">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/8.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.4">8.4</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.3">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/8.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.3">8.3</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.2">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/8.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.2">8.2</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="8.1">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/8.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/8.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="5.1">8.1</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.1">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/7.1.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.1/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.1">7.1</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.2">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/7.2.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.2/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.2">7.2</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.3">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/7.3.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.3/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.3">7.3</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.4">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/7.4.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.4/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.4">7.4</button>
								    </td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.5">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/7.5.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
									    <button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/7.5/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="7.5">7.5</button>
									</td>
									<td style="padding-right:0;padding-left:0;"></td>
									<td style="padding-right:0;padding-left:0;"></td>
									<td style="padding-right:0;padding-left:0;"></td>
								</tr>
								<tr>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/32/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="32">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/32.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/32/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="32">32</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/31/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="31">
										<img src="<?php echo base_url();?>public/assets/back/images/mixto/31.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/31/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="31">31</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/30/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="30">
										<img src="<?php echo base_url();?>public/assets/back/images/mixto/30.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/30/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="30">30</button>
									</td>
								    <td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/29/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="29">
										<img src="<?php echo base_url();?>public/assets/back/images/mixto/29.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/29/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="29">29</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/28/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="28">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/28.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/28/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="28">28</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/27/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="27">
								        <img src="<?php echo base_url();?>public/assets/back/images/mixto/27.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/27/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="27">27</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/26/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="26">
							    	    <img src="<?php echo base_url();?>public/assets/back/images/mixto/26.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/26/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="26">26</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/25/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="25">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/25.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/25/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="25">25</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/24/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="24">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/24.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/24/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="24">24</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/23/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="23">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/23.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/23/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="23">23</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/22/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="22">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/22.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/22/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="22">22</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/21/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="21">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/21.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/21/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="21">21</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/20/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="20">
										<img src="<?php echo base_url();?>public/assets/back/images/mixto/20.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/20/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="20">20</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/19/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="19">
										<img src="<?php echo base_url();?>public/assets/back/images/mixto/19.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/19/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="19">19</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/18/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="18">
										<img src="<?php echo base_url();?>public/assets/back/images/mixto/18.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a><br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/m/18/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="18">18</button>
									</td>
									<td style="padding-right:0;padding-left:0;"><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/17/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="17">
									    <img src="<?php echo base_url();?>public/assets/back/images/mixto/17.0.png" style="border-radius:0;width:auto;height:auto;padding-bottom:5px;"></a> <br>
										<button type="button" class="btn btn-link" style="color:black" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_plan/17/<?php echo  $details['patient_id'];?>/<?php echo  $details['appointment_id'];?>/<?php echo $details['doctor_id'];?>/');" data-whatever="17">17</button>
									</td>
					</tr>
				</tbody>
			</table>
			<div id="instrucciones"></div>
        </div>
    </div>
    <div class="container-fluid" >
        <div class="table-responsive w-100">
            <div class="col-sm-12" id="table_results_tooth">
            </div>
        </div>
    </div>
    <script>
    $('#ocultar-mostrar-mixto').click(function(e) {
        $('#ninos').hide(500);
        $('#mixto').show(500);
        $('#adultos').hide(500);
    });
    </script>