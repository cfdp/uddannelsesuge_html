
/**
*
* PLUGIN: jquery.geocode
* BY: Mattias Norell
* VERSION: 0.9.3 (based on jQuery 1.4.4)
* BROWSERS: Safari 4, Chrome 7, IE9, Firefox 4
* ABOUT: Display a GoogleMap, geocoded
* HOW-TO: $(div).geocode({adress:"street,city",zoom:16});
*
**/
(function ($) {
    $.fn.geocode = function (options) {
        var defaults = { address: "", zoom: 16 };
        var options = $.extend(defaults, options);
        options.mapCanvas = $(this).attr("id");

        try {
            if (google) {
                $.fn.geocode.gmapApiLoaded(options);
            } else {
                $.fn.geocode.loadApi(options);
            }
        } catch (err) {
            $.fn.geocode.loadApi(options);
        }
        return false;
    };
    $.fn.geocode.loadApi = function (options) {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=gmapApiLoadedFromServer";
        window.gmapApiLoadedFromServer = function () {
            $.fn.geocode.gmapApiLoaded(options);
        }
        $("body").append(script);
    }

    $.fn.geocode.gmapApiLoaded = function (options) {
        var geocoder = new google.maps.Geocoder();
        if (geocoder) {
            geocoder.geocode({ 'address': options.address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var lngLat = results[0].geometry.location;

                    var mapOptions = {
                        zoom: options.zoom,
                        center: lngLat,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }

                    var map = new google.maps.Map(document.getElementById(options.mapCanvas), mapOptions);
                    var marker = new google.maps.Marker({ map: map, position: lngLat });
                } else {
                    // console.log("Geocoding failed: " + status);
                }
            });
        };
    }
})(jQuery); 