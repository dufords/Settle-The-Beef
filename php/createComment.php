<?php
    /*
    Parameters:
        UserID: ID of the user that posted the comment, required
        CommentText: Text for the comment, required
        ArgID: ID of the argument which is being commented on, required

    Returns:
        ["Error"]: Something went wrong, maybe wrong parameters given

        returns nothing on success
    */
    require_once('config.php');
    
	$entries = $_POST;
	
	if(!isset($entries["UserID"])||!isset($entries["CommentText"])||!isset($entries["ArgID"])){
		$error = ["Error"=> "Incorrect parameters"];
		exit(json_encode($error));
	}
    $userId = $entries["UserID"];
    $arg = $entries["ArgID"];
    $comment = addslashes($entries["CommentText"]);
    $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);

	$error = mysqli_connect_error();
    if($error != null){
        $error = ["Error"=>"Unable to connect to database: ".$error];
        mysqli_close($conn);
        exit(json_encode($output));
    }else{
		if($comment!=""){              
            $sql = "INSERT INTO ".COMMENTDB."(`UserID`, `ArgID`, `CommentText`, `date`) VALUES (".$userId.",".$arg.",'".$comment."',now())";
            if(!mysqli_query($conn, $sql)){
				$error = [ "Error" => $sql." ".mysqli_error($conn)];
				mysqli_close($conn);
				exit(json_encode($error));
            }
        }else{
			$error = ["Error"=>"No comment"];
			mysqli_close($conn);
			exit(json_encode($error));
        }
		mysqli_close($conn);
    }
?>