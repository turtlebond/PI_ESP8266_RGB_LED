<html>
<head>

 <title>Home Automation</title>
 <script type="text/javascript" src="jscolor.min.js"></script>
<link rel="stylesheet" href="tab.css" />

<div class="tabs">
    <ul class="tab-links">
	<li class="active"><a href="index_rgb.php">RGB Light</a></li>
	<li><a href="index_rgb_auto.php">RGB Light Automation</a></li>
    </ul>
</div>


<?php
$value=$_GET["value"];
$addr=$_GET['addr'];

$led_common="c";
//c-common cathode
//a-common anode

//echo $value;
//echo $addr;
$value="$value,$led_common";

//value= "option,color1,colo2,color3,color4,color5"
shell_exec("echo -n $value | nc -4u -w1 $addr 2390");

?>

<script type="text/javascript" >

var addr=new Array;



function setValue(opt,c,address)
{
	var ajaxDisplay = document.getElementById('ajaxDiv');

	var val=opt +"," + c;
	
	//ajaxDisplay.innerHTML=val;

	var ajax_val;

	if(window.XMLHttpRequest) ajax_val= new XMLHttpRequest();
	else  ajax_val= new ActiveXObject("Microsoft.XMLHTTP");
	ajax_val.open("GET","?value=" + val +"&addr="+ address ,true );
	ajax_val.send();
	ajax_val.onreadystatechange = function() {
	    if(ajax_val.readyState == 4 && ajax_val.status == 200){ 	
//		ajaxDisplay.innerHTML = ajax_val.responseText;
	}
	}

}

function onchange_dropdown(id_select){

	var id=id_select.slice(0,-4);
	
	var ajaxDisplay = document.getElementById('ajaxDiv');
//	ajaxDisplay.innerHTML = id;
	
	var dropdownSelect=document.getElementById(id_select);
	var select_value=dropdownSelect.value;

//	ajaxDisplay.innerHTML = select_value;
	if ( select_value==4 || select_value==5 || select_value==6 || select_value==7 ){
		for (i=1; i< 5 ; i++) {
			var id_text= id + "_txt" + i;
			var color_field=document.getElementById(id_text);	
			color_field.disabled=false;
	
		}
	}

	else if ( select_value==1 || select_value==2 || select_value==3 ){
		for (i =1; i< 5 ; i++) {
			var id_text= id + "_txt" + i; 
			var color_field=document.getElementById(id_text);	
			color_field.disabled=true;
	
		}		
	}
	
}

function update_sql(id,status,blink_opt,value){

	var ajaxDisplay = document.getElementById('ajaxDiv');

	var ajax_update;

	if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
	else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

	ajax_update.open("GET","status_rgb_sql.php?opt=1" + "&id=" + id + "&status=" + status +"&blink_option=" + blink_opt + "&value=" + value ,true);
	ajax_update.send();

	ajax_update.onreadystatechange = function() {
    		if(ajax_update.readyState == 4 && ajax_update.status == 200){ 
//		ajaxDisplay.innerHTML=ajax_update.responseText;

	}
	}

}

function onclick_btn(id_btn){

	var ajaxDisplay = document.getElementById('ajaxDiv');

	var id=id_btn.slice(0,-5);	
	var btn=id_btn.slice(-1);
//	ajaxDisplay.innerHTML = btn;
	
	var id_select=id + "_sel";
	var select=document.getElementById(id_select);
	var opt=select.value;
//	ajaxDisplay.innerHTML = opt;
	
	var c = new Array;
	var c1="";
	for (i=0; i<5; i++ ){
		var id_text= id + "_txt" + i; 
		var color=document.getElementById(id_text);
		c[i]=color.value;
		c1=c1 + c[i] +",";
	}

	c1=c1.slice(0,-1);

//	ajaxDisplay.innerHTML = c1;

	var address=addr[id];

	switch (btn) {
		case '0': 
			update_sql(id,0,opt,c1);
			setValue(0,c, address);
			break;
		case '1': 
			update_sql(id,1,opt,c1);
			setValue(opt,c,address);
			break;

	}
	
	update_page();
		
}

