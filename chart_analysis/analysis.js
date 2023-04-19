var quill_editor;

google.charts.load('current', {packages: ['corechart']});

$(document).ready(function(){
    //show email analysis by default
    $("div#email_analysis").show();
    $("div#filtered_analysis").hide();

    load_filter_options()      
    load_emails().then(function(response){
        $("#email_table").html(response);

        $("div#email_table table tr, this").click(function(){
            console.log("Clicked on row.")
            var email_id = $(this).attr("id");

            if (email_id == "header" || email_id == "" || email_id == null)
            {
                return;
            }
            else
            {
                get_email_data(email_id).then(function(response){
                    var email_data = response.response;

                    var email_data_html = "";

                    for (attr in email_data) {
                        email_data[attr] = parseInt(email_data[attr])
                    }

                    var percentage_opened = 100 * (email_data['total_opened'] / email_data['total_recipients'])
                    var percentage_link_clicks = 100 * email_data['total_clicked'] / email_data['total_recipients']
                    
                    email_data_html += "Percentage opened: " + percentage_opened + "%<br>"
                    email_data_html += "Percentage clicked through: " + percentage_link_clicks + "%<br>"
                    $("div#email_data").html(email_data_html);

                    drawEmailChart(email_data)
                })
            }
            
        })
    })

    //on email analysis button click
    $("button#select_email_analysis").click(function(){
        $("div#email_analysis").show();
        $("div#filtered_analysis").hide();
    })

    //on filtered analysis button click
    $("button#select_filtered_analysis").click(function(){
        $("div#filtered_analysis").show();
        $("div#email_analysis").hide();
    })

    $("#form_submit").click(function(){
        console.log("Clicked submit.")
        getFilteredAnalysis();
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
    
    var json_form_data = {}
    

    json_form_data["subject"] = $("input#email_subject").val();
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
            $("#send_email_response").html(responseHTML);
            $("#send_email_errors").attr("style", "color:red");
            $("#send_email_errors").html(errorHTML);
        }
    })
    
}
  
function load_emails(){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'get_emails.php',
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

function get_email_data(email_id){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'get_email_data.php',
            dataType: 'json',
            type: 'POST',
            data: {email_id: email_id},
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



function drawEmailChart(email_data){ 
      // Define the chart to be drawn.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Attribute')
      data.addColumn('number', 'Count');
      data.addRows([
        ['Total Recipients', email_data['total_recipients']],
        ['Total Opens', email_data['total_opened']],
        ['Total Link Clicks', email_data['total_clicked']]
      ]);

      // Instantiate and draw the chart.
      var chart = new google.visualization.BarChart(document.getElementById('data_chart'));
      chart.draw(data, null);
}