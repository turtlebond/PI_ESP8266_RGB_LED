<html>
<head>

 <title>Home Automation</title>
 <script type="text/javascript" src="jscolor.min.js"></script>
<link rel="stylesheet" href="tab.css" />

<div class="tabs">
    <ul class="tab-links">
        <li><a href="index.php">Camera</a></li>
        <li ><a href="index_switch.php">Switch</a></li>
	<li><a href="index_automate.php">Switch Automation</a></li>
	<li><a href="index_rgb.php">RGB Light</a></li>
	<li class="active"><a href="index_rgb_auto.php">RGB Light Automation</a></li>
    </ul>
</div>

<script type="text/javascript" >


var oldOn1 = new Array; 
var oldOn2 = new Array;
var oldOff1 = new Array;
var oldOff2 = new Array;
var oldDay1 = new Array;
var oldDay2 = new Array;
var oldColor1 = new Array; 
var oldColor2 = new Array;
var oldBlink1 = new Array;
var oldBlink2 = new Array;

var newOn1 , newOn2;
var newOff1 , newOff2;
var newDay1 , newDay2;
var newColor1 , newColor2;
var newBlink1 , newBlink2;



function onchange_dropdown(id_select){

	var id=id_select.slice(0,-6);
	var div=id_select.slice(0,-4);
	div=div.slice(2);
	
	var ajaxDisplay = document.getElementById('ajaxDiv');
//	ajaxDisplay.innerHTML=id_select + "...." + id +"..." + div;
	
	var dropdownSelect=document.getElementById(id_select);
	var select_value=dropdownSelect.value;

	if ( select_value==4 || select_value==5 || select_value==6 || select_value==7 ){
		for (i=1; i< 5 ; i++) {
			var id_text= id + "_"+div+"_ctxt" + i; 
			var color_field=document.getElementById(id_text);	
			color_field.disabled=false;
	
		}
	}

	else if ( select_value==1 || select_value==2 || select_value==3 ){
		for (i =1; i< 5 ; i++) {
			var id_text= id + "_"+div+"_ctxt" + i; 
			var color_field=document.getElementById(id_text);	
			color_field.disabled=true;
	
		}		
	}

}



function IsValidTime(timeStr){
	
	var ajaxDisplay = document.getElementById('ajaxDiv');
//	ajaxDisplay.innerHTML = timeStr;

	var timePat1 = /^(\d{1,2}):(\d{2}):(\d{2})?$/; 
	var timePat2 = /^(\d{1,2}):(\d{2})?$/; 
	var matchArray1 = timeStr.match(timePat1);


	if( matchArray1==null){
		
		var matchArray2 = timeStr.match(timePat2);
		hour = matchArray2[1];
		minute = matchArray2[2] ;
	}
	else {
		hour = matchArray1[1];
		minute = matchArray1[2] ;
		second = matchArray1[3];
	}


	if (hour < 0  || hour > 23) {
		alert("Hour must be between 0 and 23.");
		return 0;
	}

	if (minute < 0 || minute > 59) {
		alert("Minute must be between 0 and 59.");
		return 0;
	}

	return 1;
}

function check_days(id,div_i){
	var ajaxDisplay = document.getElementById('ajaxDiv');
	var days_checked="";
	for(var k=0; k<7;k++) {


		var id_day_chk= id + "_" + div_i+ "_d"+k;  
		var day_ck=document.getElementById(id_day_chk).checked;

		switch(k) {
		    case 0:
			if(day_ck==true) {
			days_checked=days_checked.concat("Sun,");
			}
			break;
		    case 1:
			if(day_ck==true) {
			days_checked=days_checked.concat("Mon,");
			 }
			break;
		    case 2:
			if(day_ck==true) {
			days_checked=days_checked.concat("Tue,");
			 }
			break;
		    case 3:
			if(day_ck==true) {
			days_checked=days_checked.concat("Wed,");
			 }
			break;
		    case 4:
			if(day_ck==true) {
			days_checked=days_checked.concat("Thu,");
			 }
			break;
		    case 5:
			if(day_ck==true){
			days_checked=days_checked.concat("Fri,");
			 }
			break;
		    case 6:
			if(day_ck==true) {
			days_checked=days_checked.concat("Sat,");
			 }
			break;
		
		}
					
	}

	var days_checked=days_checked.slice(0, -1);	
//	ajaxDisplay.innerHTML = days_checked;	
	return days_checked;

}

