<?php
namespace App\Entity;

$server_name="localhost";
$username="root";
$pass="";
$dbname="victorious";
$con=new mysqli($server_name,$username,$pass,$dbname);
if ($con->connect_error){
    die("Connection failed :".$con->connect_error);
}
$sql="SELECT * FROM `noti` ";
$result=$con->query($sql);
echo $result->num_rows;
/*if($result->num_rows > 0){
    while($row=$result->fetch_assoc()){
        echo "id". $row["id"];
    }
} else{
        echo "0 result";
    }*/
$con->close();
?>