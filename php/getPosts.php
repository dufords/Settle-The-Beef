<?php
	/*
	Parameters:
		UserID: ID of a user, optional
		ArgID: ID of an argument, optional
		Keyword: text to be found inside the title of an argument, optional
		Order{Top, Date, Comments, Votes}: In what order should the arguments be shown. Optional, default is date
			*Top refers to the most votes in the last 24 hours
		Posts: How many posts should be shown, max. Optional, default is all 
		Skip: Only useful is 'Posts' has been set. How many posts to skip before returning posts
	
	Returns:
		["Error"]: Error in getting votes, possibly wrong parameters given
		
		["Results"][i]:
			["ArgID"]: ID of the argument
			["Title"]: Title of the argument
			["LeftSide"]: Text about the left side of the argument
			["RightSide"]: Text about the right side of the argument
			["UserName"]: User who posted the argument
			["UserID"]: ID of the user who posted
			["Votes"]: Total count of votes
			["LeftCount"]: Total count of votes for the Left Side
			["RightCount"]: Total count of votes for the Right Side
			["Comments"]: Total count of comments
			["Date"]: Date the argument was posted
	*/

	require_once('config.php');
	//print "{\"Error\":1}";
	
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$error = mysqli_connect_error();
	if($error != null){
		$output = ["Error" => "Unable to connect to database: ".$error];
		exit(json_encode($output));
	}

	$entries = $_POST;
    
	if(isset($entries["UserID"])){
		$specific = "Where a.UserID = ".$entries["UserID"];
	}else if(isset($entries["ArgID"])){
		$specific = "Where a.ArgID = ".$entries["ArgID"];
	}
	// else all entries

	if(isset($entries["Keyword"])){
		if(isset($specific)){
			$keyword = " && ";
		}else{
			$keyword = " where ";
		}
		$keyword = $keyword."Title Like '%".$entries["Keyword"]."%' ";
	}
	
	$order = "Order by";
	if(isset($entries["Order"])){
		if($entries["Order"] == 'Date'){
			$order = $order." Date DESC";
		}else if($entries["Order"] == 'Comments'){
			$order = $order." Comments DESC";
		}else if($entries["Order"] == 'Votes'){
			$order = $order." Votes DESC";
		}else if($entries["Order"] == 'Top'){
			if(isset($specific) || isset($keyword)){
				$order = " && ";
			}else{
				$order = " WHERE ";
			}
			$order = $order." a.date >= NOW() - INTERVAL 1 DAY";
		}
	}else{
		//default is by date
		$order = $order." a.Date DESC";
	}

	if(isset($entries["Posts"])){
		$numPosts = "Limit ";
		$posts = $entries["Posts"];

		if(isset($entries["Skip"])){
			$skip = $entries["Skip"];
			$numPosts = $numPosts.$skip.", ";
		}
		$numPosts = $numPosts." ".$posts;
	}
	
	if(!isset($specific)){
		$specific = "";
	}
	if(!isset($order)){
		$order = "";
	}
	if(!isset($numPosts)){
		$numPosts = "";
	}
	if(!isset($keyword)){
		$keyword = "";
	}

	$sql = "select a.ArgID, Title, LeftSide, RightSide, UserName, a.UserID, COALESCE(c.Comments,0) as Comments, COALESCE(v.Votes,0) as Votes, COALESCE(v.LeftCount,0) as LeftCount, COALESCE(v.RightCount,0) as RightCount, a.Date from ".ARGUMENTDB." a inner join ".USERDB." u on u.UserID = a.UserID left join ( SELECT ArgID, count(CommentText) as Comments from ".COMMENTDB." group by ArgID ) c on a.ArgID = c.ArgID left JOIN ( select ArgID, count(Vote) as Votes, count(case when Vote = 0 then 1 end) as LeftCount, count(case when Vote = 1 then 1 end) as RightCount from ".VOTEDB." group by ArgID ) v on v.ArgID = a.ArgID ".$specific." ".$keyword." ".$order." ".$numPosts;
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
			$entry["LeftCount"] = $row["LeftCount"];
			$entry["RightCount"] = $row["RightCount"];
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

	
