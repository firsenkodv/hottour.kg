export function canche_contacts() {
    /* нажатие на один из контактов */
    $('body').on('click', '._canche__js', function (event) {



        var Type = $(this).data('type');
        var Ob = $(this).data('object');


        $.ajax({
            url: "/canche.contacts",
            method: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "type": Type,
                "object": Ob,
            },
            success: function (response) {
                /**
                 * ничего не делаем.
                 */
            }
        });

    });
    /* нажатие на один из контактов */


}
