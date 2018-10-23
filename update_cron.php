<?php

$script_path="/var/www/html/main";
$automate="$script_path/automate.sh";

$opt=$_GET['opt'];

$id=$_GET['id'];

$tOn=$_GET['tOn'];
$tOn2=$_GET['tOn2'];
$tOnOLD=$_GET['tOnOLD'];
$tOn2OLD=$_GET['tOn2OLD'];

$tOff=$_GET['tOff'];
$tOff2=$_GET['tOff2'];
$tOffOLD=$_GET['tOffOLD'];
$tOff2OLD=$_GET['tOff2OLD'];

$Day=$_GET['Day'];
$DayOLD=$_GET['DayOLD'];
$Day2=$_GET['Day2'];
$Day2OLD=$_GET['Day2OLD'];

$Color1=$_GET['Color1'];
$Color2=$_GET['Color2'];
$oldColor2=$_GET['oldColor2'];
$oldColor1=$_GET['oldColor1'];

$Blink1=$_GET['Blink1'];
$Blink2=$_GET['Blink2'];
$oldBlink2=$_GET['oldBlink2'];
$oldBlink1=$_GET['oldBlink1'];
/*
echo "id=$id<br>";
echo "opt=$opt<br>";
echo "tOn=$tOn<br>";
echo "tOFf=$tOff<br>";
echo "tOn2=$tOn2<br>";
echo "tOFf2=$tOff2<br>";
echo "Day=$Day<br>";
echo "Day2=$Day2<br>";
echo "DayOLD=$DayOLD<br>";
*/


$filename="cron.txt";
$path="/var/www/html/";
$file="$path/$filename";

$tOn_hr=substr($tOn, 0,2);
$tOff_hr=substr($tOff, 0,2);
$tOnOLD_hr=substr($tOnOLD, 0,2);
$tOffOLD_hr=substr($tOffOLD, 0,2);

$tOn_min=substr($tOn, 3,2);
$tOff_min=substr($tOff, 3,2);
$tOnOLD_min=substr($tOnOLD, 3,2);
$tOffOLD_min=substr($tOffOLD, 3,2);



$tOn2_hr=substr($tOn2, 0,2);
$tOff2_hr=substr($tOff2, 0,2);
$tOn2OLD_hr=substr($tOn2OLD, 0,2);
$tOff2OLD_hr=substr($tOff2OLD, 0,2);

$tOn2_min=substr($tOn2, 3,2);
$tOff2_min=substr($tOff2, 3,2);
$tOn2OLD_min=substr($tOn2OLD, 3,2);
$tOff2OLD_min=substr($tOff2OLD, 3,2);

$content_on="* * $Day $automate -i $id -v $Color1 -b $Blink1";
$content_off="* * $Day $automate -i $id -v $Color1 -b 0";

$content_on_old="* * $DayOLD $automate -i $id -v $oldColor1 -b $oldBlink1";
$content_off_old="* * $DayOLD $automate -i $id -v $oldColor1 -b 0";

$content_on2="* * $Day2 $automate -i $id -v $Color2 -b $Blink2";
$content_off2="* * $Day2 $automate -i $id -v $Color2 -b 0";

$content_on2_old="* * $Day2OLD $automate -i $id -v $oldColor2 -b $oldBlink2";
$content_off2_old="* * $Day2OLD $automate -i $id -v $oldColor2 -b 0";
$mail=">/dev/null 2>&1";

echo "content_on=$content_on<br>";
echo "content_on_old=$content_on_old<br>";

$time_ON_new="$tOn_min $tOn_hr $content_on $mail";
$time_ON_old="$tOnOLD_min $tOnOLD_hr $content_on_old $mail";

$time_ON2_new="$tOn2_min $tOn2_hr $content_on2 $mail";
$time_ON2_old="$tOn2OLD_min $tOn2OLD_hr $content_on2_old $mail";



$time_OFF_new="$tOff_min $tOff_hr $content_off $mail";
$time_OFF_old="$tOffOLD_min $tOffOLD_hr $content_off_old $mail";

$time_OFF2_new="$tOff2_min $tOff2_hr $content_off2 $mail";
$time_OFF2_old="$tOff2OLD_min $tOff2OLD_hr $content_off2_old $mail";


//echo "time_ON_new=$time_ON_new<br>";
//echo "time_ON_old=$time_ON_old<br>";
//echo "time_ON2_new=$time_ON2_new<br>";
//echo "time_ON2_old=$time_ON2_old<br>";

//echo "time_OFF_new=$time_OFF_new<br>";
//echo "time_OFF_old=$time_OFF_old<br>";
//echo "time_OFF2_new=$time_OFF2_new<br>";
//echo "time_OFF2_old=$time_OFF2_old<br>";


function cronfile_delete($filename,$time_old,$time_new){
	$file_content = file_get_contents($filename);
	if ((strpos($file_content,$time_old)) !== false){
		$file_content=str_replace($time_old,$time_new,$file_content);
		$file_content=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $file_content); //clear empty lines
		file_put_contents($filename,$file_content);
	}
}

function cronfile_update($filename,$time_old,$time_new){
	$file_content = file_get_contents($filename);
//	echo "time_old=$time_old   time_new=$time_new<br>";
	if ((strpos($file_content,$time_old)) !== false){
		$file_content=str_replace($time_old,$time_new,$file_content);
		file_put_contents($filename,$file_content);
	}
	else{
		$fhandle=fopen($filename,'a+')  or die("Unable to open file!");
		$text="$time_new\n";
		fwrite($fhandle,$text);
		fclose($fhandle);
	}

}

$output = shell_exec('crontab -l');
file_put_contents($filename,$output);

switch ($opt){

case 0: 
//	echo "option=0<br>";
	cronfile_delete($filename,$time_ON_old,'');
	cronfile_delete($filename,$time_OFF_old,'');
	cronfile_delete($filename,$time_ON2_old,'');
	cronfile_delete($filename,$time_OFF2_old,'');
	break;

case 1: 
//	echo "option=1<br>";
	cronfile_update($filename,$time_ON_old,$time_ON_new);
	cronfile_update($filename,$time_OFF_old,$time_OFF_new);
	break;

case 2: 
//	echo "option=2<br>";
	cronfile_update($filename,$time_ON_old,$time_ON_new);
	cronfile_update($filename,$time_OFF_old,$time_OFF_new);
	cronfile_update($filename,$time_ON2_old,$time_ON2_new);
	cronfile_update($filename,$time_OFF2_old,$time_OFF2_new);
	break;

case 3: 
//	echo "option=3<br>";
	cronfile_delete($filename,$time_ON2_old,'');
	cronfile_delete($filename,$time_OFF2_old,'');
	break;

}

exec("crontab $filename");

//echo "Done"

?>
