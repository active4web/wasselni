import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/Screens/endOrderScreen/endOrderScreen.dart';
import 'package:wassalny/model/cartProvider.dart';
import 'package:wassalny/model/deleteItem.dart';
import 'package:wassalny/model/updateCartProvider.dart';

class CartScreen extends StatefulWidget {
  @override
  _CartScreenState createState() => _CartScreenState();
}

class _CartScreenState extends State<CartScreen> {
  bool loader = false;
  // ignore: override_on_non_overriding_member
  String lang = Get.locale?.languageCode??'ar';
  List<AllProduct> allProducts = [];
  String? currncy;
  Future<void> future() async {
    loader = true;
    try {
      allProducts = (await Provider.of<CartListProvider>(context, listen: false)
          .fetchCart(lang))!;
      for (var i = 0; i < allProducts.length; i++) {
        print('${allProducts[i].price} price');
        currncy = allProducts[i].currencyName;
      }
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

  Future<void> _updateIndex({
    int? productId,
    int? quan,
    int? id,
    int? idForProduct,
  }) async {
    // bool auth =
    //     Provider.of<UpdateIndexOfCartProvider>(context, listen: false).deleted;
    try {
      await Provider.of<UpdateIndexOfCartProvider>(context, listen: false)
          .updateIndex(
              lang: lang,
              idKey: productId,
              idOrder: id,
              quantity: quan,
              productID: idForProduct);

      // ignore: unused_catch_clause
    } on HttpExeption catch (error) {
    } catch (error) {
      print(error);
    }
  }

  double totalPrice(List<AllProduct> allProducts) {
    double sum = 0;
    setState(() {
      for (var i = 0; i < allProducts.length; i++) {
        print('${allProducts[i].price} price');

        sum += (num.parse(allProducts[i].price??'') * num.parse(allProducts[i].quantity.toString()??''));
      }
    });
    return sum;
  }

  Future<void> remove(int id) async {
    loader = true;

    try {
      await Provider.of<RemoveFromCartProvider>(context, listen: false)
          .removeProduct(id);
      setState(() {
        allProducts.removeWhere((element) => element.idProduct == id);
      });
      setState(() {
        loader = false;
      });
      Get.snackbar(
        "DeletDone".tr,
        "deleteFromCart".tr,
        titleText: Text(
          "DeletDone".tr,
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 20,
          ),
        ),
        messageText: Text(
          "deleteFromCart".tr,
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 18,
          ),
        ),
      );
    } catch (error) {
      print(error);

      setState(() {
        loader = false;
      });
      Get.snackbar(
        "error".tr,
        "NoInternet".tr,
        titleText: Text(
          "error".tr,
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 20,
          ),
        ),
        messageText: Text(
          "NoInternet".tr,
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 18,
          ),
        ),
      );
      throw (error);
    }
  }

  @override
  void initState() {
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final width = (MediaQuery.of(context).size.width);
    final hieght = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    // TextEditingController counterController = TextEditingController();
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.blue,
        iconTheme: IconThemeData(
          color: Colors.white,
        ),
        actionsIconTheme: IconThemeData(
          color: Colors.white,
        ),
        centerTitle: true,
        actions: [
          SizedBox(
            width: width * 0.3,
          ),
          Container(
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: Colors.white,
            ),
            child: Padding(
              padding: const EdgeInsets.all(7),
              child: Center(
                child: Text(
                  allProducts.length.toString(),
                  style: TextStyle(color: Colors.blue, height: 1.8),
                ),
              ),
            ),
          ),
          IconButton(
            onPressed: () async {
              await Provider.of<CartListProvider>(context, listen: false)
                  .emptyCart(lang, allProducts[0].idOrder);
              future();
            },
            icon: Icon(
              Icons.delete,
            ),
          ),
        ],
        title: Text(
          "cart".tr,
          style: TextStyle(
            color: Colors.white,
            fontSize: 20.sp,
          ),
        ),
      ),
      body: Container(
        height: hieght,
        width: width,
        child: Padding(
          padding: const EdgeInsets.all(5),
          child: loader
              ? Center(child: CircularProgressIndicator())
              : allProducts.isEmpty
                  ? Center(
                      child: Text(
                        "noProducts".tr,
                        style: TextStyle(
                          color: Colors.blue,
                          fontSize: 22.sp,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    )
                  : Column(
                      children: [
                        Expanded(
                          child: ListView.builder(
                              itemCount: allProducts.length,
                              itemBuilder: (BuildContext context, int index) {
                                return Dismissible(
                                  background: Container(
                                    width: width,
                                    color: Colors.blue,
                                    child: Padding(
                                      padding: const EdgeInsets.all(12),
                                      child: Align(
                                        alignment: Alignment.centerRight,
                                        child: Icon(
                                          Icons.delete,
                                          size: 28.r,
                                          color: Color(0xffA8915F),
                                        ),
                                      ),
                                    ),
                                  ),
                                  key: ValueKey(allProducts[index].idProduct),
                                  onDismissed: (direction) {
                                    remove(allProducts[index].idProduct!);
                                  },
                                  child: Card(
                                    elevation: 5,
                                    shape: RoundedRectangleBorder(
                                        borderRadius:
                                            BorderRadius.circular(10)),
                                    child: Container(
                                      width: width,
                                      height: hieght * 0.2,
                                      child: Row(
                                        children: [
                                          ClipRRect(
                                            borderRadius: BorderRadius.only(
                                              topRight: Radius.circular(10),
                                              bottomRight: Radius.circular(10),
                                            ),
                                            child: Container(
                                              height: hieght,
                                              width: width * 0.4,
                                              child: Image.network(
                                                allProducts[index].image??'',
                                                fit: BoxFit.fill,
                                                errorBuilder: (context, error,
                                                        stackTrace) =>
                                                    Image.asset(
                                                  'assets/images/sema.png',
                                                  fit: BoxFit.fill,
                                                ),
                                              ),
                                            ),
                                          ),
                                          Column(
                                            children: [
                                              Align(
                                                alignment: Alignment.topCenter,
                                                child: Container(
                                                  width: width * 0.5,
                                                  height: hieght * 0.035,
                                                  child: Padding(
                                                    padding:
                                                        const EdgeInsets.only(
                                                            right: 5),
                                                    child: Text(
                                                      allProducts[index]
                                                          .productName??'',
                                                      overflow:
                                                          TextOverflow.ellipsis,
                                                      maxLines: 6,
                                                    ),
                                                  ),
                                                ),
                                              ),
                                              Align(
                                                alignment: Alignment.topCenter,
                                                child: Container(
                                                  width: width * 0.5,
                                                  child: Padding(
                                                    padding:
                                                        const EdgeInsets.only(
                                                            right: 5),
                                                    child: Text(
                                                      allProducts[index]
                                                          .serviceName??'',
                                                      overflow:
                                                          TextOverflow.ellipsis,
                                                      maxLines: 6,
                                                    ),
                                                  ),
                                                ),
                                              ),
                                              SizedBox(
                                                height: hieght * 0.013,
                                              ),
                                              Container(
                                                height: hieght * 0.05,
                                                child: Row(
                                                  mainAxisAlignment:
                                                      MainAxisAlignment.center,
                                                  crossAxisAlignment:
                                                      CrossAxisAlignment.center,
                                                  children: [
                                                    IconButton(
                                                      icon: Icon(
                                                        Icons.remove,
                                                        color: Colors.black,
                                                        size: 30.r,
                                                      ),
                                                      onPressed: allProducts[
                                                                      index]
                                                                  .quantity ==
                                                              1
                                                          ? null
                                                          : () {
                                                              setState(() {
                                                                allProducts[
                                                                        index]
                                                                    .quantity--;
                                                              });
                                                              _updateIndex(
                                                                  idForProduct:
                                                                      allProducts[
                                                                              index]
                                                                          .idProduct,
                                                                  productId: 2,
                                                                  quan: allProducts[
                                                                          index]
                                                                      .quantity,
                                                                  id: allProducts[
                                                                          index]
                                                                      .idOrder);
                                                            },
                                                    ),
                                                    // TextField(
                                                    //   controller:
                                                    //       counterController,
                                                    // ),
                                                    Text(
                                                      allProducts[index]
                                                          .quantity
                                                          .toString(),
                                                      style: TextStyle(
                                                          color: Colors.black,
                                                          fontSize: 18.sp),
                                                    ),
                                                    IconButton(
                                                        icon: Icon(
                                                          Icons.add,
                                                          color: Colors.black,
                                                          size: 30.r,
                                                        ),
                                                        onPressed: () {
                                                          setState(() {
                                                            allProducts[index]
                                                                .quantity++;
                                                          });
                                                          _updateIndex(
                                                              idForProduct:
                                                                  allProducts[
                                                                          index]
                                                                      .idProduct,
                                                              productId: 1,
                                                              quan: allProducts[
                                                                      index]
                                                                  .quantity,
                                                              id: allProducts[
                                                                      index]
                                                                  .idOrder);
                                                        }),
                                                    IconButton(
                                                        icon: Icon(
                                                          Icons.delete,
                                                          color: Colors.black,
                                                          size: 30.r,
                                                        ),
                                                        onPressed: () {
                                                          remove(
                                                              allProducts[index]
                                                                  .idProduct!);
                                                        }),
                                                  ],
                                                ),
                                              ),
                                              SizedBox(height: 10.h),
                                              Container(
                                                decoration: BoxDecoration(
                                                    color: Colors.blue,
                                                    borderRadius:
                                                        BorderRadius.circular(
                                                            10)),
                                                child: Padding(
                                                  padding:
                                                      const EdgeInsets.all(8.0),
                                                  child: Text(
                                                    '${allProducts[index].quantity * double.parse(allProducts[index].price??'')} ${allProducts[index].currencyName}',
                                                    style: TextStyle(
                                                        color: Colors.white),
                                                  ),
                                                ),
                                              ),
                                            ],
                                          ),
                                        ],
                                      ),
                                    ),
                                  ),
                                );
                              }),
                        ),
                        Align(
                          alignment: Alignment.bottomCenter,
                          child: Container(
                            child: Center(
                              child: Padding(
                                padding: const EdgeInsets.all(8.0),
                                child: Text(
                                  '${"totalCart".tr} : ${totalPrice(allProducts)} $currncy ',
                                  style: TextStyle(
                                      color: Colors.blue,
                                      fontSize: 20.sp,
                                      fontWeight: FontWeight.bold),
                                ),
                              ),
                            ),
                            color: Colors.white,
                          ),
                        ),
                        SizedBox(
                          height: hieght * 0.03,
                        ),
                        Align(
                          alignment: Alignment.bottomCenter,
                          child: InkWell(
                            onTap: () => Get.to(
                              () => EndOrderScreen(
                                id: allProducts[0].idOrder!,
                              ),
                            ),
                            child: Container(
                              width: width,
                              height: hieght * 0.1,
                              child: Center(
                                child: Row(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    Center(
                                      child: Text(
                                        "donePay".tr,
                                        style: TextStyle(
                                            color: Colors.white,
                                            fontSize: 20.sp,
                                            fontWeight: FontWeight.bold),
                                      ),
                                    ),
                                    SizedBox(
                                      width: 20.w,
                                    ),
                                    Icon(
                                      Icons.shopping_cart_outlined,
                                      size: 25.r,
                                      color: Colors.white,
                                    )
                                  ],
                                ),
                              ),
                              color: Colors.blue,
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
