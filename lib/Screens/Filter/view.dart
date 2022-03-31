import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/Location/view.dart';

import 'package:wassalny/model/home.dart';
import 'package:wassalny/model/searchByCityOffers.dart';
import 'package:wassalny/model/searchStates.dart' as states;

import 'filter_city.dart';
import 'filter_map_page.dart';

class Filter extends StatefulWidget {
  final int searchType;
  Filter(this.searchType);
  @override
  _FilterState createState() => _FilterState();
}

class _FilterState extends State<Filter> {
  TextEditingController _search = TextEditingController();

  String city;
  int cityId;
  String category;
  int categoryId;
  String government;
  int governmentId;
  String department;
  String departmentId;
  List<AllDepartment> allDepartment;
  String lang = Get.locale.languageCode;
  bool loader = false;
  Future<void> getStates() async {
    String lang = Get.locale.languageCode;
    loader = true;
    try {
      await Provider.of<states.SearchStatesProvider>(context, listen: false)
          .fetchAllOffers(lang);

      setState(() {
        loader = false;
      });
    } catch (e) {}
  }

  Future<void> _submit() async {
    bool doneSearching = Provider.of<SearchOffersByCity>(context, listen: false)
        .doneCitySearching;
    showDaialogLoader(context);
    try {
      doneSearching =
          await Provider.of<SearchOffersByCity>(context, listen: false)
              .fetchCitySearch(
                  limt: 100,
                  pageNumber: 0,
                  state: governmentId,
                  departmentId: departmentId,
                  catId: categoryId,
                  city: cityId,
                  lang: lang);

      print(governmentId);
      print(categoryId);
      print(cityId);
      print(departmentId);

      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog("NoInternet".tr, context);
    } finally {
      if (doneSearching) {
        Future.delayed(Duration(seconds: 2)).then((value) {
          Navigator.of(context).pop();
          Get.to(FilterCity(
            search: Provider.of<SearchOffersByCity>(context, listen: false)
                .searchProductName,
          ));
        });
      }
    }
  }

  @override
  void initState() {
    getStates();
    super.initState();
  }

  Widget filter(Widget widget) => Container(
      height: 50,
      padding: EdgeInsets.symmetric(horizontal: 20),
      decoration: BoxDecoration(
        color: Colors.blue,
        borderRadius: BorderRadius.all(Radius.circular(30)),
        border: Border.all(color: Colors.blue, width: 2),
      ),
      child: widget);