function update_page(){
	var ajaxDisplay = document.getElementById('ajaxDiv');

	var ajax_update;

	if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
	else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

	ajax_update.open("GET","status_rgb_sql.php?opt=0" ,true);
	ajax_update.send();

	ajax_update.onreadystatechange = function() {
    		if(ajax_update.readyState == 4 && ajax_update.status == 200){ 
	
		var jsonStr = JSON.parse(ajax_update.responseText);
//		ajaxDisplay.innerHTML=ajax_update.responseText;

		var elements=jsonStr[0];

		for (var i=1; i< elements+1; i++) {
			var j=(i-1)*6+1;

			var id=jsonStr[j];
			var title=jsonStr[j+1];
			var status=jsonStr[j+2];
			var option=jsonStr[j+3];			
			var value=jsonStr[j+4];
			addr[id]=jsonStr[j+5];

			var tdArea= id + "tdArea";
			var tdAreaText=document.getElementById(tdArea);
			tdAreaText.innerHTML=title;

			var tdStatus= id + "tdStatus";
			var tdStatusText=document.getElementById(tdStatus);

			var tdOption= id + "tdOption";
			var tdOptionText=document.getElementById(tdOption);
		
			var id_select=id + "_sel";
			var select=document.getElementById(id_select);
		
			if ( status == 1) {
				//select.value=option;
				tdStatusText.innerHTML="ON";
				tdOptionText.innerHTML=option;
			}
			else {
				tdStatusText.innerHTML="OFF";
				tdOptionText.innerHTML="";
			}			

			var res=value.split(",");

			for (k=0; k<5; k++ ){
					var id_text= id + "_txt" + k; 
					var color=document.getElementById(id_text);
					color.value=res[k];
				}
		}

		jscolor.installByClassName("jscolor");	
		

		}
	}
	
}


function create_table(){

	var ajaxDisplay = document.getElementById('ajaxDiv');

	var ajax_update;
	

	var mytable = document.createElement("TABLE");
	mytable.setAttribute("id","myTable");
	mytable.id="myTable";
    	mytable.border = "1";
	
	var x=["Area","Status","Blink Option","Choose Option","Color","Action"];
	var header_tr= document.createElement('tr'); 

	for (var k=0; k<6; k++){
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

			for ( var k=0; k<6; k++){
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
					td.id=id+"tdOption";
					break;	
	
				case 3: 
					var id_select=id + "_sel";
		
					var dropdownSelect=document.createElement("select");
					dropdownSelect.setAttribute("id", id_select);
					dropdownSelect.setAttribute("onchange", 'onchange_dropdown(id);');
	
					for (i =1; i<8 ;i++) {
						var op = document.createElement("option");
						op.value=i;
						op.text=i;
						dropdownSelect.appendChild(op);
					}

					td.appendChild(dropdownSelect);
					break;
				case 4: 	
					var id_select=id + "_sel";
					var dropdownSelect=document.getElementById(id_select);
					var select_value=dropdownSelect.value;


					for (i=0; i<5; i++ ){
						var id_text= id + "_txt" + i; 

						var div = document.createElement("div");
						div.setAttribute("class", "form-item");

						var color_text = document.createElement("input");
						color_text.setAttribute("id", id_text);
						color_text.className= 'jscolor';	
						color_text.setAttribute("value", "123456");

						div.appendChild(color_text) ;
						td.appendChild(div) ;
					}

					if ( select_value==4 || select_value==5 || select_value==6 || select_value==7 ){
						for (i=1; i< 5 ; i++) {
							var id_text= id + "_txt" + i;
							var color_field=document.getElementById(id_text);	
							color_field.disabled=false;
	
						}
					}

					else if ( select_value==1 || select_value==2 || select_value==3 ){
						for (i =1; i< 5 ; i++) {
							var id_text= id + "_txt" + i; 
							var color_field=document.getElementById(id_text);	
							color_field.disabled=true;
	
						}		
					}
					break;
				
				case 5: 
					for (i=0; i<2; i++) {
						var val;
						var id_button = id + "_btn" + i;
						var button = document.createElement("input");
						button.setAttribute("type","button");
						button.setAttribute("id", id_button);
						switch (i) {
							case 1: 
								val= "Set";
								break;
							case 0: 
								val="Off";
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
