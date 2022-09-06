<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}


//REQUIRE DATABASE AND SET OBJECT ---------------->>>
require __DIR__.'/db.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
//REQUIRE DATABASE AND SET OBJECT ----------------<<<

// GET DATA FORM REQUEST ------------------------->>>
$data = json_decode(file_get_contents("php://input"));
$returnData = [];
// GET DATA FORM REQUEST -------------------------<<<

//AUTHENTICATE REQUEST METHOD -------------------->>>
if($_SERVER["REQUEST_METHOD"] != "POST"){
    $returnData = msg(0,404,'Page Not Found!'); }
//AUTHENTICATE REQUEST METHOD --------------------<<<

//CHECKING EMPTY FIELDS -------------------------->>>
elseif(
       !isset($data->email) 
    || !isset($data->password) 
    || empty(trim($data->email))
    || empty(trim($data->password))
       ){
        $returnData = msg(0,422,'Please Fill in all Required Fields!');
       }
//CHECKING EMPTY FIELDS --------------------------<<<


else {
     $email = trim($data->email);
     $password = trim($data->password);

    //VALIDATING EMAIL --------------------------->>>
     if(!filter_var($email, FILTER_VALIDATE_EMAIL)){$returnData = msg(0,422,'Invalid Email Address!');}
    //VALIDATING EMAIL ---------------------------<<<
   
    //VALIDATING INPUT LENGHT -------------------->>>
    elseif(strlen($password) < 8){$returnData = msg(0,422,'Your password must be at least 8 characters long!');}
    elseif(strlen($email) < 2){$returnData = msg(0,422,'Your email must be at least 3 characters long!');}
    //VALIDATING INPUT LENGHT --------------------<<<

    else {
        try {
            //CHECK IF EMAIL EXISTS -------------->>>
            $check_email = "SELECT `email` FROM `users` WHERE `email`=:email";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $check_email_stmt->execute();
            if ($check_email_stmt->rowCount()){ $returnData = msg(0,422, 'This email already exist! <a href="signin">SignIn Insread?</a>'); }
            //CHECK IF EMAIL EXISTS --------------<<<
             


            else {
                //PREPARING SQL STMT ------------->>>
                $insert_query = "INSERT INTO `users`(`email`,`password`) VALUES(:email,:password)";
                $insert_stmt = $conn->prepare($insert_query);
                //PREPARING SQL STMT -------------<<<

                //BINDING DATA ------------------->>>
                $insert_stmt->bindValue(':email', htmlspecialchars(strip_tags($email)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT),PDO::PARAM_STR);
                //BINDING DATA -------------------<<<

                //INSERTING DATA ----------------->>>
                $insert_stmt->execute();
                $returnData = msg(1,201, '<p style="color:#10E32A">Your Registration Was successful!, kindly signin to continue</p>');
                //INSERTING DATA -----------------<<<
            }

        }
        //HANDLING PHP DATA OBJECTS EXCEPTION----->>>
        catch(PDOException $e){$returnData = msg(0,500,$e->getMessage()); }
        //HANDLING PHP DATA OBJECTS EXCEPTION-----<<<
        }
}

//RESPONSE --------------------------------------->>>
echo json_encode($returnData);
//RESPONSE ---------------------------------------<<<