export function export_user() {

    var Func = false;
    /* все пользователи */
    $('body').on('click','.e_alluser__js', function(event){
         Func = 'allUsers';
         ajaxReq(Func);
    });
    /* только пользователи */
    $('body').on('click','.e_user__js', function(event){
         Func = 'Users';
         ajaxReq(Func);
    });
    /* только менеджеры */
    $('body').on('click','.e_manager__js', function(event){
         Func = 'Managers';
         ajaxReq(Func);
    });
    /* только РОП */
        $('body').on('click','.e_rop__js', function(event){
             Func = 'Rops';
             ajaxReq(Func);
    });
    /* только админ */
        $('body').on('click','.e_admin__js', function(event){
             Func = 'Admins';
             ajaxReq(Func);
    });


}


function ajaxReq(Func) {
    $.ajax({
        url: "/export.excel.user",
        method: "POST",

        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "func": Func,

        },
        success: function (response) {

            console.log(response.func);
            if(response.error) {
                alert(response.error)
            } else

                   {
                            var link = document.createElement('a');
                            link.setAttribute('href', '/storage/user_export/'+   Func +  moment().format('DD.MM.YYYY')  +'.xlsx');
                            link.setAttribute('download', Func + moment().format('DD.MM.YYYY') + '.xlsx');
                            link.click();

                            console.log('/storage/user_export/'+   Func +  moment().format('DD.MM.YYYY')  +'.xlsx');

                        }
        }
    });
}
