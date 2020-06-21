function createArgument() {
	//getting variables for argument post
	var title = document.getElementById("argument-title").value;
	var left = document.getElementById("argument-left").value;
    var right = document.getElementById("argument-right").value;

    //getting UserID from cookies
    var cookieArray = document.cookie.split("&");
    var UserID = cookieArray[0].substr(cookieArray[0].indexOf("=")+1);
    
    //creates filter for posts
    var requestFilters = "Title=" + title + "&LeftSide=" + left + "&RightSide=" + right + "&UserID=" + UserID;

    //send filter to php, gets back posts
    var returned = requestHandlerGetData("createArgument.php",requestFilters);

    returned.then(
        result => {
            //parse the response text
            jsOBJ = JSON.parse(result);

            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("Error: " + String(jsOBJ["Error"]));
            } 
            //move window to argument page
            else {
                window.location.assign("http://localhost/STB/argument_page.html?ArgID=" + jsOBJ["Results"]["ArgID"]);
            }
        }
    )
    return false;
}
