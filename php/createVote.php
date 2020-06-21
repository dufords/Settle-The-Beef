<?php
    /*
    Parameters:
        UserID: ID about the user that posted the argument, required
        ArgID: The argument that is being voted on, required
        Vote: 0,1, voting for left or right side of the argument

    Return:
        ["Error"]: Error, maybe couldn't connect to the server 

        ["Results"]
            ["Vote"]: -1,0,1 the side that was voted on before, -1 if there was no vote before
    */
    require_once('config.php');

    $entries = $_POST;
    //$entries = ["Vote"=>3, "ArgID"=>3, "UserID"=>3];
    if(
        !isset($entries["Vote"]) ||
        !isset($entries["ArgID"]) ||
        !isset($entries["UserID"])
    ){
        $error = ["Error"=>"Parameters not set"];
        exit(json_encode($error));
    }
    //echo $entries["Vote"]." ";
    //echo $entries["ArgID"]." ";
    //echo $entries["UserID"]." ";
    $db_table = VOTEDB;
    $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $toreturn = [];
    $arr = [];
    $error = mysqli_connect_error();
    if($error != null){
        $output = ["Error"=>"Unable to connect to database: ".$error];
        mysqli_close($conn);
        exit(json_encode($output));
    }else{
        $arg = $entries["ArgID"];
        $voteSide = $entries["Vote"];
        $userId = $entries["UserID"];
        $sql = "SELECT * from ".VOTEDB." WHERE UserID = ".$userId." AND ArgID = ".$arg;
        $result = mysqli_query($conn, $sql);
        if(is_object($result) && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $arr["Vote"] = $row["Vote"];
            //Duplicate
            $sql = "UPDATE ".VOTEDB." SET Vote = ".$voteSide." WHERE UserId = ".$userId." AND ArgId = ".$arg.";";
            $result = mysqli_query($conn, $sql);
        }else{
            //New Vote
            $sql = "INSERT INTO ".$db_table." (ArgId, UserId, Vote)
            VALUES ('".$arg."', '".$userId."', '".$voteSide."')";
            if(!mysqli_query($conn, $sql)){
                $toreturn = ["Error"=> $sql." ".mysqli_error($conn)];
                mysqli_close($conn);
                exit(json_encode($toreturn));
            }
            $arr["Vote"] = -1;
            //$arr["Vote"] = $row["Vote"];
        }
    }
    $toreturn["Results"] = $arr;
    mysqli_close($conn);
    exit(json_encode($toreturn));
?>