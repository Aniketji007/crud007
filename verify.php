<?php
session_start();
require_once './config.php';


if (isset($_POST['login']) && 'true' === $_POST['login']) {
    $password = md5($_POST['password']);
    $username = $_POST['userName'];
    $query =  "select * from admin where password='$password' AND (username='$username' or email='$username')";
    $sql = $conn->query($query);
    $conn->close();
    if ($sql->num_rows > 0) {
        $data = $sql->fetch_assoc();
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $array = array(
            'message' => 'user found'
        );
        echo json_encode($array);
    } else {
        $array = array(
            'message' => 'user not found'
        );
        echo json_encode($array);
    }
    exit;
}

if (isset($_POST['signUp']) && 'true' === $_POST['signUp']) {
    $password = md5($_POST['password']);
    $username = $_POST['username'];
    $email = $_POST['email'];

    $query =  "INSERT INTO ADMIN(`username`,`email`,`password`) values('$username', '$email', '$password')";

    $sql = $conn->query($query);
    $conn->close();

    if ($sql) {
        $array = array(
            'status' => true,
            'message' => 'data added successfully'
        );
        echo json_encode($array);
    } else {
        $array = array(
            'status' => false,
            'message' => 'something error please try again'
        );
        echo json_encode($array);
    }
    exit;
}

if (isset($_POST['userEntry']) && 'add' === $_POST['userEntry']) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $hobbies = implode(',', $_POST['hobbies']);

    $query =  "INSERT INTO user(`username`,`email`,`phone_no`,`dob`,`gender`,`hobbies`,`course`) values('$username', '$email', $phoneNo,'$dob','$gender','$hobbies','$course')";

    $sql = $conn->query($query);

    if ($sql) {
        $query = "select * from user order By `id` DESC limit 1";
        $sql = $conn->query($query);
        $latest_entry = $sql->fetch_assoc();
        $array = array(
            'status' => true,
            'entry' => array($latest_entry),
            'message' => 'data added successfully'
        );

        echo json_encode($array);
    } else {
        $array = array(
            'status' => false,
            'message' => 'something error please try again'
        );
        echo json_encode($array);
    }
    exit;
}

if (isset($_POST['userEntry']) && 'update' === $_POST['userEntry']) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $hobbies = implode(',', $_POST['hobbies']);

    $query =  "UPDATE user SET `username`='$username' , `email`='$email', `phone_no`=$phoneNo, `dob`='$dob', `gender`='$gender',`hobbies`='$hobbies', `course`='$course' where `id`=$id";

    $sql = $conn->query($query);

    if ($sql) {
        $data = array(
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'phone_no' => $phoneNo,
            'dob' => $dob,
            'gender' => $gender,
            'hobbies' => $hobbies,
            'course' => $course,
        );
        $array = array(
            'status' => true,
            'query' => 'updated',
            'updated_data' => $data,
            'message' => 'data updated successfully'
        );

        echo json_encode($array);
    } else {
        $array = array(
            'status' => false,
            'message' => 'something error please try again'
        );
        echo json_encode($array);
    }
    exit;
}

if (isset($_POST['userDelete']) && isset($_POST['deleteId']) && 'true' === $_POST['userDelete']) {
    $id = $_POST['deleteId'];

    $query = "DELETE FROM user where `id`=$id";
    $sql = $conn->query($query);

    if ($sql) {
        $array = array(
            'status' => true,
            'id' => $id,
            'message' => 'Remove data successfully'
        );

        echo json_encode($array);
    } else {
        $array = array(
            'status' => false,
            'message' => 'something error please try again'
        );
        echo json_encode($array);
    }
}

if (isset($_POST['editData']) && 'true' === $_POST['editData'] && isset($_POST['editId']) &&  !empty($_POST['editId']) && isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $id = (int) $_POST['editId'];
    $query = "SELECT * FROM user where `id`=$id";
    $sql = $conn->query($query);

    if ($sql->num_rows > 0) {
        $data = $sql->fetch_all(MYSQLI_ASSOC);

        $array = array(
            'status' => true,
            'entry' => $data[0],
            'message' => 'Existing data'
        );

        echo json_encode($array);
    }
}

if (isset($_POST['fetchUserData']) && 'true' === $_POST['fetchUserData'] && isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $query = 'SELECT * FROM user';
    $sql = $conn->query($query);

    if ($sql->num_rows > 0) {
        $data = $sql->fetch_all(MYSQLI_ASSOC);

        $array = array(
            'status' => true,
            'entry' => $data,
            'message' => 'data added successfully'
        );

        echo json_encode($array);
    }
    exit;
}


if (isset($_POST['logout']) && 'true' === $_POST['logout']) {
    $array = array();
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        session_destroy();
        $array['login_status'] = true;
        $array['message'] = 'User log out successfully';
    } else {
        $array['login_status'] = false;
        $array['message'] = 'User already logout';
    }
    echo json_encode($array);
    exit;
}
