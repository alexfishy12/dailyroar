$(document).ready(function() {
    $("button#upload").hide()
    $("div#loading_message").hide()
    $("div#responseMessage").hide()
    $("input#uploadcsv").on("change", function() {
        console.log("File change...")
        var fileInput = $(this).get(0);
        var files = fileInput.files;
        console.log(files)

        if (files.length > 0) {
            $("button#upload").show()
        }
        else {
            $("button#upload").hide()
        }
    })

    $("button#upload").on("click", readCSV)
})

function readCSV()
{
    $("div#loading_message").show()
    $("div#loading_message").html("Uploading CSV...<br><br>Please be patient. This may take a few minutes.")
    $("button#upload").hide()
    $("input#uploadcsv").hide()
    var file = document.getElementById("uploadcsv");
    var fileName = file.files[0];

    Papa.parse(fileName, {
        header: true, // use the first row as headers
        skipEmptyLines: "greedy", // ignore empty rows
        complete: function(results) {
            console.log(results.data); // log the parsed data to the console
            
             
                // convert the JSON object to a string
            var jsonString = JSON.stringify(results.data);

            // create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            var csv_is_uploaded = false
            var ellipses = "..."
            var interval = setInterval(function() {
                if (csv_is_uploaded == true) {
                    clearInterval(interval);
                    $("div#loading_message").hide()
                } else {
                    if (ellipses == "...") {
                        ellipses = ""
                    }
                    else if (ellipses == "") {
                        ellipses = "."
                    }
                    else if (ellipses == ".") {
                        ellipses = ".."
                    }
                    else if (ellipses == "..") {
                        ellipses = "..."
                    }
                    $("div#loading_message").html("Uploading CSV" + ellipses + "<br><br>Please be patient. This may take a few minutes.")
                }
            }, 1000); // Change the interval to make the counter go faster/slower

            $("div#loading_message").show()
            upload_csv(jsonString).then(function (response) {
                csv_is_uploaded = true
                clearInterval(interval);
                $("div#loading_message").hide()
                $("div#responseMessage").show()
                $("div#responseMessage").html(response)
            })
        }
      });

      // push changes to the database
        function upload_csv(csv){
            return new Promise(function(resolve) {
                $.ajax({
                    url: 'uploadCSV.php',
                    dataType: 'text',
                    type: 'POST',
                    data: csv,
                    success: function (response, status) {
                        console.log('AJAX Success.');
                        resolve("Student CSV successfully uploaded!");
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log('AJAX Error:' + textStatus);
                        resolve("Error " . textStatus);
                    }
                })
            });
        }


}






