<?php

function parseFloat($ptString) { 
            if (strlen($ptString) == 0) { 
                    return false; 
            } 

            $pString = str_replace(" ", "", $ptString); 

            if (substr_count($pString, ",") > 1) 
                $pString = str_replace(",", "", $pString); 

            if (substr_count($pString, ".") > 1) 
                $pString = str_replace(".", "", $pString); 

            $pregResult = array(); 

            $commaset = strpos($pString,','); 
            if ($commaset === false) {$commaset = -1;} 

            $pointset = strpos($pString,'.'); 
            if ($pointset === false) {$pointset = -1;} 

            $pregResultA = array(); 
            $pregResultB = array(); 

            if ($pointset < $commaset) { 
                preg_match('#(([-]?[0-9]+(\.[0-9])?)+(,[0-9]+)?)#', $pString, $pregResultA); 
            } 
            preg_match('#(([-]?[0-9]+(,[0-9])?)+(\.[0-9]+)?)#', $pString, $pregResultB); 
            if ((isset($pregResultA[0]) && (!isset($pregResultB[0]) 
                    || strstr($preResultA[0],$pregResultB[0]) == 0 
                    || !$pointset))) { 
                $numberString = $pregResultA[0]; 
                $numberString = str_replace('.','',$numberString); 
                $numberString = str_replace(',','.',$numberString); 
            } 
            elseif (isset($pregResultB[0]) && (!isset($pregResultA[0]) 
                    || strstr($pregResultB[0],$preResultA[0]) == 0 
                    || !$commaset)) { 
                $numberString = $pregResultB[0]; 
                $numberString = str_replace(',','',$numberString); 
            } 
            else { 
                return false; 
            } 
            $result = (float)$numberString; 
            return $result; 
}   

function xrange($start, $limit, $step = 1) {
    if ($start < $limit) {
        if ($step <= 0) {
            throw new LogicException('Step must be +ve');
        }

        for ($i = $start; $i <= $limit; $i += $step) {
            yield $i;
        }
    } else {
        if ($step >= 0) {
            throw new LogicException('Step must be -ve');
        }

        for ($i = $start; $i >= $limit; $i += $step) {
            yield $i;
        }
    }
}

function modf($x) {
    $m = fmod($x, 1);
    return [$m, $x - $m];
}


function getPathLength($lat1,$lng1,$lat2,$lng2)
{
    $R = '6371000'; //# radius of earth in m
    $lat1rads = deg2rad($lat1);
    $lat2rads = deg2rad($lat2);
    $deltaLat = deg2rad(($lat2 - $lat1));
    $deltaLng = deg2rad(($lng2 - $lng1));
    $a = sin($deltaLat/2) * sin($deltaLat/2) + cos($lat1rads) * cos($lat2rads) * sin($deltaLng/2) * sin($deltaLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $d = $R * $c;
    return $d;
}

function getDestinationLatLong($lat,$lng,$azimuth,$distance){

    $R = 6378.1; //#Radius of the Earth in km
    $brng = deg2rad($azimuth); #Bearing is degrees converted to radians.
    $d = $distance / 1000; #Distance m converted to km
    $lat1 = deg2rad($lat); #Current dd lat point converted to radians
    $lon1 = deg2rad($lng); #Current dd long point converted to radians
    $lat2 = asin(sin($lat1) * cos($d/$R) + cos($lat1)* sin($d/$R)* cos($brng));
    $lon2 = $lon1 + atan2(sin($brng) * sin($d/$R)* cos($lat1), cos($d/$R)- sin($lat1)* sin($lat2));
    #convert back to degrees
    $lat2 = rad2deg($lat2);
    $lon2 = rad2deg($lon2);

    return [$lat2, $lon2];  
}

function calculateBearing($lat1,$lng1,$lat2,$lng2){
   // '''calculates the azimuth in degrees from start point to end point'''
    $startLat = deg2rad($lat1);
    $startLong = deg2rad($lng1);
    $endLat = deg2rad($lat2);
    $endLong = deg2rad($lng2);
    $dLong = $endLong - $startLong;
    $dPhi = log(tan($endLat / 2 + pi() / 4) / tan($startLat / 2 + pi() / 4));
    if (abs($dLong) > pi()) {
        if ($dLong > 0) {
            $dLong = -(2 * pi() - $dLong);
        } else {
            $dLong = 2 * pi() + $dLong;
        }
    }
    $bearing = (rad2deg(atan2($dLong, $dPhi)) + 360) % 360;
    return $bearing;
}

function main($interval, $azimuth, $lat1, $lng1, $lat2, $lng2) 
{
    $d = getPathLength($lat1, $lng1, $lat2, $lng2);
    $rapydUnpack = modf($d / $interval);
    $remainder = $rapydUnpack[0];
    $dist = $rapydUnpack[1];
    $counter = parseFloat($interval);
    $coords = [];
    array_push($coords, [ $lat1, $lng1 ]);

    $xRange = xrange(0, intval($dist));

    foreach ($xRange as $rapydIndex => $value) 
    {
    //print $value;
        $distance =$value;
        $coord = getDestinationLatLong($lat1, $lng1, $azimuth, $counter);
        $counter = $counter + parseFloat($interval);
        array_push($coords, $coord);
    }
    array_push($coords, [ $lat2, $lng2]);

    return $coords;
}

/*

function getMidPoint($lat1,  $lng1 , $lat2, $lng2) {

  #point interval in meters
    $interval = 1;
    #direction of line in degrees
    #start point
    //$lat1 = 43.97076;
    //$lng1 = 12.72543;
    #end point
    //$lat2 = 43.969730;
    //$lng2 = 12.728294;
    $azimuth = calculateBearing($lat1,$lng1,$lat2,$lng2);
    //print $azimuth;
    $coords = main($interval,$azimuth,$lat1,$lng1,$lat2,$lng2);
   
    return $coords;
}*/

//echo $_GET['lat1']." - ".$_GET['lng1']."  ".$_GET['lat2']." - ".$_GET['lng2'];
$lat1 = 25.59472; 
$lng1 = 85.11535;

$lat2 = 25.59471;
$lng2 = 85.11535;

/*
$lat1 = 43.97076;
$lng1 = 12.72543;

$lat2 = 43.969730;
$lng2 = 12.728294;
*/

 $interval = 20;
  $azimuth = calculateBearing($lat1,$lng1,$lat2,$lng2);
// $azimuth = 116;
  // print $azimuth."<br>";
  
 
$coords = main($interval,$azimuth,$lat1,$lng1,$lat2,$lng2);
 echo json_encode($coords);
?>
