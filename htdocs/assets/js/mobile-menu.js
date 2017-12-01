document.querySelectorAll('.mobile-bar .fa-bars')[0].addEventListener('click', function(){
    document.querySelectorAll('.mobile-nav')[0].style.width = '100%';
});
document.querySelectorAll('.mobile-nav .fa-times')[0].addEventListener('click', function(){
    document.querySelectorAll('.mobile-nav')[0].style.width = '0';
});

touchStartX = 0;
touchEndX = 0;
touchStartY = 0;
touchEndY = 0;
document.querySelectorAll('.mobile-nav')[0].addEventListener('touchstart', function(e){
    touchStartX = e.changedTouches[0].clientX;
    touchStartY = e.changedTouches[0].clientY;
});
document.querySelectorAll('.mobile-nav')[0].addEventListener('touchend', function(e){
    touchEndX = e.changedTouches[0].clientX;
    touchEndY = e.changedTouches[0].clientY;
    if(touchStartX + 50 < touchEndX && touchStartY + 300 > touchEndY && touchStartY - 300 < touchEndY){
        document.querySelectorAll('.mobile-nav')[0].style.width = '0';
    }
});
