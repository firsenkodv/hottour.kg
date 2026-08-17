//todo:jquery
$(document).ready(function () {

    $('input[type="checkbox"].check_all').on('change', function() {

        if($(this).attr('data-chance') == 1) {
            $('.checkbox_change').prop('checked', false);
            $(this).attr('data-chance', 0);

        } else {
            $('.checkbox_change').prop('checked', true);
            $(this).attr('data-chance', 1);
        }

    });

});
