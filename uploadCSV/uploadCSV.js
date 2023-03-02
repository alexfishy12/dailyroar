function readCSV()
{
    var file = document.getElementById("uploadcsv");
    var fileName = file.files[0];

  

    Papa.parse(fileName, {
        header: true, // use the first row as headers
        complete: function(results) {
          console.log(results.data); // log the parsed data to the console
        }
      });
}

