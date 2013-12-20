<?php
class Event {
	var $dat;
	var $nom;
	var $intervenant;
	var $hdebut;
	var $hfin;
	var $salle;


	function Event($dat,$nom,$intervenant,$hdebut,$hfin,$salle){
		$this->setDat($dat);
		$this->setNom($nom);
		$this->setIntervenant($intervenant);
		$this->setHdebut($hdebut);
		$this->setHfin($hfin);
		$this->setSalle($salle);
	}

	public function setDat($dat){
		$this->dat = $dat;
	}
	
	public function getDat(){
		return $this->dat;
	}
	
	public function getDatUs(){
	    $arrtmp = explode("/",$this->getDat);
		return $arrtmp[0].'/'.$arrtmp[1].'/2013';
	}
    
    public function setNom($nom){
		$this->nom = $nom;
	}
	
	public function setIntervenant($intervenant){
		$this->intervenant = $intervenant;
	}
	
	public function setHdebut($hdebut){
		$this->hdebut = $hdebut;
	}
	
	public function setHfin($hfin){
		$this->hfin = $hfin;
	}
	
	public function setSalle($salle){
		$this->salle = $salle;
	}
	
	public function getHfin(){
		return $this->hfin;
	}
	
	public function getHdebut(){
		return $this->hdebut;
	}

	public function getNom(){
		return $this->nom;
	}
	
	public function getSalle(){
		return $this->salle;
	}
	
	public function getIcal(){
	    $arr = explode("/",$this->getDat());
	    
	    $d = $arr[0];
	    $m = $arr[1];
	    $Y = $arr[2];
        $hdd = explode(":",$this->getHdebut());
        $heure = $hdd[0]-1;
        $heure=sprintf("%02d", $heure); 
        $minu  = $hdd[1];
        $hd = $heure.$minu;
        $hff = explode(":",$this->getHfin());
        $heuref = $hff[0]-1;
        $heuref=sprintf("%02d", $heuref); 
        $minuf  = $hff[1];
        $hf = $heuref.$minuf;
	    //$hd = str_replace(':','',$this->getHdebut());
	    //$hf = str_replace(':','',$this->getHfin());
	    $str = "BEGIN:VEVENT\r\n";
	    $str = $str.'DTSTART:'.$Y.$m.$d.'T'.$hd.'00Z'."\r\n";
	    $str = $str.'DTEND:'.$Y.$m.$d.'T'.$hf.'00Z'."\r\n";
	    $str = $str."SUMMARY:".$this->getNom()."-".$this->intervenant."\r\n";
	    $str = $str."CATEGORIES:Ecole\r\n";
	    $str = $str."LOCATION:".$this->getSalle()."\r\n";
	    $str = $str."DESCRIPTION:Descript\r\n";
	    $str = $str."END:VEVENT\r\n";
	    
	    return $str;
    
	}

}