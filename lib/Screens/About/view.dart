import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/utils.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/model/aboutandcontact.dart';

import '../../Components/constants.dart';

class About extends StatefulWidget {
  @override
  _AboutState createState() => _AboutState();
}

class _AboutState extends State<About> {
  bool loader = false;
  Future<void> getAbout() async {
    String lang = Get.locale?.languageCode??'ar';
    loader = true;
    try {
      await Provider.of<AboutAndContactUS>(context, listen: false)
          .fetchAboutAndContactUs(lang);

      setState(() {
        loader = false;
      });
    } catch (e) {}
  }

  @override
  void initState() {
    getAbout();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    String about = Provider.of<AboutAndContactUS>(context, listen: false).about;
    return Scaffold(
      appBar: TitleAppBar(title: "aboutApp".tr),
      body: ListView(
        padding: EdgeInsets.all(20.r),
        children: [
          SizedBox(height: 50.h),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 60),
            child: Image.asset(appLogo),
          ),
          SizedBox(height: 30.h),
          loader
              ? Center(
                  child: CircularProgressIndicator(),
                )
              : MyText(
                  title: about,
                  weight: FontWeight.w500,
                  size: 25.r,
                )
        ],
      ),
    );
  }
}
