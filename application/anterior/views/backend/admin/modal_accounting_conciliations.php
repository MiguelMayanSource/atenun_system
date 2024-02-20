<style type="text/css">
    .profile-tile.profile-tile-inlined.modal-accounting {
        cursor: pointer !important;
    }
</style>
<div class="modal-content animated fadeInDown">
    <form action="javascript:void(0);" method="POST">
        <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Elige una de las opciones.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="profile-tile profile-tile-inlined modal-accounting" onclick="window.location.href='<?php echo base_url();?>admin/bank_conciliations/';">
                                <div class="profile-tile-box">
                                    <div class="tile-controls"></div>
                                    <div class="" style="display: inline-block;width: 65px;height: auto;font-size: 30px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0407_credit_card"></i></div>
                                    <div class="pt-user-last" style="font-size: 15px !important;">Conciliación bancaria</div>
                                    <div class="pt-user-name">Ver</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="profile-tile profile-tile-inlined modal-accounting" onclick="window.location.href='<?php echo base_url();?>admin/cash_flows/';">
                                <div class="profile-tile-box">
                                    <div class="tile-controls"></div>
                                    <div class="" style="display: inline-block;width: 65px;height: auto;font-size: 30px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0425_money_payment_dollar_cash"></i></div>
                                    <div class="pt-user-last" style="font-size: 15px !important;">Flujo de efectivo</div>
                                    <div class="pt-user-name">Ver</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>