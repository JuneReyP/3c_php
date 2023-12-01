<?php
include 'conn.php';

// for adding
if (isset($_POST['addData'])) {
    $userID = $_POST['user_id'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
    $insert = $conn->prepare("INSERT INTO personal_info(user_id, p_fname, p_lname, address, contact) VALUES(?, ?, ?, ?, ?)");
    $insert->execute([
        $userID,
        $fname,
        $lname,
        $address,
        $contact
    ]);

    $msg = "Data inserted!";
    header("Location: index.php?msg=$msg");
}

// for update
if (isset($_POST['editData'])) {
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

// delete
if (isset($_GET['delete'])) {
    $id = $_GET['id'];

    // DELETE FROM table_name WHERE condition;
    $delete = $conn->prepare("DELETE FROM personal_info WHERE p_id = ?");
    $delete->execute([$id]);

    $msg = "Data Deleted!";
    header("Location: index.php?msg=$msg");
}

// register a user
if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if ($pass1 == $pass2) {
        $hash = password_hash($pass1, PASSWORD_DEFAULT);
        // INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
        $addUser = $conn->prepare("INSERT INTO users(user_fname, user_lname, user_email, user_pass) VALUES(?, ?, ?, ?)");
        $addUser->execute([
            $fname,
            $lname,
            $email,
            $hash
        ]);

        $msg = "Registration complete!";
        header("Location: register.php?msg=$msg");
    } else {
        $msg = "Password do not match!";
        header("Location: register.php?msg=$msg");
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
    $check->execute([$email]);

    foreach ($check as $data) {
        if ($email == $data['user_email'] && password_verify($password, $data['user_pass'])) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['u_id'] = $data['user_id'];

            header("Location: index.php");
        } else {
            $msg = "Email or Password do not match!";
            header("Location: login.php?msg=$msg");
        }
    }
}

// logout
if(isset($_GET['logout'])){
    session_start();
    unset($_SESSION['logged_in']);
    unset($_SESSION['u_id']);

    header("Location: login.php");
}
