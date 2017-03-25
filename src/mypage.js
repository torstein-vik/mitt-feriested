function init(){
    $(".deletecomment").click(function() {
        if(window.confirm("Are you sure?")){
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
}
