//delete current table entries
function clearTable(tableVar) {
    //deletes all rows currently in the table
    var tableLength = tableVar.rows.length;
    for (var i = 0; i < tableLength; i++) {
        tableVar.deleteRow(0);
    }
}

//function to load the argument page
function loadArgumentPage() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var Arg = urlParams.get('ArgID');

    loadArgument(Arg);
    loadComments(Arg);
    loadVotes(Arg);
}

/*
*
* functions for updating arguments
*
*/
//loads the selected argument
function loadArgument(ArgID) {
    //creates filter for posts
    var requestFilters = "ArgID=" + ArgID;

    //send filter to php, gets back posts
    var returned = requestHandlerGetData("getPosts.php", requestFilters);
    returned.then(
        result => {
            //parse the response text
            jsOBJ = JSON.parse(result);
            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("Error: " + String(js["Error"]));
            } 
            //insert posts into table
            else {
                populateArg(jsOBJ);
            }
        }
    )
}

//loads all argument information onto the page
function populateArg(jsOBJ) {
	//creating variables to put argument post information in
	var title = document.getElementById("argument-title");
	var hostUser = document.getElementById("host-user");
	var date = document.getElementById("date");
	var leftArg = document.getElementById("argument-left");
	var rightArg = document.getElementById("argument-right");
    var commentSection = document.getElementById("comment-section");

    //setting the values of the above variables
    title.innerHTML = String(jsOBJ["Results"][0]["Title"]);
    //hostUser.innerHTML = "<a href=\"http://localhost/STB/account_page.html?UserID=" + jsOBJ["Results"][0]["UserID"] + "\">" + "Posted by: " +jsOBJ["Results"][0]["UserName"] + "</a>";
    hostUser.innerHTML = "<a href=\"http://localhost/STB/account_page.html?UserID=" + jsOBJ["Results"][0]["UserID"] + "\"style=\"color: #fffff0\"" + ">" + "Posted by: " +jsOBJ["Results"][0]["UserName"] + "</a>";
    date.innerHTML = "Date created: " + jsOBJ["Results"][0]["Date"];
    leftArg.innerHTML = String(jsOBJ["Results"][0]["LeftSide"]);
    rightArg.innerHTML = String(jsOBJ["Results"][0]["RightSide"]);
}

/*
*
* functions for updating comments
*
*/
//loads the comments
function loadComments(ArgID) {
    //creating a reference variable to the tables body
    var table = document.getElementById("comment-section"); 

    //delete table entries
    clearTable(table);

    //creates filter for posts
    var requestFilters = "ArgID=" + ArgID;

    //send filter to php, gets back posts
    var returned = requestHandlerGetData("getComments.php", requestFilters);
    returned.then(
        result => {
            //parse the response text
            jsOBJ = JSON.parse(result);

            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("Error: " + String(js["Error"]));
            } 
            //insert comments into table
            else {
                insertCommentRows(jsOBJ, table);
            }
        }
    )
}

//inserts rows in comments box
function insertCommentRows (jsOBJ, table) {
    var total = Object.keys(jsOBJ["Results"]).length;

    for (var i = 0; i < total; i++){
        var rowInserted = table.insertRow(i);                                                   //creating a new row

        //creating cells to hold the posts information
        var cell1 = rowInserted.insertCell(0);
        var cell2 = rowInserted.insertCell(1);


        
        cell1.innerHTML = "<a href=\"http://localhost/STB/account_page.html?UserID=" + jsOBJ["Results"][i]["UserID"] + "\">" + jsOBJ["Results"][i]["UserName"] + "</a>";
        cell2.innerHTML = String(jsOBJ["Results"][i]["CommentText"]);
    }
}

//creating a new comment
function createNewComment() {
    //getting ArgID from url
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var ArgID = urlParams.get('ArgID');
    //getting UserID from cookies
    var cookieArray = document.cookie.split("&");
    var UserID = cookieArray[0].substr(cookieArray[0].indexOf("=")+1);

    //referencing comment box for new comment value
    var newComment = document.getElementById("comment").value;

    //creates filter for posts
    var requestFilters = "UserID=" + UserID + "&CommentText=" + newComment + "&ArgID=" + ArgID;

    //send filter to php, gets back comments
    var returned = requestHandlerGetData("createComment.php", requestFilters);
    returned.then(
        result => {
            //parse the response text
            if (result !== ""){
                jsOBJ = JSON.parse(result);
            }

            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("You need to login to comment");
            } 
            //load comments for arg with ArgID
            else {
                document.getElementById("comment").value = "";
                loadComments(ArgID);
            }
        }
    )

    return false;
}

/*
*
* functions for updating votes
*
*/
//loads the votes
function loadVotes(ArgID) {
    //creates filter for posts
    var requestFilters = "ArgID=" + ArgID;

    //sends filter to php, gets back votes
    var returned = requestHandlerGetData("getVotes.php", requestFilters);
    returned.then(
        result => {
            //parse the response text
            var jsOBJ = JSON.parse(result);
            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("Error: " + String(jsOBJ["Error"]));
            } 
            //insert votes into their places
            else {
                populateVotes(jsOBJ);
            }
        }
    )
}

//loads vote values
function populateVotes(jsOBJ){
    //creating a reference variable to the vote elements
    var leftVotes = document.getElementById("left-votes");
    var rightVotes = document.getElementById("right-votes");

    //assign values to variables above
    leftVotes.innerHTML = String(jsOBJ["Results"][0]["LeftCount"]);
    rightVotes.innerHTML = String(jsOBJ["Results"][0]["RightCount"]);
}

//function called when a user votes
function vote(side) {
    //getting ArgID from url
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var ArgID = urlParams.get('ArgID');
    //getting UserID from cookies
    var cookieArray = document.cookie.split("&");
    var UserID = cookieArray[0].substr(cookieArray[0].indexOf("=")+1);

    //send filter to php, gets back posts
    var requestFilters = "UserID=" + UserID + "&ArgID=" + ArgID + "&Vote=" + side;

    //creates filter for posts
    var returned = requestHandlerGetData("createVote.php", requestFilters);
    returned.then(
        result => {
            jsOBJ = JSON.parse(result);
            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("You need to login to vote");
            } 
            //load the votes
            else {
                loadVotes(ArgID);
            }
        }
    )
}

//function called when a user votes left
function voteLeft() {
    vote(0);
}

//function called when a user votes right
function voteRight() {
    vote(1);
}