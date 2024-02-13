
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:get/get.dart';
import 'package:meta/meta.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:wassalny/model/categories_model.dart';
import 'package:wassalny/network/auth/dio.dart';
import 'package:dio/dio.dart' as Dio;
part 'intro_page_state.dart';

class IntroPageCubit extends Cubit<IntroPageState> {
  IntroPageCubit() : super(IntroPageInitial());

  static IntroPageCubit get(context)=>BlocProvider.of(context);

  CategoriesModel? categoriesModel;

  Future<void> getCategories()async{
    emit(GetCategoriesLoadingState());
    SharedPreferences preferences = await SharedPreferences.getInstance();
    final response=await dio().post('user_api/categories',
    data: Dio.FormData.fromMap(
      {
        "key":1234567890,
        'token_id': preferences.getString('bool'),
        'lang': Get.locale?.languageCode??'ar'
      }
    ),
    );
    if(response.data['status']){
      categoriesModel=CategoriesModel.fromJson(response.data);
    emit(GetCategoriesSuccessState());
    }else{
      emit(GetCategoriesErrorState());
    }
  }
}
