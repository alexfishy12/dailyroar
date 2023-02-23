var quill_editor;

$(document).ready(function(){
    //initialize quill editor
    quill_editor = new Quill('#email_editor', {
        modules: { toolbar: '#toolbar' },
        theme: 'snow'
    });
    
    $("#form_submit").on("click", function(){
        console.log("Clicked submit.")
        getEmailAttributes()
    })
})

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

    //add file attachments to "attachments" property of json
    //json_form_data["attachments"] = $('#email_attachments').prop('files');
    
    
    console.log(json_form_data)
    send_email(json_form_data).then(function(response) {
        console.log(response);
        if (response.startsWith("ERROR")) {
            var error_message = response.split(/:(.*)/s)[1];

            $("#send_email_response").attr("style", "color:red")
            $("#send_email_response").html(error_message);
        }
        else if (response.startsWith("SUCCESS")){
            var success_message = response.split(/:(.*)/s)[1];
            $("#send_email_response").attr("style", "color:black");
            $("#send_email_response").html(success_message);
        }
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