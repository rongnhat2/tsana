// View
const View = {

};
// Controller
(() => { 

    var stickyNav = $('body').offset().top;
    window.onscroll = function() {
        window.pageYOffset > stickyNav ? $('header').addClass('is-scroll') : $('header').removeClass('is-scroll');
    }; 

    $(document).on('click', '.navigation-control', function() {
        $(".nav-wrapper").toggleClass("is-open")
    });
     

})();