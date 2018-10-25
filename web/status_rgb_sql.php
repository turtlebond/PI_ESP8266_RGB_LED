<?php

$host="localhost";
$user="mog";
$passwd="123456";
$dB="my_db";

$z=array();

$table="led_rgb";

$opt=$_GET['opt'];
$id=$_GET['id'];
$status=$_GET['status'];
$blink=$_GET['blink_option'];
$value=$_GET['value'];

$blink1=$_GET['blink_option1'];
$blink2=$_GET['blink_option2'];
$value1=$_GET['value1'];
$value2=$_GET['value2'];
$auto1=$_GET['auto1'];
$auto2=$_GET['auto2'];
$on1=$_GET['on1'];
$on2=$_GET['on2'];
$off1=$_GET['off1'];
$off2=$_GET['off2'];
$day1=$_GET['day1'];
$day2=$_GET['day2'];

$con=mysqli_connect($host,$user,$passwd,$dB) or die('Could not connect: ' . mysqli_error($con));


mysqli_select_db($con,$dB);


if($opt==0){
	$value="id,description,status,blink_option,value,address";
	$sql="SELECT $value FROM $table";
	$result = mysqli_query($con,$sql);

	$num_rows = mysqli_num_rows($result);
	array_push($z,$num_rows);


	while($row = mysqli_fetch_array($result)){ 
		array_push($z,$row['id'],$row['description'],$row['status'],$row['blink_option'],$row['value'],$row['address']);
		//$z[]=$row['name'];
		//$z[]=$row['value'];
	}

	echo json_encode($z);
	mysqli_free_result($result);
	
}
if( $opt==1){
	
	$sql = "UPDATE $table SET status=$status,blink_option=$blink,value='$value' WHERE id=$id";
	
	if (mysqli_query($con, $sql)) {
	    echo "Record updated successfully\n";
	} else {
	    echo "Error updating record: " . mysqli_error($con);
	}
	
}

if($opt==2){
	$value="id";
	$sql="SELECT $value FROM $table";
	$result = mysqli_query($con,$sql);

	$num_rows = mysqli_num_rows($result);
	array_push($z,$num_rows);


	while($row = mysqli_fetch_array($result)){ 
		array_push($z,$row['id']);
		//$z[]=$row['name'];
		//$z[]=$row['value'];
	}

	echo json_encode($z);
	mysqli_free_result($result);
	
}
if($opt==3){
	$value="id,description,value1,value2,auto1,auto2,on1,on2,off1,off2,day1,day2,blink_option1,blink_option2";
	$sql="SELECT $value FROM $table";
	$result = mysqli_query($con,$sql);

	$num_rows = mysqli_num_rows($result);
	array_push($z,$num_rows);


	while($row = mysqli_fetch_array($result)){ 
		array_push($z,$row['id'],$row['description'],$row['value1'],$row['value2'],$row['auto1'],$row['auto2'],$row['on1'],$row['on2'],$row['off1'],$row['off2'],$row['day1'],$row['day2'],$row['blink_option1'],$row['blink_option2']);
	}

	echo json_encode($z);
	mysqli_free_result($result);
	
}
elseif( $opt==4){
	
	$sql = "UPDATE $table SET auto1=$auto1,blink_option1=$blink1,value1='$value1',on1='$on1',off1='$off1',day1='$day1',auto2=$auto2,blink_option2=$blink2,value2='$value2',on2='$on2',off2='$off2',day2='$day2' WHERE id=$id";
	
	if (mysqli_query($con, $sql)) {
	    echo "Record updated successfully\n";
	} else {
	    echo "Error updating record: " . mysqli_error($con);
	}
	
}


mysqli_close($con);

?>

