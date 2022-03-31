import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:pull_to_refresh/pull_to_refresh.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/service_details/servicesDetails.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/searchLAndLat.dart';

// package:wasalny/Screens/service_details/servicesDetails.dart

class FilterSearchLatAndLagScreen extends StatefulWidget {
  final int catId;
  final double lat;
  final double lag;
  final int searchType;
  final int cityId;
  final int governmentId;
  const FilterSearchLatAndLagScreen(
      {this.catId,
      this.lag,
      this.lat,
      this.searchType,
      this.cityId,
      this.governmentId});

  @override
  _FilterSearchLatAndLagScreenState createState() =>
      _FilterSearchLatAndLagScreenState();
}

class _FilterSearchLatAndLagScreenState
    extends State<FilterSearchLatAndLagScreen> {
  RefreshController _refreshController =
      RefreshController(initialRefresh: false);
  bool loader;
  String lang = Get.locale.languageCode;

  Future<void> _sentFav(int isFav, int productId) async {
    bool done =
        Provider.of<UpdateFavProvider>(context, listen: false).doneSenting;

    try {
      done = await Provider.of<UpdateFavProvider>(context, listen: false)
          .updateFav(
        key: isFav == 0 ? '1' : '2',
        id: productId,
      );

      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }
    if (done) {
      future();
    }
  }

  Future<void> future() async {
    loader = true;
    var provider = Provider.of<SearchLatAndLagProvider>(context, listen: false);
    provider.searchLatAndLag.clear();
    // var nextLength = provider.searchLatAndLag.length + 20;
    try {
      await provider.fetchFilerSearch(
          catId: widget.catId,
          limt: 100,
          pageNumber: 0,
          lat: widget.lat,
          lag: widget.lag,
          city: widget.cityId,
          state: widget.governmentId,
          searchType: widget.searchType,
          lang: lang);
      Get.snackbar('الاحداثيات', "long : ${widget.lag} , lat : ${widget.lat} ",
          snackPosition: SnackPosition.BOTTOM,
          instantInit: true,
          duration: Duration(seconds: 10));

      setState(() {
        loader = false;
      });
      _refreshController.refreshCompleted();
      // _refreshController.loadComplete();
    } catch (error) {
      _refreshController.refreshCompleted();
      // _refreshController.loadComplete();
      print(error);
      setState(() {
        loader = false;
      });
      throw (error);
    }
  }

  void initState() {
    future();

    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final width = (MediaQuery.of(context).size.width);
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    print(widget.catId);
    final List<AllProduct> list =
        Provider.of<SearchLatAndLagProvider>(context).searchLatAndLag;
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        title: Text(
          "researchResults".tr,
          style: TextStyle(
            color: Colors.blue,
          ),
        ),
        centerTitle: true,
        iconTheme: IconThemeData(
          color: Colors.blue,
        ),
      ),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : Padding(
              padding: EdgeInsets.symmetric(vertical: 10, horizontal: 8),
              child: list.isEmpty
                  ? Center(
                      child: Text(
                        "NoSearch".tr,
                        style: TextStyle(
                            fontSize: 30,
                            fontWeight: FontWeight.bold,
                            color: Colors.blue),
                      ),
                    )
                  : GridView.builder(
                      shrinkWrap: true,
                      scrollDirection: Axis.vertical,
                      gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisSpacing: 0,
                        childAspectRatio:
                            MediaQuery.of(context).size.width * .0022,
                        crossAxisCount: 2,
                        mainAxisSpacing: 0,
                      ),
                      itemCount: list.length,
                      itemBuilder: (context, index) {
                        return InkWell(
                          onTap: () {
                            Get.to(
                              ServicesDetails(
                                id: list[index].prodId,
                              ),
                            );
                          },
                          child: Column(
                            children: [
                              Container(
                                  decoration: BoxDecoration(
                                    borderRadius: BorderRadius.circular(15),
                                    color: Colors.white,
                                    image: DecorationImage(
                                      fit: BoxFit.fill,
                                      image: NetworkImage(
                                          list[index].productImage),
                                    ),
                                  ),
                                  height: hight * 0.2,
                                  width:
                                      MediaQuery.of(context).size.width * .3),
                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  IconButton(
                                      onPressed: () {
                                        _sentFav(list[index].favExit,
                                            list[index].prodId);
                                        setState(() {});
                                      },
                                      icon: list[index].favExit == 0
                                          ? Icon(
                                              CupertinoIcons.heart,
                                              color: Colors.red,
                                            )
                                          : Icon(
                                              CupertinoIcons.heart_fill,
                                              color: Colors.red,
                                            )),
                                  SizedBox(
                                    width: 8,
                                  ),
                                  Icon(
                                    Icons.star,
                                    color: Colors.yellow,
                                  ),
                                  list[index].totalRate == '' ||
                                          list[index].totalRate == null
                                      ? Text('0')
                                      : Text(list[index].totalRate),
                                ],
                              ),
                              Text(list[index].productName,
                                  overflow: TextOverflow.ellipsis,
                                  maxLines: 1,
                                  style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      fontSize: 16),
                                  textAlign: TextAlign.start),
                            ],
                          ),
                        );
                      }),
            ),
    );
  }
}
