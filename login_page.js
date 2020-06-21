//function called to login
function logIn(isLogin, UserVar, PassVar){
    //if signup do this
    if(!isLogin){
        var user = UserVar;
        var pass = PassVar;
    }
    //if login do this
    else{
        var user = document.getElementById("username").value;
        var pass = document.getElementById("password").value;
    }

    //clear form data since we return false on submit in html
    document.getElementById("loginForm").reset();

    //creates filter for posts
    var requestFilters = "UserName=" + user + "&Password=" + pass;

    //send filter to php, gets back user
    var returned = requestHandlerGetData("login.php", requestFilters);
    returned.then(
    result => {
        //parse the response text
        jsOBJ = JSON.parse(result);

        //if theres an error alert
        if (jsOBJ["Error"]) {
            alert("Error: " + String(js["Error"]));
        } 
        //reload and verify login
        else {
            location.reload();
            verifyLogin(jsOBJ, user);
        }
    }
)
    return false;
}

//verify login function
function verifyLogin(jsOBJ, UserNameVar){
    //if successful login
    if(jsOBJ["Status"] == 0){
        //create a cookie
        document.cookie = "UserID="+ jsOBJ["Results"]["UserID"] + "&UserName=" + UserNameVar + "; path=/";
        window.location.assign("title_page.html");
    }

    //if failed login
    if(jsOBJ["Status"] == 1){
        alert("Wrong Log-in");
    }
}

//creates a new user
function createUser() {
    //creating reference variables to the users info
	var user = document.getElementById("usernameSign").value;
    var pass = document.getElementById("passwordSign").value;
    
    //clear form data since we return false on submit in html
    document.getElementById("signupForm").reset();

    //creates filter for posts
    var requestFilters = "UserName=" + user + "&Password=" + pass;

    //send filter to php, gets back UserID
    var returned = requestHandlerGetData("createUser.php", requestFilters);
    
    returned.then(
        result => {
            //parse the response text
            jsOBJ = JSON.parse(result);

            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("Error: " + String(jsOBJ["Error"]));
            } 
            //else do stuff with the jsonObject
            else {
                logIn(false,user, pass);
            }
        }
    )
    return false;
}