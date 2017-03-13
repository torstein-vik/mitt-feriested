function init(){

    $(".tagselector").click(function(){
        $(".tagselector.active").removeClass("active");
        $(this).addClass("active");

        updateContent();
        removeImages();
    });

}

$('.tagselector[tagid=1]').css({"clip-path": "polygon(10% 5%, 100% 0, 95% 100%, 0 95%)"});

function removeImages(){
    //$(".tagselector img").animate({height: 0, width: 0}, 500)
}

function updateContent(){
    var flags = getCurrentFlags();

    $.ajax({
        url:("api?type=attractions&redir=" + $("#redir").html() + "&flags="+flags)
    }).done(function(data){
        if(flags == getCurrentFlags()){
            $("#attractions").html(data);
        }

        testEmpty();
    })
}

function testEmpty(){
    if($(".tagselector").length == 0){

    }
}

function getCurrentFlags(){
    var flags = 0;

    $(".tagselector.active").each(function(){
        var tagid = $(this).attr('tagid');

        flags |= (1 << (tagid - 1))
    });

    return flags;
}
