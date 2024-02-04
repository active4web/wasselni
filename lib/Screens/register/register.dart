import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:http/http.dart' as http;
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Components/constants.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';
import 'package:wassalny/Screens/login/view.dart';
import 'package:wassalny/model/offers.dart';
import 'package:wassalny/model/user.dart';
import 'package:wassalny/network/auth/auth.dart';
import 'package:wassalny/network/auth/provider/condition.dart';

import 'county/list.dart';

class Register extends StatefulWidget {
  @override
  _RegisterState createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  Widget dropList() {
    return InkWell(
      // onTap: () => languageWidget(context),
      child: Container(
        height: 55,
        padding: EdgeInsets.symmetric(horizontal: 20),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.all(Radius.circular(30)),
          border: Border.all(color: Colors.blue, width: 2),
        ),
        child: Row(
          children: [
            Expanded(
              child: MyText(
                  title: "ChoseLang".tr,
                  weight: FontWeight.bold,
                  color: Colors.red,
                  size: 17),
            ),
            Icon(
              Icons.keyboard_arrow_down,
              size: 30,
            )
          ],
        ),
      ),
    );
  }

  String lang = Get.locale?.languageCode??'';
  bool isPassword = true;
  IconData icon = Icons.visibility;
  String? token;
  String? token_id;
  String? city;
  String? cityId;
  bool loader = false;
  Future<void> future() async {
    loader = true;
    try {
      await Provider.of<CityDropDownProvider>(context, listen: false)
          .fetchAllCites(lang);
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

  User user = User();
  final GlobalKey<FormState> key = GlobalKey<FormState>();

  Future<void> _submit() async {
    bool auth = Provider.of<Auth>(context, listen: false).doneSentRegister;

    if (!key.currentState!.validate()) {
      return;
    }
    key.currentState?.save();
    showDaialogLoader(context);
    try {
      auth = await Provider.of<Auth>(context, listen: false)
          .register(user, lang, cityId??'');
      Get.updateLocale(Locale('ar'));
      // ignore: unused_catch_clause
    } on HttpExeption catch (error) {
      Navigator.of(context).pop();
      print(error);
      showErrorDaialog("FoundedUser".tr, context);
    } catch (error) {
      print("1111111111111111111111111111111111111111111111111111");
      print(error.toString());
      Navigator.of(context).pop();
      showErrorDaialog('NoInternet'.tr, context);
    } finally {
      if (auth) {
        Navigator.of(context).pop();
        Get.offAll(BottomNavyView());
      }
    }
  }

  @override
  void initState() {
    future();
    getPrivacy();
    super.initState();
  }


  bool isChecked = false;

  @override
  Widget build(BuildContext context) {

    print(lang);
    List<ListCountry>? list =
        Provider.of<CityDropDownProvider>(context, listen: false).list;
    print(list);
    return  Scaffold(
      body: Form(
        key: key,
        child: loader
            ? Center(child: CircularProgressIndicator())
            : ListView(
          padding: EdgeInsets.all(30),
          children: [
            Align(
              alignment: Alignment.topRight,
              child: IconButton(
                onPressed: () {
                  _modalBottomSheetMenu(context);
                },
                icon: Container(
                    width: 30,
                    height: 30,
                    decoration: BoxDecoration(
                        color: Colors.blue, shape: BoxShape.circle),
                    child: Icon(
                      FontAwesomeIcons.globe,
                      color: Colors.white,
                    )),
              ),
            ),
            SizedBox(height: 50.h),
            Padding(
                padding: const EdgeInsets.symmetric(horizontal: 60),
                child: Image.asset(appLogo)),
            SizedBox(height: 80),
            // dropList(),
            // SizedBox(height: 10),
            CustomTextField(
                onSaved: (val) {
                  user.newname = val;
                },
                valid: (val) {
                  if (val!.isEmpty) {
                    return "Thisfieldisrequired".tr;
                  } else {
                    return null;
                  }
                },
                hint: "name".tr),
            SizedBox(height: 10),
            CustomTextField(
                onSaved: (val) {
                  user.newphone = val;
                },
                inputFormatters: <TextInputFormatter>[
                  FilteringTextInputFormatter.allow(
                      RegExp('[a-z A-Z 0-9]'))
                ],
                valid: (val) {
                  if (val!.isEmpty) {
                    return "Thisfieldisrequired".tr;
                  } else {
                    return null;
                  }
                },
                hint: "phoneNumber".tr,
                textDirection: TextDirection.ltr,
                type: TextInputType.phone),
            SizedBox(height: 10),
            CustomTextField(
                onSaved: (val) {
                  user.newAdress = val;
                },
                valid: (val) {
                  if (val!.isEmpty) {
                    return "Thisfieldisrequired".tr;
                  } else {
                    return null;
                  }
                },
                hint: "address".tr),
            SizedBox(height: 10),
            Container(
              height: 55,
              padding: EdgeInsets.symmetric(horizontal: 20),
              decoration: BoxDecoration(
                borderRadius: BorderRadius.all(Radius.circular(30)),
                border: Border.all(color: Colors.blue, width: 2),
              ),
              child: InkWell(
                onTap: () => showDialog(
                  context: context,
                  builder: (BuildContext context) {
                    return AlertDialog(
                      backgroundColor: Colors.blue[300],
                      content: Container(
                        width: MediaQuery.of(context).size.width * 0.8,
                        child: citiesWidget(
                          context,
                          list!,
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
                        child: Text(city == null ? "country".tr : city??'',
                            maxLines: 1,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                                color: Colors.red,
                                fontWeight: FontWeight.bold,
                                fontSize: 17))),
                    Icon(Icons.keyboard_arrow_down,
                        color: Colors.white, size: 30)
                  ],
                ),
              ),
            ),
            SizedBox(height: 10),
            CustomTextField(
                inputFormatters: <TextInputFormatter>[
                  FilteringTextInputFormatter.allow(
                      RegExp('[a-z A-Z 0-9]'))
                ],
                isPassword: isPassword,
                suffixIcon: icon,
                suffixPress: () {
                  isPassword = !isPassword;
                  isPassword
                      ? icon = Icons.visibility
                      : icon = Icons.visibility_off_outlined;
                  setState(() {});
                },
                onSaved: (val) {
                  print(val);
                  user.password = val;
                },
                valid: (val) {
                  if (val!.isEmpty) {
                    return "Thisfieldisrequired".tr;
                  } else {
                    return null;
                  }
                },
                hint: "password".tr,
                textDirection: TextDirection.ltr,
                type: TextInputType.visiblePassword),
            SizedBox(height: 10),
            Column(
              children: [
                Row(
                  children: [
                    Expanded(
                      child: Checkbox(
                          value: isChecked,
                          onChanged: (check){
                            setState(() {
                              isChecked = check!;
                            });
                          }),
                    ),
                    Text('بالضغط على تسجيل الدخول يعني الموافقه على',
                      style: TextStyle(
                          color: Colors.black
                      ),
                    ),
                  ],
                ),
                InkWell(
                  onTap: (){
                    showAlertDialog(context);
                  },
                  child: Text('شروط واحكام التطبيق',
                      style: TextStyle(
                          decoration: TextDecoration.underline,
                          color: Colors.red
                      )
                  ),
                ),
                // InkWell(
                //   onTap: (){
                //     showAlertDialog(context);
                //   },
                //   child: Expanded(
                //     child: RichText(
                //       text: TextSpan(
                //         text: 'بالضغط على تسجيل الدخول يعني الموافقه على ',
                //         style: TextStyle(
                //             color: Colors.black
                //         ),
                //         children: const <TextSpan>[
                //           TextSpan(
                //               text: 'شروط واحكام ',
                //               style: TextStyle(
                //                   decoration: TextDecoration.underline,
                //                   color: Colors.red
                //               )),
                //         ],
                //       ),
                //     ),
                //   ),
                // ),
              ],
            ),
            CustomButton(
                backgroundColor: Colors.blue,
                borderColor: Colors.blue,
                isShadow: 1,
                onTap: cityId == null
                    ? () => Get.snackbar('انتباه', 'يرجي اختيار الدوله')
                    : _submit,
                textColor: Colors.white,
                label: "login".tr),
            InkWell(
              onTap: () {
                Get.to(
                  Login(),
                );
              },
              child: Center(
                child: Text(
                  "do you have account".tr,
                  style: TextStyle(
                      color: Colors.blue,
                      fontSize: 20,
                      decoration: TextDecoration.underline),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  String terms_conditions = "";
  bool isLoading = true;
 getPrivacy() async {
    final response =
    await http.post(Uri.parse("${baseUrl}/pages/get_contact_info"), body: {
      "key": "1234567890",
      "token_id":
     'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjUiLCJwaG9uZSI6IjAxMDYyMzcxMTI0IiwiZW1haWwiOiJhc2hyYWYgbW9oYW1tZWQgYXR0eWEgZWxraG9seSIsIkFQSV9USU1FIjoxNjY1NjU1OTAzfQ.TLYHZ3T7kvfriZmtjRPt5Zmy8HjyNI6J2TK7-vC2KV8',
      'lang':lang
    });

    var data = json.decode(response.body);
    if (data['status']) {
      setState(() {
        //Load Providers Details
        terms_conditions = data['result']['terms_conditions'];
        isLoading = false;
      });
    } else {
      print("$data");

    }
  }

  void showAlertDialog(BuildContext context){
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(30)),
        contentPadding: const EdgeInsets.symmetric(horizontal: 40, vertical: 40),
        title: Row(
          children: [
            Text('شروط واحكام',
            textAlign: TextAlign.center,
            style: TextStyle(
              fontSize: 17
            ),
            ),
            Spacer(),
            IconButton(
                onPressed: (){
              Navigator.pop(context);
            },
                icon: Icon(Icons.close))
          ],
        ),
        content: Container(
          child: SingleChildScrollView(
            child: Column(
             // mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                Text(
                  terms_conditions
                  //  'جميع المحتويات في هذا الموقع ، بما في ذلك النصوص الكاملة للوثائق، والتصميم والصور والبرامج والنصوص وغيرها من المعلومات (إجمالا ، \"المحتوى\") هي من ممتلكات شركة المنظومة أو الجهات المرخصة بموجب العقود الموقعة معها. وجميع هذه المحتويات محمية بموجب قوانين وأنظمة حقوق المؤلف وغيرها من قوانين الملكية الفكرية.\r\nلا يجوز لك نسخ أو عرض أو توزيع أو تعديل أو نشر أو إعادة إنتاج أو تخزين أو نقل أو إنشاء أعمال اشتقاقية ، أو بيع أو ترخيص جميع أو أي جزء من محتويات ، أو منتجات أو خدمات القواعد، والتي تم الحصول عليها من هذا الموقع في أي وسيلة ولأي احد، ما عدا ما ينص بشكل صريح على السماح به بموجب القانون المعمول به أو على النحو المبين في هذه الشروط والبنود ذات الصلة أو ترخيص أو اتفاق مشترك.\r\nيمكنك تنزيل أو طباعة المحتويات من الموقع لاستخدامك الشخصي فقط، وليس الاستخدام التجاري، شريطة عدم المساس بجميع حقوق التأليف والنشر واتفاقيات الملكية الفكرية الأخرى.\r\nلا يجوز لك تجاوز حدود الاستخدام العادل للمحتوى بما في ذلك القيام باسترجاع كميات كبيرة وبشكل منتظم لمحتويات القواعد من اجل إنشاء مجموعات من البحوث والدراسات أو بناء قواعد معلومات منها سواء بشكل مباشر أو غير مباشر أو لاي سبب آخر. وفي حال تجاوز المستخدم الفرد تنزيل ملفات المحتوى بما يزيد عن (200 ملف ) في اليوم الواحد، فإن ذلك يعتبر اختراق لحدود الاستخدام العادل والطبيعي للمحتوى وعليه فيحق للشركة منعه وحجبه عن الوصول للمحتوى واتخاذ الإجراءات القانونية المناسبة ضده.\r\nيمنع بشكل قطعي استخدام برامج الروبوت ، والعناكب والزواحف وغيرها من البرامج أو الوصول إلى القواعد عبر برامج أخرى غير مصرحة، كما يمنع استخدام برامج جمع وحصد العناوين البريدية أو عناوين البريد الإلكتروني من الموقع لأغراض غير مناسبة أو استخدامها لاغراض الدعاية التجارية. ويمكن مراسلة الشركة بشكل مباشر في حال الرغبة في الاستفسار عن الأغراض المشروعة، أو طلبات للحصول على إذن لنشر أو إعادة إنتاج أو توزيع أو عرض أو تقديم أعمال مشتقة من أي محتوى من محتويات القواعد والموقع بشكل عام.\r\nلا يجوز لك استخدام القواعد أو موقع الشركة لنشر أو توزيع أي معلومات (بما في ذلك البرمجيات أو المحتويات الأخرى) والتي تعد غير قانونية ، أو تنتهك أو تتعدى على حقوق أي شخص آخر ، أو المسيئة لأي جهة كانت، أو المواد الإباحية والمبتذلة ، أو تحتوي على الفيروسات أو غيرها من المكونات الضارة ، أو التي لا تجيزها الانظمة المحلية والدولية. لا يجوز لك ، دون موافقة الشركة استخدام الموقع لنشر أو توزيع أي إعلان ، أو مادة ترويجية، أو أي سلع أو خدمات,'
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  void _modalBottomSheetMenu(BuildContext context) {
    showMenu(
      context: context,
      position: RelativeRect.fill,
      items: [
        PopupMenuItem(
          child: InkWell(
            onTap: () {
              Get.updateLocale(Locale('ar'));
              lang = 'ar';
              Navigator.pop(context);
              setState(() {});
            },
            child: Container(
              padding: EdgeInsets.all(15),
              child: Row(
                children: [
                  Expanded(
                      child: MyText(
                          title: "اللغة العربية", weight: FontWeight.bold)),
                  Offstage(
                    offstage: Get.locale?.languageCode == 'ar' ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.primary),
                  ),
                ],
              ),
            ),
          ),
        ),
        PopupMenuItem(
          child: InkWell(
            onTap: () {
              Get.updateLocale(Locale('tr'));
              lang = 'tr';
              Navigator.pop(context);
              setState(() {});
            },
            child: Container(
              padding: EdgeInsets.all(15),
              child: Row(
                children: [
                  Expanded(
                      child: MyText(title: "Türkçe", weight: FontWeight.bold)),
                  Offstage(
                    offstage: Get.locale?.languageCode == 'tr' ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.primary),
                  ),
                ],
              ),
            ),
          ),
        ),
        PopupMenuItem(
          child: InkWell(
            onTap: () {
              Get.updateLocale(
                Locale('en'),
              );
              lang = 'en';

              Navigator.pop(context);

              setState(() {});
            },
            child: Row(
              children: [
                Expanded(
                  child: MyText(title: "English", weight: FontWeight.bold),
                ),
                Offstage(
                  offstage: Get.locale?.languageCode == 'en' ? false : true,
                  child: Icon(Icons.check_circle, color: MyColors.primary),
                )
              ],
            ),
          ),
        ),
      ],
    ).then((value) {
      print('lld');
      future();
    });
  }

  // Widget languageWidget(BuildContext context) {
  //   return Container(
  //     height: MediaQuery.of(context).size.width * .65,
  //     margin: EdgeInsets.only(top: 0),
  //     padding: EdgeInsets.fromLTRB(15, 15, 15, 15),
  //     decoration: BoxDecoration(
  //         color: Colors.white,
  //         borderRadius: BorderRadius.only(
  //             topLeft: Radius.circular(20), topRight: Radius.circular(20))),
  //     child: Column(
  //       children: [
  //         InkWell(
  //           onTap: () {
  //             Get.updateLocale(Locale('ar'));
  //             lang = 'ar';
  //             Navigator.pop(context);
  //             setState(() {});
  //           },
  //           child: Container(
  //             padding: EdgeInsets.all(15),
  //             child: Row(
  //               children: [
  //                 Expanded(
  //                     child: MyText(
  //                         title: "اللغة العربية", weight: FontWeight.bold)),
  //                 Offstage(
  //                   offstage: Get.locale.languageCode == 'ar' ? false : true,
  //                   child: Icon(Icons.check_circle, color: MyColors.primary),
  //                 ),
  //               ],
  //             ),
  //           ),
  //         ),
  //         Divider(
  //           thickness: 1,
  //           color: MyColors.primary.withOpacity(.3),
  //         ),
  //         InkWell(
  //           onTap: () {
  //             Get.updateLocale(Locale('tr'));
  //             lang = 'tr';
  //
  //             Navigator.pop(context);
  //             setState(() {});
  //           },
  //           child: Container(
  //             padding: EdgeInsets.all(15),
  //             child: Row(
  //               children: [
  //                 Expanded(
  //                     child: MyText(title: "Türkçe", weight: FontWeight.bold)),
  //                 Offstage(
  //                   offstage: Get.locale.languageCode == 'tr' ? false : true,
  //                   child: Icon(Icons.check_circle, color: MyColors.primary),
  //                 ),
  //               ],
  //             ),
  //           ),
  //         ),
  //         Divider(
  //           thickness: 1,
  //           color: MyColors.primary.withOpacity(.3),
  //         ),
  //         Container(
  //           padding: EdgeInsets.all(15),
  //           child: InkWell(
  //             onTap: () {
  //               // Get.updateLocale(
  //               //   Locale('en'),
  //               // );
  //               lang = 'en';
  //
  //               Navigator.pop(context);
  //
  //               setState(
  //                 () {},
  //               );
  //             },
  //             child: Row(
  //               children: [
  //                 Expanded(
  //                   child: MyText(title: "English", weight: FontWeight.bold),
  //                 ),
  //                 Offstage(
  //                   offstage: Get.locale.languageCode == 'en' ? false : true,
  //                   child: Icon(Icons.check_circle, color: MyColors.primary),
  //                 )
  //               ],
  //             ),
  //           ),
  //         ),
  //       ],
  //     ),
  //   );
  // }

  Widget citiesWidget(BuildContext context, List<ListCountry> cities) {
    return ListView.builder(
      itemCount: cities.length,
      shrinkWrap: true,
      itemBuilder: (context, index) {
        return InkWell(
          onTap: () {
            setState(() {
              city = cities[index].nameCountry;
              cityId = cities[index].idCountry;
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
                    offstage: city == cities[index].nameCountry ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.green)),
                // SizedBox(width: 10),
                Expanded(
                  child: Padding(
                    padding: EdgeInsets.only(bottom: 5),
                    child: Center(
                      child: MyText(
                        title: cities[index].nameCountry,
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