var div2_visible=0;

function onclick_btn(id_btn){

	var ajaxDisplay = document.getElementById('ajaxDiv');

	var id=id_btn.slice(0,-5);	
	var btn=id_btn.slice(-1);
	

	var blink_option1, blink_option2;
	var on1, on2;
	var off1 ,off2;
	var color1="";
	var color2="";
	var day1="";
	var day2="";
	

	//get the drop down , Time on and time off values
	//also get  the color values
	for ( var div_i=0; div_i<2; div_i ++) {
		var id_select=id + "_"+div_i + "_sel";
		var id_textOn= id + "_" + div_i+ "_tOn";
		var id_textOff= id + "_" + div_i+ "_tOff";

		if ( div_i==0) {
			blink_option1=document.getElementById(id_select).value;	
			on1=document.getElementById(id_textOn).value;
			off1=document.getElementById(id_textOff).value;
		}
		else if ( div_i==1) {
			blink_option2=document.getElementById(id_select).value;
			on2=document.getElementById(id_textOn).value;
			off2=document.getElementById(id_textOff).value;

		}
		//color
		for (var k=0; k<5; k++ ){
			var id_color= id + "_"+div_i+"_ctxt" + k; 
			var color=document.getElementById(id_color).value;
			if ( div_i==0) color1=color1 + color +",";
			else if ( div_i==1) color2=color2 + color +",";
		}

		
	}

	
	color1=color1.slice(0,-1);
	color2=color2.slice(0,-1);
		
	//check days
	day1=check_days(id,0);
	day2=check_days(id,1);

	newColor1=color1;
	newColor2=color2;
	newDay1=day1;
	newDay2=day2;	
	newOn1=on1;
	newOn2=on2;	
	newOff1=off1;
	newOff2=off2;
	newColor1=color1;
	newColor2=color2;
	newBlink1=blink_option1;
	newBlink2=blink_option2;


	var tdStatus= id + "tdStatus";
	tdStatusText=document.getElementById(tdStatus).innerHTML;

		

	switch (btn) {

		case '0': //disable
			var auto1=0; 
			var auto2=0;
			update_sql(id,auto1,blink_option1,color1,on1,off1,day1,auto2,blink_option2,color2,on2,off2,day2);
			update_page();
			update_cron(id,0);
			break;

		case '1': //update
			var auto1=1;
			var auto2=0;
			var val_on2=1;
			var val_off2=1;
			var sel=0;

			//ajaxDisplay.innerHTML=div2_visible;
			
			if( div2_visible==1 && tdStatusText=="Enabled") {
				var auto2=1;
				if (day2 =="") alert("Please select day");
				val_on2=IsValidTime(on2);
				val_off2=IsValidTime(off2);
				sel=1;
				
			}

			
			if (day1 =="") alert("Please select day");
			if(IsValidTime(on1)==1 && IsValidTime(off1)==1 && val_on2 && val_off2)
				update_sql(id,auto1,blink_option1,color1,on1,off1,day1,auto2,blink_option2,color2,on2,off2,day2);

			update_page();
			if (sel) update_cron(id,2);
			else update_cron(id,1);

			break;

		case '2': //+ sign - enable div2
			div2_visible=1;
		
			var div_i=1;
			var div_select_id=id+"_DIV"+div_i+"_sel";
			document.getElementById(div_select_id).style.display="inline";

			var div_color_id=id+"_DIV"+div_i+"_ctxt";
			document.getElementById(div_color_id).style.display="inline";

			var div_on_id=id+"_DIV"+div_i+"_tOn";
			document.getElementById(div_on_id).style.display="inline";

			var div_off_id=id+"_DIV"+div_i+"_tOff";
			document.getElementById(div_off_id).style.display="inline";
			
			for (var day=0; day<7; day++) {
					var div_day_id=id+"_DIV"+div_i+"_d"+day;
					document.getElementById(div_day_id).style.display="inline";
					
				}
			break;

		case '3': //- sign .. set auto2=0
			var auto1=1;
			var auto2=0;
			var div_i=1;
			div2_visible=0;

			var div_select_id=id+"_DIV"+div_i+"_sel";
			document.getElementById(div_select_id).style.display="none";

			var div_color_id=id+"_DIV"+div_i+"_ctxt";
			document.getElementById(div_color_id).style.display="none";

			var div_on_id=id+"_DIV"+div_i+"_tOn";
			document.getElementById(div_on_id).style.display="none";

			var div_off_id=id+"_DIV"+div_i+"_tOff";
			document.getElementById(div_off_id).style.display="none";
			
			for (var day=0; day<7; day++) {
					var div_day_id=id+"_DIV"+div_i+"_d"+day;
					document.getElementById(div_day_id).style.display="none";
					
				}

			update_sql(id,auto1,blink_option1,color1,on1,off1,day1,auto2,blink_option2,color2,on2,off2,day2);
			update_page();
			update_cron(id,3);
			break;
			

	}

		
}

