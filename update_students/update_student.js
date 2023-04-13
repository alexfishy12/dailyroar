var changed_students = [];

$(document).ready(function() {
    console.log("Document ready.");
    
    $("div#info").hide();
    $("div#students_table").hide();
    $("div#form_options").hide();
    $("div#review_options").hide();
    $("div#finished_options").hide();

    $("form#search").submit(function(e) {
        e.preventDefault();
        console.log("Search form submitted.");
        get_students($("#search_box").val());
    });
    $("button#done").on("click", function(){
        console.log("Done button clicked.");
        review_students();
    });
    $("button#confirm").on("click", function(){
        console.log("Confirm button clicked.");
        confirm_update_students();
    });
    $("button#make_changes").on("click", function(){
        console.log("Make changes button clicked.");
        make_changes();
    })
    
});

function make_changes() {
    // hide the review options
    $("div#review_options").hide()
    $("div#form_options").show()
    // show the done button
    // enable all inputs so further actions can be done in the make changes stage
    $("#students_table input").each(function () {
        $(this).removeAttr("readonly");
    });
    $("#students_table select").each(function () {
        $(this).removeAttr("disabled");
    });
    $("#students_table input[type='checkbox']").each(function () {
        $(this).removeAttr("disabled");
    });
}

function confirm_update_students() {
    var html = "";
    update_students().then(function(response){
        console.log(response);
        response = JSON.parse(response)
        html = response.response;
        $("div#update_response").html(html);
    })
    $("div#review_options").hide();
    $("div#finished_options").show();
}

function get_students(search_text) {
    var html = "";
    request_students(search_text).then(function(response){
        if (response.includes("Error")) {
            html = "<b>ERROR:</b><br>" + response;
            display_students_table(html, true);
        }
        else
        {
            html = response;
            display_students_table(html, false);
        }
        initialize_input_change_detection();
    })
}

function review_students() {
    if (changed_students.length < 1) {
        return;
    }

    //hide search form
    $("form#search").hide();
    //hide form_options
    $("div#form_options").hide();

    // disable all inputs so no further actions can be done in the review stage
    $("#students_table input").each(function () {
        $(this).attr("readonly", "readonly");
    });
    $("#students_table select").each(function () {
        $(this).attr("disabled", "disabled");
    });
    $("#students_table input[type='checkbox']").each(function () {
        $(this).attr("disabled", "disabled");
    });

    // hide all rows in the table
    $("tr").each(function () {
        var elem = $(this);
        if (elem.attr("id") == "header") {
            return;
        }
        elem.hide();
    })

    //show rows in the table that were edited
    changed_students.forEach(student => {
        $("tr#" + student.id).show()
        console.log(student.id);
    })

    // show review options
    $("div#review_options").show()
    $("div#info").html("<b>Review the students you have made changes to, then click \"Confirm\" to push changes to the database.</b>");
}

function display_students_table(html, isError) {
    if (isError) {
        $("div#info").show();
        $("#students_table_error").html(html)
    }
    else {
        $("div#info").show();
        $("div#info").html("Make any changes to students in the table, then click \"Done\" to review. <br><br><u>Key</u><br>Original values: <span class='original_value' style='color:aquamarine;'>____</span><br>New Values: <span class='new_value' style='color:yellow;'>____</span>");
        $("div#students_table").html(html);
        $("div#students_table").show();
        $("div#form_options").show();
    }
}

