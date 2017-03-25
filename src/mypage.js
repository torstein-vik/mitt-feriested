function init(){
    $(".deletecomment").click(function() {
        if(window.confirm("Are you sure? This can not be undone.")){
            $.ajax({
                url: 'api?type=deletecomment&tipid=' + $(this).attr('tipid')
            }).done(function (res){
                $(this).prev().animate({'height': 0, 'padding-top': 0, 'padding-bottom': 0}, 500, function(){
                    $(this).remove();

                    if($(".comment").length == 0){
                        location.reload();
                    }
                });

                $(this).remove();
            }.bind(this))

        }
    });

    $("#ban").click(function(){
        if(window.confirm("Are you sure? This can not be undone.")){
            $.ajax({
                url: "/api?type=ban&userid=" + $(this).attr("userid")
            }).done(function(res){
                location.href = "/?page=mypage";
            }.bind(this));
        }
    });

    $("#regrade").click(function(){
        if(window.confirm("Are you sure?")){
            $.ajax({
                url: "/api?type=regrade&userid=" + $(this).attr("userid") + "&npriv=" + $(this).attr("npriv")
            }).done(function(res){
                location.reload();
            }.bind(this));
        }
    });
}