function update_cron(id,opt){

	var ajaxDisplay = document.getElementById('ajaxDiv');

	var ajax_update;
	if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
	else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

	switch (opt){
	case 0: 
		ajax_update.open("GET","update_cron.php?opt=0" + "&tOnOLD=" + oldOn1[id] +"&tOffOLD=" + oldOff1[id] + "&DayOLD=" + oldDay1[id] +  "&oldColor1="+oldColor1[id] + "&oldBlink1="+oldBlink1[id] + "&tOn2OLD=" + oldOn2[id] +"&tOff2OLD=" + oldOff2[id]  + "&Day2OLD=" + oldDay2[id]  + "&oldColor2="+oldColor2[id]  + "&oldBlink2="+oldBlink2[id] +"&id=" + id,true);

		break;

	case 1:
		ajax_update.open("GET","update_cron.php?opt=1" + "&tOn="+ newOn1 +"&tOff=" + newOff1 + "&Day=" + newDay1 + "&Color1="+newColor1 + "&Blink1="+newBlink1 + "&tOnOLD=" + oldOn1[id] + "&tOffOLD=" + oldOff1[id]  + "&DayOLD=" + oldDay1[id]   + "&oldColor1="+oldColor1[id]  + "&oldBlink1="+oldBlink1[id] +"&id=" + id,true);
		break;

	case 2:
		ajax_update.open("GET","update_cron.php?opt=2" + "&tOn="+ newOn1 +"&tOff=" + newOff1 + "&Day=" + newDay1 + "&Color1="+newColor1 + "&Blink1="+newBlink1 + "&tOnOLD=" + oldOn1[id] +"&tOffOLD=" + oldOff1[id]  + "&DayOLD=" + oldDay1[id]   + "&oldColor1="+oldColor1[id] +  "&oldBlink1="+oldBlink1[id] + "&tOn2=" + newOn2 +"&tOff2=" + newOff2 + "&Day2=" + newDay2 + "&Color2="+newColor2 + "&Blink2="+newBlink2 + "&tOn2OLD=" + oldOn2[id] +"&tOff2OLD=" + oldOff2[id] + "&Day2OLD=" + oldDay2[id]  + "&oldColor2="+oldColor2[id]  + "&oldBlink2="+oldBlink2[id]+ "&id=" + id,true);
		break;
	case 3:
		ajax_update.open("GET","update_cron.php?opt=3" + "&tOn2OLD="+ oldOn2[id] +"&tOff2OLD=" + oldOff2[id] + "&Day2OLD=" + oldDay2[id] + "&id=" + id,true);
		break;

	}

	ajax_update.send();
	ajax_update.onreadystatechange = function() {
	if(ajax_update .readyState == 4 && ajax_update.status == 200){ 
//		ajaxDisplay.innerHTML=ajax_update.responseText;

	}
	}


}

function update_sql(id,auto1,blink_opt1,value1,on1,off1,day1,auto2,blink_opt2,value2,on2,off2,day2){

	var ajaxDisplay = document.getElementById('ajaxDiv');
		

	var ajax_update;

	if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
	else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

	ajax_update.open("GET","status_rgb_sql.php?opt=4" + "&id=" + id + "&auto1=" + auto1 + "&blink_option1=" + blink_opt1 + "&value1=" + value1 + "&on1=" + on1 + "&off1=" + off1 +"&day1=" + day1 + "&auto2=" + auto2 + "&blink_option2=" + blink_opt2 +"&value2=" + value2 + "&on2=" + on2 + "&off2=" + off2 +"&day2=" + day2,true);

		
	ajax_update.send();

	ajax_update.onreadystatechange = function() {
    		if(ajax_update.readyState == 4 && ajax_update.status == 200){ 
//		ajaxDisplay.innerHTML=ajax_update.responseText;

	}
	}

}

