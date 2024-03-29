import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';

import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/searchCity/searchCity.dart';
import 'package:wassalny/model/searchByCity.dart';
import 'package:wassalny/model/searchStates.dart' as states;

import '../../Components/constants.dart';

// ignore: must_be_immutable
class SetAddress extends StatefulWidget {
  int? vategory;
  String? name;
  int? searchType;
  SetAddress({this.name, this.vategory, this.searchType});
  @override
  _SetAddressState createState() => _SetAddressState();
}

class _SetAddressState extends State<SetAddress> {
  String? city;
  int? cityId;

  String? government;
  int? governmentId;

  String lang = Get.locale?.languageCode??'ar';

  Future<void> _submit() async {
    bool doneSearching =
        Provider.of<SearchCity>(context, listen: false).doneSearching;
    showDaialogLoader(context);
    try {
      doneSearching = await Provider.of<SearchCity>(context, listen: false)
          .fetchSearch(widget.name??'', 100, 0, widget.vategory??0, cityId??0,
              governmentId??0, widget.searchType??0, lang);
      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog("NoInternet".tr, context);
    } finally {
      if (doneSearching) {
        Future.delayed(Duration(seconds: 2)).then((value) {
          Navigator.of(context).pop();
          Get.to(SearchCityScreen(
            search: Provider.of<SearchCity>(context, listen: false).searchName,
          ));
        });
      }
    }
  }

  bool loader = false;
  Future<void> getStates() async {
    String lang = Get.locale?.languageCode??'ar';
    loader = true;
    try {
      await Provider.of<states.SearchStatesProvider>(context, listen: false)
          .fetchAllOffers(lang);

      setState(() {
        loader = false;
      });
    } catch (e) {}
  }

  @override
  void initState() {
    getStates();
    super.initState();
  }

  Widget searchContainer(void Function()? onTap, String title) => InkWell(
        onTap: onTap,
        child: Row(
          children: [
            Expanded(
              child: Container(
                alignment: Alignment.center,
                padding: EdgeInsets.all(40),
                // height: 100,
                // width: 100,
                decoration: BoxDecoration(
                    shape: BoxShape.circle, color: Colors.pinkAccent),
                child: MyText(
                    alien: TextAlign.center,
                    title: title,
                    color: Colors.white,
                    weight: FontWeight.bold),
              ),
            ),
          ],
        ),
      );
  @override
  Widget build(BuildContext context) {
    final provider = Provider.of<states.SearchStatesProvider>(context);
    List<states.AllState> state = provider.states;
    List<states.AllState> goverment =
        state.where((element) => element.stateId == cityId).toList();
    List<states.AllCity> finalcity = [];
    for (var i = 0; i < goverment.length; i++) {
      finalcity = goverment[i].allCities??[];
    }
    print(widget.vategory);

    return Scaffold(
      appBar: TitleAppBar(title: "Selecttheaddress".tr),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : ListView(
              padding: EdgeInsets.all(20),
              children: [
                Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 60),
                    child: Image.asset(appLogo, width: 100)),
                SizedBox(height: 20.h),
                Row(
                  children: [
                    Expanded(
                      child: MyText(
                          alien: TextAlign.center,
                          title: "TextInLangScreen".tr,
                          weight: FontWeight.w500,
                          size: 25),
                    ),
                  ],
                ),
                SizedBox(height: 20.h),
                Container(
                  padding: EdgeInsets.all(10),
                  decoration: BoxDecoration(
                    color: Colors.blue,
                    borderRadius: BorderRadius.all(Radius.circular(30)),
                    border: Border.all(color: Colors.blue, width: 2),
                  ),
                  child: InkWell(
                    onTap: () => showDialog(
                      context: context,
                      builder: (BuildContext context) {
                        return AlertDialog(
                          backgroundColor: Colors.blue[300],
                          content: Center(
                            child: Container(
                              width: MediaQuery.of(context).size.width * 0.8,
                              child: citiesWidget(context, state),
                            ),
                          ),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.all(
                              Radius.circular(
                                20,
                              ),
                            ),
                          ),
                        );
                      },
                    ),

                    //  _modalBottomSheetMenu(context, state),
                    child: Row(
                      children: [
                        Expanded(
                          child: Text(
                            city == null ? "SelectState".tr : city??'',
                            maxLines: 2,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                                color: Colors.white,
                                fontWeight: FontWeight.bold,
                                fontSize: 17),
                          ),
                        ),
                        Icon(Icons.keyboard_arrow_down,
                            color: Colors.white, size: 30)
                      ],
                    ),
                  ),
                ),
                SizedBox(height: 10),
                Container(
                  padding: EdgeInsets.all(10),
                  decoration: BoxDecoration(
                    color: Colors.blue,
                    borderRadius: BorderRadius.all(Radius.circular(30)),
                    border: Border.all(color: Colors.blue, width: 2),
                  ),
                  child: InkWell(
                    onTap: () => showDialog(
                      context: context,
                      builder: (BuildContext context) {
                        return AlertDialog(
                          backgroundColor: Colors.blue[300],
                          content: Center(
                            child: Container(
                              width: MediaQuery.of(context).size.width * 0.8,
                              child: finalcity.isEmpty
                                  ? Text(
                                      'nostate'.tr,
                                      style: TextStyle(color: Colors.white),
                                    )
                                  : ListView.builder(
                                      itemCount: finalcity.length,
                                      shrinkWrap: true,
                                      itemBuilder: (context, index) {
                                        return InkWell(
                                          onTap: () {
                                            setState(() {
                                              if (finalcity.isEmpty) {
                                                government = "SelectState".tr;
                                              } else
                                                government =
                                                    finalcity[index].cityName;
                                              governmentId =
                                                  finalcity[index].cityId;
                                            });
                                            Navigator.pop(context);
                                          },
                                          child: Container(
                                            padding: EdgeInsets.all(5),
                                            decoration: BoxDecoration(
                                              color: Colors.blue[800],
                                              borderRadius:
                                                  BorderRadius.circular(10),
                                            ),
                                            margin: EdgeInsets.symmetric(
                                                vertical: 5),
                                            child: Row(
                                              crossAxisAlignment:
                                                  CrossAxisAlignment.center,
                                              children: [
                                                Offstage(
                                                    offstage: government ==
                                                            finalcity[index]
                                                                .cityName
                                                        ? false
                                                        : true,
                                                    child: Icon(
                                                        Icons.check_circle,
                                                        color: MyColors.green)),
                                                // SizedBox(width: 10),
                                                Expanded(
                                                  child: Padding(
                                                    padding: EdgeInsets.only(
                                                        bottom: 5),
                                                    child: Center(
                                                      child: MyText(
                                                        title: finalcity[index]
                                                            .cityName,
                                                        size: 18,
                                                        weight: FontWeight.bold,
                                                        color: Colors.white,
                                                      ),
                                                    ),
                                                  ),
                                                ),
                                              ],
                                            ),
                                          ),
                                        );
                                      },
                                    ),
                            ),
                          ),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.all(
                              Radius.circular(
                                20,
                              ),
                            ),
                          ),
                        );
                      },
                    ),
                    child: Row(
                      children: [
                        Expanded(
                          child: Text(
                            government == null || finalcity.isEmpty
                                ? "Selectcity".tr
                                : government??'',
                            maxLines: 2,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                                color: Colors.white,
                                fontWeight: FontWeight.bold,
                                fontSize: 17),
                          ),
                        ),
                        Icon(Icons.keyboard_arrow_down,
                            color: Colors.white, size: 30)
                      ],
                    ),
                  ),
                ),
                SizedBox(height: 10),
                // filter(street == null ? "اختر الحي" : street),
                // SizedBox(height: 50.h),
                CustomButton(
                    backgroundColor: Colors.red,
                    borderColor: Colors.red,
                    isShadow: 0,
                    onTap: _submit,
                    textColor: Colors.white,
                    label: "Search".tr)
              ],
            ),
    );
  }

  // _modalBottomSheetMenu(BuildContext context, List<states.AllState> list) {
  //   showModalBottomSheet(
  //     shape: RoundedRectangleBorder(
  //       borderRadius: BorderRadius.only(
  //         topLeft: Radius.circular(20),
  //         topRight: Radius.circular(20),
  //       ),
  //     ),
  //     context: context,
  //     builder: (builder) {
  //       return StatefulBuilder(
  //         builder: (context, setState) {
  //           return citiesWidget(context, list);
  //         },
  //       );
  //     },
  //   );
  // }

