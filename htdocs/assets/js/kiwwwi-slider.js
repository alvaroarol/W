/*******************************************************************************
KIWWWI SLIDER
*******************************************************************************/
//Buttons for sliding to next and previous slides must be given the classes .slide-right and .slide-left .
//They should be placed as direct children of the slider container. Their CSS is not defined by Kiwwwi Slider.
//
//Parameters (obligatory)
//sliderEl -> Element that contains the slides.
//            Slides must be <article> elements.
//            The element must have an id.
//duration -> Time between auto-slide in ms, false if no auto-slide

class KiwwwiSlider{

    /***************************************************************************
    CONSTRUCTOR
    ***************************************************************************/
    constructor(sliderEl, duration){
        this.sliderEl = sliderEl;
        this.duration = duration;
        this.currentSlide = 1;
        this.numberOfSlides = document.querySelectorAll('#' + this.sliderEl.id + '>article').length;
        this.slideRightButton = document.querySelectorAll('#' + this.sliderEl.id + '>.slide-right');
        this.slideLeftButton = document.querySelectorAll('#' + sliderEl.id + '>.slide-left');
        this.setCSS();
        this.rightButton();
        this.leftButton();
        this.swipe();
        if(this.duration != false){
            var self = this;
            this.timer = setInterval(function(){
                self.slideRight();
            }, this.duration);
        }
    }

    /***************************************************************************
    METHODS
    ***************************************************************************/
    //CSS
    setCSS(){
        Object.assign(this.sliderEl.style, {
            'position': 'relative',
            'overflow-x': 'hidden'
        });
        for(var i = 0; i < this.numberOfSlides; i ++){
            Object.assign(document.querySelectorAll('#' + this.sliderEl.id + '>article')[i].style, {
                'position': 'absolute',
                'top': '0',
                'left': (i * 100) + '%',
                'width': '100%',
                'height': '100%',
                'transition': 'left 0.75s'
            });
        }
    }

    //Slide left
    slideLeft(){
        if(this.currentSlide == 1){
            for(var i = 0; i < this.numberOfSlides; i ++){
                document.querySelectorAll('#' + this.sliderEl.id + '>article')[i].style.left = ((i * 100) - ((this.numberOfSlides - 1) * 100)) + '%';
            }
            this.currentSlide = this.numberOfSlides;
        }
        else{
            for(var i = 0; i < this.numberOfSlides; i ++){
                document.querySelectorAll('#' + this.sliderEl.id + '>article')[i].style.left = ((i * 100) - ((this.currentSlide - 2) * 100)) + '%';
            }
            this.currentSlide --;
        }
        // this.hideShowButtons();
    }

    //Slide right
    slideRight(){
        if(this.currentSlide == this.numberOfSlides){
            for(var i = 0; i < this.numberOfSlides; i ++){
                document.querySelectorAll('#' + this.sliderEl.id + '>article')[i].style.left = ((i * 100)) + '%';
            }
            this.currentSlide = 1;
        }
        else{
            for(var i = 0; i < this.numberOfSlides; i ++){
                document.querySelectorAll('#' + this.sliderEl.id + '>article')[i].style.left = ((i * 100) - (this.currentSlide * 100)) + '%';
            }
            this.currentSlide ++;
        }
        // this.hideShowButtons();
    }

    //Hide/show Buttons
    hideShowButtons(){
        if(this.slideRightButton[0] != null && this.currentSlide == this.numberOfSlides){
            this.slideRightButton[0].style.display = 'none';
        }
        else if(this.slideRightButton[0] != null && this.currentSlide != this.numberOfSlides){
            this.slideRightButton[0].style.display = 'inline';
        }
        if(this.slideLeftButton[0] != null && this.currentSlide == 1){
            this.slideLeftButton[0].style.display = 'none';
        }
        else if(this.slideLeftButton[0] != null && this.currentSlide != 1){
            this.slideLeftButton[0].style.display = 'inline';
        }
    }

    //Swipe
    swipe(){

        this.touchStart = 0;
        this.touchEnd = 0;

        var self = this;

        this.sliderEl.addEventListener('touchstart', function(e){
            self.touchStart = e.changedTouches[0].clientX;
        });

        this.sliderEl.addEventListener('touchend', function(e){
            self.touchEnd = e.changedTouches[0].clientX;
            if(self.touchStart + 50 < self.touchEnd){
                if(self.duration != false){
                    clearInterval(self.timer);
                    self.timer = setInterval(function(){
                        self.slideRight();
                    }, self.duration);
                }
                self.slideLeft();
            }
            else if(self.touchStart - 50 > self.touchEnd){
                if(self.duration != false){
                    clearInterval(self.timer);
                    self.timer = setInterval(function(){
                        self.slideRight();
                    }, self.duration);
                }
                self.slideRight();
            }
        });

    }

    //Slide right button
    rightButton(){
        if(this.slideRightButton[0] != null){
            var self = this;
            this.slideRightButton[0].addEventListener('click', function(){
                if(self.duration != false){
                    clearInterval(self.timer);
                    self.timer = setInterval(function(){
                        self.slideRight();
                    }, self.duration);
                }
                self.slideRight();
            });
        }
    }

    //Slide left button
    leftButton(){
        if(this.slideLeftButton[0] != null){
            var self = this;
            this.slideLeftButton[0].addEventListener('click', function(){
                if(self.duration != false){
                    clearInterval(self.timer);
                    self.timer = setInterval(function(){
                        self.slideRight();
                    }, self.duration);
                }
                self.slideLeft();
            });
        }
    }

}
