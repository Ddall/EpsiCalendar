<?php
//VARIABLES
	if(isset($_GET['date'])){
	    $dat            = $_GET['date'];
	    if(preg_match('/-/',$dat)){
	       $arrd = explode('-',$dat);
	       $dat = $arrd[1].'/'.$arrd[2].'/'.$arrd[0];
	    }
	}else{
	    $dat            = date('m/d/Y');
	}
	$rd = rand(1,999999);
	$ac_name        = 'arthur.girard1';
	$ac_password    = 'AAA666';
    $params         = '__ac_name='.$ac_name.'&__ac_password='.$ac_password;
	$url            = 'http://ecampuslyon.epsi.fr/emploi_du_temps?date='.$dat.'&'.$params;

//CURL RECUPERATION HTML
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'CALEXPORT');

    $resultat = curl_exec ($ch);

    curl_close($ch);

//CONTENU HTML VERS TXT
    $filname = 'txt/'.$ac_name.'_'.date('dmY').$rd.".txt";
    $fil = fopen($filname,'w+');
    fwrite($fil,$resultat);
    fclose($fil);

//TXT VERS TXT AVEC UNIQUEMENT CONTENU A PARSER
    $tmpfilname = 'txt/'.$ac_name.$rd.'_tmp.txt';
    unlink($tmpfilname);
    $tmpfil = fopen($tmpfilname,'a+');
    $lines = file($filname);
    
    foreach ($lines as $lineContent)
    {
        if(preg_match('/<DIV class="Case"/',$lineContent)){
	        fwrite($tmpfil,$lineContent);
	    }
    }
    fclose($tmpfil);
//FORMAT DATE
function dateToUs($datbizar){
    $arr = explode('/',$datbizar);
    
    return $arr[2].'-'.$arr[0].'-'.$arr[1];
}
function UsToDate($dat){
    $arr = explode('-',$dat);
    
    return $arr[1].'/'.$arr[2].'/'.$arr[0];
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>EPSI Calendar</title>

    <!-- Loading Bootstrap -->
    <link href="flatui/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="flatui/css/flat-ui.css" rel="stylesheet">
    <link href="flatui/css/demo.css" rel="stylesheet">

    <!--<link rel="shortcut icon" href="images/favicon.ico">-->
  </head>


  <body>
    <div class="container">
      <div class="demo-headline">
        <h1 class="demo-logo">

          Calendrier I4 Groupe 1 Initial
          <small>Telechargement de la semaine du jour selectionné</small>
        </h1>
      </div> <!-- /demo-headline -->
        
      <div class="col-md-14">
      
        <div class="tile">
        
      	    <?php
      	       echo '<form name="form" method="GET" action="">
      	                <input id="datp" type="date" name="date" value="'.dateToUs($dat).'" onchange="document.forms[\'form\'].submit()"/>
      	             </form>';
                echo "<a href='dlcal.php?date=$dat&rd=$rd' class='btn btn-block btn-lg btn-success'>Telecharger calendrier</a>";
            //onchange="document.forms[\'form\'].submit()"
            //$valeurphp = "<script language='Javascript'> document.write(variableGlobaleJavascript); </script>";
            ?>
        </div>
      </div>

    
      </div>

    
    <!-- Load JS here for greater good =============================-->

    <script src="flatui/js/jquery-1.8.3.min.js"></script>
    <script src="flatui/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="flatui/js/jquery.ui.touch-punch.min.js"></script>
    <script src="flatui/js/bootstrap.min.js"></script>
    <script src="flatui/js/bootstrap-select.js"></script>
    <script src="flatui/js/bootstrap-switch.js"></script>
    <script src="flatui/js/flatui-checkbox.js"></script>
    <script src="flatui/js/flatui-radio.js"></script>
    <script src="flatui/js/jquery.tagsinput.js"></script>
    <script src="flatui/js/jquery.placeholder.js"></script>
    <script src="flatui/js/jquery.stacktable.js"></script>
    <script src="http://vjs.zencdn.net/4.1/video.js"></script>
    <script src="flatui/js/application.js"></script>
  </body>
</html>



