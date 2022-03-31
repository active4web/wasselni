import 'package:flutter/material.dart';
import 'package:get/utils.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/model/aboutandcontact.dart';

class About extends StatefulWidget {
  @override
  _AboutState createState() => _AboutState();
}

class _AboutState extends State<About> {
  bool loader = false;
  Future<void> getAbout() async {
    String lang = Get.locale.languageCode;
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
      appBar: titleAppBar(context, "aboutApp".tr),
      body: ListView(
        padding: EdgeInsets.all(20),
        children: [
          SizedBox(height: 50),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 60),
            child: Image.asset('assets/images/logo.png'),
          ),
          SizedBox(height: 30),
          loader
              ? Center(
                  child: CircularProgressIndicator(),
                )
              : MyText(
                  title: about,
                  weight: FontWeight.w500,
                  size: 25,
                )
        ],
      ),
    );
  }
}
