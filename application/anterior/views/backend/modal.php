    <script type="text/javascript">
    function showAjaxModal(url)
    {
        jQuery('#exampleModal .modal-dialog').html('<center><img style="background-color:#fff;border-radius:50%; width:85px;margin-left: 350px;" src="<?php echo base_url();?>public/uploads/loader.gif" /></center>');
        jQuery('#exampleModal').modal('show', {backdrop: 'true'});
        $.ajax({
            url: url,
            success: function(response)
            {
                jQuery('#exampleModal .modal-dialog').html(response);
            }
        });
    }
    function modal_lg(url)
    {
        jQuery('#modal_lg .modal-dialog').html('<center><img style="background-color:#fff;border-radius:50%; width:85px;margin-left: 350px;" src="<?php echo base_url();?>public/uploads/loader.gif" /></center>');
        jQuery('#modal_lg').modal('show', {backdrop: 'false'});
        $.ajax({
            url: url,
            success: function(response)
            {
                
                jQuery('#modal_lg .modal-dialog').html(response);
            }
        });
    }
    
    
    function modal_xl(url)
    {
        jQuery('#modal_xl .modal-dialog').html('<center><img style="background-color:#fff;border-radius:50%; width:100px;margin-left: 350px;" src="<?php echo base_url();?>public/uploads/loader.gif" /></center>');
        jQuery('#modal_xl').modal('show', {backdrop: 'true'});
        $.ajax({
            url: url,
            success: function(response)
            {
                
                jQuery('#modal_xl .modal-dialog').html(response);
            }
        });
    }
    </script>
    
    <div aria-hidden="true" class="modal fade bd-example-modal-lg " role="dialog" tabindex="-1" id="exampleModal">
        <div class="modal-dialog modal-dialog-centered">
            
        </div>
    </div>

    <div aria-hidden="true" class="modal fade bd-example-modal-lg " role="dialog" tabindex="-1" id="modal_lg">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            
        </div>
    </div>
    
    
    <div aria-hidden="true" class="modal fade bd-example-modal-xl " role="dialog" tabindex="-1" id="modal_xl">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            
        </div>
    </div>