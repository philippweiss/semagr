
<?php

$title = $_GET['title'];

dbconnect();

$query1 = "select distinct class.id, class.title, class.type as ctype, class.sst as csst, class.ects as cects, lecturer.name as lname, lecturer.rating as lrating from class, lecturer where class.lecturer_id = lecturer.id and class.title='".$title."'";
$res1 = mysql_query($query1);

while($data1 = mysql_fetch_assoc($res1)){
    
    if(!(in_array($data1['id'], checkCookie()))){
    
    
        echo        "<div id='".$data1['id']."' class='lecture' draggable='true' ondragstart='drag(event)'>".
                    "<a href='intocart.php?title=".$title."&id=".$data1['id']."'>".$data1['id']."</a>&nbsp;".$data1['title'].", ".$data1['ctype']."&nbsp;".$data1['csst']." SST, &nbsp;".$data1['cects']." ECTS <br/>".
                    $data1['lname']."&nbsp;".$data1['lrating']."<br/><br/>".
                    
                    "Termine<br/>".
                    "<table>".
                    "<tr><td>Datum</td><td>Zeit</td><td>Raum</td>";
                    
        $query2 = "select * from class, schedule, lecturer where class.title='".$title."' and class.id = schedule.class_id and class.lecturer_id = lecturer.id and class.id=".$data1['id'];
        $res2 = mysql_query($query2);
        
        while($data2 = mysql_fetch_assoc($res2)){
                    
            echo "<tr><td>".$data2['weekday'].", ".$data2['date']."</td><td>".$data2['from']."-".$data2['until']."</td><td>".$data2['room']."</td></tr>";        
        }
                
        
        echo "</table></div>";
    
    }
}

?>