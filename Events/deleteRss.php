<?php 
// ob_start();
// session_start();
require_once '../db_connect.php';

if (!isset($_SESSION['admin']) ) {
   header("Location: events.php");
   exit;
}

// select logged-in users details
$res = mysqli_query($conn, "SELECT * FROM users WHERE userId=" . $_SESSION['admin']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);



if ($_GET['id']) {
   $feedID = $_GET['id'];

   $sql = "SELECT * FROM feeds WHERE feedID = $feedID" ;
   $result = $conn->query($sql);
   $data = $result->fetch_assoc();

   $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
   <title >Löschen </title>

   <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar sticky-top navbar-dark bg-dark">
        <div><p class="text-white"> Hi <?php echo $userRow['userName']; ?> !</p></div>

        <div class="mx-auto">
            <a class="btn btn-outline-warning" href="createRss.php" role="button">Neuen Feed erstellen</a>
        </div>

        <div class="mr-3 text-white">
            <?php echo $userRow['userEmail']; ?>
        </div>
        <!-- <div class="image">
            <img class="icon" src="img/icon/<#?php echo $userRow['foto']; ?>" />
        </div> -->
    </nav>


<hr>
<div class= 'bg-info text-dark pt-2 pb-2'>
<h3><center>Feed wirklich löschen?</center></h3>
<form action ="a_deleteRss.php" method="post">

   <input type="hidden" name= "feedID" value="<?php echo $data['feedID'] ?>" />
   <div class= "d-flex justify-content-center">
   <button type="submit" class="btn btn-outline-dark">Löschen</button >
   <a href="eventsAdmin.php"><button type="button" class="btn btn-outline-dark">Zurück</button ></a>
   </div>
</form>
</div>
</body>
</html>

<?php
}
?>