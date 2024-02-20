      <?php
        $this->db->where('financial_id', $param2);
        $incomes = $this->db->get('financial')->result_array();
        foreach($incomes as $row):
    ?>
      <div class="modal-content animated fadeInDown">
          <div class="modal-header" style="background-color:#fff;">
              <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
                  <span style="vertical-align:-3px">Actualizar ingreso</span>
              </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form action="<?php echo base_url();?>staff/financial/update/<?php echo $row['financial_id'];?>" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  <div class="form-group">
                      <div class="container">
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="form-group m-b-15">
                                      <label for="simpleinput">Descripción</label>
                                      <input type="text" name="description" value="<?php echo $row['description'];?>" class="form-control">
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group m-b-15">
                                      <label for="simpleinput">Método de Pago</label>
                                      <select class="itemName form-control" style="width:100%" name="method">
                                          <option value="">Seleccionar</option>
                                          <option value="1" <?php if($row['method'] == 1) echo "selected";?>>Efectivo</option>
                                          <option value="2" <?php if($row['method'] == 2) echo "selected";?>>Tarjeta</option>
                                          <option value="3" <?php if($row['method'] == 3) echo "selected";?>>Cheque</option>
                                          <option value="4" <?php if($row['method'] == 4) echo "selected";?>>Depósito</option>
                                          <option value="5" <?php if($row['method'] == 5) echo "selected";?>>Transferencia</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group m-b-15">
                                      <label for="simpleinput">Monto</label>
                                      <input type="number" name="amount" value="<?php echo $row['amount']?>" required="" class="form-control">
                                  </div>
                              </div>
                              <div class="col-sm-12">
                                  <label>Tipo de transacción:</label>
                                  <div class="form-group text-center">
                                      <div class="custom-control custom-radio" style="display:inline">
                                          <input type="radio" class="custom-control-input" id="customRadio3" name="type" value="1" <?php echo $row['type']== 1 ? 'checked':''; ?>>
                                          <label class="custom-control-label" for="customRadio3">Ingreso</label>
                                      </div>
                                      <div class="custom-control custom-radio" style="display:inline">
                                          <input type="radio" class="custom-control-input" id="customRadio4" name="type" value="0" <?php echo $row['type']== 0 ? 'checked':''; ?>>
                                          <label class="custom-control-label" for="customRadio4">Egreso</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group m-b-15">
                                      <label for="simpleinput">No. de referencia</label>
                                      <div class="form-group">
                                          <input type="text" name="reference" value="<?php echo $row['reference']?>" class="form-control">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group m-b-15">
                                      <label for="simpleinput" value="<?php echo $row['reference_file'] ?>">Subir comprobante</label>
                                      <input type="file" name="reference_file" class="form-control" accept="image/*">
                                  </div>
                              </div>
                              <div class="col-sm-12">
                                  <div class="form-group m-b-15">
                                      <div class="form-group">
                                          <div class="custom-control custom-checkbox mr-sm-2">
                                              <input type="checkbox" id="invoice2" name="invoice2" value="1" <?php if($row['invoice'] == 1) echo "checked";?> class="custom-control-input check">
                                              <label class="custom-control-label" for="invoice2">Factura</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-6" id="fact1">
                                  <div class="form-group m-b-15">
                                      <label for="simpleinput">No. factura</label></label>
                                      <div class="form-group">
                                          <input type="text" name="invoice_code" id="invoice_code" value="<?php echo $row['invoice_code'] ?>" class="form-control">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-6" id="fact21">
                                  <div class="form-group m-b-15">
                                      <label for="simpleinput">Subir factura</label>
                                      <input type="file" name="invoice_file" id="invoice_file" class="form-control" accept="image/*" value="<?php echo $row['invoice_file'] ?>">
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
      <script>
<?php if($this->db->get_where('financial', array('financial_id' => $row['financial_id']))->row()->invoice != 1):?>
$('#fact1').hide();
$('#fact21').hide();
<?php endif;?>
      </script>
      <?php endforeach;?>



      <script>
$(document).ready(function() {
    $('input[name="reference_file"]').fileuploader({
        theme: 'default',
    });
    $('input[name="invoice_file"]').fileuploader({
        theme: 'default',
    });
});
      </script>

      <script type="text/javascript">
$(function() {
    $('[name="invoice2"]').change(function() {
        if ($(this).is(':checked')) {
            $('#fact1').show(500);
            $('#fact21').show(500);
            $("#invoice_file").attr("required", true);
            $("#invoice_code").attr("required", true);
        } else {
            $('#fact1').hide(500);
            $('#fact21').hide(500);
            $("#invoice_file").attr("required", false);
            $("#invoice_code").attr("required", false);

        };
    });
});
      </script>