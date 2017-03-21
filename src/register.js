function init(){
    $("#registerform").submit(function(event){
        event.preventDefault();

        $("#errmsg").animate({width: "0"});

        $.ajax({
            method:"POST",
            url:"api?type=register",
            data:{
                username: $("input[name='username']").val(),
                password: $("input[name='password']").val(),
                conf_password: $("input[name='conf_password']").val()
            }
        }).done(function (result){
            if (result == "SUCCESS"){
                location.href = "?page=" + $("#registerform").attr("redir");
            } else {
                $("#errmsg").html({
                    PASSWD_MISMATCH_ERR: "The passwords don't match!",
                    USERNAME_USED_ERR: "Username already in use!",
                    UNKNOWN_ERR: "Unknown error. Please contact administator.",
                    USERNAME_EMPTY: "Username is empty!",
                    PASSWORD_EMPTY: "Password is empty!"
                }[result]);
                $("#errmsg").animate({width: "500px"});

            }
        });
    })
}
