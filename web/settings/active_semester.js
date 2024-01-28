$(document).ready(function() {
    console.log("Document ready.");

    $("div.response").hide();
    
    set_year_options()

    server_request("../get_semesters.php", "POST").then(function(response) {
        switch (response.status) {
            case "success":
                load_semesters(response.data);
                break;
            case "failure":
                $("#error_message").html(response.data);
                break;
            case "error":
                console.error(response.data);
                break;
            default:
                console.log(response)
                break;
        }
    })
    event_handler()
});

function load_semesters(semesters) { 
    if (semesters.length == 0) {
        console.log("No semesters found.")
        $("select#semester").append("<option value='" + null + "' selected class='original_value'>None found</option>")
        return
    }
    
    console.log(semesters)
    // add option to select dropdown and set active semester to selected
    for (semester in semesters) {
        var semester = semesters[semester]
        if (semester.IsActive == 1) {
            $("span#active_semester_text").html(`${semester.Semester} ${semester.Year}`)
            $("select#semester").append("<option value='" + semester.ID + "' selected class='original_value'>" + semester.Semester + " " + semester.Year + "</option>")
        }
        else {
            $("select#semester").append("<option value='" + semester.ID + "'>" + semester.Semester + " " + semester.Year + "</option>")
        }
    }
}

function event_handler() {
    $("button#save_active").click(function(){
        const semester_id = $("select#semester > option:selected").val()
        console.log("Semester ID: " + semester_id)
        set_active_semester(semester_id)
    })

    $("button#create_new_semester").click(function (){
        $("div#active_semester").hide()
        $("form#create_semester").show()
    })

    $("button#cancel").click(function(){
        $("form#create_semester").hide()
        $("div#active_semester").show()
    })

    $("button#go_back").click(function(){
        window.location.reload()
    })

    $("form#create_semester").submit(function(e){
        e.preventDefault();
        var form_data = new FormData(document.querySelector('form'))

        create_semester(form_data);
    })
}

function show_success(data){
    $("div.forms").hide();
    $("div#errors").html("");

    $("div#response").html(data);

    $("div.response").show();
}

function show_error(data) {
    $("div.forms").hide();
    $("div#response").html("");
    $("div#errors").html(data);

    $("div.response").show();
}

function set_year_options() {
    var select_new_year = $("select#new_year")
    var currentYear = new Date().getFullYear();
    var lastYear = 2099;
    
    for (var year = currentYear; year <= lastYear; year++) {
        var option = document.createElement("option");
        option.value = year;
        option.text = year;
        select_new_year.append(option)
    }
}



function set_active_semester(semester_id){
    var form_data = new FormData();
    form_data.append("ID", semester_id);
    server_request("set_active_semester.php", "POST", form_data).then(function(response) {
        switch (response.status) {
            case "success":
                show_success(response.data)
                break;
            case "failure":
                show_error(response.data)
                break;
            case "error":
                console.error(response.data);
                break;
            default:
                console.log(response)
                break;
        }
    });
}


function create_semester(form_data){
    server_request("create_semester.php", "POST", form_data).then(function(response) {
        switch (response.status) {
            case "success":
                show_success(response.data)
                break;
            case "failure":
                show_error(response.data)
                break;
            case "error":
                console.error(response.data);
                break;
            default:
                console.log(response)
                break;
        }
    });
}