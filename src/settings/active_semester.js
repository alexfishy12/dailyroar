$(document).ready(function() {
    console.log("Document ready.");

    $("form#create_semester").hide();
    $("div.response").hide();
    
    set_year_options()

    get_semesters().then(function(response){
        if (response.response.length > 0) {
            const semesters = response.response
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
        else {
            console.log("No semesters found.")
            $("select#semester").append("<option value='" + null + "' selected class='original_value'>None found</option>")
        }
    })

    event_handler()
    
});

function event_handler() {
    $("button#save_active").click(function(){
        const semester_id = $("select#semester > option:selected").val()
        console.log("Semester ID: " + semester_id)
        set_active_semester(semester_id).then(function(response){
            show_response(response)
        })
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
        var formData = new FormData(document.querySelector('form'))

        create_semester(formData).then(function(response){
            show_response(response)
        })
    })
}

function show_response(response){
    $("div.forms").hide();
    $("div#errors").html("");
    $("div#response").html("");

    console.log(response)

    const responseText = response.response;
    const errors = response.errors;

    var errorHTML = "";
    for (error in errors) {
        errorHTML += errors[error] + "<br>"
    }

    $("div#errors").html(errorHTML);

    $("div#response").html(responseText);

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
    return new Promise(function(resolve) {
        $.ajax({
            url: 'set_active_semester.php',
            dataType: 'json',
            type: 'POST',
            data: {ID: semester_id},
            success: function (response, status) {
                console.log('AJAX Success.');
                resolve(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('AJAX Error:' + textStatus);
                resolve("Error " . textStatus);
            }
        })
    });
}


function create_semester(formData){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'create_semester.php',
            dataType: 'json',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response, status) {
                console.log('AJAX Success.');
                resolve(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('AJAX Error:' + textStatus);
                resolve("Error " . textStatus);
            }
        })
    });
}


function get_semesters(){
    return new Promise(function(resolve) {
        $.ajax({
            url: '../get_semesters.php',
            dataType: 'json',
            type: 'POST',
            success: function (response, status) {
                console.log('AJAX Success.');
                resolve(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('AJAX Error:' + textStatus);
                resolve("Error " . textStatus);
            }
        })
    });
}