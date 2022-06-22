// View
const View = {
    Form: {
        Login:{
            getVal(){
                var resource = "#login-form";
                var fd = new FormData();
                var required_data = [];
                var onPushData = true;

                var data_email      = $(`${resource}`).find('.data-email').val();
                var data_password   = $(`${resource}`).find('.data-password').val(); 

                if (View.validateEmail(data_email) == null) { 
                    if (data_email == '') { 
                        required_data.push('Email is required.'); onPushData = false 
                    }else{
                        required_data.push('Email is not valid.'); onPushData = false 
                    }
                }
                if (data_password == '') { required_data.push('Password required'); onPushData = false } 
                
                if (onPushData) {
                    fd.append('data_email', data_email); 
                    fd.append('data_password', data_password); 
                    return fd;
                }else{ 
                    var required_noti = ``;
                    for (var i = 0; i < required_data.length; i++) { required_noti += `<div class="notification-item error">${required_data[i]}</div>`; }
                    $(`${resource}`).find('.notification-wrapper').prepend(` <div class="notification-group">${required_noti}</div> `)
                    return false;
                }
            }, 
            onPush(name, callback){
                $(document).on('click', `.action-login`, function() {
                    if($(this).attr('atr').trim() == name) {
                        var data = View.Form.Login.getVal(); 
                        if (data) callback(data);
                    }
                });
            },
        },
        Register: {
            getVal(){
                var resource = "#register-form";
                var fd = new FormData();
                var required_data = [];
                var onPushData = true;

                var data_email      = $(`${resource}`).find('.data-email').val();
                var data_password   = $(`${resource}`).find('.data-password').val();
                var data_name       = $(`${resource}`).find('.data-name').val(); 

                if (View.validateEmail(data_email) == null) { 
                    if (data_email == '') { 
                        required_data.push('Email is required.'); onPushData = false 
                    }else{
                        required_data.push('Email is not valid.'); onPushData = false 
                    }
                }
                if (data_password.split("").length < 8) { required_data.push('password minimum of 8 characters'); onPushData = false }
                if (data_name == "") { required_data.push('Name is required.'); onPushData = false } 
                
                if (onPushData) {
                    fd.append('data_email', data_email);
                    fd.append('data_name', data_name);
                    fd.append('data_password', data_password); 
                    return fd;
                }else{ 
                    var required_noti = ``;
                    for (var i = 0; i < required_data.length; i++) { required_noti += `<div class="notification-item error">${required_data[i]}</div>`; }
                    $(`${resource}`).find('.notification-wrapper').prepend(` <div class="notification-group">${required_noti}</div> `)
                    return false;
                }
            }, 
            onPush(name, callback){
                $(document).on('click', `.action-register`, function() {
                    if($(this).attr('atr').trim() == name) {
                        var data = View.Form.Register.getVal(); 
                        if (data) callback(data);
                    }
                });
            },
        },

    },
    validateEmail(email){
        return email.match( /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ );
    },
};
// Controller
(() => { 
    async function redirect_logined(url, delayValue) {
        await delay(delayValue);
        window.location.replace(url);
    }
    function delay(delayInms) {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve(2);
            }, delayInms);
        });
    }
    View.Form.Register.onPush("Push", (fd) => { 
        IndexView.Notification.remove(`#login-form`); 
        $(".action-register").text(`Registing`)
        Api.Auth.Register(fd)
            .done(res => {
                if (res.status == 201) {
                    $(".login-wrapper").removeClass("is-open")
                    $("#success-form").addClass("is-open") 
                }else{
                    IndexView.Notification.append(`#login-form`, `error`, res.message);  
                }
            })
            .fail(err => { })
            .always(() => { });
    })
    View.Form.Login.onPush("Push", (fd) => { 
        IndexView.Notification.remove(`#login-form`); 
        $(".action-login").text(`On going`)
        Api.Auth.Login(fd)
            .done(res => {
                if (res.status == 200) {
                    $(".action-login").text(`Logined`) 
                    IndexView.Notification.append(`#login-form`, `success`, res.message);  
                    redirect_logined('/', 1000)
                }else{
                    $(".action-login").text(`Login`) 
                    IndexView.Notification.append(`#login-form`, `error`, res.message);  
                }
            })
            .fail(err => { })
            .always(() => { });
    })
})();