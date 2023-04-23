
var quill_editor;
var json_form_data = {}

var quill;


$(document).ready(function(){
    load_filter_options()


    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],
        ['link'], 
      
        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction
      
        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],
      
        ['clean']                                         // remove formatting button
      ];


    //initialize quill editor
    quill = new Quill('#editor', {
        modules: { 
            toolbar: toolbarOptions,
            
        },
        theme: 'snow'
    });
    console.log(quill)

    var toolbar = quill.theme.modules.toolbar
    lastLinkRange = null;

    /**
     * Add protocol to link if it is missing. Considers the current selection in Quill.
     */
    function updateLink() {
        var selection = quill.getSelection(),
            selectionChanged = false;
        if (selection === null) {
            var tooltip = quill.theme.tooltip;
            if (tooltip.hasOwnProperty('linkRange')) {
                // user started to edit a link
                lastLinkRange = tooltip.linkRange;
                return;
            } else {
                // user finished editing a link
                var format = quill.getFormat(lastLinkRange),
                    link = format.link;
                quill.setSelection(lastLinkRange.index, lastLinkRange.length, 'silent');
                selectionChanged = true;
            }
        } 
        else {
            var format = quill.getFormat();
            if (!format.hasOwnProperty('link')) {
                return; // not a link after all
            }
            var link = format.link;
        }
        // add protocol if not there yet
        if (!/^https?:/.test(link)) {
            link = 'http://' + link;
            quill.format('link', link);
            // reset selection if we changed it
            if (selectionChanged) {
                if (selection === null) {
                    quill.setSelection(selection, 0, 'silent');
                } else {
                    quill.setSelection(selection.index, selection.length, 'silent');
                }
            }
        }
    }

    // listen for clicking 'save' button
    editor.addEventListener('click', function(event) {
        // only respond to clicks on link save action
        if (event.target === editor.querySelector('.ql-tooltip[data-mode="link"] .ql-action')) {
            updateLink();
        }
    });

    // listen for 'enter' button to save URL
    editor.addEventListener('keydown', function(event) {
        // only respond to clicks on link save action
        var key = (event.which || event.keyCode);
        if (key === 13 && event.target === editor.querySelector('.ql-tooltip[data-mode="link"] input')) {
            updateLink();
        }
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


    // function gets email attachments 
   $('#email_attachments').on('change', function() {
        var fileNamesArray = [];
        var fileInput = $(this).get(0);
        var files= fileInput.files;
        var formData = new FormData();

        for (var i = 0; i < files.length; i++) {
            formData.append('file[]', files[i]);
            fileNamesArray.push(files[i].name);
          }
       
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            json_form_data["attachments"] = fileNamesArray;
          }
          else {
            console.log('Error: ' + this.status);
          }
        };
      
        xhr.open('POST', 'upload_attachments.php', true);
        xhr.send(formData);
     
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
    
  

    json_form_data["subject"] = $("input#email_subject").val();
    // var delta = quill.getContents();
    // var text = quill.getText();

    //add html content from QuillJS to "body" property of json
    var just_html = quill.root.innerHTML;
    console.log(just_html)
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



    console.log(json_form_data);
    
    
    // Enable file upload after sprint 1
    
    //add file attachments to "attachments" property of json
   /* var files = $('#email_attachments').prop('files')[0];

    
    if (files != null) {
        uploadFile()
    }


    */

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
            $("#send_email_response").html(responseHTML);
            $("#send_email_errors").attr("style", "color:red");
            $("#send_email_errors").html(errorHTML);
        }
    })
    
} // end getemailattribute function




/*
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
*/

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
                resolve(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('AJAX Error:' + textStatus);
                resolve("Error " . textStatus);
            }
        })
    });
}