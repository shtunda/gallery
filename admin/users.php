<?php include("includes/header.php"); ?>

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
            Users
            <small>Subheading</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Blank Page
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->
<?php 
$users = User::findAllUsers();
foreach($users as $user){
?>
<p><?php echo $user->username ?></p>
<a href="users.php?destroy=<?php echo $user->id ?>">delete</a>
<?php } ?>
        </div>
        <!-- /#page-wrapper -->
        <form action="<?php storeUser() ?>" method="post">
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">
            <input type="text" name="first_name" placeholder="first_name">
            <input type="text" name="last_name" placeholder="last_name">
            <input type="submit" name="store_user">
    
         </form>
         <form action="" method="post">
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">
            <input type="text" name="first_name" placeholder="first_name">
            <input type="text" name="last_name" placeholder="last_name">
            <input type="submit" name="update_user" value="update">
    
         </form>

  <?php include("includes/footer.php"); ?>
<?php
 destroyUser();
//  if(isset($_POST['update_user'])){
    $user = User::findUserById(7);
    $user->username = "updated";
    $user->password = "updated";
    $user->first_name = "updated";
    $user->last_name = "updated";
    $user->update();
//  }