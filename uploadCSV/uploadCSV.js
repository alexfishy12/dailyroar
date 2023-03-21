function readCSV()
{
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

            // // set the HTTP method and URL
            // xhr.open('POST', 'uploadCSV/uploadCSV.php');

            // // set the request header to indicate that the payload is JSON
            // xhr.setRequestHeader('Content-Type', 'application/json');

            // // send the JSON payload
            // xhr.send(jsonString);

            upload_csv(jsonString).then(function (response) {
                $("#responseMessage").html(response)
            })
        }
      });

      // push changes to the database
        function upload_csv(csv){
            return new Promise(function(resolve) {
                $.ajax({
                    url: 'uploadCSV2.php',
                    dataType: 'text',
                    type: 'POST',
                    data: csv,
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


}






