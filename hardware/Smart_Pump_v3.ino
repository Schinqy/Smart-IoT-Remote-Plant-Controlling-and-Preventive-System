#include <DHT.h>
#include <EEPROM.h>
#include "DHT.h"

#include <SIM808.h>
#include <SoftwareSerial.h>
#define DHTPIN 3    // what pin we're connected to

// Uncomment whatever type you're using!
#define DHTTYPE DHT11   // DHT 11  
DHT dht(DHTPIN, DHTTYPE);
#define POSITION_SIZE   128     ///< Size of the position buffer
#define NL  "\r\n"

#if defined(__AVR__)
    typedef __FlashStringHelper* __StrPtr;
#else
    typedef const char* __StrPtr;
#endif

const int enFan = 6;
const int enPump = 9;
const int heater = 10;
float humid,temp;
const byte triggerPin = 4;
const byte echoPin = 5;
 float lati, lon;
 const float h = 0.00;
const float ht = 21.87;
float perc;
const signed long lastTime = 0;
const unsigned long timerDelay = 1000; //post data with a delay of 10sec



#define SIM_RST   9 ///< SIM808 RESET
#define SIM_RX    11 ///< SIM808 RXD
#define SIM_TX    12 ///< SIM808 TXD
#define SIM_PWR   7 ///< SIM808 PWRKEY
//#define SIM_STATUS  8 ///< SIM808 STATUS

#define SIM808_BAUDRATE 9600    ///< Control the baudrate use to communicate with the SIM808 module
#define SERIAL_BAUDRATE 9600   ///< Controls the serial baudrate between the arduino and the computer
#define NO_FIX_GPS_DELAY 3000   ///< Delay between each GPS read when no fix is acquired
#define FIX_GPS_DELAY  5000    ///< Delay between each GPS read when a fix is acquired



SoftwareSerial simSerial(SIM_RX, SIM_TX);
SIM808 sim808 = SIM808(SIM_RST);
char position[POSITION_SIZE];
#include <Arduino_JSON.h>

const char* ssid = "NBV";
const char* password = "MALKONDELIA#";

//Your IP address or domain name with URL path
const char* serverName = "http://protathings.000webhostapp.com/api/esp-outputs-action.php?action=outputs_state&board=1";
// Update interval time set to 5 seconds
const long interval = 5000;
unsigned long previousMillis = 0;


String outputsState;

void setup() {
  Serial.begin(9600);
dht.begin(); 
pinMode(SIM_PWR , OUTPUT);
pinMode(triggerPin , OUTPUT);
pinMode(heater , OUTPUT);
pinMode(enFan , OUTPUT);
pinMode(enPump , OUTPUT);
delay(2000);
digitalWrite(SIM_PWR, HIGH);
delay(1000);
digitalWrite(SIM_PWR, LOW);
delay(1000);

    simSerial.begin(SIM808_BAUDRATE);
    sim808.begin(simSerial);
    Serial.println("IM ALIVE");
//sim808.powerOnOff(true); 

    sim808.powerOnOffGps(true);
delay(5000);
    //sim808.init();
    if (sim808.enableGprs("econet.net", NULL, NULL))
     //if (sim808.enableGprs("internet.netone", NULL, NULL))
      Serial.println("GPRS enabled");
    else
      Serial.println("GPRS failed");
}

void loop() {
  //Serial.println("Tamuloop");
 unsigned long currentMillis = millis();
  
  if(currentMillis - previousMillis >= interval) {
    if(httpAutoStatus() == "0")
    {
          webCtrl();
         postData();
         // sendSMSs();
    }
    else if(httpAutoStatus() == "1")
    {
      autoCtrl(); 
    }
    else
    {
      //OFFLINE DO SOMETHING
      Serial.println("OFFLINE");
      autoCtrl();
    }
    
    
      // save the last HTTP GET Request
      previousMillis = currentMillis;
  }   
}

void webCtrl()
{
  
      outputsState = httpGET();
      Serial.println(outputsState);
      JSONVar myObject = JSON.parse(outputsState);
  
      // JSON.typeof(jsonVar) can be used to get the type of the var
      if (JSON.typeof(myObject) == "undefined") {
        Serial.println("Parsing input failed!");
        return;
      }
    
    //  Serial.print("JSON object = " + String(myObject));
    
      // myObject.keys() can be used to get an array of all the keys in the object
      JSONVar keys = myObject.keys();
    
      for (int i = 0; i < keys.length(); i++) {
        JSONVar value = myObject[keys[i]];
        Serial.print("GPIO: ");
        Serial.print(keys[i]);
        Serial.print(" - SET to: ");
        Serial.println(value);
        pinMode(atoi(keys[i]), OUTPUT);
        digitalWrite(atoi(keys[i]), atoi(value));
      }
}


String httpGET() 
{
      char response[200]; 
    char response2[200]; 
    String payload = "{}"; 
 uint16_t responseCode2=   sim808.httpGet("http://protathings.000webhostapp.com/esp-outputs-action.php?action=outputs_state&board=1", response2, 512);
delay(500);

  if (responseCode2>0) {
   Serial.println("Status: " + String(responseCode2));
   Serial.print("Response: ");Serial.println(response2);
    payload =response2;
  }
  else {
    Serial.print("Error code: ");
    Serial.println(responseCode2);
  }
  return payload;
}

