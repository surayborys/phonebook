
(function($, undefined){
//$ == jQuery
    $(function(){
        $('#filter-id').click(function(){ 
                var name = document.querySelector('#f_name');
                var phone = document.querySelector('#f_phone');
                var date = document.querySelector('#f_date');
                var group = document.querySelector('#f_group');
                
                var error = document.querySelector('#filter-error-id');
                   error.innerHTML = "";
                   
                if(!name.value && !phone.value && !date.value && !group.value) {
                    error.innerHTML = "Fill at least one field";
                } else {
                    console.log(
                           'name: ' + name.value +
                           'phone: ' + phone.value +
                           'date: ' + date.value +
                           'group: ' + group.value
                        );
                    window.location = "/abonent/filter/?name=" + name.value +
                            "&phone=" + phone.value + 
                            "&date=" + date.value +
                            "&group=" + group.value;
                }
            });
        });
})(jQuery);




