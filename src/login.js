function init(){
    $("#loginform").submit(function(event){
        event.preventDefault();

        $("#errmsg").animate({height: "0"});

        $.ajax({
            method:"POST",
            url:"api?type=login",
            data:{
                username: $("input[name='username']").val(),
                password: $("input[name='password']").val()
            }
        }).done(function (result){
            if (result == "SUCCESS"){
                location.href = "?page=" + $("#loginform").attr("redir");
            } else {
                $("#errmsg p").html({
                    USERNAME_ERR: "No such username!",
                    PASSWORD_ERR: "Wrong password!"
                }[result]);
                $("#errmsg").animate({height: "100px"});

            }
        });
    })
}
