<?php 
// PART ZERO : BACKEND FUNCTION
function my_calendar($month,$year)
{
	$types  =["audio conf","video conf","meeting"];
        $urls   =["http://meet/audio","http://meet/video","N/A"];
        $texts  =["Audio metting with a customer","Meeting with Team A","Team meeting"];

        for ($i=0;$i<rand(2,5);$i++)
        {
            $random=rand(0,sizeof($types)-1);
            $infos[$i]=new stdClass();
            $infos[$i]->date=$year.'-'.$month.'-'.sprintf("%'.02d", rand(0,28));
            $infos[$i]->text=$texts[$random];
            $infos[$i]->url=$urls[$random];
            $infos[$i]->type=$types[$random];
            $infos[$i]->time="20:00:00";
        }
        return $infos;
}

// PART ONE : INTERFACE
$year_month_regex="#^/calendar/([12]\d{3}/(0[1-9]|1[0-2]))$#";
    
if (preg_match($year_month_regex,$_SERVER['REQUEST_URI'],$match))
{
	// PART TWO : IMPLEMENTATION
	header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT' );
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');	
        header('Content-Type: application/json');

        $cal  =explode("/", substr($match[0],-7));
        $year =$cal[0];
        $month=$cal[1];
       
        $infos=new stdClass();
        $infos->month                   = $month;
        $infos->year                    = $year;
        $infos->days_in_month           = date('j', mktime(0,0,0,$month+1,0,$year));
        $infos->first_day_of_the_month  = date('D', mktime(0,0,0,$month,1,$year));        
        
        $infos->events=my_calendar($month,$year);
        
        echo json_encode($infos);                    
    }
    else 
    {                        
        header("Status: 404 Not Found", false, 404);
    }        

?>
