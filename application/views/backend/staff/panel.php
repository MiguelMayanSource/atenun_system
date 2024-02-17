<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="hello">¡Hola <?php echo $this->accounts_model->get_name('admin', $this->session->userdata('login_user_id'));?>!</h4>
                        <div class="panel-cta-w cta-with-media purple">
                            <div class="cta-content">
                                <p class="cta-header">Bienvenido al tablero principal, acá podras controlar lo que realizan los doctores y tu equipo de trabajo, ver informes y llevar el control de los pacientes.</p>
                                <div class="cta-media">
                                    <img alt="" style="width:120px; height:150px;" src="https://medicaby.com/resources/app-icons/dr.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Cirugias de los ultimos 15 dias</h4>
                        <span class="app-divider2"></span>
                        <canvas id="myChart" height="180" style="width:100%"></canvas>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="" style="padding: 20px;border-radius: 15px;">
                        <h4 class="panel-content-title">Usuarios</h4>
                        <span class="app-divider2"></span>
                        <div style="padding-top:15px">
                            <div class="row">
                            </div>
                        </div>
                        <div style="padding-top:15px">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="profile-tile profile-tile-inlined">
                                        <div class="profile-tile-box">
                                            <div class="pt-avatar-w"><img style="width:200px; height:180px;" alt="" src="<?php echo base_url();?>public/uploads/doctors.svg"></div>
                                            <div class="pt-user-last" style="font-size:30px">Doctores</div>
                                            <span class="badge badge-warning" style="font-size:30px"><?php echo $this->db->get_where('admin',array('status !='=>0,'owner'=>1))->num_rows();?></span>
                                            <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>staff/doctors';">ir</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="profile-tile profile-tile-inlined">
                                        <div class="profile-tile-box">
                                            <div class="pt-avatar-w"><img style="width:200px; height:180px;" alt="" src="<?php echo base_url();?>public/uploads/personal.svg"></div>
                                            <div class="pt-user-last" style="font-size:30px">Equipo</div>
                                            <span class="badge badge-warning" style="font-size:30px"><?php echo $this->db->get_where('staff',array('status !='=>0))->num_rows();?></span>
                                            <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>staff/staff';">ir</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="profile-tile profile-tile-inlined">
                                        <div class="profile-tile-box">
                                            <div class="pt-avatar-w"><img style="width:200px; height:180px;" alt="" src="<?php echo base_url();?>public/uploads/Paciente.svg"></div>
                                            <div class="pt-user-last" style="font-size:30px">Pacientes</div>
                                            <span class="badge badge-warning" style="font-size:30px"><?php echo $this->db->get_where('patient',array('status !='=>0))->num_rows();?></span>
                                            <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>staff/patients';">ir</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://rawgit.com/nnnick/Chart.js/v1.0.2/Chart.min.js"></script>
        <script>
        Chart.types.Bar.extend({
            name: "BarAlt",
            initialize: function(data) {
                Chart.types.Bar.prototype.initialize.apply(this, arguments);
                if (this.options.curvature !== undefined && this.options.curvature <= 1) {
                    var rectangleDraw = this.datasets[0].bars[0].draw;
                    var self = this;
                    var radius = this.datasets[0].bars[0].width * this.options.curvature * 0.5;
                    this.datasets.forEach(function(dataset) {
                        dataset.bars.forEach(function(bar) {
                            bar.draw = function() {
                                var y = bar.y;
                                bar.y = Math.min(bar.y + radius, self.scale.endPoint - 1);
                                var barRadius = (bar.y - y);
                                rectangleDraw.apply(bar, arguments);
                                Chart.helpers.drawRoundedRectangle(self.chart.ctx, bar.x - bar.width / 2, bar.y - barRadius + 1, bar.width, bar.height, barRadius);
                                ctx.fill();
                                bar.y = y;
                            }
                        })
                    })
                }
            }
        });
        var lineChartData = {
            labels: [<?php $week = $this->crud_model->date_week(date('Y-m-d'));
                foreach($week as $w)
                {

                    echo substr($w, -2).',';

                }
        ?>],
            datasets: [{
                fillColor: "<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>",
                strokeColor: "<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>",
                data: [<?php $week = $this->crud_model->date_week(date('Y-m-d'));
                                foreach($week as $w)
                                {

                                    echo $this->crud_model->fill_week_sop($w).',';

                                }
                        ?>]
            }]
        };
        var ctx = document.getElementById("myChart").getContext("2d");
        var myLine = new Chart(ctx).BarAlt(lineChartData, {
            curvature: 1
        });
        </script>