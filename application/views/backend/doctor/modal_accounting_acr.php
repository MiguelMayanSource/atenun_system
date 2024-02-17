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
                        <div class="col-sm-4">
                            <div class="profile-tile profile-tile-inlined modal-accounting" onclick="window.location.href='<?php echo base_url();?>doctor/adjust/';">
                                <div class="profile-tile-box">
                                    <div class="tile-controls"></div>
                                    <div class="" style="display: inline-block;width: 65px;height: auto;font-size: 30px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i></div>
                                    <div class="pt-user-last" style="font-size: 15px !important;">Ajustes</div>
                                    <div class="pt-user-name">Ver</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="profile-tile profile-tile-inlined modal-accounting" onclick="window.location.href='<?php echo base_url();?>doctor/closing/';">
                                <div class="profile-tile-box">
                                    <div class="tile-controls"></div>
                                    <div class="" style="display: inline-block;width: 65px;height: auto;font-size: 30px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0009_book_reading_read_manual"></i></div>
                                    <div class="pt-user-last" style="font-size: 15px !important;">Cierres</div>
                                    <div class="pt-user-name">Ver</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="profile-tile profile-tile-inlined modal-accounting" onclick="window.location.href='<?php echo base_url();?>doctor/opening/';">
                                <div class="profile-tile-box">
                                    <div class="tile-controls"></div>
                                    <div class="" style="display: inline-block;width: 65px;height: auto;font-size: 30px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0016_bookmarks_reading_book"></i></div>
                                    <div class="pt-user-last" style="font-size: 15px !important;">Reaperturas</div>
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