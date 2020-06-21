<?php
    define('DBHOST', 'localhost');
    define('DBNAME', 'argumentdb');
    define('DBUSER', 'root');
    define('DBPASS', '');

    define('ARGUMENTDB', 'L_Argument');
    define('VOTEDB', 'L_Vote');
    define('USERDB', 'L_User');
    define('COMMENTDB', 'L_Comment');
    define('DOMAIN', 'http://localhost/STB/');
    define('HOMEPAGE', 'homepage.php');
    define('POSTPAGE', 'arg.php');
    define('SUBMITARG', 'submitarg.php');
    define('NEWARG', 'newarg.php');
    define('USERPAGE', 'user.php');
    define('LOGINPAGE', 'login.php');
    define('LOGINVALIDATE', 'logincheck.php');
    define('LOGOUTPAGE', 'logout.php');
    define('COMMENTPAGE', 'comment.php');
    define('VOTEPAGE', 'vote.php');
    define('IDCOOKIE', 'ArgumentCookie');
    define('NAMECOOKIE', 'ArgumentCookieName');
    define('CREATEUSER', 'createuser.php');
    function goHome(){
        header("Refresh:0; url=".DOMAIN.HOMEPAGE);
    }
?>