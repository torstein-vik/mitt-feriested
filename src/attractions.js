function init(){
    updateContent();

    $(".tagselector").click(function(){
        $(this).toggleClass("active");
        updateContent();
    });
}

function updateContent(){
    $("#attractions").html("Please wait...");

    var flags = getCurrentFlags();

    $.ajax({
        url:("data?type=attractions&redir=" + $("#redir").html() + "&flags="+flags)
    }).done(function(data){
        setTimeout(function(){
            if(flags == getCurrentFlags()){
                $("#attractions").html(data);
            }
        }, 500);
    })
}

function getCurrentFlags(){
    var flags = 0;

    $(".tagselector.active").each(function(){
        var tagid = $(this).attr('tagid');

        flags |= (1 << (tagid - 1))
    });

    return flags;
}
