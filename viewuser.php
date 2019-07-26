<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<SCRIPT type="text/javascript">
$(document).ready(function(){
$('#menu ul').hide();
$('#menu li a').mouseenter(function() {

$(this).next().slideToggle('slow');
}
);
});
</script>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 50%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

</style>
</head>
<body>
<center>
<h2>EMPLOYEES LOGS</h2>
<table border=1>
<tr>
<th>ID</th>
<th>Name</th>
<th>View Details</th>
</tr>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "credit_management";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id,name,age,email,currentcredit,gender FROM employee";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["id"]. " </td><td> " . $row["name"]." </td><td><UL ID='menu'>
<LI><a>VIEW</a>
<UL><LI><b>Credit:  <b><A>" . $row["currentcredit"]."</A></LI><LI><b>Age<b>: <A>" . $row["age"]."</A></LI><LI><b>Email<b>:<A>" . $row["email"]."</A></LI><LI><b>Gender<b>: <A>" . $row["gender"]."</A></LI>
</UL></td></tr><br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
</table>
</center>
</body>
</html>