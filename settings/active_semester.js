$(document).ready(function() {
    console.log("Document ready.");
    
    get_semesters().then(function(repsonse){
        
    })
});


// push changes to the database
function set_active_semester(){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'set_active_semester.php',
            dataType: 'text',
            type: 'POST',
            data: {active_semester: changed_students},
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

// push changes to the database
function create_semester(year, semester, make_active){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'create_semester.php',
            dataType: 'text',
            type: 'POST',
            data: {year: year, semester: semester, make_active: make_active},
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

// push changes to the database
function get_semesters(){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'get_semesters.php',
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