export function change_tabs() {
    $('body').on('click', '.__tab__js', function (event) {

       let data_change =  $(this).data('change');
       $('.__tab__js').removeClass('active');
       $(this).addClass('active');
        $('.s_change').removeClass('active');

        $('.s_change').each(function (index) {
            if($(this).hasClass(data_change)) {
                $(this).addClass('active');
            }

        });

    });

}

