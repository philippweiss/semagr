

<ul>
<?php

$title = $_GET['title'];

$con = mysql_connect('localhost','root','root');
mysql_select_db('wuapps');


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
