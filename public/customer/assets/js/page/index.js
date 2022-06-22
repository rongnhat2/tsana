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
    
    window.onload = function () {
        Particles.init({
            selector: ".background" 
        }); 
        removePreview();
    };
    const particles = Particles.init({
        selector: ".background",
        color: ["#81e276", "#ffffff"],
        connectParticles: true,
        responsive: [{
            breakpoint: 768,
            options: {
                color: ["#ffffff", "#81e276"],
                maxParticles: 43,
                connectParticles: false 
            } 
        }] 
    });
    function delay(delayInms) {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve(2);
            }, delayInms);
        });
    }
    async function removePreview(){ 
        $(".I-preview").addClass("on-show");
        await delay(1500);
        $("html").removeClass("preview-loader"); 
        $(".I-preview").removeClass("on-show");
    }
    

    // Canvas
    let FULL_SCREEN     = 1920;
    let IPAD_SCREEN     = 1000;
    let MOBILE_SCREEN   = 600;
    let screen_width    = $(window).width();
    let screen_height   = $(window).height();
    let image_width     = 0;
    let image_height    = 0;
    let calc_xy_image   = 0;
    const image = new Image();   
    image.src = 'assets/images/banner-top-2.png';
    image.onload = function() { 
        image_width = this.width;
        image_height = this.height;  
        calc_xy_image = image_width / image_height; 

        if (screen_width < MOBILE_SCREEN) {
            let screen_vh = 0.6;
            let [delta_width_canvas, delta_height_canvas, translate_X] = calculate_responsive(screen_vh)
            $(".I-banner").css({ "height": `${delta_height_canvas}px` });
            $("#canvas1").attr("width", screen_width);
            $("#canvas1").attr("height", delta_height_canvas);
            renderCanvas(this, translate_X, delta_width_canvas, delta_height_canvas);
        }else if(screen_width < IPAD_SCREEN){ 
            let screen_vh = 0.9;
            let [delta_width_canvas, delta_height_canvas, translate_X] = calculate_responsive(screen_vh)
            $(".I-banner").css({ "height": `${delta_height_canvas}px` });
            $("#canvas1").attr("width", screen_width);
            $("#canvas1").attr("height", delta_height_canvas); 
            renderCanvas(this, translate_X, delta_width_canvas, delta_height_canvas);
        }else if(screen_width < FULL_SCREEN){
            let screen_vh = 1;
            let [delta_width_canvas, delta_height_canvas, translate_X] = calculate_responsive_lg(screen_vh)
            console.log([delta_width_canvas, delta_height_canvas, translate_X]);
            $(".I-banner").css({ "height": `${delta_height_canvas}px` });
            $("#canvas1").attr("width", screen_width);
            $("#canvas1").attr("height", delta_height_canvas);
            renderCanvas(this, translate_X, delta_width_canvas, delta_height_canvas);
        }else{
            let screen_vh = 1;
            let translate_X = 0;
            $(".I-banner").css({ "height": `${image_height}px` });  
            $("#canvas1").attr("width", image_width);
            $("#canvas1").attr("height", image_height); 
            renderCanvas(this, translate_X, image_width, image_height); 
        } 
    };  
    function calculate_responsive_lg(screen_vh){
        let calc_y_screen_canvas = image_width / screen_width;
        let delta_height_canvas = image_height / calc_y_screen_canvas;
        let translate_X = 0; 
        return [screen_width, delta_height_canvas, translate_X];
    }
    function calculate_responsive(screen_vh){
        let calc_y_screen_image = image_height / screen_height / screen_vh; 
        let delta_width_canvas = image_width / calc_y_screen_image;
        let delta_height_canvas = image_height / calc_y_screen_image;
        let translate_X = (delta_width_canvas - screen_width) / 2; 
        return [delta_width_canvas, delta_height_canvas, translate_X];
    }
    function renderCanvas(image, translate_X, image_width, image_height){
        const canvas = document.getElementById('canvas1');
        const ctx = canvas.getContext('2d'); 
        ctx.fillRect(0, 0, image_width, image_height); 
        ctx.filter = "grayscale(1) brightness(1.05) contrast(1.15)";   
        ctx.drawImage(image, -translate_X, 0, image_width, image_height); 
        var pos = { x: 0, y: 0 }; 
        var yMousePos = 0;
        var lastScrolledTop = 0; 
        document.addEventListener('mousemove', draw);  
        document.addEventListener('mousedown', setPosition);   
        $(window).scroll(function(event) { 
            if(lastScrolledTop != $(document).scrollTop()){
                yMousePos -= lastScrolledTop;
                lastScrolledTop = $(document).scrollTop();
                yMousePos += lastScrolledTop;
            } 
        }); 
        $(document).mouseup(async function(e) {
            var container = $("#canvas1");
            if (container.is(e.target)) {
                await delay(1500);
                ctx.fillRect(0, 0, image_width, image_height);
            }
        });
        function setPosition(e) {
          pos.x = e.clientX;
          pos.y = e.clientY + yMousePos;
        } 
        function draw(e) { 
          if (e.buttons !== 1) return;
          ctx.globalCompositeOperation = 'destination-out';
          ctx.beginPath(); // begin 
          ctx.lineWidth = 150;
          ctx.lineCap = 'round';
          ctx.strokeStyle = '#c0392b'; 
          ctx.moveTo(pos.x, pos.y); // from
          setPosition(e);
          ctx.lineTo(pos.x, pos.y); // to 
          ctx.stroke(); // draw it!
        }
    }

})();