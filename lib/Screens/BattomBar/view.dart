import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/dialogs.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/globalState.dart';
import 'package:wassalny/Screens/Filter/view.dart';
import 'package:wassalny/Screens/Home/view.dart';
import 'package:wassalny/Screens/Offerss/view.dart';

class BottomNavyView extends StatefulWidget {
  final int index;

  BottomNavyView({
    this.index,
  });

  @override
  _BottomNavyViewState createState() => _BottomNavyViewState();
}

class _BottomNavyViewState extends State<BottomNavyView>
    with TickerProviderStateMixin {
  int type = 0;
  int isRent = 0;
  int pageIndex = 0;
  bool showFilter = false;
  List<Widget> pages = [
    Home(),
    Offerss(
      searchType: 1,
    ),
    Filter(1)
  ];

  @override
  void didChangeDependencies() {
    setState(
      () {
        pageIndex = widget.index == null ? 0 : widget.index;
      },
    );
    super.didChangeDependencies();
  }

  // @override
  // void initState() {
  //   super.initState();
  // }

  void _pageChanged(int page) {
    setState(
      () {
        pageIndex = page;
      },
    );
  }

  final _pageController = PageController(
      initialPage: GlobalState.instance.get('selectedPage') != null
          ? GlobalState.instance.get('selectedPage')
          : 0);

  void navigationTapped(int page) {
    GlobalState.instance.set('selectedPage', null);
    setState(() {
      pageIndex = page;
      // _selectedPage = page;
    });
    _pageController.animateToPage(page,
        duration: const Duration(milliseconds: 10),
        curve: Curves.linearToEaseOut);
  }

  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: () =>
          displayLogoutDialog(context, "closeApplication".tr, "wantExit".tr),
      child: Scaffold(
        resizeToAvoidBottomInset: false,
        backgroundColor: Color.fromRGBO(250, 250, 250, 1),
        body: GestureDetector(
          onTap: () {},
          child: Stack(
            children: [
              PageView.builder(
                  physics: NeverScrollableScrollPhysics(),
                  controller: _pageController,
                  onPageChanged: _pageChanged,
                  itemCount: pages.length,
                  itemBuilder: (context, index) {
                    return pages[pageIndex];
                  }),
              Positioned(
                bottom: 0,
                right: 0,
                left: 0,
                child: Container(
                  decoration: BoxDecoration(
                    color: Colors.blue,
                    boxShadow: [
                      BoxShadow(
                          color: MyColors.lightBlue.withOpacity(.3),
                          spreadRadius: 1,
                          blurRadius: 1,
                          offset: Offset(0, 1))
                    ],
                  ),
                  child: Row(
                    children: [
                      Expanded(
                        child: InkWell(
                          onTap: () {
                            navigationTapped(0);
                          },
                          child: Column(
                            children: [
                              SizedBox(height: 3),
                              Icon(Icons.home, size: 28, color: Colors.white),
                              SizedBox(height: 0),
                              MyText(
                                title: "Main".tr,
                                color: Colors.white,
                                size: 11,
                              ),
                              SizedBox(height: 3),
                            ],
                          ),
                        ),
                      ),
                      Container(
                        height: 40,
                        width: .4,
                        color: Colors.black,
                        child: Container(),
                      ),
                      Expanded(
                        child: InkWell(
                          onTap: () {
                            navigationTapped(1);
                          },
                          child: Column(
                            children: [
                              SizedBox(height: 3),
                              Icon(Icons.offline_bolt,
                                  size: 28, color: Colors.white),
                              SizedBox(height: 0),
                              MyText(
                                title: "offers".tr,
                                color: Colors.white,
                                size: 11,
                              ),
                              SizedBox(height: 3),
                            ],
                          ),
                        ),
                      ),
                      Container(
                          height: 40,
                          width: .4,
                          color: Colors.black,
                          child: Container()),
                      Expanded(
                        child: InkWell(
                          onTap: () {
                            navigationTapped(2);
                          },
                          child: Column(
                            children: [
                              SizedBox(height: 3),
                              Icon(Icons.search, size: 28, color: Colors.white),
                              SizedBox(height: 0),
                              MyText(
                                title: "Searchfilter".tr,
                                color: Colors.white,
                                size: 11,
                              ),
                              SizedBox(height: 3),
                            ],
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
