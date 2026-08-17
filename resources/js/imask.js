//todo:jquery
$(document).ready(function () {
    const phone = document.querySelectorAll('input[name="phone"]');
    const maskOptions = {
        mask: '+{0}(000)000-00-00',
      //  lazy: false
    };
    for (var i = 0; i < phone.length; i++){
        const mask = new IMask(phone[i], maskOptions);
    }
})
