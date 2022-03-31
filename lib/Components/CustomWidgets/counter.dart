import 'package:flutter/material.dart';

import 'MyText.dart';


Widget counterPart(BuildContext context, Function onTap, IconData icon) {
  return InkWell(
      onTap: onTap,
      child: Container(
          decoration: BoxDecoration(
              shape: BoxShape.circle, border: Border.all(width: 1)),
          child: Icon(icon, size: 20)));
}

Widget counter(
    BuildContext context, int count, Function increment, Function decrement) {
  return Row(children: [
    counterPart(context, increment, Icons.add),
    SizedBox(width: 10),
    MyText(title: "$count", weight: FontWeight.bold, size: 20),
    SizedBox(width: 10),
    counterPart(context, decrement, Icons.remove)
  ]);
}
