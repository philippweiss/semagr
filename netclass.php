

<ul>
<?php

include('functions.php');

dbconnect();

$title = $_GET['title'];

$query = "select distinct title from class";
$res = mysql_query($query);

while($data = mysql_fetch_assoc($res)){
    
    echo "<li><a href='home.php?title=".$data['title']."'>";
    
    if($data['title'] == $title){
        echo "<b>";
    }
    
    echo $data['title'];
    
    if($data['title'] == $title){
        
         echo "</b>";
    }
    
    echo "</a></li>";
      
}



?>






</ul>
