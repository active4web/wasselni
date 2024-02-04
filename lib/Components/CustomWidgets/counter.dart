import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import 'MyText.dart';


Widget counterPart(BuildContext context, void Function()? onTap, IconData icon) {
  return InkWell(
      onTap: onTap,
      child: Container(
          decoration: BoxDecoration(
              shape: BoxShape.circle, border: Border.all(width: 1)),
          child: Icon(icon, size: 20.r)));
}

Widget counter(
    BuildContext context, int count, void Function()? increment, void Function()? decrement) {
  return Row(children: [
    counterPart(context, increment, Icons.add),
    SizedBox(width: 10.w),
    MyText(title: "$count", weight: FontWeight.bold, size: 20.r),
    SizedBox(width: 10.w),
    counterPart(context, decrement, Icons.remove)
  ]);
}
