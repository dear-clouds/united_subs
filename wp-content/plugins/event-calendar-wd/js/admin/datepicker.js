(function ($) {

    $('#ecwd_event_repeat_until_input, #ecwd_date_from_filter, #ecwd_date_to_filter').datetimepicker({
        scrollMonth: false,
        scrollInput: false,
        timepicker:false,
        closeOnDateSelect:true,
        format:'Y/m/d'
    });

    hide_show_time();
    $('.ecwd_all_day_event').click(function() {
        hide_show_time();
    });

    function hide_show_time(){
        var dateFromGlobal, dateToGlobal;
        dateFromGlobal = $("#ecwd_event_date_from").val(),
            dateToGlobal = $("#ecwd_event_date_to").val();
        if ($('#ecwd_all_day_event').prop('checked') === true) {
            $("#ecwd_event_date_from, #ecwd_event_date_to").datetimepicker({
                timepicker:false,
                format:'Y/m/d',
                scrollInput: false,
                closeOnDateSelect:true
            });
            if(dateFromGlobal) {
                $("#ecwd_event_date_from").attr('value', dateFromGlobal.split(' ')[0]);

            }
            if(dateToGlobal) {
                $("#ecwd_event_date_to").attr('value', dateToGlobal.split(' ')[0]);
            }
        } else {
            $('#ecwd_event_date_from, #ecwd_event_date_to').datetimepicker({
                timepicker:true,
                format:'Y/m/d H:i',
                scrollInput: false,
                closeOnDateSelect:false
            });
            if(dateFromGlobal) {
                $("#ecwd_event_date_from").attr('value', dateFromGlobal);
            }
            if(dateToGlobal) {
                $("#ecwd_event_date_to").attr('value', dateToGlobal);
            }
        }

    }

}(jQuery));