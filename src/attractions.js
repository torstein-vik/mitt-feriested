function init(){

    $(".tagselector").click(function(){
        $(".tagselector.active").removeClass("active");
        $(this).addClass("active");

        updateContent();
        removeImages();
    });

}

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
    if($(".attraction").length != 0){
        $('.attraction').css('padding', '10px');
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
