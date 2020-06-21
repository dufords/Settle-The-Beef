/*
script to handle nav bar functionality
*/
//if cookie isnt empty, were logged in, change the button to logout
if(document.cookie !== ""){
    //getting User and UserID from cookies
	var cookieArray = document.cookie.split("&");
	var UserID = cookieArray[0].substr(cookieArray[0].indexOf("=")+1);
	var User = cookieArray[1].substr(cookieArray[1].indexOf("=")+1);
    //referencing elements in the html
    var logBtn = document.getElementById("logBtn");
    var acctBtn = document.getElementById("acctBtn");
    //sends user to their account page
    acctBtn.innerHTML = "<a href=\"http://localhost/STB/account_page.html?UserID=" + UserID + "\">" + User + "</a>";
    //logs user out and clears cookies
    logBtn.innerHTML = "<a href=\"title_page.html\"; onclick=\"deleteCookieLogout();\">Logout</a>";
}
//when user isnt signed in
else{
    //referencing elements in html
    var argBtn = document.getElementById("argBtn");
    var acctBtn = document.getElementById("acctBtn");
    //directing users to login/signup page
    argBtn.innerHTML = "<a href=\"http://localhost/STB/login_page.html\"; onclick=\"alertUser();\">Create Argument</a>";
    acctBtn.innerHTML = "<a href=\"http://localhost/STB/login_page.html\"; onclick=\"alertUser();\">My Account</a>";
}

//function to alert user that they need to log in
function alertUser() {
    alert("You need to log in first!");
}

//deletes cookies
function deleteCookieLogout () {
    //delete the cookie (make it expired)
    document.cookie = "UserID= ; expires = Thu, 01 Jan 1970 00:00:00 GMT; path=/"; 
}
