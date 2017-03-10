function init(){
    updateContent();

    var caught = 0;

    $(".tagselector").click(function(){
        setTimeout(function(){
            if(caught > 0){
                caught--;
            } else {
                $(this).toggleClass("active");
                updateContent();
            }
        }.bind(this), 20);
    });


    $(".tagselector").dblclick(function(){
        caught += 1;

        if($(this).hasClass("active")){
            $(".tagselector").addClass("active");
            $(this).removeClass("active");
        } else {
            $(".tagselector").removeClass("active");
            $(this).addClass("active");
        }
        updateContent();
    });
}

function updateContent(){var flags = getCurrentFlags();

    $.ajax({
        url:("api?type=attractions&redir=" + $("#redir").html() + "&flags="+flags)
    }).done(function(data){
        if(flags == getCurrentFlags()){
            $("#attractions").html(data);
        }
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
