import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/service_details/servicesDetails.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/searchByCity.dart';

// package:wasalny/Screens/service_details/servicesDetails.dart

class SearchCityScreen extends StatefulWidget {
  final List<AllProductCC> search;
  SearchCityScreen({
    this.search,
  });
  @override
  _SearchCityScreenState createState() => _SearchCityScreenState();
}

class _SearchCityScreenState extends State<SearchCityScreen> {
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
      // future();
    }
  }

  @override
  Widget build(BuildContext context) {
    final width = (MediaQuery.of(context).size.width);
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    print(widget.search.toString());
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
                scrollDirection: Axis.vertical,
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisSpacing: 0,
                  crossAxisCount: 2,
                  childAspectRatio: 0.7,
                  mainAxisSpacing: 0,
                ),
                itemCount: widget.search.length,
                itemBuilder: (context, index) {
                  return InkWell(
                    onTap: () {
                      Get.to(
                        ServicesDetails(
                          id: widget.search[index].prodId,
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
                                fit: BoxFit.cover,
                                image: NetworkImage(
                                    widget.search[index].productImage),
                              ),
                            ),
                            height: hight * 0.2,
                            width: MediaQuery.of(context).size.width * .3),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            IconButton(
                                onPressed: () {
                                  _sentFav(widget.search[index].favExit,
                                      widget.search[index].prodId);
                                  setState(() {});
                                },
                                icon: widget.search[index].favExit == 0
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
                            widget.search[index].totalRate == '' ||
                                    widget.search[index].totalRate == null
                                ? Text('0')
                                : Text(widget.search[index].totalRate),
                          ],
                        ),
                        Text(widget.search[index].productName,
                            overflow: TextOverflow.ellipsis,
                            maxLines: 1,
                            style: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: width * 0.043),
                            textAlign: TextAlign.start),
                      ],
                    ),
                  );
                }),
      ),
    );
  }
}
