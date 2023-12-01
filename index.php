<?php include 'header.php';
if(!isset($_SESSION['logged_in'])){
    header("Location: login.php");
    ob_end_flush();
}
?>
<!-- row for input -->
<div class="row justify-content-center">
    <div class="col-md-5 shadow mt-5 p-3">
        <?php if (isset($_GET['msg'])) { ?>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['msg'] ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php } ?>
        <?php
        if (isset($_GET['edit'])) {
            // display the data to be edited here 
            $id = $_GET['id'];
            $selectData = $conn->prepare("SELECT * FROM personal_info WHERE p_id = ?");
            $selectData->execute([$id]);

            foreach ($selectData as $data) { ?>

                <form action="process.php" method="post">
                    <input type="hidden" name="p_id" value="<?= $data['p_id'] ?>">
                    <div class="mb-3 mt-2">
                        <label for="fname">Firstname</label>
                        <input type="text" class="form-control mb-3" id="fname" name="firstname" value="<?= $data['p_fname'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lname">Lastname</label>
                        <input type="text" class="form-control mb-3" id="lname" name="lastname" value="<?= $data['p_lname'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control mb-3" id="address" name="address" value="<?= $data['address'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="contact">Contact No.</label>
                        <input type="number" class="form-control mb-3" id="contact" name="contact" value="<?= $data['contact'] ?>">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-warning" type="submit" name="editData">Update</button>
                    </div>
                </form>
            <?php }
        } else { ?>
            <form action="process.php" method="post">
                <input type="hidden" name="user_id" value="<?= $_SESSION['u_id'] ?>">
                <div class="mb-3 mt-2">
                    <label for="fname">Firstname</label>
                    <input type="text" class="form-control mb-3" id="fname" name="firstname">
                </div>
                <div class="mb-3">
                    <label for="lname">Lastname</label>
                    <input type="text" class="form-control mb-3" id="lname" name="lastname">
                </div>
                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control mb-3" id="address" name="address">
                </div>
                <div class="mb-3">
                    <label for="contact">Contact No.</label>
                    <input type="number" class="form-control mb-3" id="contact" name="contact">
                </div>
                <div class="mb-3">
                    <button class="btn btn-success" type="submit" name="addData">Add</button>
                </div>
            </form>
        <?php } ?>
    </div>
</div>
<!-- 
            row for display
         -->
<hr>
<div class="row mt-4 justify-content-center">
    <div class="col-sm-10">
        <div class="table">
            <table class="table shadow p-2">
                <thead>
                    <th>#</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $userID = $_SESSION['u_id'];
                    $cnt = 1;
                    $select = $conn->prepare("SELECT * FROM personal_info WHERE user_id = ?");
                    $select->execute([$userID]);
                    foreach ($select as $value) { ?>

                        <tr>
                            <td><?= $cnt++ ?></td>
                            <td><?= $value['p_fname'] ?></td>
                            <td><?= $value['p_lname'] ?></td>
                            <td><?= $value['address'] ?></td>
                            <td><?= $value['contact'] ?></td>
                            <td><a href="index.php?edit&id=<?= $value['p_id'] ?>" class="text-decoration-none">✏️</a> | <a href="process.php?delete&id=<?= $value['p_id'] ?>" class="text-decoration-none">❌</a></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</body>

</html>