<?php 

    function calendrier_mois($mois,$annee)
    {
        $types  =["audio conf","video conf","meeting"];
        $urls   =["http://meet/audio","http://meet/video","N/A"];
        $texts  =["Audio metting with a customer","Meeting with Team A","Team meeting"];

        for ($i=0;$i<rand(2,5);$i++)
        {
            $random=rand(0,sizeof($types)-1);
            $infos[$i]=new stdClass();
            $infos[$i]->date=$annee.'-'.$mois.'-'.sprintf("%'.02d", rand(0,28));
            $infos[$i]->text=$texts[$random];
            $infos[$i]->url=$urls[$random];
            $infos[$i]->type=$types[$random];
            $infos[$i]->time="02:00pm";
        }
        return $infos;
    }

    $annee_mois_regex="#^/calendar/([12]\d{3}/(0[1-9]|1[0-2]))$#";
    
    $date          = getdate();
    $jour_courant  = $date['mday'];
    $mois_courant  = $date['mon'];
    $annee_courant = $date['year'];    
    
    if (preg_match($annee_mois_regex,$_SERVER['REQUEST_URI'],$match))
    {
        header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT' );
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');	
        header('Content-Type: application/json');

        $cal = explode("/", substr($match[0],-7));
        $annee=$cal[0];
        $mois =$cal[1];
      
       
        if (($mois == $mois_courant) && ($annee == $annee_courant)) 
        {
            $jour = $jour_courant;
        } 
        else 
        {
            $jour = -1;
        }

        $infos=new stdClass();
        $infos->current_day             = $jour;
        $infos->month                   = $mois;
        $infos->year                    = $annee;
        $infos->days_in_month           = date('j', mktime(0,0,0,$mois+1,0,$annee));
        $infos->first_day_of_the_month  = date('D', mktime(0,0,0,$mois,1,$annee));        
        
        $infos->events=calendrier_mois($mois,$annee);
        
        echo json_encode($infos);                    
    }
    else 
    {                        
        header("Status: 404 Not Found", false, 404);
    }        

?>