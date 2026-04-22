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