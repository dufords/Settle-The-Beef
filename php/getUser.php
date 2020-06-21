<?php
    /*
    Parameters:
        UserID: ID for the user
    Returns:
        ["Error"]: Error in finding the user, maybe no parameters were supplied

        ["Results"]
            ["UserName"]: Name of the user
            ["Votes"]: Number of votes made by the user
            ["Comments"]: Number of comments left by the user
    */
	require_once('config.php');
	
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$error = mysqli_connect_error();
	if($error != null){
		$output = ["Error"=> "Unable to connect to database: ".$error];
		exit(json_encode($output));
	}

	$entries = $_POST;

	if(!isset($entries["UserID"])){
        $error = ["Error" => "Incorrect Parameters"];
		exit(json_encode($error));
    }
    $userId = $entries["UserID"];

	$sql = "select a.ArgID, Title, LeftSide, RightSide, UserName, a.UserID, COALESCE(v.Votes,0) as Votes, COALESCE(c.Comments,0) as Comments, a.Date from ".ARGUMENTDB." a inner join ".USERDB." u on u.UserID = a.UserID left join ( SELECT ArgID, count(CommentText) as Comments from ".COMMENTDB." group by ArgID ) c on a.ArgID = c.ArgID left JOIN ( select ArgID, count(Vote) as Votes from ".VOTEDB." group by ArgID ) v on v.ArgID = a.ArgID ".$specific." ".$keyword." ".$order." ".$numPosts;
	$toreturn = [];
	$arr = [];
	$result = mysqli_query($conn, $sql);
	if(is_object($result) && $result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$entry = [];
			$entry["ArgID"] = $row["ArgID"];
			$entry["Title"] = $row["Title"];
			$entry["LeftSide"] = $row["LeftSide"];
			$entry["RightSide"] = $row["RightSide"];
			$entry["UserName"] = $row["UserName"];
			$entry["UserID"] = $row["UserID"];
			$entry["Votes"] = $row["Votes"];
			$entry["Comments"] = $row["Comments"];
			$entry["Date"] = $row["Date"];
			array_push($arr, $entry);
    	}
	}	  else{
		//print "didn't get results";
	}

	$toreturn["Results"] = $arr;
    mysqli_close($conn);
	print json_encode($toreturn);
?>

	
