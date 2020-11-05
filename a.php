<?php 

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "sample";

try {
  $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName;
  $pdo = new PDO($dsn, $dbUser, $dbPassword);
} catch(PDOException $e) {
  echo "DB Connection Failed: " . $e->getMessage();
}

$status = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $date=$_POST['date'];
  $time=$_POST['time'];
  $num=$_POST['num'];
  if(empty($name) || empty($email) || empty($message) || empty($date)||empty($time)||empty($num)) {
    $status = "All fields are compulsory.";
  } else {
    if(strlen($name) >= 255 || !preg_match("/^[a-zA-Z-'\s]+$/", $name)) {
      $status = "Please enter a valid name";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $status = "Please enter a valid email";
    } else {

      $sql = "INSERT INTO try (name, email,date,time,num, message) VALUES (:name, :email,:date,:time,:num, :message)";

      $stmt = $pdo->prepare($sql);
      
      $stmt->execute(['name' => $name, 'email' => $email,'date'=>$date,'time'=>$time,'num'=>$num, 'message' => $message]);

      $status = "Your message was sent";
      $name = "";
      $email = "";
      $date= "";
      $date="";
      $num="";
      $message = "";
    }
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="surveycss.css">
  
</head>

<body>
  <div class="container">

    <form action="" method="POST" class="main-form">
    <h1>BOOKING ZONE</h1>
    <h3>NAME</h3>
      <div class="form-group">
        <input type="text" id="name" name="name" class="form-control"  placeholder="Your Name" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $name ?>">
      </div><br>
    <h3>EMAIL</h3>
      <div class="form-group">
        <input type="text" id="email" name="email" class="form-control" placeholder="Your Email" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $email ?>">
      </div><br>
      <h3>DATE OF EVENT</h3>
      <div class="form-group">
        <input type="date" id="date" name="date" class="form-control" placeholder="Date of event" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $date ?>">
      </div><br>
      <h3>TIME OF EVENT</h3>
      <div class="form-group">
        <input type="time" id="time" name="time" class="form-control" placeholder="time of event" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $time ?>">
      </div><br>
      <h3>NUMBER OF PEOPLE</h3>
      <div class="form-group">
        <input type="number" id="num" name="num" class="form-control" placeholder="number of people" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $num ?>">
      </div><br>
      <h3>EXTRA REMARKS/MESSAGE</h3>
      <div class="form-group">
        <textarea id="message" name="message" class="form-control" placeholder="SEND A MESSAGE" rows="5"><?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $message ?></textarea>         
      </div><br>

      <input type="submit" class="btn btn-primary" value="Submit">

      
    </form>
  </div>



</body>

</html>   