function request_students(search_text){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'get_students.php',
            dataType: 'text',
            type: 'POST',
            data: {search_text: search_text},
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

function initialize_input_change_detection() {
    console.log("Initializing input change detection function.");
    $("#students_table input,select").each(function() {
        var elem = $(this);
     
        // Save current value of element
        elem.data('oldVal', elem.val());
        elem.data('student_id', $(elem).closest('tr').attr('id'))
     
        // Look for changes in the value
        elem.on("propertychange input paste", function(event){
            
            //checkbox values get different behavior
            if (elem.attr("type") == "checkbox") {
                push_changed_student_attr(elem);
                var index = get_changed_student_index(elem)
                if (student_has_changes(index) == false) {
                    remove_student(index);
                }
                else {
                    $("button#done").attr("disabled", false);
                }
                console.log(changed_students);
                return;
            }

            // for the rest of the inputs
            // If value has changed...
            if (elem.data('oldVal') != elem.val()) {
                // Do action
                elem.attr("class", "new_value")
                push_changed_student_attr(elem);
                $("button#done").attr("disabled", false);
                $("form#search").hide();
            }
            else {
                //remove change from changed_student_attributes array
                elem.attr("class", "")
                
                remove_attribute(elem);
                
                //removes the student from changed_students array if they don't have any changed attributes
                var index = get_changed_student_index(elem)
                if (student_has_changes(index) == false) {
                    remove_student(index);
                }
                else {
                    $("button#done").attr("disabled", false);
                    $("form#search").hide();
                }
            }
            
            console.log(changed_students);
        });
    });
}

// removes attribute from the list of changed attributes for a student
function remove_attribute(elem) {
    var index = get_changed_student_index(elem)

    // removes old attribute value
    changed_students[index].old_values = changed_students[index].old_values.filter(function (obj) {
        return obj.column_name != elem.attr('name');
    });

    // removes new attribute value
    changed_students[index].new_values = changed_students[index].new_values.filter(function (obj) {
        return obj.column_name != elem.attr('name');
    });
}

// pushes changed attribute to corresponding student in changed_student array
function push_changed_student_attr(elem) {
    var index = get_changed_student_index(elem);

    // Maybe display changed option names instead of the ID of the option
    var option_name = "";
    if (elem.prop('tagName') == "SELECT") {
        option_name = elem.find(":selected").text()
        console.log("Option name: " + option_name)
    }

    // If attribute is checkbox, do this, then end function
    if (elem.attr("type") == "checkbox") {
        console.log(elem.val())

        if (index != -1) {
            changed_students[index].delete = checkbox_to_boolean(elem.val())
        }
        else {
            changed_students.push({
                "id": elem.data('student_id'), 
                "old_values": [],
                "new_values": [],
                "delete": checkbox_to_boolean(elem.val())
            })
        }
        return;
    }
    // If student is in array, update the existing student data. Otherwise, add new student to array
    if (index != -1) {
        remove_attribute(elem)
        changed_students[index].old_values.push({
            "column_name": elem.attr('name'), 
            "value": elem.data('oldVal'),
        });
        changed_students[index].new_values.push({
            "column_name": elem.attr('name'), 
            "value": elem.val()
        })
    }
    else {
        changed_students.push({
            "id": elem.data('student_id'), 
            "old_values": [{"column_name": elem.attr('name'), "value": elem.data('oldVal')}],
            "new_values": [{"column_name": elem.attr('name'), "value": elem.val()}],
            "delete": false
        })
    }
}

// get the index of a student (by id) in the changed_students array
function get_changed_student_index(elem) {
    return changed_students.map(student => student.id).indexOf(elem.data('student_id'));
}

// push changes to the database
function update_students(){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'send_updates.php',
            dataType: 'text',
            type: 'POST',
            data: {changed_students: changed_students},
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

// converts "on" and "off" values to true and false
function checkbox_to_boolean(val){
    if (val == "on") {
        return true;
    }
    else {
        return false;
    }
}

// checks to see if student has changes
function student_has_changes(index){
    if (changed_students[index].old_values.length < 1 && 
        changed_students[index].old_values.length < 1 && 
        changed_students[index].delete == false) {
        return false;
    }
    else {
        return true;
    }
}

// removes student from changed_students array
function remove_student(index) {
    changed_students.splice(index, 1);
    if (changed_students.length < 1) {
        $("button#done").attr("disabled", true)
        $("form#search").show();
    }
}