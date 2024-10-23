$(function(){
    $(window).resize(function(){
        if($(window).innerWidth() <= 900){
            $("header nav .down").hide() 
        }else{
            $("header nav").show()
            $("header nav .down").show()
        }
    
    });
    $(".nav-icon, header nav").on("click", function(){
        if($(window).innerWidth() <= 900){
            $("header nav .down").hide()
            $("header nav").toggle(500)
        }else{
            $("header nav .down").show() 
        }
    })

    $("img").on("error", function(){
        $(this).attr("src","/_assets/images/articles/default-article-image.png")
    })
    
   

})
