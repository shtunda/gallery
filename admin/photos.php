<?php include("includes/header.php"); 
if(!$session->isSignedIn()){
    redirect('login.php');
 }
 $photos = Photo::findAll();
?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
           <?php include("includes/top_nav.php") ?>


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/sidebar.php") ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

        <div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Photos
            <small>Subheading</small>
        </h1>
       <div class="col-md-6">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Size</th>
                </tr>
                <tbody>
                <?php
                      foreach($photos as $photo) :
                        $path = 'images/' . $photo->file_name;
                 ?>
                 <tr>
                    <td><?php echo $photo->id ?></td>
                    <td><img class="admin-photo" src="<?php echo $photo->imagePath() ?>" alt="">
                        <div class="pictures_link">
                            <a href="delete_photo.php?photo_id=<?php echo $photo->id ?>">Delete</a>
                            <a href="edit_photo.php?id=<?php echo $photo->id ?>">Edit</a>
                            <a href="">View</a>
                        </div>
                </td>
                    <td><?php echo $photo->file_name ?></td>
                    <td><?php echo $photo->title ?></td>
                    <td><?php echo $photo->size ?></td>
                 </tr>
                 <?php endforeach; ?>
                </tbody>
            </thead>
        </table>
       </div>
    </div>
   
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>