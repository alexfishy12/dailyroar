$(document).ready(function() {
    console.log("JS connected.")
    $("form#login").submit(function(e) {
        e.preventDefault();
        var values = {};
        $.each($('form#login').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });

        var formData = new FormData();
        formData.append("login_id", values['login_id']);
        formData.append("password", values['password']);

        server_request("login.php", "POST", formData).then(function(response) {
            switch (response.status) {
                case "success":
                    window.location.replace(response.data)
                    break;
                case "failure":
                    $("#errorMessage").html(response.data)
                    break;
                case "error":
                    console.error(response.data)
                    break;
                default:
                    console.log(response)
                    break;
            }
        });
    })
})