String httpAutoStatus() 
{
      char response[200]; 
    char response2[200]; 
    String payload = "{}"; 
 uint16_t responseCode2=   sim808.httpGet("http://protathings.000webhostapp.com/200/auto_hw.php", response2, 512);
delay(500);

  if (responseCode2>0) {
   Serial.println("Status: " + String(responseCode2));
   Serial.println("Auto Status: " + String(response2));
    payload =response2;
  }
  else {
    Serial.println("Error code: " + String(responseCode2));
  }


  return payload;
}






void getTemp()
{
  // Reading temperature or humidity takes about 250 milliseconds!
  // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)

  // Read temperature as Celsius
  temp = dht.readTemperature();
  delay(500);

Serial.println("Temp:" + String(temp));
}

void getHumidity()
{
    humid = dht.readHumidity();
  
  delay(500);
  Serial.println("Humidity: " + String(humid));
}

void getVolume()
{
float h = 0.00;
//float ht = 250.00;
  
  //*******************************CALCULATE DISTANCE*******************************//
  digitalWrite(triggerPin, LOW);
  delayMicroseconds(2);
  digitalWrite(triggerPin,HIGH);
  delayMicroseconds(10);
  float duration=pulseIn(echoPin, HIGH); 
  float d=duration/58.2;

 Serial.println(d);
  delay(100);

//*******************************CALCULATE DISTANCE END*******************************//

  //delay(1000);
  Serial.print("volume:");
  
  // Serial.print(" cm\n");
  Serial.print("\n");
  h = ht - d;  // trash height, 0 - 21.87 cm. Change depending on tank height
  perc = (h/ht) * 100; // percentage volume of water in a tank
  
  if(perc > 100)
  {
    perc = 100;
  }
  else if(perc <0)
  {
    perc = 0;
  }
  
  Serial.println(String(perc) + "%");
}



void postData()
{
 getTemp();
 getHumidity();
 getVolume();
//getData();
    char response2[200]; 
  //String f = api_key=tPmAT5Ab3j7F9&temp=30&humidity=25&vol=30&lat=-17&lng=35;
   String f = String("api_key=tPmAT5Ab3j7F9") + "&temp=" + String(temp,2) + "&humidity=" + String(humid, 2) + "&vol=" + String(perc, 2) + String("&lat=") + String(lati, 6) + String("&lng=") + String(lon, 6)+ "";
int len2 = f.length() + 1;
char fChar[len2];
   f.toCharArray(fChar, len2);
 Serial.print("Payload: "); Serial.println(fChar);
Serial.print("Payload Str: "); Serial.println(f);

  
    uint16_t responseCode2 = sim808.httpPost("http://protathings.000webhostapp.com/200/post_data.php",S_F("application/x-www-form-urlencoded"), fChar, response2, 512);
    
Serial.println("Status: " + String(responseCode2));
   Serial.println("Response: " + String(response2));
}




/*
void updateSerial()
{
  delay(500);
  while (Serial.available()) 
  {
    simSerial.write(Serial.read());//Forward what Serial received to Software Serial Port
  }
  while(simSerial.available()) 
  {
    Serial.write(simSerial.read());//Forward what Software Serial received to Serial Port
  }
}

void sendSMSs()
{
 simSerial.println("AT+CMGF=1"); // Configuring TEXT mode
 updateSerial();
 simSerial.println("AT+CMGS=\"+263776xxxxxx\"");//change ZZ with country code and xxxxxxxxxxx with phone number to sms
  updateSerial();
  simSerial.print("[SMART ALERT] Vol=" + String(perc) + "%. H=" + String(humid, 2) + ". T=" + String(temp, 2)  ); //text content
  updateSerial();
  simSerial.write(26);
  delay(1500);
}
*/





/*
void getData()
{
  SIM808GpsStatus status = sim808.getGpsStatus(position, POSITION_SIZE);
    Serial.println("TAMULOOP");
    
    if(status < SIM808GpsStatus::Fix) {
       // delay(NO_FIX_GPS_DELAY);
        Serial.println("No fix yet...");    
    }
if(status == SIM808GpsStatus::Fix) Serial.println("Normal");
    else Serial.println("Accurate");
  
    __StrPtr state;

    sim808.getGpsField(position, SIM808GpsField::Latitude, &lati);
    sim808.getGpsField(position, SIM808GpsField::Longitude, &lon);
  Serial.print(lati); Serial.print(",");  Serial.print(lon);
}
*/


void autoCtrl()
{
   getTemp();
 getHumidity();
 getVolume();
   if(perc >= 80) 
   {
    digitalWrite(enPump, HIGH);
   }
   else if( perc <= 20 )
   {
    digitalWrite(enPump, LOW);
   } 
   else if( temp >=40)
   {
     digitalWrite(heater, LOW);
      digitalWrite(enFan, HIGH);
   }
   else if(temp <=15)
   {
    digitalWrite(heater, HIGH);
      digitalWrite(enFan, LOW);
   }
   else
   {
    Serial.println("ALL GOOD");
   }
}
