import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:get/get.dart';
import 'package:meta/meta.dart';
import 'package:wassalny/model/home.dart';

import '../../../network/auth/dio_helper.dart';

part 'home_state.dart';

class HomeCubit extends Cubit<HomeState> {
  HomeCubit() : super(HomeInitial());

  static HomeCubit get(context)=>BlocProvider.of(context);

  HomeModel? homeModel;

  Future<void> fetchHomeData()async{
    emit(FetchHomeDataLoading());
    final response=await DioHelper.postData(url: "get_home",
      data: {
        "key":1234567890,
        "lang":Get.locale?.countryCode??''
      },
    );
    if(response.data['status']){
      homeModel=HomeModel.fromJson(response.data);
      print(response.data);
    emit(FetchHomeDataSuccess());
    }else{
      emit(FetchHomeDataError());
    }

  }
}
