<?php
    session_start();
	$sender="";
	$receiver="";
	$in_credit="";
	$errors=array();
	//connect to database
	$db= mysqli_connect("localhost","root","","credit_management");
	
	//if register button is clicked
	if(isset($_POST['submit_btn']))
	{
		$sender=mysqli_real_escape_string($db,$_POST['sender']);
		$receiver=mysqli_real_escape_string($db,$_POST['receiver']);
		$in_credit=mysqli_real_escape_string($db,$_POST['in_credit']);
		
		if($sender==$receiver)
   {
	   die("<br><br><br><h1>cannot transfer credit to yourself</h1>");
   }
   if(isset($_POST["sender"],$_POST["receiver"]))
   {	   
		$query = "SELECT * FROM employee WHERE id=$sender";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0)
		{
				$query = "SELECT * FROM employee WHERE id=$receiver";
				$result = mysqli_query($db,$query);
				if(mysqli_num_rows($result) > 0)
				{
						$query = "SELECT currentcredit FROM employee WHERE id=$sender";
						$result =mysqli_query($db,$query);
					    $row = mysqli_fetch_row($result);
						$sbal=$row[0];
						if($sbal < $in_credit)
						{
							echo "<br><br><br><h1>insufficeint balance</h1>";							
						}
						else
						{
							
							$newbal=$sbal-$in_credit;
							
							$sql = "UPDATE employee SET currentcredit=$newbal WHERE id=$sender";
							if (mysqli_query($db, $sql)) 
							{
								$querys = "SELECT currentcredit FROM employee WHERE id=$receiver";
							$results =mysqli_query($db,$querys);
							$rows = mysqli_fetch_row($results);
						
							$rbal=$rows[0];
							$r=$rbal+$in_credit;
								$stm = "UPDATE employee SET currentcredit=$r WHERE id=$receiver";
								if(mysqli_query($db, $stm))
								{
									echo "<script>document.getElementById('id1').style.display = 'inline-block';</script>";
								}
								else
								{
									die("<br><br><br><h1>error while updating</h1>");
								}
								$status="yes";
								

							   

							} 
							else 
							{
								echo "<br><br><br><h1>Error updating record:</h1> " . mysqli_error($db);
							}

							
						}
				}
				else
				{
					echo "<br><br><br><h1>receiver doesn't exist</h1>";
				}
		}
		else
		{
			echo "<br><br><br><h1>sender doesn't exist</h1>";
		}

   }
	}
	
	
	//ensure that form fiels are filled properly
	if(empty($sender))
	{
		array_push($errors,"Username is required");
	}
	if(empty($receiver))
	{
		array_push($errors,"Email-Id is required");
	}
	if(empty($in_credit))
	{
		array_push($errors,"Password is required");
	}

	
	//if there are no errors save the data to users table
	if(count($errors)==0) 
	{
		
		$sql="insert into transfer(sender,receiver,in_credit) values ('$sender','$receiver','$in_credit')";
		mysqli_query($db,$sql);	
		header('Location:tra.php');
	}
	

?>

<html>
<head>
<title>transfer page</title>
<style>
.box
{
background-color:white;
width:40%;
}

.input100 {
  font-family: Raleway-Medium;
  color: #555555;
  line-height: 1.2;
  font-size: 18px;

  display: block;
  width: 50%;
  background: transparent;
  height: 55px;
  padding: 0 25px 0 25px;
}
.button {
  border-radius: 4px;
  background-color: #A9A9A9;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 20px;
  padding: 10px;
  width: 140px;
  margin: 5px;
}
.credit1
{
	text-indent: -175px;
}

.credit
{
	text-indent: -115px;
}
h5{float:right; text-indent: -115px}
</style>	
<script>
function myFunction() {
  alert("Credit Transfer Successfully!");
}
</script>  
</head>
<body style="background-color:#F5F5F5">
<a href="home.html"><h5>BACK</h5></a>
<center>
	<div class="box">
	<br>
	<br>
	<h2>CREDIT TRANSFER</h2>
	<br>
	<form action="tra.php" method="post">
		<label class="credit1"><h4>SENDER:</h4></label>
		<input name="sender" type="text" class="input100" placeholder="Type your id_no." required ><br>
		
		<label class="credit1"><h4>RECEIVER:</h4></label>
		<input name="receiver" type="text" class="input100" placeholder="Type receiver id_no." required /><br>
		
		
		<label class="credit"><h4>ENTER THE CREDIT:</h4></label>
		<input name="in_credit" type="text" class="input100" placeholder="Enter the credit" required /><br><br>
		
			
		<input name="submit_btn" type="submit" class="button" value="TRANSFER" onclick="myFunction()"" required /></br><br>
		
	</form>
	

	</center>
	
	</div>


</body>
</html>