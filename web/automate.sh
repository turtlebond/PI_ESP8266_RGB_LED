#!/bin/bash

user="mog";
pwd="123456";
db="my_db";
table="led_rgb";
udp_port="2390";

led_common="c";
#c-common cathode
#a-common anode


while getopts i:v:b: opt
do
	case $opt in
	  i)id=$OPTARG;;
	  v)val=$OPTARG;;
	  b)blink=$OPTARG;;
	  *)echo "Invalid arg";;
	esac
done
	
shift $((OPTIND - 1))

if [[ -z $id ]]
then
echo "Please provide id value"
exit 1;
fi

if [[ -z $val ]]
then
echo "Please provide value to overwrite"
exit 1;
fi

if [[ -z $blink ]]
then
echo "Please provide blink option to overwrite"
exit 1;
fi
	if [ "$blink" -eq 0 ]
	then
		status=0;
	else
		status=1;
	fi

	mysql -D $db -u $user -p$pwd -se "update $table set status=$status,blink_option=$blink,value='$val' where id=$id"
	read -r ip_addr <<< $(mysql -D $db -u $user -p$pwd -se "SELECT address FROM $table where id=$id")


	value="$blink,$val,$led_common";

	echo -n $value | nc -4u -w1 $ip_addr $udp_port
	

# value= "option(1),color1(6),colo2(6),color3(6),color4(6),color5(6),common anode/cathode(1)"
# a=common anode
# c=common cathode
      

exit 0
