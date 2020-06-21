//delete current table entries
function clearTable(tableVar) {
    //deletes all rows currently in the table
    var tableLength = tableVar.rows.length;
    for (var i = 0; i < tableLength; i++) {
        tableVar.deleteRow(0);
    }
}

//function called to populate tables
function loadUser() {
    //getting UserID from url
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	var User = urlParams.get('UserID');

    //populating tables
	populateUserArgs(User);
	populateUserComments(User);
}

//display all users arguments
function populateUserArgs(UserID) {
    //creating a reference variable to the tables body
    var table = document.getElementById("argsBody"); 

    //delete table entries
    clearTable(table);

    //creates filter for posts
    var requestFilters = "UserID=" + UserID;

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
            //insert username into display and posts into table
            else {
                if (Object.keys(jsOBJ["Results"]).length == 0) {
                    var userDisplay = document.getElementById("username-display");
                    var UserID = cookieArray[0].substr(cookieArray[0].indexOf("=")+1);
                    var UserName = cookieArray[1].substr(cookieArray[1].indexOf("=")+1);
                    userDisplay.innerHTML = UserName + "'s Account Page";
                }
                else {
                    var userDisplay = document.getElementById("username-display");
                    userDisplay.innerHTML = String(jsOBJ["Results"][0]["UserName"] + "'s Account Page");
                }

                insertArgRows(jsOBJ, table);
            }
        }
    )
}

//inserts rows in argument table
function insertArgRows (jsOBJ, table) {
    //length of result
    var total = Object.keys(jsOBJ["Results"]).length;

    //creating a row for each post and inserting
    for (var i = 0; i < total; i++){
		var rowInserted = table.insertRow(i);													//creating a new row

		//creating cells to hold the posts information
		var cell1 = rowInserted.insertCell(0);
		var cell2 = rowInserted.insertCell(1);
		var cell3 = rowInserted.insertCell(2);
        var cell4 = rowInserted.insertCell(3);


        cell1.innerHTML = "<a href=\"http://localhost/STB/argument_page.html?ArgID=" + jsOBJ["Results"][i]["ArgID"]+ "\">" + jsOBJ["Results"][i]["Title"] + "</a>";
		cell2.innerHTML = String(jsOBJ["Results"][i]["Comments"]);
        cell3.innerHTML = String(jsOBJ["Results"][i]["Votes"]);
        cell4.innerHTML = String(jsOBJ["Results"][i]["Date"]);
	}
}

//display all users arguments
function populateUserComments(UserID) {
    //creating a reference variable to the tables body
    var table = document.getElementById("commentsBody"); 

    //delete table entries
    clearTable(table);

    //creates filter for posts
    var requestFilters = "UserID=" + UserID;

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
		var rowInserted = table.insertRow(i);													//creating a new row

		//creating cells to hold the posts information
		var cell1 = rowInserted.insertCell(0);
		var cell2 = rowInserted.insertCell(1);
		var cell3 = rowInserted.insertCell(2);

		cell1.innerHTML = String(jsOBJ["Results"][i]["CommentText"]);
        cell2.innerHTML = "<a href=\"http://localhost/STB/argument_page.html?ArgID=" + jsOBJ["Results"][i]["ArgID"]+ "\">" + jsOBJ["Results"][i]["Title"] + "</a>";
        cell3.innerHTML = String(jsOBJ["Results"][i]["Date"]);
	}
}