$(document).ready(function(){
    $(".nav.navbar-nav a").click(function(){
        $(".nav.navbar-nav").find("li.active").removeClass("active");
        $(this).addClass("active");
    });
});