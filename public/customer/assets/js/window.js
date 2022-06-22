// View
const IndexView = { 
    Notification: {
        append(resource, status, message){
            $(resource)
                        .find('.notification-wrapper')
                        .append(` <div class="notification-group">
                                    <div class="notification-item ${status}">${message}</div>
                                </div> `)
        },
        remove(resource){
            $(resource).find('.notification-wrapper .notification-group').remove();
        }
    },
    Form: {
        Logout: { 
            onPush(name, callback){
                $(document).on('click', `.action-logout`, function() {
                    if($(this).attr('atr').trim() == name) { 
                        callback();
                    }
                });
            },
        }
    },
    init(){ 
    }
};
// Controller
(() => {
    IndexView.init();
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
    window.onload = function () {
      Particles.init({
        selector: ".background" });

    };
    const particles = Particles.init({
      selector: ".background",
      color: ["#81e276", "#ffffff"],
      connectParticles: true,
      responsive: [
      {
        breakpoint: 768,
        options: {
          color: ["#ffffff", "#81e276"],
          maxParticles: 43,
          connectParticles: false } 
      }] 
  });

    $(document).on('click', '[modal-control]', function() {
        var name = $(this).attr('modal-control')
        $(`.I-modal[modal-block=${name}]`).addClass('active');
        $("html").addClass("o-hidden")
    });
    $(document).mouseup(function(e) {
        var container = $(".modal-dialog");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.I-modal').removeClass('active');
            $("html").removeClass("o-hidden")
        }
    });
    $(document).on('click', '[modal-close]', function() {
        var name = $(this).attr('modal-close')
        $(`.I-modal[modal-block=${name}]`).removeClass('active');
        $("html").removeClass("o-hidden")
    });

    $(document).on('click', '[modal-full-control]', function() {
        var name = $(this).attr('modal-full-control')
        $(`.I-full-modal[modal-full-block=${name}]`).addClass('active');
        $("html").addClass("o-hidden")
    });
    $(document).mouseup(function(e) {
        var container = $(".modal-dialog");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.I-full-modal').removeClass('active');
            $("html").removeClass("o-hidden")
        }
    });
    $(document).on('click', '[modal-full-close]', function() {
        var name = $(this).attr('modal-full-close')
        $(`.I-full-modal[modal-full-block=${name}]`).removeClass('active');
        $("html").removeClass("o-hidden")
    });


    $(document).on('click', '.customer-auth', function() { 
        $(this).addClass('is-open'); 
    });
    $(document).mouseup(function(e) {
        var container = $(".customer-auth");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.customer-auth').removeClass('is-open'); 
        }
    });

    IndexView.Form.Logout.onPush("Logout", (fd) => {  
        Api.Auth.Logout()
            .done(res => {
                if (res.status == 200) redirect_logined('/', 100)
            })
            .fail(err => { })
            .always(() => { });
    })


    $(".open-register-form").on("click", function(){
        $('#login-form').removeClass(`is-open`)
        $('#register-form').addClass(`is-open`)
    })  
    $(".open-login-form").on("click", function(){
        $('#login-form').addClass(`is-open`)
        $('#register-form').removeClass(`is-open`)
    })   
})();