//request handler
function requestHandlerGetData(phpFileLink, filter) {
    //create link to server
    var serverLink = "http://localhost/STB/php/" + phpFileLink;
    var xhr = new XMLHttpRequest();

    //creates a promise to return
    function getUserDataWithPromise() {
        return new Promise(function(resolve, reject) {
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status >= 300) {
                        reject("Error, status code = " + xhr.status)
                    } else {
                        resolve(xhr.responseText);
                    }
                }
            }
            xhr.open('POST', serverLink, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(filter);
        });
    }

    return getUserDataWithPromise();
}