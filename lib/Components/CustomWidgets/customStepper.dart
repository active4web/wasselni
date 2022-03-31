import 'package:flutter/material.dart';

import 'myColors.dart';

Widget orderStatusSteps(
  BuildContext context,
  int status,
  Function onFirstTap,
  Function onSecondTap,
  Function onThirdTap,
) {
  return Material(
      borderRadius: BorderRadius.all(Radius.circular(8)),
      elevation: 0,
      child: Container(
          decoration:
              BoxDecoration(borderRadius: BorderRadius.all(Radius.circular(8))),
          child: Column(mainAxisAlignment: MainAxisAlignment.center, children: <
              Widget>[
            Stack(children: <Widget>[
              Padding(
                  padding: const EdgeInsets.only(top: 18, right: 10, left: 10),
                  child: Container(
                      width: MediaQuery.of(context).size.width,
                      child: Row(children: <Widget>[
                        Container(
                            height: 1,
                            width: MediaQuery.of(context).size.width * .24 - 12,
                            color: status == 3 || status == 4
                                ? MyColors.lightBlue
                                : Color.fromRGBO(202, 202, 202, 1)),
                        Container(
                            height: 1,
                            width: MediaQuery.of(context).size.width * .24 - 12,
                            color: status == 3 || status == 4
                                ? MyColors.lightBlue
                                : Color.fromRGBO(202, 202, 202, 1)),
                        Container(
                            height: 1,
                            width: MediaQuery.of(context).size.width * .24 - 12,
                            color: status == 4
                                ? MyColors.lightBlue
                                : Color.fromRGBO(202, 202, 202, 1)),
                        Container(
                            height: 1,
                            width: MediaQuery.of(context).size.width * .24 - 12,
                            color: status == 4
                                ? MyColors.lightBlue
                                : Color.fromRGBO(202, 202, 202, 1))
                      ]))),
              Container(
                  margin: EdgeInsets.symmetric(horizontal: 10),
                  width: MediaQuery.of(context).size.width,
                  child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: <Widget>[
                        preparedStep(context, status, onFirstTap),
                        inWayStep(context, status, onSecondTap),
                        deliveredStep(context, status, onThirdTap)
                      ]))
            ]),
            SizedBox(height: 10),
            Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: <Widget>[
                  Container(
                      child: Text('بيانات المنتج',
                          style: TextStyle(
                              fontSize: 13,
                              color: status == 2 || status == 3 || status == 4
                                  ? MyColors.lightBlue
                                  : status == -1
                                      ? Colors.red
                                      : Color.fromRGBO(202, 202, 202, 1)))),
                  Container(
                    child: Text('بيانات المزاد',
                        style: TextStyle(
                            fontSize: 13,
                            color: status == 3 || status == 4
                                ? MyColors.lightBlue
                                : Color.fromRGBO(202, 202, 202, 1))),
                  ),
                  Container(
                      child: Center(
                          child: Text('بيانات الدفع',
                              style: TextStyle(
                                  fontSize: 13,
                                  color: status == 4
                                      ? MyColors.lightBlue
                                      : Color.fromRGBO(202, 202, 202, 1)))))
                ])
          ])));
}

double radius = 40;
double size = .25;
double containerSize = 40;

Widget preparedStep(BuildContext context, int status, Function onFirstTap) {
  return InkWell(
    onTap: onFirstTap,
    child: Container(
        padding: EdgeInsets.all(8),
        decoration: BoxDecoration(
            color: status == 2 ? Colors.white : MyColors.lightBlue,
            shape: BoxShape.circle,
            border: Border.all(
                width: 1.5,
                color: status == 2
                    ? MyColors.lightBlue
                    : status == 3 || status == 4
                        ? Colors.transparent
                        : Color.fromRGBO(202, 202, 202, 1))),
        child: Image.asset("assets/images/stepperIcon1.png",
            color: status == 2
                ? MyColors.lightBlue
                : status == 3 || status == 4
                    ? Colors.white
                    : Color.fromRGBO(202, 202, 202, 1))),
  );
}

Widget inWayStep(BuildContext context, int status, Function onSecondTap) {
  return InkWell(
    onTap: onSecondTap,
    child: Container(
        padding: EdgeInsets.all(8),
        decoration: BoxDecoration(
            color: status == 4 ? MyColors.lightBlue : Colors.white,
            shape: BoxShape.circle,
            border: Border.all(
                width: 1.5,
                color: status == 3
                    ? MyColors.lightBlue
                    : status == 4
                        ? Colors.white
                        : Color.fromRGBO(202, 202, 202, 1))),
        child: Image.asset("assets/images/stepperIcon2.png",
            color: status == 3
                ? MyColors.lightBlue
                : status == 4
                    ? Colors.white
                    : Color.fromRGBO(202, 202, 202, 1))),
  );
}

Widget deliveredStep(BuildContext context, int status, Function onThirdTap) {
  return InkWell(
    onTap: onThirdTap,
    child: Container(
        padding: EdgeInsets.all(8),
        decoration: BoxDecoration(
            color: Colors.white,
            shape: BoxShape.circle,
            border: Border.all(
                width: 1.5,
                color: status == 4
                    ? MyColors.lightBlue
                    : Color.fromRGBO(202, 202, 202, 1))),
        child: Image.asset("assets/images/stepperIcon3.png",
            color: status == 4 ? MyColors.lightBlue : Colors.grey)),
  );
}
