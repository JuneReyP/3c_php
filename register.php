<?php 
include 'header.php'; 

if(isset($_SESSION['logged_in'])){
    header("Location: index.php");
}
?>
<div class="row mt-5 justify-content-center">
    <div class="col-md-4">
        <?php if (isset($_GET['msg'])) { ?>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['msg'] ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php } ?>
        <form action="process.php" method="post" class="shadow p-3">
            <div class="mb-3">
                <label for="fname">Firstname</label>
                <input type="text" id="fname" class="form-control" name="fname">
            </div>
            <div class="mb-3">
                <label for="lname">Lastname</label>
                <input type="text" id="lname" class="form-control" name="lname">
            </div>
            <div class="mb-3">
                <label for="email"> Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="pass1">Password</label>
                <input type="password" name="pass1" id="pass1" class="form-control">
            </div>
            <div class="mb-3">
                <label for="pass2">Confirm Password</label>
                <input type="password" name="pass2" id="pass2" class="form-control">
            </div>
            <div class="mb-3">
                <button type="submit" name="register" class="btn btn-success">Register</button>
            </div>
        </form>
    </div>
</div>
</body>

</html>