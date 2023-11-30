<?php
include 'conn.php';

// for adding
if(isset($_POST['addData'])){
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
    $insert = $conn->prepare("INSERT INTO personal_info(p_fname, p_lname, address, contact) VALUES(?, ?, ?, ?)");
    $insert->execute([
        $fname,
        $lname,
        $address,
        $contact
    ]);

    $msg = "Data inserted!";
    header("Location: index.php?msg=$msg");
}

// for update
if(isset($_POST['editData'])){
    $id = $_POST['p_id'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // UPDATE table_name SET column1 = value1, column2 = value2, ... WHERE condition;
    $update = $conn->prepare("UPDATE personal_info SET p_fname = ?, p_lname = ?, address = ?, contact = ? WHERE p_id = ?");
    $update->execute([
        $fname,
        $lname,
        $address,
        $contact,
        $id
    ]);

    $msg = "Data Updated!";
    header("Location: index.php?msg=$msg");
}
?>