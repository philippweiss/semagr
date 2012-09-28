<?php 

     
if(isset($_COOKIE['id'])){
    
    
    
    dbconnect();
    
    
    
    
    $query1 = "select * from class where id = ";
    $selectedLectures = checkCookie();

    
    foreach($selectedLectures as $i => $value){
    
        $query1 .= $value;
        
        
        if($i < count($selectedLectures) - 1){
            
            $query1 .= " or id = ";
        }
        
  
    }
    
    $res1 = mysql_query($query1);
    
    while($data1 = mysql_fetch_assoc($res1)){
        
        echo "<span id='".$data1['id']."' draggable='true' ondragstart='drag(event)'>".$data1['id']." ".$data1['title']."</span> ".checkCollision($data1['id'])."<br>";
    }
    
    
 
    
}

 

?>