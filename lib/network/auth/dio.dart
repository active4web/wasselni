import 'package:dio/dio.dart';
import 'package:wassalny/Components/constants.dart';

 Dio dio() {
  Dio dio = Dio();
  dio.options.baseUrl = baseUrl;
  // dio.options.connectTimeout = 10000;
  return dio;

}


