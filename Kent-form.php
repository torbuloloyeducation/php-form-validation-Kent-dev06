<?php
$name = $email = $gender = $website = $phone = "";
$password = $confirm_password = "";
$nameErr = $emailErr = $genderErr = $websiteErr = $phoneErr = "";
$passwordErr = $confirmErr = $termsErr = "";
$attemp = 0;

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $attemp = isset($_POST["attemp"]) ? (int)$_POST["attemp"] + 1 : 1;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }

    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }

    if (empty($_POST["confirm_password"])) {
        $confirmErr = "Confirm your password";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirmErr = "Passwords do not match";
        }
    }

    if (!isset($_POST["terms"])) {
        $termsErr = "You must agree to the terms";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Validation</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>

<h2>PHP Form Validation</h2>
<p>Submission Attempt: <?= $attemp ?></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

    Name: <input type="text" name="name" value="<?= $name ?>">
    <span class="error">* <?= $nameErr ?></span><br><br>

    Email: <input type="text" name="email" value="<?= $email ?>">
    <span class="error">* <?= $emailErr ?></span><br><br>

    Phone: <input type="text" name="phone" value="<?= $phone ?>">
    <span class="error">* <?= $phoneErr ?></span><br><br>

    Website: <input type="text" name="website" value="<?= $website ?>">
    <span class="error">* <?= $websiteErr ?></span><br><br>

    Password: <input type="password" name="password">
    <span class="error">* <?= $passwordErr ?></span><br><br>

    Confirm Password: <input type="password" name="confirm_password">
    <span class="error">* <?= $confirmErr ?></span><br><br>

    Gender:
    <input type="radio" name="gender" value="female" <?= ($gender=="female") ? 'checked' : '' ?>> Female
    <input type="radio" name="gender" value="male" <?= ($gender=="male") ? 'checked' : '' ?>> Male
    <span class="error">* <?= $genderErr ?></span><br><br>

    <input type="checkbox" name="terms" <?= isset($_POST['terms']) ? 'checked' : '' ?>>
    I agree to the terms
    <span class="error">* <?= $termsErr ?></span><br><br>

    <input type="hidden" name="attemp" value="<?= $attemp ?>">

    <input type="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    $nameErr == "" && $emailErr == "" && $phoneErr == "" &&
    $websiteErr == "" && $genderErr == "" &&
    $passwordErr == "" && $confirmErr == "" && $termsErr == "") {

    echo "<h3>Your Input</h3>";
    echo "Name: $name <br>";
    echo "Email: $email <br>";
    echo "Phone: $phone <br>";
    echo "Website: $website <br>";
    echo "Gender: $gender <br>";
}
?>

</body>
</html>