const Api = {
    Auth: {}, 
};
(() => {
    $.ajaxSetup({
        headers: { 
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
        },
        crossDomain: true
    });
})();


//Auth
(() => {
    Api.Auth.Register = (data) => $.ajax({
        url: `/customer/api/auth/register`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    });
})();
 