function update_page(){
	var ajaxDisplay = document.getElementById('ajaxDiv');

	var ajax_update;

	if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
	else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

	ajax_update.open("GET","status_rgb_sql.php?opt=3" ,true);
	ajax_update.send();

	ajax_update.onreadystatechange = function() {
    		if(ajax_update.readyState == 4 && ajax_update.status == 200){ 
	
		var jsonStr = JSON.parse(ajax_update.responseText);
//		ajaxDisplay.innerHTML=ajax_update.responseText;

		var elements=jsonStr[0];

		for (var i=1; i< elements+1; i++) {
			var j=(i-1)*14+1;

			var id=jsonStr[j];
			var title=jsonStr[j+1];
			var value1=jsonStr[j+2];
			var value2=jsonStr[j+3];
			var auto1=jsonStr[j+4];
			var auto2=jsonStr[j+5];
			var on1=jsonStr[j+6];
			var on2=jsonStr[j+7];
			var off1=jsonStr[j+8];
			var off2=jsonStr[j+9];
			var day1=jsonStr[j+10];
			var day2=jsonStr[j+11];
			var blink1=jsonStr[j+12];
			var blink2=jsonStr[j+13];		
	
			oldColor1[id]=value1;
			oldColor2[id]=value2;
			oldOn1[id]=on1;
			oldOff1[id]=off1;	
			oldOn2[id]=on2;
			oldOff2[id]=off2;
			oldDay1[id]=day1;
			oldDay2[id]=day2;
			oldBlink1[id]=blink1;
			oldBlink2[id]=blink2;	


			var tdArea= id + "tdArea";
			var tdAreaText=document.getElementById(tdArea);
			tdAreaText.innerHTML=title;


			//show the automation status based on the auto_en
			var tdStatus= id + "tdStatus";
			var tdStatusText=document.getElementById(tdStatus);	
			
			if ( auto1 ==1 )
				tdStatusText.innerHTML="Enabled";
			else
				tdStatusText.innerHTML="Disabled";			


			//hide/unhide div-1 for dropdown, checkbox, time, color based on auto2
			//enabled disable +/- button
			var div_i=1;
			var div_select_id=id+"_DIV"+div_i+"_sel";
			var divSelect=document.getElementById(div_select_id);	

			var div_color_id=id+"_DIV"+div_i+"_ctxt";
			var divColor=document.getElementById(div_color_id);

			var div_on_id=id+"_DIV"+div_i+"_tOn";
			var divOn=document.getElementById(div_on_id);

			var div_off_id=id+"_DIV"+div_i+"_tOff";
			var divOff=document.getElementById(div_off_id);

			var id_button_add = id + "_btn2";
			var id_button_minus = id + "_btn3";
			
					
	
			if ( auto2==0) {

				
				document.getElementById(id_button_add).disabled=false;
				document.getElementById(id_button_minus).disabled=true;

				divSelect.style.display="none";
				divColor.style.display="none";	
				divOn.style.display="none";
				divOff.style.display="none";

				for (var day=0; day<7; day++) {
					var div_day_id=id+"_DIV"+div_i+"_d"+day;
					var divDay=document.getElementById(div_day_id);
					divDay.style.display="none";
				}
			}
			else {

				document.getElementById(id_button_add).disabled=true;
				document.getElementById(id_button_minus).disabled=false;

				divSelect.style.display="inline";
				divColor.style.display="inline";	
				divOn.style.display="inline";
				divOff.style.display="inline";
				for (var day=0; day<7; day++) {
					var div_day_id=id+"_DIV"+div_i+"_d"+day;
					var divDay=document.getElementById(div_day_id);
					divDay.style.display="inline";
				}

			}

			
			//show colors based on the div		
			var res=value1.split(",");
			var res2=value2.split(",");
			for ( var div_i=0; div_i<2; div_i ++) {	
				for (var k=0; k<5; k++ ){
					var id_text= id + "_"+div_i+"_ctxt" + k; 
					var color=document.getElementById(id_text);
					if ( div_i ==0)	color.value=res[k];
					else if (div_i ==1)color.value=res2[k];						

				}
			}

			//show timeOn and timeOff
			for ( var div_i=0; div_i<2; div_i ++) {	
				var id_textOn= id + "_" + div_i+ "_tOn"; 
				var id_textOff= id + "_" + div_i+ "_tOff"; 
				var tOn=document.getElementById(id_textOn);
				var tOff=document.getElementById(id_textOff);
				if ( div_i ==0) {
					tOn.value=on1;
					tOff.value=off1;				
				}
				else if (div_i ==1) {
					tOn.value=on2;
					tOff.value=off2;				
				}
			}

			//show day
			for ( var div_i=0; div_i<2; div_i ++) {	
				if ( div_i==0) day=day1;
				else if (div_i==1) day=day2; 
				for ( k=0; k<7; k++) {
					var id_day_chk= id + "_" + div_i+ "_d"+k; 
					element=document.getElementById(id_day_chk);
					switch (k) {
					case 0: 
						var matches=day.match(/Sun/g);
						if(matches!=null) element.setAttribute("checked",true);
						break;
					case 1:
						var matches=day.match(/Mon/g);
						if(matches!=null) element.setAttribute("checked",true);
						break;
					case 2:
						var matches=day.match(/Tue/g);
						if(matches!=null) element.setAttribute("checked",true);
						break;	
					case 3:
						var matches=day.match(/Wed/g);
						if(matches!=null) element.setAttribute("checked",true);
						break;		
					case 4:
						var matches=day.match(/Thu/g);
						if(matches!=null) element.setAttribute("checked",true);
						break;	
					case 5:
						var matches=day.match(/Fri/g);
						if(matches!=null) element.setAttribute("checked",true);
						break;	
					case 6:
						var matches=day.match(/Sat/g);
						if(matches!=null) element.setAttribute("checked",true);
						break;	
					
					}
					
				
				}
			}

			//disable color except 1st if drop down is 1-3
			
		}

		jscolor.installByClassName("jscolor");	
		

		}
	}
	
}


