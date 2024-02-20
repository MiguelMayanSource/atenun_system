<?php 
    $doctor_id = $id_;
    $this->db->where('admin_id', $doctor_id);
    $info = $this->db->get('admin')->result_array();    
    foreach($info as $details): 
?>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/doctor_profile/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i><?php if($owner == 1):?> Editar perfil <?php else:?> Ver perfil<?php endif;?></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/notifications/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/doctor_security/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/doctor_activity/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>admin/doctor_calendar/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i> Calendario <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/doctor_appointments/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/doctor_permissions/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos </a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="margin-bottom: 20%;  margin-top: 0px; margin-left: 0px; margin-right: 0px;">
        <div class="row">
            <div class="col-sm-12" style="float: none; margin: 0 auto;">
                <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Agenda en Medicaby - <?php echo $this->accounts_model->get_name('admin',$details['admin_id']);?>.</span>
                </h4>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Registro de agenda diaria.</span>
                    <span class="alert-content">Aquí podrás visualizar todas las actividades que tenga el doctor dentro de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span>.</span>
                </div>
                <br>
                <div class="app-side">
                    <div class="app-side-i">
                        <div style="width: 100%;">
                            <div class="card-widget">
                                <div class="card-body">
                                    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#5bb3f5;" data-title="Pendiente" data-toggle="tooltip" data-original-title="" title=""></div>
                                    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#528410;" data-title="Confirmada" data-toggle="tooltip" data-original-title="" title=""></div>
                                    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#e0345e;" data-title="Cancelada" data-toggle="tooltip" data-original-title="" title=""></div>
                                    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#a66767;" data-title="Reprogramada" data-toggle="tooltip" data-original-title="" title=""></div>
                                    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#0044e9;" data-title="Finalizada" data-toggle="tooltip" data-original-title="" title=""></div>
                                    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#6342ff;" data-title="Eventos" data-toggle="tooltip" data-original-title="" title=""></div>
                                    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#e6b517;" data-title="Pendiente de pago" data-toggle="tooltip" data-original-title="" title=""></div>
                                    <div id="kt_calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $get_appointments = $this->appointment_model->get_aptms_doctor($this->session->userdata('current_clinic'), $doctor_id);?>
<script>
var KTCalendarBasic = function() {
    return {
        init: function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var calendarEl = document.getElementById('kt_calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                themeSystem: 'bootstrap',
                locale: 'es',
                isRTL: KTUtil.isRTL(),
                timeFormat: 'h:mm t',
                header: {
                    left: 'title',
                    center: 'dayGridMonth,timeGridWeek,timeGridDay,list',
                    right: 'prev,next today'
                },
                height: 900,
                contentHeight: '100%',
                displayEventEnd: true,
                displayEventTime: true,
                eventLimitText: "",
                eventLimit: true,
                aspectRatio: 3,
                nowIndicator: true,
                eventTimeFormat: {
                    hour: "numeric",
                    minute: "2-digit",
                    meridiem: "short",
                },
                buttonText: {
                    today: 'Hoy'
                },
                now: TODAY + 'T09:25:00', // just for demo
                views: {
                    month: {
                        eventLimit: 3,
                    },
                    dayGridMonth: {
                        buttonText: 'Mes'
                    },
                    timeGridWeek: {
                        buttonText: 'Semana'
                    },
                    timeGridDay: {
                        buttonText: 'Día'
                    },
                    list: {
                        buttonText: 'Lista'
                    }
                },
                defaultView: window.mobilecheck() ? "list" : "dayGridMonth",
                defaultDate: TODAY,
                editable: false,
                eventLimit: true,
                navLinks: true,
                events: [
                    <?php foreach($get_appointments as $app):?> {
                        id: '<?php echo $app['appointment_id']; ?>',
                        title: '<?php echo $this->appointment_model->getTitle($app['appointment_id'],$app['status']);?>',
                        start: '<?php echo $this->appointment_model->calendar_start_date($app['date'], $app['time']);?>',
                        end: '<?php echo $this->appointment_model->calendar_end_date($app['date'], $app['time']);?>',
                        description: '',
                        className: "<?php echo $this->appointment_model->get_status($app['status']);?>"
                    },
                    <?php endforeach; ?>
                ],
                eventRender: function(info) {
                    var element = $(info.el);

                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                },
                eventClick: function(into, jsEvent, view) {
                    showAjaxModal('<?php echo base_url();?>modal/popup/modal_details/' + into.event.id);
                },

            });
            calendar.render();
        }
    };
}();

jQuery(document).ready(function() {
    KTCalendarBasic.init();
});
window.mobilecheck = function() {
    var check = false;
    (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) ||
            /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
            .test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};
</script>
<script src="<?php echo base_url();?>public/assets/calendar/js/scripts.bundle.js"></script>
<script src="<?php echo base_url();?>public/assets/calendar/js/fullcalendar.bundle.js"></script>

<?php endforeach;?>