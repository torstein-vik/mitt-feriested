function init(){
    updateContent();

    $(".tagselector").click(function(){
        $(this).toggleClass("active");
    });
}

function updateContent(){
    var flags = 0;

    $("#attractions").html("Please wait...");

    $(".tagselector.active").each(function(){
        var tagid = $(this).attr('tagid');

        flags |= (1 << (tagid - 1))
    });


    $.ajax({
        url:("data?type=attractions?tags="+flags)
    }).done(function(data){
        setTimeout(function(){
            $("#attractions").html(data);
        }, 500);
    })
}
