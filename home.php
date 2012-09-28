<?php 
        include('functions.php');
        include('head.php');
?>

<div id='wrapper'>
    <div id='header'><a href='home.php'>semagr</a></div>
    
    <div id='netclass'>
        <?php include('netclass.php'); ?>
    </div>
    

    
    <div id='workbench' ondrop='dropIntoWorkbench(event,"<?php echo $title; ?>")' ondragover='allowDrop(event)'>
        <?php include('workbench.php'); ?>
    </div>
    
    <div id='toolbar'>
        <div id='benchmark'>
            <!--<?php include('benchmark.php'); ?>-->
        </div>
        <div id='classcart' ondrop='dropIntoClasscart(event,"<?php echo $title; ?>")' ondragover='allowDrop(event)'>
            <?php include('classcart.php'); ?>  
        </div>
    </div>
    <div id='footer'><a href='home.php'>impressum</a></div>

</div>

</body>
</html>