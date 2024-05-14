

$("#formlogin").submit(function(event){
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url : "/auth",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : formData,
        type : "post",
        dataType : "json",
        Accept: "application/json",
        async : false,
        cache : false,
        contentType : false,
        processData : false,
        success : function (data) { 
            $("#notification").html("");
            if(data.status == true) {

                // set localstorage cronTimer
                localStorage.setItem('cronCurrentTimer', 0);

                $("#notification").html("<div class=\"alert alert-success\" id=\"success\"> <button class=\"close\" data-close=\"success\"></button> "+data.message+" </div>");
                setTimeout(function(){ location.href = '/dashboard'; }, 2000);
            } else {
                $("#notification").html("<div class=\"alert alert-danger\" id=\"danger\"> <button class=\"close\" data-close=\"alert\"></button> "+data.message+" </div>");
            }
        },
        error : function(jqXHR, textStatus, errorThrown) {
            $("#notification").html("<div class=\"alert alert-danger\" id=\"danger\"> <button class=\"close\" data-close=\"alert\"></button> Username atau Password anda Salah ! </div>");
        }
    })
});

// function logout() {
//     localStorage.clear();
//     location.href = '/logout';
// }