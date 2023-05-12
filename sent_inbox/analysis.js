var quill;

google.charts.load('current', {packages: ['corechart']});

$(document).ready(function(){
    //show email analysis by default
    $("div#email_analysis").show();
    $("div#filtered_analysis").hide();
    $("div#selected_email").hide()

    //load_event_handlers()
    //load_filter_options()      

    quill = new Quill('#editor', {
        modules: {
            toolbar: {}
        },
        theme: 'snow',
        readOnly: true
    });

    const toolbar = quill.getModule('toolbar');
    toolbar.container.style.display = 'none'; // hide the toolbar
    
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
                show_email(email_id);
            }
            
        })
    })

    $("button#go_back").on('click', function() {
        $("div#selected_email").hide()
        $("div#email_table").show()
    })
})

function show_email(email_id) {
    get_email_data(email_id).then(function(response){
        $("div#selected_email").show()
        $("div#email_table").hide()
        const parsedData = JSON.parse(response);
        console.log(parsedData)

        // print out email metadata
        const email_metadata = parsedData.response.email_metadata
        var email_metadata_html = 
        "ID: " + email_metadata.email.ID + "<br>" +
        "Sent: " + email_metadata.email.Created + "<br>" +
        "Sender: " + email_metadata.email.Sender + "<br>" +
        "Subject: " + email_metadata.email.Subject + "<br>";
        
        
        $("#email_metadata").html(email_metadata_html)

        // paste the body
        var body = email_metadata.email.Body
        console.log(body)
        body = decodeURI(body)
        console.log(body)
        $("#editor").html(body)
        
        // print out email analysis data
        const email_data = parsedData.response.email_data
        for (attr in email_data) {
            email_data[attr] = parseInt(email_data[attr])
        }
        
        var percentage_opened = 100 * (email_data['total_opened'] / email_data['total_recipients'])
        var percentage_link_clicks = 100 * (email_data['total_clicked'] / email_data['total_recipients'])
        percentage_opened = percentage_opened.toFixed(2);
        percentage_link_clicks = percentage_link_clicks.toFixed(2);
        
        var email_data_html = "";
        email_data_html += "Total recipients: " + email_data['total_recipients'] + "<br>"
        email_data_html += "Percentage opened: " + percentage_opened + "%<br>"
        email_data_html += "Percentage link clicks: " + percentage_link_clicks + "%<br>"
        $("div#email_data").html(email_data_html);

        // print out google chart
        drawEmailChart(email_data)

        // print out email recipient filter data

        const class_standing = email_metadata.filters.class_standing
        var class_standing_string = ""
        for (standing in class_standing){
            var standing = class_standing[standing][0]
            var standing_full_name = ""
            if (standing == "FR") {
                standing_full_name = "freshmen"
            }
            else if (standing == "SO") {
                standing_full_name = "sophomores"
            }
            else if (standing == "JR") {
                standing_full_name = "juniors"
            }
            else if (standing == "SR") {
                standing_full_name = "seniors"
            }
            else if (standing == "GR") {
                standing_full_name = "graduates"
            }
            class_standing_string += standing_full_name + ", ";
        }
        class_standing_string = class_standing_string.slice(0, -2)

        var recipient_filters_html = "This email was sent to all " + class_standing_string + " with majors or minors in any of the following:<br><br>"

        const curriculum = email_metadata.filters.curriculum
        var curriculum_string = ""
        for (major in curriculum){
            curriculum_string += curriculum[major][0] + "<br>"
        }
        recipient_filters_html += curriculum_string
        $("div#recipient_filters").html(recipient_filters_html)
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

function get_email_data(email_id){
    return new Promise(function(resolve) {
        $.ajax({
            url: 'get_email_data.php',
            dataType: 'text',
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

//////// THE FOLLOWING CODE IS FOR FILTERED ANALYSIS IMPLEMENTATION
/*
    
function load_event_handlers() {
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
}

//function that gets curriculum
function load_filter_options() {
    get_filter_options().then(function(response){
        var jsonResponse = JSON.parse(response)
        $("select#curriculum").html(jsonResponse.response.curriculum_dropdown)
        $("select#class_standing").html(jsonResponse.response.class_standing_dropdown)
        $("#get_response").html(response.errors)
    })
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

function getEmailAttributes(){
    
    var json_form_data = {}

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
    
    console.log(json_form_data)

    // send_email(json_form_data).then(function(response) {
    //     console.log(response);
    //     var responseHTML = "";
    //     var errorHTML = "";
    //     response = JSON.parse(response);
    //     console.log(response);
    //     if (response) {
    //         for (item in response.response) {
    //             responseHTML += response.response[item] + "<br>";
    //         }
    //         for (item in response.errors) {
    //             errorHTML += response.errors[item] + "<br>";
    //         }
    //         $("#send_email_response").html(responseHTML);
    //         $("#send_email_errors").attr("style", "color:red");
    //         $("#send_email_errors").html(errorHTML);
    //     }
    // })  
}
*/