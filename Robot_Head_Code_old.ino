#include <Wire.h>
#include <Servo.h>

Servo lJawSrv;
Servo rJawSrv;

Servo tongueSrv;
Servo lLeftCheekSrv;
Servo uLeftCheekSrv;
Servo lLipSrv;
Servo uLipSrv;
Servo lRightCheekSrv;
Servo uRightCheekSrv;

double lJawPos = 0.0;
double lJawPrev = 0.0;
double lJawSmooth = 0.0;
bool lJawAchieved = true;
double rJawPos = 0.0;
double rJawPrev = 0.0;
double rJawSmooth = 0.0;
bool rJawAchieved = true;
int i = 0;

double input1 = 0.0;
double input2 = 0.0;
int howSmooth = 0; //Higher value more smoothing

void setup() {
  Serial.begin(115200);
  
  //lJawSrv.attach(15);
  lJawSrv.attach(19);

  //tongueSrv.attach(25);
  //rJawSrv.attach(23);
  //lLeftCheekSrv.attach(21);
  //uLeftCheekSrv.attach(29);
  //lLipSrv.attach(17);
  //uLipSrv.attach(27);

  //lRightCheekSrv.attach(31); //fucked
  //uRightCheekSrv.attach(19); //fucked
}

void loop() {
  lJawSmooth = smoothing(lJawPos, lJawPrev, 5);
  lJawPrev = lJawSmooth;

  lJawSrv.write(lJawSmooth);

  if (i >= 3000) {
    if (lJawPos == 90) {
      lJawPos = 0;
    } else {
      lJawPos = 90;
    }

    i = 0;
  }

  i++;
}

double smoothing(double input1, double input2, int howSmooth){
  return (input1 * (0 + (howSmooth * 0.01))) + (input2 * (1 - (howSmooth * 0.01)));
}
