import 'package:flutter/material.dart';
// import 'package:wasalny/Home/view.dart';
import 'dart:ui';

class MyText extends StatelessWidget {
  final String? title;
  final Color? color;
  final double? size;
  final TextAlign? alien;
  final FontWeight? weight;

  const MyText(
      {this.title,
      this.color,
      this.size,
      this.alien,
      this.weight});

  @override
  Widget build(BuildContext context) {
    return Text("$title",
        textAlign: alien,
        // overflow: TextOverflow.ellipsis,
        style: TextStyle(
            color: color,
            fontSize: size,
            fontFamily: "GE-Snd-Book",
            fontWeight: weight,
            height: 1.5
            ));
  }
}
