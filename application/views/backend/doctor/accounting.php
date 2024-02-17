<div id="main-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls"></div>
                    <div class="" style="display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0016_bookmarks_reading_book"></i></div>
                    <div class="pt-user-last">Partidas</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>doctor/departures/';">Ver</div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls"></div>
                    <div class="" style="display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0017_office_archive"></i></div>
                    <div class="pt-user-last">Libros</div>
                    <div class="pt-user-name" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_books/')">Ver</div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls"></div>
                    <div class="" style="display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0007_book_reading_read_bookmark"></i></div>
                    <div class="pt-user-last">Conciliaciones</div>
                    <div class="pt-user-name" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_accounting_conciliations/')">Ver</div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls"></div>
                    <div class="" style="display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i></div>
                    <div class="pt-user-last">Ajustes, Cierres y Reaperturas</div>
                    <div class="pt-user-name" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_acr/')">Ver</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

</script>