$(function() {
    $("#start_date").datepicker({
        dateFormat: 'dd-mm-yy',
        onSelect: function(selectedDate) {
            $("#end_date").datepicker("option", "minDate", selectedDate);
        }
    });
    
    $("#end_date").datepicker({
        dateFormat: 'dd-mm-yy',
        onSelect: function(selectedDate) {
            $("#start_date").datepicker("option", "maxDate", selectedDate);
        }
    });
});
