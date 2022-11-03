<?php include("includes/header.php"); 
if(!$session->isSignedIn()){
    redirect('login.php');
 }
 if(empty($_GET['photo_id'])){
    redirect('photos.php');
 }
 $photo = Photo::findById($_GET['photo_id']);
 if($photo){
    $photo->deletePhoto();
    redirect('photos.php');
 }else{
    redirect('photos.php');
 }
?>