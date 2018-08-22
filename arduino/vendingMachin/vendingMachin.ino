#include <TFT.h>                // LCD
#include <SPI.h>                // LCD
#include <SoftwareSerial.h>   // 블루투스
#include <Servo.h>             // 서보모터

#define CS   10   // LCD
#define DC   9    // LCD
#define RESET  8  // LCD

//블루투스
int bluetoothTx = 2;  // TX-O pin of bluetooth mate, Arduino D2
int bluetoothRx = 3;  // RX-I pin of bluetooth mate, Arduino D3

SoftwareSerial bluetooth(bluetoothTx, bluetoothRx);

TFT myScreen = TFT(CS, DC, RESET);

char printout[6];           // 출력할 문자 저장 배열
int moneyBtnPinNum = 48;    // 돈 버튼 핀 번호
int LEDPinNum = 7;          // LED 핀 번호
int product1_PinNum = 49;   // 제품1 버튼 핀 번호
int product2_PinNum = 5;    // 제품2 버튼 핀 번호
int product3_PinNum = 6;    // 제품3 버튼 핀 번호
int motor1_PinNum = 47;     // 제품1 서보모터 핀 번호
int motor2_PinNum = 46;     // 제품2 서보모터 핀 번호
int motor3_PinNum = 44;     // 제품3 서보모터 핀 번호
int buttonState;            // 동전 버튼 상태
int state = 0;              // 한 번 클릭
int count = 0;              // 넣은 금액
int clickState1 = 0;        // 제품1의 버튼 상태
int clickState2 = 0;        // 제품2의 버튼 상태
int clickState3 = 0;        // 제품3의 버튼 상태

Servo myservo1;
int pos1 = 0;
int servostate1 = 0;
int right1 = 0;
int left1 = 0;

Servo myservo2;
int pos2 = 0;
int servostate2 = 0;
int right2 = 0;
int left2 = 0;

Servo myservo3;
int pos3 = 0;
int servostate3 = 0;
int right3 = 0;
int left3 = 0;

void setup(){
  pinMode(moneyBtnPinNum, INPUT);         // 돈 버튼
  pinMode(LEDPinNum, OUTPUT);             // LED 버튼
  pinMode(product1_PinNum, INPUT);        // 제품1 버튼
  pinMode(product2_PinNum, INPUT);        // 제품2 버튼
  pinMode(product3_PinNum, INPUT);        // 제품3 버튼
  
  myScreen.begin();                       // LCD 시작
  myScreen.background(0,0,0);             // LCD 배경 검정색 지정
  myScreen.stroke(255,255,255);           // LCD 글자색 흰색 지정
  
  myScreen.setTextSize(2);                // LCD 글자 크기 2로 지정
  myScreen.text("input money", 10, 0);    // LCD (10,0)위치에 글 출력
  
  myScreen.setTextSize(3);                // LCD 글자 크기 3으로 지정
  myScreen.text("no", 50, 100);           // LCD (50, 100)위치에 글 출력

  //블루투스
  Serial.begin(9600);  // Begin the serial monitor at 9600bps

  bluetooth.begin(115200);  // The Bluetooth Mate defaults to 115200bps
  bluetooth.print("$");  // Print three times individually
  bluetooth.print("$");
  bluetooth.print("$");  // Enter command mode
  delay(100);  // Short delay, wait for the Mate to send back CMD
  bluetooth.println("U,9600,N");  // Temporarily Change the baudrate to 9600, no parity
  // 115200 can be too fast at times for NewSoftSerial to relay the data reliably
  bluetooth.begin(9600);  // Start bluetooth serial at 9600
}

