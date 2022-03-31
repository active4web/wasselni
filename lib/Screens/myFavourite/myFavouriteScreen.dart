import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/service_details/servicesDetails.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/getMyFav.dart';

class MyFavouriteScreen extends StatefulWidget {
  @override
  _MyFavouriteScreenState createState() => _MyFavouriteScreenState();
}

class _MyFavouriteScreenState extends State<MyFavouriteScreen> {
  bool liked = true;
  bool loader = false;

  List<AllFavourite> allProducts = [];
  Future<void> future() async {
    loader = true;
    try {
      allProducts =
          await Provider.of<FavouriteListProvider>(context, listen: false)
              .fetchCart();

      setState(() {
        loader = false;
      });
    } catch (error) {
      print(error);
      setState(() {
        loader = false;
      });
      throw (error);
    }
  }

  Future<void> _sentFav() async {
    int id;
    bool done =
        Provider.of<UpdateFavProvider>(context, listen: false).doneSenting;
    for (var i = 0; i < allProducts.length; i++) {
      id = allProducts[i].prodId;
    }
    try {
      done = await Provider.of<UpdateFavProvider>(context, listen: false)
          .updateFav(
        key: '2',
        id: id,
      );

      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }
    if (done) {
      setState(() {
        allProducts.removeWhere((element) => element.prodId == id);
      });
    }
  }

  @override
  void initState() {
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          'Favourite'.tr,
          style: TextStyle(
            color: Colors.white,
          ),
        ),
        centerTitle: true,
      ),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : allProducts.isEmpty || allProducts == null
              ? Center(
                  child: Text(
                  'لا توجد لديك اي اماكن مفضله حتي الان',
                  style: TextStyle(
                    color: Colors.blue,
                    fontSize: 22,
                    fontWeight: FontWeight.bold,
                  ),
                ))
              : Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: GridView.builder(
                    shrinkWrap: true,
                    scrollDirection: Axis.vertical,
                    itemCount: allProducts.length,
                    gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisSpacing: 10,
                      childAspectRatio: 3 / 2.9,
                      crossAxisCount: 2,
                      mainAxisSpacing: 10,
                    ),
                    itemBuilder: (context, index) {
                      return InkWell(
                        onTap: () {
                          Get.to(
                            ServicesDetails(id: allProducts[index].prodId),
                          );
                        },
                        child: Column(
                          children: [
                            SizedBox(
                              height: 8,
                            ),
                            Stack(
                              children: [
                                Container(
                                  decoration: BoxDecoration(
                                    borderRadius: BorderRadius.circular(15),
                                    color: Colors.white,
                                    image: DecorationImage(
                                      fit: BoxFit.cover,
                                      image: NetworkImage(
                                          allProducts[index].productImage),
                                    ),
                                  ),
                                  height:
                                      MediaQuery.of(context).size.height * 0.18,
                                  // width: MediaQuery.of(context).size.width * .3,
                                ),
                                Padding(
                                  padding: const EdgeInsets.all(4.0),
                                  child: InkWell(
                                      onTap: _sentFav,
                                      child: Icon(
                                        CupertinoIcons.heart_fill,
                                        color: Colors.red,
                                      )),
                                ),
                              ],
                            ),
                            Text(allProducts[index].productName,
                                overflow: TextOverflow.ellipsis,
                                maxLines: 1,
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 18),
                                textAlign: TextAlign.start),
                          ],
                        ),
                      );
                    },
                  ),
                ),
    );
  }
}
