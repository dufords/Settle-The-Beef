<?php
    /*
    Parameters:
        ArgID: Returns counts of votes associated with the argument
    Returns:
        ["Results"]
            ["LeftCount"]: Count of votes for the left side
            ["RightCount"]: Count of votes for the right side
            
    Parameters:
        UserID: Returns The arguments that a user voted on
    Returns:
        ["Results"][i]:
            ["ArgID"]: ID of the argument that was voted on
            ["Title"]: Title of the argument
            ["LeftSide"]: Text about the left side of the argument
            ["RightSide"]: Text about the right side of the argument
            ["Side"]: Which side the user voted on, 0 means left, 1 means right


    Parameters:
        ArgID: Returns counts of votes associated with the argument
        UserID: Returns The arguments that a user voted on
    Returns:
        ["Error"]: Error in getting votes, possibly wrong parameters given

        ["Results"]
            ["Side"]: The side that the selected user voted on the selected argument, 0 means left, 1 means right

            
	*Only one method can be used at a time*

    **footnote: ["Results"][i] means that there are multiple responses that can be iterated through**

    */

	require_once('config.php');
	//print "{\"Error\":1}";
	
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$error = mysqli_connect_error();
	if($error != null){
		$output = "{\"Error\": \"Unable to connect to database: ".$error."\"}";
		exit($output);
	}

	$entries = $_POST;

    $toreturn = [];
    $arr = [];
    if(isset($entries["ArgID"]) && isset($entries["UserID"])){
        $userid = $entries["UserID"]; 
        $argid = $entries["ArgID"]; 
        $sql = "select ArgId, Vote as Side from ".VOTEDB." where UserId = ".$userid." && ArgId = ".$argid;
        $result = mysqli_query($conn, $sql);
	    if(is_object($result) && $result->num_rows > 0){
		    while($row = $result->fetch_assoc()){
			    $entry = [];
    			$entry["Side"] = $row["Side"];
			    array_push($arr, $entry);
    	    }
    	}
    } else if(isset($entries["UserID"])){
        //show all entires user has voted on?
        $id = $entries["UserID"];
        
	    $sql = "select v.ArgID, Title, LeftSide, RightSide, Vote as Side from ".VOTEDB." v inner join ".ARGUMENTDB." a on a.ArgID = v.ArgId where v.UserId = ".$id;
	    $result = mysqli_query($conn, $sql);
	    if(is_object($result) && $result->num_rows > 0){
		    while($row = $result->fetch_assoc()){
			    $entry = [];
    			$entry["ArgID"] = $row["ArgID"];
    			$entry["Title"] = $row["Title"];
	    		$entry["LeftSide"] = $row["LeftSide"];
		    	$entry["RightSide"] = $row["RightSide"];
			    $entry["Side"] = $row["Side"];
			    array_push($arr, $entry);
    	    }
    	}
    }
    else if(isset($entries["ArgID"])){
        $id = $entries["ArgID"];
        $arr = [];
	    $sql = "select count(case when vote = 0 then 1 end) as LeftCount, count(case when vote = 1 then 1 end) as RightCount from ".VOTEDB." where ArgId =".$id;
	    $result = mysqli_query($conn, $sql);
	    if(is_object($result) && $result->num_rows > 0){
		    while($row = $result->fetch_assoc()){
			    $entry = [];
                $entry["LeftCount"] = $row["LeftCount"];
                $entry["RightCount"] = $row["RightCount"];
                array_push($arr, $entry);
    	    }
        }
    }else{
        $error = ["Error"=> "Incorrect parameters given"];
        print json_encode($error);
        exit(0);
    }

	$toreturn["Results"] = $arr;
	
	print json_encode($toreturn);
?>

	
