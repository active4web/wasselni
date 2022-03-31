import 'dart:async';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:geocoder/geocoder.dart';
import 'package:geolocator/geolocator.dart';
import 'package:get/get.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:location/location.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Screens/searchLatAndLag/searchLatAndLagScreen.dart';

import 'filter_lat_lag.dart';

class FilterMapPage extends StatefulWidget {
  final String type;
  final int index;
  final int id;
  final int cityId;
  final int governmentId;
  final int searchType;
  FilterMapPage(
      {Key key,
      this.type,
      this.id,
      this.index,
      this.searchType,
      this.cityId,
      this.governmentId})
      : super(key: key);
  @override
  _FilterMapPageState createState() => _FilterMapPageState();
}

class _FilterMapPageState extends State<FilterMapPage> {
  BitmapDescriptor myIcon;
  GoogleMapController myController;
  double currentLat;
  double currentLong;
  dynamic currentAddress;

  Completer<GoogleMapController> _controller = Completer();
  String searchAddress = 'Search with Locations';
  Marker marker = Marker(
    markerId: MarkerId("1"),
  );
  Set<Marker> mark = Set();
  BitmapDescriptor pinLocationIcon;
  bool _loader = false;
  var location = Location();
  _setAddMarker(position) async {
    setState(() {
      mark.add(Marker(
        onTap: () {},
        markerId: MarkerId(mark.length.toString()),
        icon: BitmapDescriptor.defaultMarker,
        position: LatLng(currentLat, currentLong),
      ));
    });
  }

  bool _serviceEnabled;
  PermissionStatus _permissionGranted;
  LocationData _locationData;
  Future _getCurrentLocation() async {
    _loader = true;
    _serviceEnabled = await location.serviceEnabled();
    if (!_serviceEnabled) {
      _serviceEnabled = await location.requestService();
      if (!_serviceEnabled) {
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
    final coordinates =
        new Coordinates(_locationData.latitude, _locationData.longitude);
    var addresses =
        await Geocoder.local.findAddressesFromCoordinates(coordinates);
    var first = addresses.first;
    print(
        'locationsss: ${first.locality}, ${first.adminArea},${first.subLocality}, ${first.subAdminArea},${first.addressLine}, ${first.featureName},${first.thoroughfare}, ${first.subThoroughfare}');
    setState(() {
      currentLat = _locationData.latitude;
      currentLong = _locationData.longitude;
      currentAddress = first.addressLine;
    });
    _loader = false;
  }

  void initState() {
    super.initState();
    _getCurrentLocation();
  }

  Widget _confirmButton(BuildContext context) {
    return InkWell(
      onTap: () {
        print(currentLong);
        print(currentLat);
        Get.to(() => FilterSearchLatAndLagScreen(
              catId: widget.id,
              lag: currentLong,
              cityId: widget.cityId,
              governmentId: widget.governmentId,
              lat: currentLat,
              searchType: widget.searchType,
            ));
      },
      child: Container(
        height: 50,
        margin: EdgeInsets.all(10),
        width: MediaQuery.of(context).size.width,
        decoration: BoxDecoration(
          // color: Color(getColorHexFromStr("#1E92CD")),
          color: MyColors.blue,
          borderRadius: BorderRadius.circular(12.0),
        ),
        child: Center(
          child: Text(
            "Confirm".tr,
            style: TextStyle(
              fontFamily: "Cairo",
              fontWeight: FontWeight.bold,
              color: Colors.white,
              fontSize: 18,
            ),
          ),
        ),
      ),
    );
  }

  Position updatedPosition;
  String address = "";
  getLocationAddress(position, lat, lng) async {
    LatLng loc = position;
    setState(() {
      currentLat = loc.latitude;
      currentLong = loc.longitude;
    });
    final coordinates = new Coordinates(currentLat, currentLong);
    var addresses =
        await Geocoder.local.findAddressesFromCoordinates(coordinates);
    var first = addresses.first;
    // print(
    //     'locationsss: ${first.locality}, ${first.adminArea},${first.subLocality}, ${first.subAdminArea},${first.addressLine}, ${first.featureName},${first.thoroughfare}, ${first.subThoroughfare}');
    print('locationsss: ${first.thoroughfare}');
    setState(() {
      currentAddress = first.addressLine;
    });
  }

  @override
  Widget build(BuildContext context) {
    print(currentLat);
    print(currentLong);
    print(currentAddress);
    return Directionality(
      textDirection: TextDirection.rtl,
      child: Scaffold(
        appBar: titleAppBar(context, "Searchbymap".tr),
        body: currentLat == null || currentLong == null || _loader == true
            ? Center(child: CircularProgressIndicator())
            : Container(
                height: MediaQuery.of(context).size.height,
                width: MediaQuery.of(context).size.width,
                child: Stack(
                  children: <Widget>[
                    GoogleMap(
                      mapType: MapType.normal,
                      onCameraIdle: () {
                        print(updatedPosition);
                      },

                      initialCameraPosition: CameraPosition(
                          target: LatLng(currentLat, currentLong), zoom: 10.0),
                      // onMapCreated: _onMapCreated,
                      onMapCreated: (GoogleMapController controller) {
                        _controller.complete(controller);
                      },

                      onTap: (location) {
                        getLocationAddress(
                            location, location.latitude, location.longitude);
                        setState(() {});
                      },
                      onCameraMove: (loc) {
                        _updatePosition(loc);
                      },
                      markers: Set<Marker>.of(
                        <Marker>[
                          Marker(
                            draggable: true,
                            markerId: MarkerId("1"),
                            position: LatLng(currentLat, currentLong),
                            icon: BitmapDescriptor.defaultMarker,
                          )
                        ],
                      ),
                    ),
                    Positioned(
                      top: 45,
                      right: 20,
                      child: Offstage(
                        offstage: widget.index == 0 ? false : true,
                        child: InkWell(
                            onTap: () {
                              Navigator.pop(context);
                            },
                            child: Icon(Icons.close,
                                color: MyColors.blue, size: 30)),
                      ),
                    ),
                    Positioned(
                      bottom: 95,
                      right: 10,
                      left: 10,
                      child: Offstage(
                        offstage: widget.index == 0 ? true : false,
                        child: InkWell(
                            onTap: () {
                              Get.back();
                            },
                            child: _confirmButton(context)),
                      ),
                    ),
                  ],
                ),
              ),
      ),
    );
  }

  _updatePosition(CameraPosition _position) async {
    Position newMarkerPosition = Position(
        latitude: _position.target.latitude,
        longitude: _position.target.longitude,
        accuracy: 0,
        altitude: 0,
        heading: 0,
        speed: 0,
        speedAccuracy: 0,
        timestamp: DateTime.now());
    setState(() {
      updatedPosition = newMarkerPosition;
      marker = marker.copyWith(
          positionParam:
              LatLng(newMarkerPosition.latitude, newMarkerPosition.longitude));
    });
  }
}
