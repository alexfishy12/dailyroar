function server_request(url, method, data = null) {
    return new Promise(function(resolve) {
        $.ajax({
            type: method,
            url: url,
            data: data,
            processData: false, // Prevent serialization of the FormData object
            contentType: false, // Let the browser set the correct content type for FormData
            success: function (response, status) {
                // AJAX Success, server responded
                try {
                    // Try to parse response as JSON
                    response = JSON.parse(response);
                } catch (e) {
                    // Response is not JSON, Error in PHP was not caught
                    response = {
                        status: 'error', 
                        data: "Error parsing response from server.\n\nJS ERROR\n" + e + "\n\nSERVER ERROR\n" + response
                    };
                    resolve(response);
                }
                // Response successfully parsed as JSON, PHP compiled and caught all errors
                resolve(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                // AJAX Error, server did not respond
                response = {
                    status: 'error', 
                    data: "AJAX ERROR (" + textStatus + ")\n" + errorThrown
                };
                resolve(response);
            }
        })
    });
}