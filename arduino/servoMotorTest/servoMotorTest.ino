#include <Servo.h>

Servo myservo;
int pos = 0;
int state = 0;
int right = 0;
int left = 0;

void setup() {
  myservo.attach(9);
  pinMode(13, INPUT);
}

void loop() {
  if (digitalRead(13) == HIGH) {
    if (state == 0) {
      
      if (pos == 0) {
        right = 1;
        left = 0;
      }

      if (pos == 180) {
        right = 0;
        left = 1;
      }

      if (right == 1) {
        pos += 20;
        myservo.write(pos);
        delay(1000);
      }

      if (left == 1) {
        pos -= 20;
        myservo.write(pos);
        delay(1000);
      }
    }

    state = 1;
  }

  if (digitalRead(13) == LOW) {
    if (state == 1) {
      state = 0;
    }
  }
}

