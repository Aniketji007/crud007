<?php
session_start();
$user_login = isset($_SESSION['user_id']) && isset($_SESSION['username']);
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$login = isset($_SESSION['user_login']) && true === $_SESSION['user_login'] ? true : false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/jquery.js" type="text/javascript"></script>
    <title>Document</title>
</head>

<body>
    <section class="mainWrp user-data" style="display: <?= $user_login ? 'block' : 'none' ?>;">
        <nav>
            <button class="form-visibility add-new" data-form-heading="Add New Entry" data-type="add">Add New</button>
            <button class="log-out">Log Out</button>
        </nav>
        <div class="user-data">
            <div class="user-data-header">
                <p>S.No</p>
                <p>User Name</p>
                <p>Email</p>
                <p>Phone No</p>
                <p>DOB</p>
                <p>Gender</p>
                <p>Hobbies</p>
                <p>Course</p>
                <p>Edit</p>
                <p>Delete</p>
            </div>
            <div class="user-data-body"></div>
        </div>
        <div class="form-wrapper">
            <form name="entry-form" id="entry-form">
                <button class="close-button" data-hide="entry-form">Close</button>
                <h1></h1>
                <div>
                    <input placeholder="Username Or Email" type="text" name="username" id="username">
                    <label for="username">Username</label>
                </div>
                <div>
                    <input placeholder="Email" type="email" name="email" id="email">
                    <label for="email">Email</label>
                </div>
                <div>
                    <input placeholder="Phone No" type="text" name="phone-no" id="phone-no">
                    <label for="phone-no">Phone No.</label>
                </div>
                <div>
                    <label for="dob">Date Of Birth.</label>
                    <input placeholder="11-10-2000" type="date" name="dob" id="dob">
                </div>
                <div>
                    <p>Select Your Gender</p>
                    <input placeholder="Select Your Gender" type="radio" name="gender" value="male">
                    <label for="gender">Male</label>
                    <input placeholder="Select Your Gender" type="radio" name="gender" value="female">
                    <label for="gender">Female</label>
                    <input placeholder="Select Your Gender" type="radio" name="gender" value="other">
                    <label for="gender">Other</label>
                </div>
                <div>
                    <p>Select Your Hobbies</p>
                    <input placeholder="Select Your Hobbies" type="checkbox" name="hobbies" value="cricket">
                    <label for="hobbies">Cricket</label>
                    <input placeholder="Select Your Hobbies" type="checkbox" name="hobbies" value="football">
                    <label for="hobbies">Football</label>
                    <input placeholder="Select Your Hobbies" type="checkbox" name="hobbies" value="movies">
                    <label for="gender">Movies</label>
                </div>
                <div>
                    <select name="course" id="course">
                        <option value="arts">Arts</option>
                        <option value="mba">MBA</option>
                        <option value="bca">BCA</option>
                        <option value="bsc">BSC</option>
                    </select>
                </div>
                <div class="form-button">
                    <button type="submit" data-type="add">Add</button>
                    <button type="reset">Clear</button>
                </div>
            </form>
        </div>
    </section>
    <section class="login-form" style="display: <?= $user_login ? 'none' : 'block' ?>;">
        <div class="form-wrapper active">
            <form name="form-sign-in">
                <div>
                    <input placeholder="Username" type="text" name="username" id="username">
                    <label for="username">Username or Email</label>
                </div>
                <div>
                    <input placeholder="Password" type="password" name="password" id="password">
                    <label for="passowrd">Password</label>
                </div>
                <div class="form-button">
                    <button type="submit" value="add_new">Sign In</button>
                    <button class="sign-up">Sign Up</button>
                </div>
            </form>
        </div>
        <div class="form-wrapper">
            <form name="form-sign-up">
                <div>
                    <input placeholder="Username" type="text" name="username" id="username">
                    <label for="username">Username</label>
                </div>
                <div>
                    <input placeholder="Email" type="email" name="email" id="email">
                    <label for="email">Email</label>
                </div>
                <div>
                    <input placeholder="Password" type="password" name="password" id="password">
                    <label for="passowrd">Password</label>
                </div>
                <div>
                    <input placeholder="Confirm Password" type="password" name="confirm_password" id="confirm_password">
                    <label for="confirm_password">Confirm Password</label>
                </div>
                <div class="form-button">
                    <button type="submit" value="add_new">Sign Up</button>
                    <button class="sign-in">Sign In</button>
                </div>
            </form>
        </div>
    </section>
    <script src="assets/js/index.js"></script>
</body>

</html>