<?php

    
    

    $expire=time()-1;
    
    setcookie("id[".$_GET['id']."]", $_GET['id'], $expire);
    
    header("Location: http://localhost:8888/wuapps/home.php?title=".$_GET['title']);

?>

<?php include('head.php'); ?>


</body>
</html>