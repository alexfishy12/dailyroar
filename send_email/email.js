var quill_editor;

$(document).ready(function(){
    //initialize curriculum options
    load_filter_options()
    $("#email_curriculum").innerHTML

    //initialize class standing options


    //initialize quill editor
    quill_editor = new Quill('#email_editor', {
        modules: { toolbar: '#toolbar' },
        theme: 'snow'
    });
    
    $("#form_submit").on("click", function(){
        console.log("Clicked submit.")
        getEmailAttributes()
    })

    $("button#upload").on('click', function() {
        console.log("Files uploading...")
        uploadFile();
    })

    //on select filter
    
    $("select#curriculum").change(function() {
        var selected_option = $("select#curriculum option:selected, this");
        console.log(selected_option)
        $("select#selected_curriculum").append(selected_option);
    })
    
    $("select#selected_curriculum").change(function() {
        var selected_option = $("select#selected_curriculum option:selected, this");
        console.log(selected_option)
        $("select#curriculum").append(selected_option);
    })

    $("select#class_standing").change(function() {
        var selected_option = $("select#class_standing option:selected, this");
        console.log(selected_option)
        $("select#selected_class_standing").append(selected_option);
    })

    $("select#selected_class_standing").change(function() {
        var selected_option = $("select#selected_class_standing option:selected, this");
        console.log(selected_option)
        $("select#class_standing").append(selected_option);
    })
})

//function that gets curriculum
function load_filter_options() {
    get_filter_options().then(function(response){
        var jsonResponse = JSON.parse(response)
        $("select#curriculum").html(jsonResponse.response.curriculum_dropdown)
        $("select#class_standing").html(jsonResponse.response.class_standing_dropdown)
        $("#get_response").html(response.errors)

        console.log(jsonResponse.response.curriculum_dropdown)
    })
}


//Onclick send email button
function getEmailAttributes(){
    //only gets simple inputs that have name ad value attribute
    var formData = $("div.email_form [id^='email']").serializeArray()
    console.log(formData)
    
    //for each simple input attribute, add to json
    var json_form_data = {}
    formData.forEach(getAttribute)
    function getAttribute(attribute){
        json_form_data[attribute.name] = attribute.value
    }

    // var delta = quill_editor.getContents();
    // var text = quill_editor.getText();

    //add html content from QuillJS to "body" property of json
    var just_html = quill_editor.root.innerHTML;
    json_form_data["body"] = just_html;

    //get selected options for curriculum
    var curriculum = []
    $("select#selected_curriculum option").each(function()
    {
        console.log($(this).val())
        curriculum.push($(this).val())
    });
    json_form_data["curriculum"] = JSON.stringify(curriculum);

    //get selected options for class standing
    var class_standing = []
    $("select#selected_class_standing option").each(function()
    {
        console.log($(this).val())
        class_standing.push($(this).val())
    });
    json_form_data["class_standing"] = JSON.stringify(class_standing);
    
    // Enable file upload after sprint 1
    /*
    //add file attachments to "attachments" property of json
    var files = $('#email_attachments').prop('files')[0];

    if (files != null) {
        uploadFile()
    }
    json_form_data["attachments"] = file_path;
    */
    console.log(json_form_data)

    send_email(json_form_data).then(function(response) {
        console.log(response);
        var responseHTML = "";
        var errorHTML = "";
        response = JSON.parse(response);
        console.log(response);
        if (response) {
            for (item in response.response) {
                responseHTML += response.response[item] + "<br>";
            }
            for (item in response.errors) {
                errorHTML += response.errors[item] + "<br>";
            }
            $("#send_email_response").attr("style", "color:black");
            $("#send_email_response").html(responseHTML);
            $("#send_email_errors").attr("style", "color:red");
            $("#send_email_errors").html(errorHTML);
        }
    })
    
}

async function uploadFile() {
    let formData = new FormData(); 
    formData.append("file", $("#email_attachments").prop("files")[0]);
    await fetch('upload_attachments.php', {
      method: "POST",
      body: formData
    }).then(data => {
            console.log(data);
    })
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
            url: 'get_filter_options.php',
            dataType: 'text',
            type: 'GET',
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