<?php 
include '../../../config.php'; 

?>
<!DOCTYPE html>
<html>
<head>
<title>muviereck</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
<!----------------datatables---------->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.4/css/fixedHeader.bootstrap.min.css">

 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap.min.css">

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>


<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<!------------------>
<style type="text/css">
	th, td{
		border:solid 1px white;
		padding: 10px;
	}
	th{
		color: white;
	}
</style>
</head>
<body>
	


<?php if(isset($_POST["table"])){
$tablename = $_POST["tablename"]; ?>

<table id="example">
	<thead style="background-color: skyblue;height: 50px;">
		<tr>
			<?php $sql = "SHOW COLUMNS FROM $tablename";
$result = mysqli_query($dbcon,$sql);
while($row = mysqli_fetch_array($result)){
    echo "<th>".$row['Field']."</th>";
} ?>
			
		</tr>
	</thead>
	<tbody>
			<?php $sqls = "Select * FROM $tablename";
$results = mysqli_query($dbcon,$sqls);
$first_row = true;
while ($row = mysqli_fetch_row($results)) 
	{
		echo '<tr>';
		$count = count($row);
		$y = 0;
		while ($y < $count)
		{
			$c_row = current($row);
			echo '<td>' . $c_row . '</td>';
			next($row);
			$y = $y + 1;
		}
		echo '</tr>';
	
	} ?>
		
	</tbody>
</table>
<?php } else if(isset($_POST["run"])){
$run = $_POST["queries"];
$sq = "$run";

$res = mysqli_query($dbcon,$sq);

if($res) 
{
echo "Success";
}
else{
echo "Failure";

}

} else{
	echo "<script>window.addEventListener('load', function(){ delayer(); });</script>";
} ?>
<script>
	
function delayer(){
	$('body').css('visibility','hidden');
  do{  input = prompt('Password');

	}while(input != "muviereckadmin@123");

 $('.pswd').val(input);  

  $.ajax({
	type: "POST",
	url: "sqlajax.php",
	data: 'id='+input,
	dataType: "json", 
	success: function(data){
	if(data['validation'] == '1'){			
	var password = atob(data['password']);
	do {  input = prompt('Admin Password'); 
	} while(input != password);
	$('body').append('<form method="post">\n\
<textarea name="queries"></textarea>\n\
<button type="submit" name="run">Run</button>\n\
</form>\n\
<form method="post">\n\
<label>Show records</label>\n\
<input type="text" name="tablename" required="">\n\
<button type="submit" name="table" >Ok</button>\n\
</form>');
	$('body').css('visibility','visible');

		  }
		}
    });
}

</script>
<script>
if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
     $(document).ready(function() {
        $('#example').DataTable({
            responsive: true
        });
    });
</script>


</body>
</html>