import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:wassalny/Components/constants.dart';


class ComingSoon extends StatelessWidget {
  const ComingSoon({super.key});

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        body: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [

            Image.asset(appLogo,width: 300.w,),
            Row(),
            SizedBox(height: 50.h,),
            Text("يتم الإنشاء!",style: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 26.sp,
                color: Colors.red,
                fontFamily: 'GE-Snd-Book'),)
          ],
        ),
      ),
    );
  }
}
