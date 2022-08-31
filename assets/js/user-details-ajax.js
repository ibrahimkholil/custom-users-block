(function ($) {
    'use strict';
    $(document).ready(function () {
     $('.user-bio').click(function (){

         var button = $(this);

         $.ajax({
             method: 'POST',
             url: userDetailsObj.ajax_url,
             beforeSend: function (xhr) {
                 xhr.setRequestHeader('X-WP-Nonce', userDetailsObj.nonce);
                 button.text('Loading...');

             },
             data: {
                 action : 'user_details_callback',
                 security: userDetailsObj.nonce,
                 id : button.data('details')
             },
             success: function (r) {
                 var response = $.parseJSON(r);
                 console.log(r);
                 if(response.Status === true){
                     button.hide();
                     button.parent().append('<p class="user-bio">'+response.data+'</p>');
                 }else{
                     button.hide();
                     button.parent().append('<p class="no-user-bio">'+response.data+'</p>');

                 }
             },
             error: function (r) {
                 console.log($.parseJSON(r));
             },

         });
     })
    })

})(jQuery);
