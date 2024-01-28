var json_form_data = {}
var fileNamesArray = []
var fileFormData = null;

var editor;


$(document).ready(function(){
    $("div#send_response").hide()
    $("button#view_sent_email").hide()
    $("div#submit_error").hide()
    $("#send_email_response").hide();
    $("#send_email_errors").hide();

    load_filter_options()
    
    editor = new RichTextEditor("#editor")
      
    
    $("#form_submit").on("click", function(){
        console.log("Clicked submit.")
        getEmailAttributes()
    })

    $("button#upload").on('click', function() {
        console.log("Files uploading...")
        uploadFile();
    })
    $("button#view_sent_email").on('click', function() {
        console.log("Redirecting to email analysis page...")
        window.location.href = "../sent_inbox/index.php"
    })

    //on select filter
    
    $("select#curriculum").change(function() {
        var selected_option = $("select#curriculum option:selected, this");
        $("select#selected_curriculum").append(selected_option);
    })
    
    $("select#selected_curriculum").change(function() {
        var selected_option = $("select#selected_curriculum option:selected, this");
        $("select#curriculum").append(selected_option);
    })

    $("select#class_standing").change(function() {
        var selected_option = $("select#class_standing option:selected, this");
        $("select#selected_class_standing").append(selected_option);
    })

    $("select#selected_class_standing").change(function() {
        var selected_option = $("select#selected_class_standing option:selected, this");
        $("select#class_standing").append(selected_option);
    })

    // "select all" and "remove all" buttons

    $("button#curriculum_select_all").on("click", function() {
        var options = $("select#curriculum option, this");
        $("select#selected_curriculum").append(options);
    })

    $("button#curriculum_remove_all").on("click", function() {
        var options = $("select#selected_curriculum option, this");
        $("select#curriculum").append(options);
    })

    $("button#standing_select_all").on("click", function() {
        var options = $("select#class_standing option, this");
        $("select#selected_class_standing").append(options);
    })

    $("button#standing_remove_all").on("click", function() {
        var options = $("select#selected_class_standing option, this");
        $("select#class_standing").append(options);
    })

    var fileList = document.getElementById('fileList');

    // function gets email attachments 
   $('#email_attachments').on('change', function() {
        fileNamesArray = [];
        fileFormData = new FormData();
        var fileInput = $(this).get(0);
        var files = fileInput.files;

        fileList.innerHTML = "";
        for (var i = 0; i < files.length; i++) {
            fileFormData.append('file[]', files[i]);
            fileNamesArray.push(files[i].name);

            var p = document.createElement('p');
            p.textContent = files[i].name;
            fileList.appendChild(p);
        }     
      });    // end email onchange function  
})

//function that gets curriculum
function load_filter_options() {


    get_filter_options().then(function(response){
        var jsonResponse = JSON.parse(response)
        $("select#curriculum").html(jsonResponse.response.curriculum_dropdown)
        $("select#class_standing").html(jsonResponse.response.class_standing_dropdown)
        $("#get_response").html(response.errors)
    })
}


//Onclick send email button
function getEmailAttributes(){
    
    var submit_error = false

    json_form_data["subject"] = $("input#email_subject").val();
    
    json_form_data["body"] = editor.getHTMLCode()

    //get selected options for curriculum
    var curriculum = []
    $("select#selected_curriculum option").each(function()
    {
        curriculum.push($(this).val())
    });
    json_form_data["curriculum"] = JSON.stringify(curriculum);

    //get selected options for class standing
    var class_standing = []
    $("select#selected_class_standing option").each(function()
    {
        class_standing.push($(this).val())
    });
    json_form_data["class_standing"] = JSON.stringify(class_standing);

    $("div#submit_error").html("")
    if (json_form_data["curriculum"] == "[]") {
        $("div#submit_error").append("You must select curriculum options!<br>")
        submit_error = true
    }
    if (json_form_data["class_standing"] == "[]") {
        $("div#submit_error").append("You must select class standing options!<br>")
        submit_error = true
    }
    
    if (submit_error) {
        $("div#submit_error").show()
        return;
    }
    else {
        $("div#submit_error").hide()
    }

    
    // Enable file upload after sprint 1
    
    //add file attachments to "attachments" property of json
   /* var files = $('#email_attachments').prop('files')[0];

    
    if (files != null) {
        uploadFile()
    }


    */

    upload_attachments().then(function(){
        json_form_data["attachments"] = fileNamesArray;
        console.log(json_form_data)
        $("#send_response").show()
        $("#send_email_response").show()
        $("#send_email_response").html("<hr>Sending email...<hr>");
        $("div#compose_email_form").hide()
        send_email(json_form_data).then(function(response) {
            console.log(response);
            var responseHTML = "";
            var errorHTML = "";
            $("#send_email_response").html(responseHTML);
            $("#send_email_errors").html(errorHTML);
            response = JSON.parse(response);
            console.log(response);
            if (response) {
                for (item in response.response) {
                    responseHTML += response.response[item] + "<br>";
                }
                for (item in response.errors) {
                    errorHTML += response.errors[item] + "<br>";
                }
                $("#total_recipient_count").html("<hr>Total recipient count: <span id='recipient_number'></span>")
                if (responseHTML != "") {
                    $("#send_email_response").show();
                    $("#send_email_response").html("<hr>" + responseHTML);
                }
                if (errorHTML != "") {
                    $("#send_email_errors").show();
                    $("#send_email_errors").html("<hr style='color:#25a0ff'>" + errorHTML);
                }
                $("button#view_sent_email").show();
                var finalNumber = response.recipients; // Change this to the final number you want to count up to
                var currentNumber = 0;
                var interval = setInterval(function() {
                    if (currentNumber >= finalNumber) {
                    clearInterval(interval);
                    $('#recipient_number').text(finalNumber);
                    } else {
                    currentNumber++;
                    $('#recipient_number').text(currentNumber);
                    }
                }, 75); // Change the interval to make the counter go faster/slower
                  
            }
        })
    })
    
} // end getemailattribute function


function upload_attachments(){
    return new Promise(function(resolve) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                resolve('Success: Files uploaded.')
            }
            else {
                resolve('Error: ' + this.status);
            }
        };
        xhr.open('POST', 'upload_attachments.php', true);
        xhr.send(fileFormData);
    });
}

function send_email(email_data){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'send_email.php',
            dataType: 'text',
            type: 'POST',
            data: email_data,
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

function get_filter_options(){
    return new Promise(function(resolve) {
        $.ajax({
            url: '../get_filter_options.php',
            dataType: 'text',
            type: 'GET',
            success: function (response, status) {
                console.log('AJAX Success.');
                console.log(response);
                resolve(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('AJAX Error:' + textStatus);
                resolve("Error " . textStatus);
            }
        })
    });
}