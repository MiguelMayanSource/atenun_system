(function($) {
    'use strict';
    $(document).ready(function() {
        //alert(moment().startOf('week').add(1, 'days').add(6, 'hours').format());
        var selectedEvent;
        $('#myCalendar').pagescalendar({
            events: [{
                title: 'Primera Cita',
                class: 'bg-pasada',
                start: "2020-01-26T02:00:00-06:00",
                end:   "2020-01-26T02:30:00-06:00",
            }, {
                title: 'Meeting Roundup',
                class: 'bg-nueva',
                start: "2020-01-21T02:00:00-06:00",
                end:   "2020-01-21T03:30:00-06:00",
            }, { 
                title: 'Cita para el 23',
                class: 'bg-pasada',
                start: "2020-01-23T05:30:00-06:00",
                end:   "2020-01-23T06:00:00-06:00",
            },{
                title: 'Carlos Escobar',
                class: 'bg-nueva',
                start: "2020-01-24T02:30:00-06:00",
                end:   "2020-01-24T03:00:00-06:00",
            }, {
                title: 'Cita para el 20 a las 3',
                class: 'bg-pasada',
                start: "2020-01-20T03:00:00-06:00",
                end:   "2020-01-20T03:30:00-06:00",
            }, {
                title: 'Cita para el 20 a las 3:30',
                class: 'bg-pasada',
                start: "2020-01-20T03:30:00-06:00",
                end:   "2020-01-20T04:00:00-06:00",
            },{
                title: 'Carlos Escobar',
                class: 'bg-pasada',
                start: "2020-01-22T03:30:00-06:00",
                end:   "2020-01-22T04:00:00-06:00",
            }, {
                title: 'Drageame xD',
                class: 'bg-nueva',
                start: "2020-01-25T04:00:00-06:00",
                end:   "2020-01-25T04:30:00-06:00",
            }, {
                title: 'Cita para el 20 a las 4',
                class: 'bg-nueva',
                start: "2020-01-20T04:00:00-06:00",
                end:   "2020-01-20T04:30:00-06:00",
            }, {
                title: 'Cita cancelada',
                class: 'bg-cancelada',
                start: moment().startOf('week').add(2, 'days').add(5, 'hours').format(),
                end: moment().startOf('week').add(2, 'days').add(6, 'hours').format(),
            }, ],
            view: "week",
            onViewRenderComplete: function() {},
        });
    });
})(window.jQuery);