<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Navbar Example</title>
    <link rel="stylesheet" href=".css">
    <style>
    * {
    box-sizing: border-box; /* Ensure padding and border are included in element's total width and height */
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex; /* Use flexbox for layout */
}

.navbar {
    width: 120px; /* Set the width of the navbar */
    background-color: #333; /* Background color */
    height: 100vh; /* Full height */
    position: fixed; /* Fixed position */
}

.navbar ul {
    list-style-type: none; /* Remove default list styles */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margin */
}

.navbar ul li {
    text-align: center; /* Center align text */
}

.navbar ul li a {
    display: block; /* Make links block elements */
    color: black; /* Text color */
    padding: 5px; /* Padding for links */
    text-decoration: none; /* Remove underline */
}

.navbar ul li a:hover {
    background-color: #575757; /* Change background on hover */
}

.content {
    margin-left: 220px; /* Add margin to the left to prevent overlap with navbar */
    padding: 20px; /* Add padding for content */
}
</style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>