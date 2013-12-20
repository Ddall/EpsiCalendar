<?php
include("class/ParseCal.php");
//include("class/Event.php");
if(isset($_GET['date'])&&isset($_GET['rd'])){
    $dat = $_GET['date'];
    $rd = $_GET['rd'];
    $mypars = new ParseCal("arthur.girard1",$dat,$rd);
    $mypars->goParse();
    $collecEvent = $mypars->getCollecEvent();
    
    $filnam = 'ical/'.rand(100,999).'-'.rand(100,999).'-'.rand(100,999).'.ics';
    $fil = fopen($filnam,'w+');
    
    fwrite($fil,"BEGIN:VCALENDAR\r\n");
    fwrite($fil,"VERSION:2.0\r\n");
    fwrite($fil,"PRODID:-//hacksw/handcal//NONSGML v1.0//FR\r\n");
    fwrite($fil,"X-WR-TIMEZONE:Europe/Paris\r\n");
    fwrite($fil,"CALSCALE:GREGORIAN\r\n");
    
    foreach($collecEvent as $event){
        fwrite($fil,$event->getIcal());
    }
    fwrite($fil,"END:VCALENDAR\r\n");
    
    header("location:$filnam");
}


?>