function create_table(){

	var ajaxDisplay = document.getElementById('ajaxDiv');

	var ajax_update;
	

	var mytable = document.createElement("TABLE");
//	mytable.setAttribute("id","myTable");
	mytable.id="myTable";
    	mytable.border = "1";
	
	var x=["Area","Automation","Choose Option","Color","ON","OFF","S","M","T","W","T","F","S","Action"];
	var header_tr= document.createElement('tr'); 

	for (var k=0; k<14; k++){
		var header_text=x[k];
		var header_td = document.createElement('td');
		header_td.appendChild(document.createTextNode(header_text));
		header_tr.appendChild(header_td);
	}

	mytable.appendChild(header_tr);
	ajaxDisplay.appendChild(mytable);

	if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
	else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

	ajax_update.open("GET","status_rgb_sql.php?opt=2" ,true);
	ajax_update.send();

	ajax_update.onreadystatechange = function() {
    		if(ajax_update.readyState == 4 && ajax_update.status == 200){ 
		//ajaxDisplay.innerHTML=ajax_update.responseText;
		
		var jsonStr = JSON.parse(ajax_update.responseText);
		
		var elements=jsonStr[0];

		for ( var elem=1; elem<elements+1 ; elem++) {

			var id=jsonStr[elem];

			var tr = document.createElement('tr');
			mytable.appendChild(tr);


			for ( var k=0; k<14; k++){
				var td = document.createElement('td');
				tr.appendChild(td)
			
				switch (k) {
				case 0: 
					td.id=id+"tdArea";
					break;
				case 1: 
					td.id=id+"tdStatus";
					break;	
	
				case 2: 
					for ( var div_i=0; div_i<2; div_i ++) {

						div_select_id=id+"_DIV"+div_i+"_sel";
						var div_main= document.createElement("div");
						div_main.setAttribute("id", div_select_id);					
					
						var id_select=id + "_"+div_i + "_sel";
		
						var dropdownSelect=document.createElement("select");
						dropdownSelect.setAttribute("id", id_select);
						dropdownSelect.setAttribute("onchange", 'onchange_dropdown(id);');
	
						for (i =1; i<8 ;i++) {
							var op = document.createElement("option");
							op.value=i;
							op.text=i;
							dropdownSelect.appendChild(op);
						}

						div_main.appendChild(dropdownSelect);
						td.appendChild(div_main);
					}
										

					break;
				case 3: 
					for ( var div_i=0; div_i<2; div_i ++) {	
						div_color_id=id+"_DIV"+div_i+"_ctxt";

						var div_main=document.createElement("div");
						div_main.setAttribute("id", div_color_id);

						for (i=0; i<5; i++ ){
							var id_text= id + "_" + div_i+ "_ctxt" + i; 

							var div = document.createElement("div");
							div.setAttribute("class", "form-item");

							var color_text = document.createElement("input");
							color_text.setAttribute("id", id_text);
							color_text.className= 'jscolor';	
							color_text.setAttribute("value", "123456");

							div.appendChild(color_text) ;
							div_main.appendChild(div) ;
						}
						td.appendChild(div_main);

					}
					break;

				case 4: 
					for ( var div_i=0; div_i<2; div_i ++) {	
						var div_on_id=id+"_DIV"+div_i+"_tOn";
						var id_text= id + "_" + div_i+ "_tOn"; 

						var div_main=document.createElement("div");
						div_main.setAttribute("id", div_on_id);
						var element = document.createElement("input");
						element.setAttribute("type","text");
						element.setAttribute("id", id_text);
						div_main.appendChild(element) ;
						td.appendChild(div_main);
					}				

					break;

				case 5: 
					for ( var div_i=0; div_i<2; div_i ++) {	
						var div_off_id=id+"_DIV"+div_i+"_tOff";
						var id_text= id + "_" + div_i+ "_tOff"; 

						var div_main=document.createElement("div");
						div_main.setAttribute("id", div_off_id);
						var element = document.createElement("input");
						element.setAttribute("type","text");
						element.setAttribute("id", id_text);
						div_main.appendChild(element) ;
						td.appendChild(div_main);
					}	
					break;

				case 6: case 7: case 8: case 9: case 10: case 11: case 12: 
					for ( var div_i=0; div_i<2; div_i ++) {	
						var day= k - 6;
						var div_day_id=id+"_DIV"+div_i+"_d"+day;
						var div_main=document.createElement("div");
						div_main.setAttribute("id", div_day_id);

						var id_day_chk= id + "_" + div_i+ "_d"+day; 

						
						var element = document.createElement("input");
						element.setAttribute("type","checkbox");
						element.setAttribute("id", id_day_chk);
						div_main.appendChild(element);
						td.appendChild(div_main);
					}
					break;
			
				case 13: 
					for (i=0; i<4; i++) {
						var val;
						var id_button = id + "_btn" + i;
						var button = document.createElement("input");
						button.setAttribute("type","button");
						button.setAttribute("id", id_button);
						switch (i) {
							case 1: 
								val= "Update";
								break;
							case 0: 
								val="Disable";
								break;
							case 2: 
								val= "+";
								break;
							case 3: 
								val= "-";
								break;
						}
						button.setAttribute("value", val);
						button.setAttribute("onclick", 'onclick_btn(id);');
						td.appendChild(button);
	
					}
					break;
				}	
		

			}
			 
			
			update_page();

		}

	}
	}

	
}

function init(){
	create_table();
}

</script>

</head>
<body onload="setTimeout('init();', 100);">

</br>
 <div id="ajaxDiv"> </div>
<div id="dropdownDiv">
<!--
	<select id="dropdown" onchange="add_color_field(this.value)">
	  <option value="1">1</option>
	  <option value="2">2</option>
	</select>
-->

<div id=colorDiv>
<!--
<input class="jscolor" value="ab2567">
-->
</div>
<div id="buttonDiv">
<!--
	<input type="button" value="Set" onclick="setValue(color1.value,color2.value,color3.value,color4.value,color5.value)" />
	<input type="button" value="Off" onclick="setValue('#000000')" />
-->
</div>


</div>
</body>
</html>
