
(function($, undefined){
//$ == jQuery
    $(function(){
        $('#search-id').click(function(){ 
                var keyword = document.querySelector('#keyword');
                var error = document.querySelector('#error-id');
                   error.innerHTML = "";
                if(!keyword.value) {
                    error.innerHTML = "Can't be blank";
                } else if(keyword.value.length < 3) {
                    error.innerHTML = "Can't be shorter than 3 characters";
                } else {
                    //replace spaces, (), + and - with ''
                    var arg = keyword.value.replace(/\s/g,'');
                    arg = arg.replace(/\+/g,'');
                    arg = arg.replace(/\-/g,'');
                    arg = arg.replace(/\(/g,'');
                    arg = arg.replace(/\)/g,'');
                    window.location = "http://phnbookfront.com/abonent/search/" + arg;
                }
            });
        });
})(jQuery);




