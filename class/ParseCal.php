<?php
include("Event.php");

class ParseCal {
    
    var $dat;
    var $rd;
    var $filename;
	var $collecEvent = array();
	var $collecCorresJ = array();



	function ParseCal($username,$dat,$rd){
       
        $this->setRd($rd);
	    $this->setFilename($username);
	    $this->setDat($dat);
	    
	    $ts = strtotime($dat);
	    $m = date("m",$ts);
	    $d = date("d",$ts);
	    $N = date("N",$ts);
	    $Y = date("Y",$ts);
	    $premJ = date('m/d/Y', mktime(0, 0, 0, $m, $d-$N+1, $Y));
	    $ts = strtotime($premJ);
	    $oneday = 3600*24;
	    $dateFin = date(‘d/m/Y’, strtotime('+1 day', $ts));

	    $this->setCorresJ(103,date("d/m/Y",$ts));
	    $this->setCorresJ(122,date("d/m/Y",$ts+($oneday)));
	    $this->setCorresJ(141,date("d/m/Y",$ts+($oneday*2)));
	    $this->setCorresJ(161,date("d/m/Y",$ts+($oneday*3)));
	    $this->setCorresJ(180,date("d/m/Y",$ts+($oneday*4)));

	}
    
    function goParse(){
        $lines = file($this->getFilename());
        foreach ($lines as $lineContent)
        {
            $tmparr = explode("</div>",$lineContent);
            $tmparr[1] = str_replace('<br/>'," ! ",$tmparr[1]);
            $tmparr[1] = str_replace('</td></tr><tr><td colspan="2" class="TCProf" height="1.2em">'," ! ",$tmparr[1]);
            $tmparr[1] = str_replace('</td></tr><tr><td class="TChdeb">'," ! ",$tmparr[1]);
            $tmparr[1] = str_replace('</td><td class="TCSalle">'," ! ",$tmparr[1]);
            $tmparr[1] = str_replace('</td></tr></table>'," ! ",$tmparr[1]);
            
            $arrjour = explode(":",$tmparr[0]);
            $jour = substr($arrjour[4],0,3);
            $jour = $this->getCorresJ($jour);
            
            $exp = explode(" ! ",$tmparr[1]);
            $exp[5]=$jour;
            $heures = explode(" - ",$exp[3]);
            
            $event = new Event($jour,$exp[0],$exp[1],$heures[0],$heures[1],$exp[4]);
            $this->addEvent($event);
        }
    }
    
    function getFilename(){
        return $this->filename;
    }
    
    function setFilename($username){
        $this->filename = 'txt/'.$username.$this->getRd().'_tmp.txt';
    }
    
    function setDat($dat){
        $this->dat = $dat;
    }
    
    function getCorresJ($jour){
        return $this->collecCorresJ[$jour];
    }
    
    function setCorresJ($left,$ijour){
        $this->collecCorresJ[$left]=$ijour;
    }
    
    function getDat(){
        return $this->dat;
    }
    
    function setRd($rd){
        $this->rd = $rd;
    }
    
    function getRd(){
        return $this->rd;
    }
    
    function getCollecEvent(){
        return $this->collecEvent;
    }
    
    function addEvent($event){
        array_push($this->collecEvent,$event);
    }
    
    function showCollecEvent(){
        var_dump($this->collecEvent);
    }
}