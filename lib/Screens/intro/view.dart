import 'package:cached_network_image/cached_network_image.dart';
import 'package:card_swiper/card_swiper.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:location/location.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';
import 'package:wassalny/Screens/intro/coming_soon.dart';
import 'package:wassalny/Screens/intro/cubit/intro_page_cubit.dart';
import 'package:wassalny/Screens/login/view.dart';
import 'package:wassalny/Screens/searchScreen/searchScreen.dart' as Search;
import 'package:badges/badges.dart' as badges;
import 'package:wassalny/model/cartProvider.dart' as Cart;

import '../../Components/CustomWidgets/customTextField.dart';
import '../../Components/CustomWidgets/showdialog.dart';
import '../../Components/constants.dart';
import '../../model/home.dart';
import '../../model/homeSearch.dart';
import '../cart/cart.dart';

class IntroScreen extends StatefulWidget {
  const IntroScreen({super.key});

  @override
  State<IntroScreen> createState() => _IntroScreenState();
}

bool? _serviceEnabled;
var location = Location();
LocationData? _locationData;

PermissionStatus? _permissionGranted;

Future _getCurrentLocation() async {
  _serviceEnabled = await location.serviceEnabled();
  if (!_serviceEnabled!) {
    _serviceEnabled = await location.requestService();
    if (!_serviceEnabled!) {
      return;
    }
  }

  _permissionGranted = await location.hasPermission();
  if (_permissionGranted == PermissionStatus.denied) {
    _permissionGranted = await location.requestPermission();
    if (_permissionGranted != PermissionStatus.granted) {
      return;
    }
  }

  _locationData = await location.getLocation();
  // GeoCode geoCode = GeoCode();

  // final coordinates =
  //     new Coordinates(latitude:_locationData?.latitude, longitude:_locationData?.longitude);
  // var addresses =await geoCode.forwardGeocoding(address: address);
  // var first = addresses.first;
  // print(
  //     'locationsss: ${first.locality}, ${first.adminArea},${first.subLocality}, ${first.subAdminArea},${first.addressLine}, ${first.featureName},${first.thoroughfare}, ${first.subThoroughfare}');
  // setState(() {
  //   currentLat = _locationData?.latitude;
  //   currentLong = _locationData?.longitude;
  // });
  // setState(() {
  //   _loader = false;
  // });
  // print(currentLat);
  // print(currentLong);
}

String? _token;

_getToken() async {
  final preferences = await SharedPreferences.getInstance();
  _token = preferences.getString('bool');
}


class _IntroScreenState extends State<IntroScreen> {


  @override
  void initState() {
    _getToken();
    _getCurrentLocation();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (context) =>
      IntroPageCubit()
        ..getCategories(),
      child: Scaffold(
        body: BlocConsumer<IntroPageCubit, IntroPageState>(
          listener: (context, state) {
            // TODO: implement listener
          },
          builder: (context, state) {

            var cubit=IntroPageCubit.get(context);

            return cubit.categoriesModel==null?Center(
              child: CircularProgressIndicator(),
            ) :ListView(
              children: [
                Padding(
                  padding:  EdgeInsets.symmetric(horizontal: 15.w,vertical: 10.h),
                  child: Container(
                    height: MediaQuery.of(context).size.height * 0.25,
                    decoration: BoxDecoration(
                      border: Border(),
                      borderRadius: BorderRadius.circular(15),
                    ),
                    child: ClipRRect(
                      borderRadius: BorderRadius.circular(15),

                      child: Swiper(
                        autoplay: true,
                        itemCount: cubit.categoriesModel?.result?.mainOffers?.length??0,
                        itemBuilder: (context, index)=> InkWell(
                          onTap:
                                  (){
                          },
                          child: CachedNetworkImage(
                            imageUrl:cubit.categoriesModel?.result?.mainOffers?[index].image??'',
                            fit: BoxFit.fill,
                          ),

                        ),
                      ),
                    ),
                  ),
                ),
                // Center(
                //   child:Image.asset(appLogo,width: 200.w,) ,
                // ),
                SizedBox(height: 10.h,),
                GridView.builder(
                  shrinkWrap: true,
                  physics: NeverScrollableScrollPhysics(),
                  scrollDirection: Axis.vertical,
                  itemCount: cubit.categoriesModel?.result?.listCats?.length ??
                      0,
                  gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                    crossAxisSpacing: 2,
                    childAspectRatio: 1 / .98,
                    crossAxisCount: 2,
                    mainAxisSpacing: .9,
                  ),
                  itemBuilder: (context, index) {
                    return InkWell(
                      onTap: () {
                        if (cubit.categoriesModel?.result?.listCats?[index]
                            .catId == '77') {
                          Get.to(
                              BottomNavyView()
                          );
                        } else {
                          Get.to(
                              ComingSoon()
                          );
                        }
                      },
                      child: Column(
                        children: [
                          Container(
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(15),
                              color: Colors.blue.withAlpha(40),
                            ),
                            margin: EdgeInsets.only(right: 5),
                            height: 130.h,
                            width: 140.w,
                            child: ClipRRect(
                              borderRadius: BorderRadius.circular(15),
                              child: CachedNetworkImage(
                                placeholder: (context, url) =>
                                    Image.asset(appLogo),
                                imageUrl: cubit.categoriesModel?.result
                                    ?.listCats?[index].categoryImage ?? '',
                                fit: BoxFit.fill,
                                fadeInDuration: Duration(seconds: 2),
                              ),
                            ),
                          ),
                          Container(
                            child: Text(
                              cubit.categoriesModel?.result?.listCats?[index]
                                  .categoryName ?? '',
                              overflow: TextOverflow.ellipsis,
                              textAlign: TextAlign.center,
                              style: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 15.sp,
                              ),
                            ),
                          ),
                        ],
                      ),
                    );
                  },
                )


              ],
            );
          },
        ),
      ),
    );
  }
}


