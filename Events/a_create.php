<?php 
// ob_start();
// session_start();
require_once '../db_connect.php';

if (!isset($_SESSION['admin']) ) {
   header("Location: events.php");
   exit;
}
 // select logged-in users details
 $res = mysqli_query($conn, "SELECT * FROM users WHERE userID=" . $_SESSION['admin']);
 $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
 

 if (isset($_POST['but_upload'])) {

   $name = $_FILES['fileInput']['name'];
   $target_dir = "upload/";
   $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);
 
   // Select file type
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 
   // Valid file extensions
   $extensions_arr = array("jpg","jpeg","png","gif");
 
   // Check extension
   if( in_array($imageFileType,$extensions_arr) ){
      // Convert to base64 
     $image_base64 = base64_encode(file_get_contents($_FILES['fileInput']['tmp_name']) );
     $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
     
 } 

// if ($_POST) {

   $name = $_POST['name'];
   $description = $_POST['description'];
   $date = $_POST['date'];
   $location = $_POST['location'];

   
$sql = "INSERT INTO events (eventName, eventDate, eventDescription, eventLocation, `image`) values('$name', '$date', '$description', '$location','$image')";


    if($conn->query($sql) === TRUE) {
       echo "<div class= 'bg-secondary text-light pt-2 pb-2'>";
       echo "<p><center>Neuer Beitrag wurde erstellt</center></p>" ;
       echo "<div class= 'd-flex justify-content-center'>";
       echo "<a href='create.php'><button type='button' class= 'btn btn-outline-info'>Back</button></a>";
       echo "</div>";
       header ("refresh:2; url=eventsAdmin.php"); 
       echo "<center>Weiterleitung erfolgt in 2 Sekunden.</center>";
       echo "</div>";

   } else  {
       echo "Error " . $sql . ' ' . $conn->connect_error;
   }

   $conn->close();
}

?>