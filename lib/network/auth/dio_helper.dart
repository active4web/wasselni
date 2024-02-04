import 'package:dio/dio.dart';
import '../../Components/constants.dart';

class DioHelper {
  static Dio? dio;

  static init() {
    dio = Dio(BaseOptions(
      baseUrl: baseUrl,
      receiveDataWhenStatusError: true,
      followRedirects: false,
    ));
  }

  static Future<Response> getData({
     String? url,
    Map<String, dynamic>? query,
  }) async {
    return await dio!.get(
      url!,
      queryParameters: query,
    );
  }

  static Future<Response> postData({
     String? url,
    Map<String, dynamic>? query,
      data,
  }) async {
    return dio!.post(
      url!,
      queryParameters: query,
      data: FormData.fromMap(data),
    );
  }
}