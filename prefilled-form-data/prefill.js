jQuery(document).ready(function($){
    // Prefill logged-in user data
    if(pfdAjax.user_data){
        $('input[name="name"]').val(pfdAjax.user_data.name || '');
        $('input[name="email"]').val(pfdAjax.user_data.email || '');
    }

    // Prefill guest user data from localStorage
    $('input[name]').each(function(){
        let name = $(this).attr('name');
        if(localStorage.getItem(name)){
            $(this).val(localStorage.getItem(name));
        }
    });

    // Save data to localStorage on change
    $('input[name]').on('change', function(){
        let name = $(this).attr('name');
        localStorage.setItem(name, $(this).val());
    });
});
