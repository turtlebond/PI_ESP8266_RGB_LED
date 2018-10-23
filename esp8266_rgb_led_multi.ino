/*
//from linux
echo -n value | nc -4u -w1 ip_addr 2390

value= "option(1),color1(6),colo2(6),color3(6),color4(6),color5(6),common anode/cathode(1)"
a=common anode
c=common cathode
*/

#include <ESP8266WiFi.h>
#include <WiFiUdp.h>

char ssid[] = "MogshaNet";  //  your network SSID (name)
char pass[] = "0165123135abc";       // your network password
char led_common;


unsigned int localPort = 2390;      // local port to listen for UDP packets

char packetBuffer[50]; //buffer to hold incoming and outgoing packets

// A UDP instance to let us send and receive packets over UDP
WiFiUDP udp;

int red_dec, green_dec, blue_dec;

char option2;
void setup()
{

  pinMode(LED_BUILTIN, OUTPUT); 
  digitalWrite(LED_BUILTIN, HIGH);
  
  pinMode(0, OUTPUT); //red
  pinMode(2, OUTPUT); //green
  pinMode(3, OUTPUT); //blue
 
//  Serial.begin(115200);
//  Serial.println();
//  Serial.println();

  // We start by connecting to a WiFi network
  WiFi.begin(ssid, pass);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
  
   digitalWrite(LED_BUILTIN, LOW); 
//  Serial.println("WiFi connected");
//  Serial.println("IP address: ");
//  Serial.println(WiFi.localIP());

//  Serial.println("Starting UDP");
  udp.begin(localPort);
//  Serial.print("Local port: ");
//  Serial.println(udp.localPort());
}

void loop()
{
   
  int cb = udp.parsePacket();
  if (!cb) {
    if (option2 == '2' || option2 == '3' || option2 == '4' || option2 == '5' || option2 == '6' || option2 == '7' )
      switch_op(option2);
  }
  else {
//    Serial.print("packet received, length=");
//    Serial.println(cb);
    // We've received a packet, read the data from it
    udp.read(packetBuffer, cb); // read the packet into the buffer
//    Serial.print(packetBuffer);
//    Serial.print("\n");
   
//    //to convert UDP packet in hex to dec 
//    int bfr=strtol(packetBuffer,NULL,16);
//    Serial.println(bfr);

      char option=packetBuffer[0];
      led_common=packetBuffer[37];
      
      switch_op(option);

    }
    
    delay(10);
   
  

}

void get_color(int i)
{
      int j= i*7;

      //used to concatenate 2 bytes from UDP packet received
      String red = String(packetBuffer[j+2]);
      red.concat(packetBuffer[j+3]);

      String green = String(packetBuffer[j+4]);
      green.concat(packetBuffer[j+5]);

      String blue = String(packetBuffer[j+6]);
      blue.concat(packetBuffer[j+7]);

      //convert the string to char
      char red_c[8];
      red.toCharArray(red_c,8);
  
      char green_c[8];
      green.toCharArray(green_c,8);
  
      char blue_c[8];
      blue.toCharArray(blue_c,8);

     red_dec=strtol(red_c,NULL,16);
     green_dec=strtol(green_c,NULL,16);
     blue_dec=strtol(blue_c,NULL,16);
     
//     Serial.println(red_dec);
//     Serial.print("\n");
//     Serial.println(green_dec);
//     Serial.print("\n");
//     Serial.println(blue_dec);
//     Serial.print("\n");



}

void write_pin(int red, int green,int blue  ){


//Serial.println(led_common);

 if(led_common=='c') {
//    Serial.println("common cathode");
    analogWrite(0,red);
    analogWrite(2,green);
    analogWrite(3,blue);
  }

  else if ( led_common='a'){
 //   Serial.println("common anode");
    analogWrite(0,255-red);
    analogWrite(2,255-green);
    analogWrite(3,255-blue);
  }


}

void blink_led(int led_color, int off, int delay_val){
  for( int i=0; i< led_color; i++) {
    get_color(i);
    write_pin(red_dec,green_dec,blue_dec);
    delay(delay_val);
    if (off==1 ){
      write_pin(0,0,0);
      delay(delay_val);
    }
  }

  
}

void switch_op(char opt){
  
  switch (opt) {
   case '0':
          option2='0';
          write_pin(0,0,0);
      break;
    case '1':
          option2='1';
          blink_led(1,0,0);
      break;
     case '2':
            option2='2';
            blink_led(1,1,500);
      break;
     case '3':
            option2='3';
            blink_led(1,1,1000);
      break;
     case '4':
          option2='4';
          blink_led(5,0,500);
      break;
      case '5':
          option2='5';
          blink_led(5,0,1000);
      break;
      case '6':
          option2='6';
          blink_led(5,1,500);
      break;
      case '7':
          option2='7';
          blink_led(5,1,1000);
      break;
    default:
      // if nothing else matches, do the default
      // default is optional
    break;
  }

  
}


