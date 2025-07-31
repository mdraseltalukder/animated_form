
<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'connection/src/PHPMailer.php';
require 'connection/src/SMTP.php';
require 'connection/src/Exception.php';



  
class Connection extends mysqli{

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "modern_form";

    public function __construct(){
        parent::__construct($this->servername, $this->username, $this->password, $this->dbname);
        if($this->connect_error){
            $_SESSION['error'] = "Connection failed: " . $this->connect_error;
            die("Connection failed: " . $this->connect_error);
        }
    }

public function register($fName,$lName, $email, $password, $confirmPassword){
   if(empty($fName)){
       $_SESSION['error'] = "First Name is required";
     return false;
   }
   if(empty($lName)){
       $_SESSION['error'] = "Last Name is required";
     return false;
   }
   if(empty($email)){
       $_SESSION['error'] = "Email is required";
            return false;
   }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $_SESSION['error'] = "Invalid email format";
            return false;
   }
   if(empty($password)){
       $_SESSION['error'] = "Password is required";
            return false;
   }elseif(strlen($password) < 8){
       $_SESSION['error'] = "Password must be at least 8 characters long";
            return false;
   }
   if(empty($confirmPassword)){
       $_SESSION['error'] = "Confirm Password is required";
            return false;
   }elseif($password !== $confirmPassword){
       $_SESSION['error'] = "Passwords do not match";
            return false;
   }

$token= bin2hex(random_bytes(4));
$pass= password_hash($password, PASSWORD_DEFAULT);

  $select= "SELECT * FROM users WHERE email = '$email'";
  $result = $this->query($select);
  if($result->num_rows >0){
      $_SESSION['error'] = "Email already exists";
      return false;
  }
  $insert= "INSERT INTO users (fName, lName, email, password,token,active) VALUES ('$fName', '$lName', '$email', '$pass','$token',0)";
  $result = $this->query($insert);
  if($result){
      
      $selectQuery= "SELECT * FROM users WHERE email = '$email'";
      $selectResult = $this->query($selectQuery);
      $user = $selectResult->fetch_assoc();
if($user && $user['id']){
    $_SESSION['user'] = $user;
    $_SESSION['user_id'] = $user['id'];

      $this->sendVerificationEmail($user['email'], $user['token'], $user['id']);
      header("Location: activate.php?user_id={$user['id']}&token={$token}");
      exit();
  }else{
      $_SESSION['error'] = "User not found";
      return false;

  }
  }

}

public function sendVerificationEmail($email, $token, $id){
$mail = new PHPMailer(true);

    try {
        // SMTP Server Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mdrasel551219@gmail.com';       // তোমার Gmail
        $mail->Password   = 'wcpu pwdn qbat duwh';           // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Recipient
        $mail->setFrom('mdrasel551219@gmail.com', ); // sender (Gmail)
        $mail->addAddress($email);                            // যাকে পাঠাবে

        // Content
        $mail->isHTML(true);
     $mail->Subject = "Activate Your Account";

$mail->Body = "
<html>
  <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; color: #333;'>
    <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>

      <h2 style='color: #2c3e50;'>Welcome to Our Platform!</h2>
      <p>Hi there,</p>
      <p>Thank you for registering. To complete your registration and activate your account, please use the activation code below or click the button to activate:</p>

      <p style='margin-top: 30px; margin-bottom: 10px; font-weight: bold;'>Your Activation Code:</p>
      <code style='padding: 15px; font-size: 18px; font-family: monospace; border: 1px solid #ddd; border-radius: 5px; user-select: all; color: #000;'>
        {$token}
      </code>

      <p style='margin-top: 30px;'>Or click the button below to activate your account:</p>

      <div style='text-align: center; margin: 30px 0;'>
        <a href='http://{$_SERVER['SERVER_NAME']}/dashboard/Projects/Udemi/loginForm/modernForm/activate.php?token={$token}&user_id={$id}'
           style='background-color: #28a745; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-weight: bold; display: inline-block;'>
          Activate My Account
        </a>
      </div>

      <p>If the button doesn't work, copy and paste this link into your browser:</p>
      <p style='word-break: break-all;'>
        <a href='http://{$_SERVER['SERVER_NAME']}/dashboard/Projects/Udemi/loginForm/modernForm/activate.php?token={$token}&user_id={$id}'>
          http://{$_SERVER['SERVER_NAME']}/dashboard/Projects/Udemi/loginForm/modernForm/activate.php?token={$token}&user_id={$id}
        </a>
      </p>

      <hr style='margin-top: 40px;'>
      <p style='font-size: 12px; color: #888;'>If you didn’t register for this account, please ignore this email.</p>
    </div>
  </body>
</html>
";


        $mail->send();
        // $_SESSION['success'] = 'Message has been sent';

    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return;
    }
    }

