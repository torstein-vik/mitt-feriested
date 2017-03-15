function init(){

    $(".tagselector").click(function(){
        $(".tagselector.active").removeClass("active");
        $(this).addClass("active");

        updateContent();
    });

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
        $('#tags').addClass('tabs');
        $('.tagselector').addClass('tabs');
    } else {
        $('#tags').removeClass('tabs');
        $('.tagselector').removeClass('tabs');
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
