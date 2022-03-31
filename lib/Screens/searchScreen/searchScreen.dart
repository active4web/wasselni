import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:auto_size_text/auto_size_text.dart';
import 'package:wassalny/model/categoriseDetails.dart';
import 'package:wassalny/model/homeSearch.dart';

import '../service_details/servicesDetails.dart';

class SearchScreen extends StatefulWidget {
  final List<AllProductss> search;
  final String name;
  final String searchText;
  const SearchScreen({this.search, this.name, this.searchText});
  @override
  _SearchScreenState createState() => _SearchScreenState();
}

class _SearchScreenState extends State<SearchScreen> {
  // RefreshController _refreshController =
  //     RefreshController(initialRefresh: false);
  int pageNumber = 0;

  // ignore: unused_element
  // Future<void> _submit(int number) async {
  //   var nextLength = widget.search.length + 5;
  //   try {
  //     await Provider.of<SearchName>(context, listen: false)
  //         .fetchSearch(widget.searchText, 5, number);
  //     if (widget.search.length >= nextLength)
  //       _refreshController.loadComplete();
  //     else
  //       _refreshController.loadNoData();

  //     _refreshController.loadComplete();
  //   } catch (error) {
  //     _refreshController.loadComplete();
  //     print(error);
  //     Navigator.of(context).pop();
  //     showErrorDaialog("NoInternet".tr, context);
  //   }
  // }

  @override
  Widget build(BuildContext context) {
    // final width = (MediaQuery.of(context).size.width);
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    print(widget.search.toString());
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        title: Text(
          '${widget.name}',
          style: TextStyle(
            color: Colors.blue,
          ),
        ),
        centerTitle: true,
        iconTheme: IconThemeData(
          color: Colors.blue,
        ),
      ),
      body: Padding(
        padding: EdgeInsets.symmetric(vertical: 10, horizontal: 8),
        child: widget.search.isEmpty
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
                // physics: NeverScrollableScrollPhysics(),
                scrollDirection: Axis.vertical,
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisSpacing: 0,
                  // childAspectRatio:
                  //     MediaQuery.of(context).size.width * .0025,
                  crossAxisCount: 2,
                  mainAxisSpacing: 0,
                ),
                itemCount: widget.search.length,
                itemBuilder: (context, index) {
                  return Column(
                    children: [
                      InkWell(
                        onTap: () {
                          Get.to(ServicesDetails(
                            id: widget.search[index].prodId,
                          ));
                        },
                        child: Container(
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(15),
                              color: Colors.white,
                              image: DecorationImage(
                                fit: BoxFit.cover,
                                image: NetworkImage(
                                    widget.search[index].productImage),
                              ),
                            ),
                            height: hight * 0.2,
                            width: MediaQuery.of(context).size.width * .3),
                      ),
                      AutoSizeText(widget.search[index].productName,
                          overflow: TextOverflow.ellipsis,
                          maxLines: 1,
                          style: TextStyle(
                              fontWeight: FontWeight.bold, fontSize: 13),
                          textAlign: TextAlign.start),
                    ],
                  );
                },
              ),
      ),
    );
  }
}
