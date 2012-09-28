

function allowDrop(ev){

    ev.preventDefault();
}

function drag(ev){
    
    ev.dataTransfer.setData("Text",ev.target.id);    
}

function dropIntoClasscart(ev,title){
    
    ev.preventDefault();
    var data=ev.dataTransfer.getData("Text");
    window.location = 'intocart.php?id='+data+'&title='+title;
    
}

function dropIntoWorkbench(ev,title){

    ev.preventDefault();
    var data=ev.dataTransfer.getData("Text");
    window.location = 'removefromcart.php?id='+data+'&title='+title;

}