public function activate($id,$token){
    $update="UPDATE users SET active = 1 WHERE id = {$id} AND token = '{$token}'";
    $result = $this->query($update);
    if($result){
    $user=$this->getUser($id,$token);
    $_SESSION['user']=$user;

     header ("Location:index.php ");
    exit();

    }
   
} 
public function getUser($id,$token){
    $select="SELECT * FROM users WHERE id = {$id} AND token = '{$token}' AND active = 1";
    $result = $this->query($select);
    return $result->fetch_assoc();


}

public function signIn($email, $password, $rem){
    $select = "SELECT * FROM users WHERE email = '{$email}' AND active = 1";
    $result = $this->query($select);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;

            if ($rem === 1) {
                setcookie('user', json_encode($user), time() + 60 * 60 * 24 * 30, '/');
            }

            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
        }
    } else {
        $_SESSION['error'] = "Account not found or not activated.";
    }

    // যদি কোনো কারনে সফল না হয়
    header("Location: index.php");
    exit();
}


public function forgot($email){

$token = bin2hex(random_bytes(4));
$exp = date('Y-m-d H:i:s', strtotime('+15 minutes'));
$select= "SELECT * FROM users WHERE email = '{$email}'  AND active = 1";
$result= $this->query($select);
if($result->num_rows >0){
$user= $result->fetch_assoc();
$insert="INSERT INTO reset_password(user_id, token,expire) VALUES ('{$user['id']}', '{$token}','{$exp}')";
$run= $this->query($insert);
if($run){
$this->sendCode($user['id'], $user['token'], $user['email'], $user['fName']);
$_SESSION['success'] = "Check your email to reset your password";
}else{
  $_SESSION['error'] = "Something went wrong";
}
}else{
  $_SESSION['error'] = "Invalid Email Address";
}
}

public function sendCode($id,$token,$email,$name){
    $mail = new PHPMailer(true);

    try {
        // SMTP Server Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mdrasel551219@gmail.com';       // তোমার Gmail
        $mail->Password   = 'wcpu pwdn qbat duwh';           // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Recipient
        $mail->setFrom('mdrasel551219@gmail.com', $name); // sender (Gmail)
        $mail->addAddress($email);                            // যাকে পাঠাবে

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Reset Your Password";
     $mail->Body = "
<html>
  <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; color: #333;'>
    <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>

      <h2 style='color: #2c3e50;'>Reset Your Password</h2>
      <p>Hi,</p>
      <p>We received a request to reset your password. Use the token below or click the button to reset your password.</p>

      <p style='margin-top: 30px; margin-bottom: 10px; font-weight: bold;'>Your Reset Token:</p>
      <code style='padding: 15px; font-size: 18px; font-family: monospace; border: 1px solid #ddd; border-radius: 5px; user-select: all; color: #000;'>
        {$token}
      </code>

      <p style='margin-top: 30px;'>Or click the button below to reset your password:</p>

      <div style='text-align: center; margin: 30px 0;'>
        <a href='http://{$_SERVER['SERVER_NAME']}/dashboard/Projects/Udemi/loginForm/animated_form/resetPassword.php?token={$token}&id={$id}'
           style='background-color: #3498db; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-weight: bold; display: inline-block;'>
          Reset Password
        </a>
      </div>

      <p>If the button doesn't work, copy and paste this link into your browser:</p>
      <p style='word-break: break-all;'>
        <a href='http://{$_SERVER['SERVER_NAME']}/dashboard/Projects/Udemi/loginForm/animated_form/resetPassword.php?token={$token}&id={$id}'>
          http://{$_SERVER['SERVER_NAME']}/dashboard/Projects/Udemi/loginForm/animated_form/resetPassword.php?token={$token}&id={$id}
        </a>
      </p>

      <hr style='margin-top: 40px;'>
      <p style='font-size: 12px; color: #888;'>If you didn’t request a password reset, you can safely ignore this email.</p>
    </div>
  </body>
</html>
";

        $mail->send();
        // $_SESSION['success'] = 'Message has been sent';

    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return;
    }
}
public function reset($npassword,$cpassword, $id){
    if($npassword !== $cpassword){
        $_SESSION['error'] = "Password doesn't match";
    } else {
        $password = password_hash($npassword, PASSWORD_DEFAULT);
        $update = "UPDATE users SET password = '{$password}' WHERE id='{$id}' AND active = 1";

        echo "<pre>$update</pre>"; // Debug
        $this->query($update);
        echo "Affected Rows: " . $this->affected_rows; // Debug

        if($this->affected_rows > 0){
            $_SESSION['success'] = "Password has been reset";
            header("Location: signin.php");
            exit();
        } else {
            $_SESSION['error'] = "Password reset failed. Possibly wrong email or user not active.";
        }
    }
}




}