// View
const IndexView = { 
    init(){ 
    }
};
// Controller
(() => {
    IndexView.init();
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
              connectParticles: false 
            } 
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
    $(".open-register-form").on("click", function(){
        $('#login-form').removeClass(`is-open`)
        $('#register-form').addClass(`is-open`)
    })  
    $(".open-login-form").on("click", function(){
        $('#login-form').addClass(`is-open`)
        $('#register-form').removeClass(`is-open`)
    })   
})();