  Widget searchContainer(Function onTap, String title) => InkWell(
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
    List<AllCategories> allCategories =
        Provider.of<HomeLists>(context).allCategories;
    final provider = Provider.of<states.SearchStatesProvider>(context);
    List<states.AllState> state = provider.states;
    List<AllCategories> cities = allCategories;
    List<states.AllState> goverment =
        state.where((element) => element.stateId == cityId).toList();
    List<states.AllCity> finalcity = [];
    for (var i = 0; i < goverment.length; i++) {
      finalcity = goverment[i].allCities;
    }

    return Scaffold(
      appBar: titleAppBar(context, "filter".tr),
      body: ListView(
        padding: EdgeInsets.all(20),
        children: [
          Padding(
              padding: const EdgeInsets.symmetric(horizontal: 60),
              child: Image.asset(
                'assets/images/logo.png',
                width: 100,
              )),
          // SizedBox(height: 20),
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
          // SizedBox(height: 20),
          // filter(
          //   TransparentTextField(
          //     controller: _search,
          //     hint: "Searchbyservicename".tr,
          //     onTap: () {},
          //     icon: Icon(Icons.search, color: Colors.white),
          //   ),
          // ),
          SizedBox(height: 20),
          filter(
            InkWell(
              onTap: () => showDialog(
                context: context,
                builder: (BuildContext context) {
                  return AlertDialog(
                    backgroundColor: Colors.blue[300],
                    content: Container(
                      width: MediaQuery.of(context).size.width * 0.8,
                      child: categoryWidget(
                        context,
                        cities,
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
              // _modalBottomSheetMenu(context, cities),
              child: Row(
                children: [
                  Expanded(
                      child: Text(category == null ? "categories".tr : category,
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.bold,
                              fontSize: 17))),
                  Icon(Icons.keyboard_arrow_down, color: Colors.white, size: 30)
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
              onTap: category != null
                  ? () => showDialog(
                        context: context,
                        builder: (BuildContext context) {
                          return AlertDialog(
                            backgroundColor: Colors.blue[300],
                            content: Center(
                              child: Container(
                                width: MediaQuery.of(context).size.width * 0.8,
                                child: sectionsWidget(context, allDepartment),
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
                      )
                  : null,

              //  _modalBottomSheetMenu(context, state),
              child: Row(
                children: [
                  Expanded(
                    child: Text(
                      department == null ? "Subsections".tr : department,
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 17),
                    ),
                  ),
                  Icon(Icons.keyboard_arrow_down, color: Colors.white, size: 30)
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
                      city == null ? "SelectState".tr : city,
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 17),
                    ),
                  ),
                  Icon(Icons.keyboard_arrow_down, color: Colors.white, size: 30)
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
                                        governmentId = finalcity[index].cityId;
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
                                        crossAxisAlignment:
                                            CrossAxisAlignment.center,
                                        children: [
                                          Offstage(
                                              offstage: government ==
                                                      finalcity[index].cityName
                                                  ? false
                                                  : true,
                                              child: Icon(Icons.check_circle,
                                                  color: MyColors.green)),
                                          // SizedBox(width: 10),
                                          Expanded(
                                            child: Padding(
                                              padding:
                                                  EdgeInsets.only(bottom: 5),
                                              child: Center(
                                                child: MyText(
                                                  title:
                                                      finalcity[index].cityName,
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
                          : government,
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 17),
                    ),
                  ),
                  Icon(Icons.keyboard_arrow_down, color: Colors.white, size: 30)
                ],
              ),
            ),
          ),
          SizedBox(height: 40),
          Row(
            children: [
              Expanded(
                child: searchContainer(
                    categoryId == null
                        ? () {
                            showErrorDaialog(
                                "Pleaseenterthesectionfirst".tr, context);
                          }
                        : () {
                            Get.to(
                              FilterMapPage(
                                id: categoryId,
                                cityId: cityId,
                                governmentId: governmentId,
                                searchType: widget.searchType,
                              ),
                            );
                          },
                    "Searchbymap".tr),
              ),
              SizedBox(width: 20),
              Expanded(
                child: searchContainer(
                    categoryId == null
                        ? () {
                            showErrorDaialog(
                                "Pleaseenterthesectionfirst".tr, context);
                          }
                        : () {
                            // Get.to(SetAddress(
                            //   name: _search.text.toString(),
                            //   vategory: cityId,
                            //   searchType: widget.searchType,
                            // ));
                            _submit();
                          },
                    "adress".tr),
              ),
            ],
          ),
        ],
      ),
    );
  }

  // void _modalBottomSheetMenu(BuildContext context, List<AllCategory> cities) {
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
  //           return citiesWidget(context, cities);
  //         },
  //       );
  //     },
  //   );
  // }

  Widget categoryWidget(BuildContext context, List<AllCategories> cities) {
    return ListView.builder(
      itemCount: cities.length,
      shrinkWrap: true,
      itemBuilder: (context, index) {
        return InkWell(
          onTap: () {
            setState(() {
              category = cities[index].categoryName;
              categoryId = cities[index].catId;
              allDepartment = cities[index].allDepartment;
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
                    offstage:
                        category == cities[index].categoryName ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.green)),
                // SizedBox(width: 10),
                Expanded(
                  child: Padding(
                    padding: EdgeInsets.only(bottom: 5),
                    child: Center(
                      child: MyText(
                        title: cities[index].categoryName,
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

  Widget sectionsWidget(BuildContext context, List<AllDepartment> cities) {
    return ListView.builder(
      itemCount: cities.length,
      shrinkWrap: true,
      itemBuilder: (context, index) {
        return InkWell(
          onTap: () {
            setState(() {
              department = cities[index].departmentName;
              departmentId = cities[index].departmentId;
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
                    offstage: department == cities[index].departmentName
                        ? false
                        : true,
                    child: Icon(Icons.check_circle, color: MyColors.green)),
                // SizedBox(width: 10),
                Expanded(
                  child: Padding(
                    padding: EdgeInsets.only(bottom: 5),
                    child: Center(
                      child: MyText(
                        title: cities[index].departmentName,
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
