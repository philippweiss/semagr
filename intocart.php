<?php
    
    include('functions.php'); 
    
    
    
    
    
    foreach($_COOKIE['id'] as $name => $value){
        
        if(checkTitle($value) == $_GET['title']){
        
            $expire=time()-1;
            setcookie("id[".$value."]", $value, $expire); 
        
        }
    }
    
    
    $expire=time()+60*60*24*30;
    setcookie("id[".$_GET['id']."]", $_GET['id'], $expire);
    
    header("Location: http://localhost:8888/wuapps/home.php?title=".$_GET['title']);

    include('head.php'); 

    
?>




</body>
</html>

