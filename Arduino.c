#include "U8glib.h"
String incomming;

U8GLIB_LD7032_60x32 u8g(9, 8, 11,10, 12); // SPI Com: SCK = 9, MOSI = 8, CS = 11, A0=10, RST =12

int xPos = 127;

void clearOLED(){ 
    u8g.firstPage();  
    do { 
    } while(u8g.nextPage()); 
} 

void setup(void) {
  Serial.begin(9600); // 9600 bps
  clearOLED();

  // assign default color value
  if ( u8g.getMode() == U8G_MODE_R3G3B2 ) {
    u8g.setColorIndex(255);     // white
  }
  else if ( u8g.getMode() == U8G_MODE_GRAY2BIT ) {
    u8g.setColorIndex(3);         // max intensity
  }
  else if ( u8g.getMode() == U8G_MODE_BW ) {
    u8g.setColorIndex(1);         // pixel on
  }
  else if ( u8g.getMode() == U8G_MODE_HICOLOR ) {
    u8g.setHiColorByRGB(255,255,255);
  } 
  pinMode(8, OUTPUT);
}

void loop(void) {
  if ( Serial.available()>0) {
    String incomming = Serial.readString();
    while(1){
      u8g.firstPage();
      char test[100];
      incomming.toCharArray(test, 100);
      int roll = ((strlen(test)/6)+2)*128;  //rollig     
      do {
        u8g.setFont(u8g_font_unifont);
        u8g.drawStr( xPos, 22, test);
        delay(6);
        } while( u8g.nextPage() );
        if(xPos > -roll){
          xPos-- ;
        }
        else{// When the yPos is off the screen, reset to 0.
          xPos = 128;
        }
    }
  }
}
