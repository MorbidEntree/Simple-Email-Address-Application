<?php
//////////////////////////////////////////////////////////
///THIS IS A THIRD PARTY SCRIPT, I DID NOT WRITE THIS////
////////////////////////////////////////////////////////
//
//   CF Image IP 0.91
//   -------------------------------
//
//   Author:    codefuture.co.uk
//   Version:   0.91
//   Date:      18-Jan-11
//
//   download the latest version from - http://codefuture.co.uk/projects/imageip/
//
//   Copyright (c) 2011 codefuture.co.uk
//   This file is part of the CF Image IP 0.9.
//
//   CF Image IP Script is free software: you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation, either version 3 of the License, or
//   (at your option) any later version.
//
//   CF Image IP Script is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//   You should have received a copy of the GNU General Public License
//   along with CF Image IP Script.  If not, see http://www.gnu.org/licenses/.
//
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
// Settings

// Image color setup
	$outerBorder	= "b9b9b9"; // ob=b9b9b9
	$innerBorder	= "ffffff"; // ib=ffffff
	$leftFill		= "cccccc"; // lf=cccccc
	$leftTextColor	= "555555"; // ltc=555555
	$rightFill		= "dddddd"; // rf=dddddd
	$rightTextColor	= "555555"; // rtc=555555

// on-the-fly color settings
//  <img src="ip.php?ob=b9b9b9&ib=ffffff&lf=cccccc&ltc=555555&rf=dddddd&rtc=555555" />

// image quality from 0-100
	$scaleQuality = 100;

////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
// Do not edit beyond this line

// get on-the-fly color settings
	if(isset($_GET['ob'])) $outerBorder		= $_GET['ob'];
	if(isset($_GET['ib'])) $innerBorder		= $_GET['ib'];
	if(isset($_GET['lf'])) $leftFill		= $_GET['lf'];
	if(isset($_GET['ltc'])) $leftTextColor	= $_GET['lt'];
	if(isset($_GET['rf'])) $rightFill		= $_GET['rf'];
	if(isset($_GET['rtc'])) $rightTextColor	= $_GET['rt'];

// draw the image
	DrawButton($outerBorder,$innerBorder,$leftFill,$leftTextColor,$rightFill,$rightTextColor,$scaleQuality);

// Functions
function ImageColorAllocateHex($image,$hex) { 
	for( $i=0; $i<3; $i++ ) {
		$temp = substr($hex, 2*$i, 2); 
		$rgb[$i] = 16 * hexdec( substr($temp, 0, 1) ) + hexdec(substr($temp, 1, 1)); 
	}
	return ImageColorAllocate ( $image, $rgb[0], $rgb[1], $rgb[2] );
}
function getRGB($hex) { 
	for( $i=0; $i<3; $i++ ) {
		$temp = substr($hex, 2*$i, 2); 
		$rgb[$i] = 16 * hexdec( substr($temp, 0, 1) ) + hexdec(substr($temp, 1, 1)); 
	}
	return $rgb;
}
function DrawButton($ob,$ib,$lf,$ltc,$rf,$rtc,$sq){

	$font['image'] = 'iVBORw0KGgoAAAANSUhEUgAAAEYAAAAFCAMAAADPPGp0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAZQTFRFAAAA////pdmf3QAAAAJ0Uk5T/wDltzBKAAAAUElEQVR42myQgQoAMQhC9f9/+hh2TWUwmjxKIwAk4ZWj9ZWOepo1pSGBwbIx+PN+xsfGMpTt+zF72gaVvf21wVIUv2KzkdmIS5Cv25jfJ8AAoLwA7HynlYYAAAAASUVORK5CYII=';
	$font['xy']= array(46 => array("x"=>59, "y"=>0, "w"=>2),48 => array("x"=>53, "y"=>0, "w"=>5),49 => array("x"=>0, "y"=>0, "w"=>5),50 => array("x"=>5, "y"=>0, "w"=>5),51 => array("x"=>11, "y"=>0, "w"=>5),52 => array("x"=>17, "y"=>0, "w"=>5),
					53 => array("x"=>23, "y"=>0, "w"=>5),54 => array("x"=>29, "y"=>0, "w"=>5),55 => array("x"=>35, "y"=>0, "w"=>5),56 => array("x"=>41, "y"=>0, "w"=>5),57 => array("x"=>47, "y"=>0, "w"=>5),73 => array("x"=>62, "y"=>0, "w"=>2),80 => array("x"=>65, "y"=>0, "w"=>5));

	header ("Content-type: image/png");
	$im = @imagecreatetruecolor(80, 15) or die ("Cannot Initialize new GD image stream");
	imagerectangle($im, 0, 0, 79, 14, ImageColorAllocateHex($im, $ob));
	imagerectangle($im, 1, 1, 78, 13, ImageColorAllocateHex($im, $ib));

	imageline ($im, 10, 1, 10, 12, ImageColorAllocateHex($im, $ib));

	imagefilledrectangle($im, 2, 2, 9, 12, ImageColorAllocateHex($im, $lf));
	imagefilledrectangle($im, 11, 2, 77, 12, ImageColorAllocateHex($im, $rf));

	$im = right2img($ltc,strtoupper('IP'),3,$font['image'],$font['xy'],$im);
	$im = right2img($rtc,strtoupper(getIpAddress()),(strlen($_SERVER['REMOTE_ADDR'])<15?15:12),$font['image'],$font['xy'],$im);

	imagepng($im,NULL,(9 - round(($sq/100) * 9)),NULL);
	imagedestroy($im);
}
function right2img($color,$text,$pos,$font,$fontxy,$im){
	$letters = imagecreatefromstring(base64_decode($font));
	$rgb = getRGB($color);
	$index = imagecolorexact($letters, 0, 0, 0);
	imagecolorset ($letters, $index, $rgb[0], $rgb[1], $rgb[2]);
	for($i=0;$i<strlen($text);$i++){
		$c = ord($text[$i]);
		imagecopy ($im, $letters, $pos, 5, $fontxy[$c]["x"], $fontxy[$c]["y"], $fontxy[$c]["w"], 5);
		$pos+=$fontxy[$c]["w"];
	}
	return $im;
}
function getIpAddress() {
	$check = array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR');
	$ip = '0.0.0.0';
	foreach ($check as $key) {
		if (isset($_SERVER[$key])) {
			list ($ip) = explode(',', $_SERVER[$key]);
			break;
		}
	}
	return $ip;
}
?>