//   Widget citiesWidget(BuildContext context, List<states.AllState> list) {
//     return ListView(
//       padding: EdgeInsets.all(15),
//       children: [
//         ListView.builder(
//           itemCount: list.length,
//           shrinkWrap: true,
//           itemBuilder: (context, index) {
//             return InkWell(
//               onTap: () {
//                 setState(() {
//                   city = list[index].stateName;
//                   cityId = list[index].stateId;
//                 });
//                 Navigator.pop(context);
//               },
//               child: Container(
//                 margin: EdgeInsets.symmetric(vertical: 5),
//                 child: Row(
//                   children: [
//                     Offstage(
//                         offstage: city == list[index].stateName ? false : true,
//                         child: Icon(Icons.check_circle, color: MyColors.green)),
//                     SizedBox(width: 10),
//                     Expanded(
//                       child: Padding(
//                         padding: EdgeInsets.only(bottom: 5),
//                         child: MyText(
//                           title: list[index].stateName,
//                           size: 18,
//                           weight: FontWeight.bold,
//                         ),
//                       ),
//                     ),
//                   ],
//                 ),
//               ),
//             );
//           },
//         ),
//       ],
//     );
//   }
// }
  Widget citiesWidget(BuildContext context, List<states.AllState> list) {
    return ListView.builder(
      itemCount: list.length,
      shrinkWrap: true,
      itemBuilder: (context, index) {
        return InkWell(
          onTap: () {
            print('==========${list[index].stateName}==============');
            setState(() {
              city = list[index].stateName;
              cityId = list[index].stateId;
            });
            Navigator.pop(context);
          },
          child: Container(
            padding: EdgeInsets.all(5),
            decoration: BoxDecoration(
              color: Colors.blue[800],
              borderRadius: BorderRadius.circular(10),
            ),
            margin: EdgeInsets.symmetric(vertical: 5),
            child: Row(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                Offstage(
                    offstage: city == list[index].stateName ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.green)),
                // SizedBox(width: 10),
                Expanded(
                  child: Padding(
                    padding: EdgeInsets.only(bottom: 5),
                    child: Center(
                      child: MyText(
                        title: list[index].stateName,
                        size: 18,
                        weight: FontWeight.bold,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
  }
}
