
import 'package:flutter/material.dart';
import 'package:get/get_core/src/get_main.dart';
import 'package:get/get_utils/src/extensions/internacionalization.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/model/all_points_model.dart';
import 'package:wassalny/model/home.dart';

import 'Home/drawer.dart';

class AllPointsScreen extends StatefulWidget {
  @override
  _AllPointsScreenState createState() => _AllPointsScreenState();
}

class _AllPointsScreenState extends State<AllPointsScreen> {
  AllPointsModel model;
  String lang = Get.locale.languageCode;
  GlobalKey<ScaffoldState> _scafold2 = GlobalKey<ScaffoldState>();
  future() async {
    model = await Provider.of<HomeLists>(context, listen: false)
        .fetchAllPoints(lang, 0, 10);
    setState(() {});
  }

  @override
  void initState() {
    // TODO: implement initState
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("points".tr),
        centerTitle: true,
      ),
      key: _scafold2,
      drawer: MyDrawer(),
      body: model != null
          ? Column(
              children: [
                ListTile(
                  title: Text("مقدم الخدمة"),
                  trailing: Text("النقاط"),
                ),
                Expanded(
                  child: ListView.separated(
                      itemBuilder: (context, index) => buildItem(index),
                      separatorBuilder: (context, index) => SizedBox(
                            height: 10,
                          ),
                      itemCount: model.result.allProviders.length),
                ),
              ],
            )
          : Center(
              child: CircularProgressIndicator(),
            ),
    );
  }

  Widget buildItem(index) => ListTile(
        title: Text(model.result.allProviders[index].userName),
        trailing: Text(model.result.allProviders[index].totalPoints),
      );
}
