import 'package:flutter/material.dart';

import 'MyText.dart';
import 'myColors.dart';

class CustomButton extends StatefulWidget {
  final String label;
  final Function onTap;
  final Color backgroundColor;
  final Color borderColor;
  final Color textColor;
  final int isShadow;
  final double textSize;
  CustomButton(
      {this.label,
      this.onTap,
      this.backgroundColor,
      this.borderColor,
      this.textColor,
      this.textSize,
      this.isShadow});

  @override
  _CustomButtonState createState() => _CustomButtonState();
}

class _CustomButtonState extends State<CustomButton> {
  @override
  Widget build(BuildContext context) {
    return InkWell(
        onTap: widget.onTap,
        child: Container(
            height: 50,
            alignment: Alignment.center,
            decoration: BoxDecoration(
                boxShadow: [
                  BoxShadow(
                      color: MyColors.primary.withOpacity(.3),
                      spreadRadius: 1,
                      blurRadius: 1,
                      offset: Offset(0, 1))
                ],
                color: widget.backgroundColor,
                border: Border.all(color: widget.borderColor, width: 1),
                borderRadius: BorderRadius.all(Radius.circular(30))),
            child: Padding(
              padding: EdgeInsets.only(top: 8),
              child: MyText(
                  title: widget.label,
                  size: 18,
                  color: widget.textColor,
                  weight: FontWeight.bold),
            )));
  }
}

class CustomSizedButton extends StatelessWidget {
  final String label;
  final Function onTap;
  final Color backgroundColor;
  final Color borderColor;
  final Color textColor;
  final int isShadow;
  final double textSize;
  final double verticalPadding;
  CustomSizedButton(
      {this.label,
      this.onTap,
      this.backgroundColor,
      this.borderColor,
      this.textColor,
      this.textSize,
      this.isShadow,
      this.verticalPadding});

  @override
  Widget build(BuildContext context) {
    return InkWell(
        onTap: onTap,
        child: Container(
            alignment: Alignment.center,
            padding: EdgeInsets.symmetric(
                vertical: verticalPadding == null ? 9 : verticalPadding),
            decoration: BoxDecoration(
                boxShadow: [
                  BoxShadow(
                      color: MyColors.primary.withOpacity(.3),
                      spreadRadius: 1,
                      blurRadius: 1,
                      offset: Offset(0, 1))
                ],
                color: backgroundColor,
                border: Border.all(color: borderColor, width: 1),
                borderRadius: BorderRadius.all(Radius.circular(30))),
            child: Padding(
                padding: EdgeInsets.only(top: 8),
                child: MyText(
                    title: label,
                    size: textSize,
                    color: textColor,
                    weight: FontWeight.bold))));
  }
}
