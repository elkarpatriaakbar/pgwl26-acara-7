@extends('layouts.template')

@section('content')
  <div id="map"></div>
@endsection

@section('css')
  <style>
    #map {
      margin-top: 55px;
      height: calc(100vh - 55px);
      width: 100%;
    }
  </style>
@endsection

@section('script')
  <script>
    /* --- 1. Inisialisasi Peta --- */
    var map = L.map('map').setView([-7.7911905, 110.3708839], 14);

    /* --- 2. Pilihan Basemap Baru (Clean & Modern) --- */
    var lightMap = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
      subdomains: 'abcd',
      maxZoom: 20
    });

    var darkMap = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
      subdomains: 'abcd',
      maxZoom: 20
    });

    var satelliteMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EBP, and the GIS User Community'
    });

    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
      attribution: 'Google Maps'
    });

    var storageUrl = "{{ asset('storage') }}";

    // Tambahkan default basemap ke peta
    lightMap.addTo(map);

    /* --- 3. Komponen Tambahan --- */
    L.control.scale({
      position: 'bottomleft',
      metric: true,
      imperial: false,
    }).addTo(map);

    /* --- 4. Fungsi Edit (Leaflet Draw) --- */
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
      draw: false,
      edit: {
        featureGroup: drawnItems,
        edit: true,
        remove: false
      }
    });
    map.addControl(drawControl);

    function setEditImagePreview(selector, imagePath) {
      var preview = $(selector);
      if (!imagePath) {
        preview.addClass('d-none').attr('src', '');
        return;
      }
      preview.removeClass('d-none').attr('src', storageUrl + '/' + imagePath);
    }

    function watchImageInput(inputId, previewSelector) {
      $('#' + inputId).on('change', function() {
        var file = this.files[0];
        if (!file) {
          setEditImagePreview(previewSelector, null);
          return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
          $(previewSelector).removeClass('d-none').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
      });
    }

    watchImageInput('image_edit_point', '#image_preview_point');
    watchImageInput('image_edit_polyline', '#image_preview_polyline');
    watchImageInput('image_edit_polygon', '#image_preview_polygon');

    // Handler saat geometri selesai diedit (drag/resize)
    map.on('draw:edited', function(e) {
      var layers = e.layers;

      layers.eachLayer(function(layer) {
        var drawnJSONObject = layer.toGeoJSON();
        var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);
        var type = drawnJSONObject.geometry.type;
        var properties = drawnJSONObject.properties;

        // Isi form modal dengan data baru
        $('#name').val(properties.name);
        $('#description').val(properties.description);
        $('#geom').val(objectGeometry);

        if (type === 'LineString') {
          setEditImagePreview('#image_preview_polyline', properties.image_path);
        } else if (type === 'Polygon') {
          setEditImagePreview('#image_preview_polygon', properties.image_path);
        } else if (type === 'Point') {
          setEditImagePreview('#image_preview_point', properties.image_path);
        }

        // Tampilkan modal sesuai tipe
        if (type === 'LineString') {
          $('#editpolylineModal').modal('show');
        } else if (type === 'Polygon') {
          $('#editpolygonModal').modal('show');
        } else if (type === 'Point') {
          $('#editpointModal').modal('show');
        }

        // Reload saat modal ditutup agar map sinkron kembali
        $('.modal').on('hidden.bs.modal', function() {
          location.reload();
        });
      });
    });

    /* --- 5. Logika Load Data Berdasarkan Halaman --- */

    @if ($page == 'edit-point')
      var point = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
          drawnItems.addLayer(layer);
          var geom = Terraformer.geojsonToWKT(feature.geometry);

          layer.on({
            click: function() {
              $('#name').val(feature.properties.name);
              $('#description').val(feature.properties.description);
              $('#geom').val(geom);
              setEditImagePreview('#image_preview_point', feature.properties.image_path);
              $('#editpointModal').modal('show');
            },
            mouseover: function() { layer.bindTooltip(feature.properties.name).openTooltip(); },
          });
        },
      });
      $.getJSON("{{ route('geojson.point', $id) }}", function(data) {
        point.addData(data);
        map.fitBounds(point.getBounds(), { padding: [100, 100] });
      });
    @endif

    @if ($page == 'edit-polyline')
      var polyline = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
          drawnItems.addLayer(layer);
          var geom = Terraformer.geojsonToWKT(feature.geometry);

          layer.on({
            click: function() {
              $('#name').val(feature.properties.name);
              $('#description').val(feature.properties.description);
              $('#geom').val(geom);
              setEditImagePreview('#image_preview_polyline', feature.properties.image_path);
              $('#editpolylineModal').modal('show');
            },
            mouseover: function() { layer.bindTooltip(feature.properties.name).openTooltip(); },
          });
        },
      });
      $.getJSON("{{ route('geojson.polyline', $id) }}", function(data) {
        polyline.addData(data);
        map.fitBounds(polyline.getBounds(), { padding: [100, 100] });
      });
    @endif

    @if ($page == 'edit-polygon')
      var polygon = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
          drawnItems.addLayer(layer);
          var geom = Terraformer.geojsonToWKT(feature.geometry);

          layer.on({
            click: function() {
              $('#name').val(feature.properties.name);
              $('#description').val(feature.properties.description);
              $('#geom').val(geom);
              setEditImagePreview('#image_preview_polygon', feature.properties.image_path);
              $('#editpolygonModal').modal('show');
            },
            mouseover: function() { layer.bindTooltip(feature.properties.name).openTooltip(); },
          });
        },
      });
      $.getJSON("{{ route('geojson.polygon', $id) }}", function(data) {
        polygon.addData(data);
        map.fitBounds(polygon.getBounds(), { padding: [100, 100] });
      });
    @endif

    /* --- 6. Layer Control --- */
    var baseMaps = {
      "Peta Terang (Clean)": lightMap,
      "Peta Gelap (Dark)": darkMap,
      "Citra Satelit": satelliteMap,
      "Google Maps": googleStreets
    };

    var overlayMaps = {
      "Data Terpilih": drawnItems
    };

    L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);

  </script>
@endsection