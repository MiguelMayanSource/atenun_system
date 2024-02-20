<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "nomenclature") echo "current";?>" href="<?php echo base_url();?>admin/nomenclature/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Nomenclatura</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "departures" || $page_name == "departure" || $page_name == "departure_edit" || $page_name == "departure_detail" || $page_name == "policy_departure") echo "current";?>" href="<?php echo base_url();?>admin/departures/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Partidas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "journal") echo "current";?>" href="<?php echo base_url();?>admin/journal/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Libro diario</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "ledger") echo "current";?>" href="<?php echo base_url();?>admin/ledger/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Mayor</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "balances") echo "current";?>" href="<?php echo base_url();?>admin/balances/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Balance de saldos</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "statement") echo "current";?>" href="<?php echo base_url();?>admin/statement/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Estado de Resultados</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "general") echo "current";?>" href="<?php echo base_url();?>admin/general/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Balance General</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "sales_book") echo "current";?>" href="<?php echo base_url();?>admin/sales_book/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Libro de ventas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "purchasing") echo "current";?>" href="<?php echo base_url();?>admin/purchasing/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Libro de compras</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "bank_book") echo "current";?>" href="<?php echo base_url();?>admin/bank_book/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Libro de bancos</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "bank_conciliations" || $page_name == "bank_conciliation" || $page_name == "bank_conciliation_detail") echo "current";?>" href="<?php echo base_url();?>admin/bank_conciliations/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Conciliación Bancaria</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "cash_flows" || $page_name == "cash_flow" || $page_name == "cash_flow_detail") echo "current";?>" href="<?php echo base_url();?>admin/cash_flows/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Flujo de efectivo</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "clients_book") echo "current";?>" href="<?php echo base_url();?>admin/clients_book/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Cuentas por cobrar</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "adjust" || $page_name == "adjust_departure" || $page_name == "adjust_detail") echo "current";?>" href="<?php echo base_url();?>admin/adjust/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Ajustes</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "closing" || $page_name == "closing_departure" || $page_name == "closing_detail") echo "current";?>" href="<?php echo base_url();?>admin/closing/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Cierres</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php if($page_name == "opening" || $page_name == "opening_departure" || $page_name == "opening_detail") echo "current";?>" href="<?php echo base_url();?>admin/opening/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Reaperturas</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>