void loop(){
  //블루투스 메시지 확인
  if(bluetooth.available()) { // If the bluetooth sent any characters
    // Send any characters the bluetooth prints to the serial monitor
    Serial.print((char)bluetooth.read());  
  }
  if(Serial.available()) { // If stuff was typed in the serial monitor
    // Send any characters the Serial monitor prints to the bluetooth
    bluetooth.print((char)Serial.read());
  }

  buttonState = digitalRead(moneyBtnPinNum);      // 돈 버튼 상태
    
  if(buttonState == HIGH){
    // 돈 넣으면
        
    if(state == 0){
      myScreen.stroke(0, 0, 0);
      myScreen.text(printout, 10, 50);

      count += 500;
      String el = String(count);
      el.toCharArray(printout, 6);
      myScreen.stroke(255,255,255);
      myScreen.text(printout, 10, 50);

      if(count >= 1000) {
        myScreen.stroke(0,0,0);
        myScreen.text("no", 50, 100);
        myScreen.stroke(255,255,255);
        myScreen.text("ok", 50, 100);

        digitalWrite(LEDPinNum,HIGH);
      }
     
      state = 1;
    }
  }
  
  if(buttonState == LOW){
    if(state == 1){
      state = 0;
    }
  }

  if (digitalRead(product1_PinNum) == HIGH && count >= 1000) {
    // 돈 1000원 이상 일 때 제품1 버튼 누르면
    
      if (clickState1 == 0) {
        myScreen.stroke(0,0,0);
        myScreen.text(printout, 10, 50);

        count -= 500;
        String el = String(count);
        el.toCharArray(printout, 6);
      
        myScreen.stroke(255,255,255);
        myScreen.text(printout, 10, 50);

        if (count < 1000) {
          myScreen.stroke(0,0,0);
          myScreen.text("ok", 50, 100);
          myScreen.stroke(255,255,255);
          myScreen.text("no", 50, 100);
          digitalWrite(LEDPinNum,LOW);
        }

        //1번 눌럿을 때 블루투스전송
        bluetooth.print("thingspeak:col1=vendung111&col2=test&col3=testing");
        bluetooth.print("[*]");
        delay(1000);

        if (servostate1 == 0) {
      
          if (pos1 == 0) {
            right1 = 1;
            left1 = 0;
          }

          if (pos1 == 180) {
            right1 = 0;
            left1 = 1;
          }

          if (right1 == 1) {
            myservo1.attach(motor1_PinNum);
            pos1 += 180;
            myservo1.write(pos1);
            delay(1000);
            myservo1.detach();
          }

          if (left1 == 1) {
            myservo1.attach(motor1_PinNum);
            pos1 -= 180;
            myservo1.write(pos1);
            delay(1000);
            myservo1.detach();
          }
        }

        servostate1 = 1;
      }

      clickState1 = 1;
  }

  if (digitalRead(product1_PinNum) == LOW) {
    if (clickState1 == 1) {
      clickState1 = 0;
    }

    if (servostate1 == 1) {
      servostate1 = 0;
    }
  }

  if (digitalRead(product2_PinNum) == HIGH && count >= 1000) {
    // 돈 1000원 이상 일 때 제품2 버튼 누르면
    
    if (clickState2 == 0) {
      myScreen.stroke(0,0,0);
      myScreen.text(printout, 10, 50);

      count -= 500;
      String el = String(count);
      el.toCharArray(printout, 6);
      
      myScreen.stroke(255,255,255);
      myScreen.text(printout, 10, 50);

      if (count < 1000) {
          myScreen.stroke(0,0,0);
          myScreen.text("ok", 50, 100);
          myScreen.stroke(255,255,255);
          myScreen.text("no", 50, 100);
          digitalWrite(LEDPinNum,LOW);
       }

       //2번 눌럿을 때 블루투스전송
        bluetooth.print("thingspeak:col1=vendung222&col2=test&col3=testing");
        bluetooth.print("[*]");
        delay(1000);

        if (servostate2 == 0) {
          
            myservo2.attach(motor2_PinNum);
            pos2 += 360;
            myservo2.write(pos2);
            delay(1000);
            myservo2.detach();
            pos2 = 0;
//
//          if (left2 == 1) {
//            myservo2.attach(motor2_PinNum);
//            pos2 -= 360;
//            myservo2.write(pos2);
//            delay(1000);
//            myservo2.detach();
//          }
        }

        servostate2 = 1;
    }

    clickState2 = 1;
  }

  if (digitalRead(product2_PinNum) == LOW) {
    if (clickState2 == 1) {
      clickState2 = 0;
    }

    if (servostate2 == 1) {
      servostate2 = 0;
    }
  }

  if (digitalRead(product3_PinNum) == HIGH && count >= 1000) {
    // 돈 1000원 이상 일 때 제품3 버튼 누르면
    
    if (clickState3 == 0) {
      myScreen.stroke(0,0,0);
      myScreen.text(printout, 10, 50);

      count -= 500;
      String el = String(count);
      el.toCharArray(printout, 6);
      
      myScreen.stroke(255,255,255);
      myScreen.text(printout, 10, 50);

      if (count < 1000) {
          myScreen.stroke(0,0,0);
          myScreen.text("ok", 50, 100);
          myScreen.stroke(255,255,255);
          myScreen.text("no", 50, 100);
          digitalWrite(LEDPinNum,LOW);
      }

      //3번 눌럿을 때 블루투스전송
        bluetooth.print("thingspeak:col1=vendung333&col2=test&col3=testing");
        bluetooth.print("[*]");
        delay(1000);

        if (servostate3 == 0) {
      
          if (pos3 == 0) {
            right3 = 1;
            left3 = 0;
          }

          if (pos3 == 180) {
            right3 = 0;
            left3 = 1;
          }

          if (right3 == 1) {
            myservo3.attach(motor3_PinNum);
            pos3 += 180;
            myservo3.write(pos3);
            delay(1000);
            myservo3.detach();
          }

          if (left3 == 1) {
            myservo3.attach(motor3_PinNum);
            pos3 -= 180;
            myservo3.write(pos3);
            delay(1000);
            myservo3.detach();
          }
        }

        servostate3 = 1;
    }

    clickState3 = 1;
  }

  if (digitalRead(product3_PinNum) == LOW) {
    if (clickState3 == 1) {
      clickState3 = 0;
    }

    if (servostate3 == 1) {
      servostate3 = 0;
    }
  }

//  myservo2.attach(motor2_PinNum);
//            pos2 += 360;
//            myservo2.write(pos2);
//            //delay(1000);
//            //myservo2.detach();
//            pos2 = 0;
}
