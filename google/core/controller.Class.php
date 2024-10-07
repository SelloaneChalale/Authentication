<?php

class Connect extends PDO{
    public function __construct(){
        parent::__construct("mysql:host=localhost;dbname=authentication", 'root', '',
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}

class Controller {
    // Function to print data
    function printData($id) {
        $db = new Connect;
        $user = $db->prepare("SELECT * FROM users WHERE id = :id");
        $user->execute([
            ':id' => $id
        ]);

        // Fetch user information
        $userInfo = $user->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists
        if ($userInfo) {
            // Build HTML content for displaying user information
            // $content = '
            // <h2>Welcome, ' . htmlspecialchars($userInfo['username'], ENT_QUOTES, 'UTF-8') . '!</h2>
            // ';
        } else {
            // Handle case when user is not found
            $content = '
            <h2>User not found</h2>
            ';
        }

        // return $content;
    }


/////////////check if user is logged////
function checkUserStatus($id, $sess){
    $db = new Connect;
    $user = $db->prepare("SELECT id from users WHERE id = :id AND session = :session");
    $user->execute([
        ':id' => intval($id),
        ':session' => $sess
    ]);

    // Fetch the result as an associative array
    $userInfo = $user->fetch(PDO::FETCH_ASSOC);

    if ($userInfo === false || $userInfo["id"] === null) {
        return false; // User doesn't exist
    } else {
        return true; // User exists
    }
}



    /////////////generate characters
function generateCode($length){
    $chars = "012345678910111213141516171819202abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $code = "";
    $clean = strlen($chars) - 1;
    while(strlen($code) < $length){
        $code .= $chars[mt_rand(0, $clean)];
    }
    return $code;
}

    ////insert data into DB
    function insertData($data){
        $db = new Connect;
        $checkUser = $db->prepare("SELECT * FROM users WHERE email =:email");
        $checkUser->execute(['email'=> $data["email"]]);
        $info = $checkUser->fetch(PDO::FETCH_ASSOC);
        

        if(!$info["id"]){
        $session = $this -> generateCode(10);
        $insertUser = $db -> prepare("INSERT INTO users(username,email,password,session) VALUES(:fname, :email, :password, :session)");
        $insertUser -> execute([
            ':fname' => $data["givenName"],
            // ':lname' => $data["familyName"],
            // ':avatar' => $data["avatar"],
            ':email' => $data["email"],
            ':password' => $this->generateCode(5),
            ':session' => $session,
            // ':id' => $this->generateCode(2),
        ]);
        if($insertUser){
            setcookie("id", $db->lastInsertId(), time()+60*60*24*30, "/", NULL);
            setcookie("sess", $session, time()+60*60*24*30, "/", NULL);
            header('Location: home.php');
        }else{
            return "ERROR insering user!";
        }}else{
            setcookie("id", $info["id"], time()+60*60*24*30, "/", NULL);
            setcookie("sess", $info["session"], time()+60*60*24*30, "/", NULL);
            setcookie("username", $info["username"], time()+60*60*24*30, "/", NULL);
            header('Location: home.php');
            $_SESSION['email'] = $data["email"];
            $_SESSION['id'] = $data["id"];
            exit();
        
        }
    }
   
}
?>