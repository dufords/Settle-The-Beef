<?php
	/*
	Parameters:
		UserID: ID of the user
	Returns:
        ["Error"]: Error in getting comments, possibly wrong parameters given

		["Results"][i]:
			["ArgID"]: ID of the argument the comment was posted on 
			["Title"]: Title of the argument 
	    	["CommentText"]: The comment text
			["Date"]: Date the comment was posted
			

	Parameters:
		ArgID: ID of the argument
	Returns:
        ["Error"]: Error in getting comments, possibly wrong parameters given

		["Results"][i]:
			["UserID"]: ID of the user that left the comment 
    		["UserName"]: Name of the user that left the comment
	    	["CommentText"]: The comment text
			["Date"]: Date the comment was posted

	*Only one method can be used at a time*

    **footnote: ["Results"][i] means that there are multiple responses that can be iterated through**

	*/


	require_once('config.php');
	//print "{\"Error\":1}";
	
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$error = mysqli_connect_error();
	if($error != null){
		$error = ["Error"=> "Unable to connect to database."];
        print json_encode($error);
        exit(0);
	}

	$entries = $_POST;

    $toreturn = [];
    $arr = [];
    if(isset($entries["UserID"])){
        $id = $entries["UserID"];
        
	    $sql = "select c.ArgID, Title, CommentText, c.Date from ".COMMENTDB." c inner join ".ARGUMENTDB." a on a.ArgID = c.ArgID where c.userid = ".$id." order by c.date desc";
	    $result = mysqli_query($conn, $sql);
	    if(is_object($result) && $result->num_rows > 0){
		    while($row = $result->fetch_assoc()){
			    $entry = [];
    			$entry["ArgID"] = $row["ArgID"];
    			$entry["Title"] = $row["Title"];
	    		$entry["CommentText"] = $row["CommentText"];
		    	$entry["Date"] = $row["Date"];
			    array_push($arr, $entry);
    	    }
    	}
    }
    else if(isset($entries["ArgID"])){
        $id = $entries["ArgID"];
        $arr = [];
	    $sql = "select c.UserID, UserName, CommentText, c.Date from l_comment c inner join l_user u on u.UserID = c.UserID where c.ArgID = ".$id;
	    $result = mysqli_query($conn, $sql);
	    if(is_object($result) && $result->num_rows > 0){
		    while($row = $result->fetch_assoc()){
			    $entry = [];
    			$entry["UserID"] = $row["UserID"];
    			$entry["UserName"] = $row["UserName"];
	    		$entry["CommentText"] = $row["CommentText"];
		    	$entry["Date"] = $row["Date"];
			    array_push($arr, $entry);
    	    }
        }
    }else{
        $error = ["Error"=> "Incorrect parameters given"];
		print json_encode($error);
		mysqli_close($conn);
        exit(0);
    }

	$toreturn["Results"] = $arr;
	mysqli_close($conn);
	print json_encode($toreturn);
?>

	
