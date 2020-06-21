//delete current table entries
function clearTable(tableVar) {
    //deletes all rows currently in the table
    var tableLength = tableVar.rows.length;
    for (var i = 0; i < tableLength; i++) {
        tableVar.deleteRow(0);
    }
}

//display lists on homepage by filter
function populateTable(filter) {
    //creating a reference variable to the tables body
    var table = document.getElementById("threadbody"); 

    //delete table entries
    clearTable(table);

    //creates filter for posts
    var requestFilters = filter + "&Posts=10";

    //send filter to php, gets back posts
    var returned = requestHandlerGetData("getPosts.php", requestFilters);
    returned.then(
        result => {
            //parse the response text
            jsOBJ = JSON.parse(result);

            //if theres an error alert
            if (jsOBJ["Error"]) {
                alert("Error: " + String(jsOBJ["Error"]));
            } 
            //insert posts into table
            else {
                insertTableRows(jsOBJ, table);
            }
        }
    )
}

//inserts posts into table
function insertTableRows (jsOBJ, table) {
    //length of result
    total = Object.keys(jsOBJ["Results"]).length;

    //creating a row for each post and inserting
    for (var i = 0; i < total; i++){
		var rowInserted = table.insertRow(i);													//creating a new row

		//creating cells to hold the posts information
		var cell1 = rowInserted.insertCell(0);
		var cell2 = rowInserted.insertCell(1);
		var cell3 = rowInserted.insertCell(2);
        var cell4 = rowInserted.insertCell(3);
        var cell5 = rowInserted.insertCell(4);


        cell1.innerHTML = "<a href=\"http://localhost/STB/argument_page.html?ArgID=" + jsOBJ["Results"][i]["ArgID"]+ "\">" + jsOBJ["Results"][i]["Title"] + "</a>";
		cell2.innerHTML = "<a href=\"http://localhost/STB/account_page.html?UserID=" + jsOBJ["Results"][i]["UserID"] + "\">" + jsOBJ["Results"][i]["UserName"] + "</a>";
		cell3.innerHTML = String(jsOBJ["Results"][i]["Comments"]);
        cell4.innerHTML = String(jsOBJ["Results"][i]["Votes"]);
        cell5.innerHTML = String(jsOBJ["Results"][i]["Date"]);
	}
}

//search bar function
function search() {
    //referencing searchbar by element
    var searchBar = document.getElementById("search-bar").value;

    //creating filter for search
    var filter = "Keyword=" + searchBar;

    //populating table with related posts
    populateTable(filter);
}