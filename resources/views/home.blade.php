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

  /* --- 2. Pilihan Basemap (Tanpa Unsorry) --- */
  var lightMap = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 20
  });

  var darkMap = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
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

  // Default basemap
  lightMap.addTo(map);

  /* --- 3. Skala Peta --- */
  L.control.scale({ position: 'bottomleft', metric: true, imperial: false }).addTo(map);

  /* --- 4. Fungsi Digitasi (Leaflet Draw) --- */
  var drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  var drawControl = new L.Control.Draw({
    draw: {
      position: 'topleft',
      circle: false,
      circlemarker: false
    },
    edit: false
  });
  map.addControl(drawControl);

  map.on('draw:created', function(e) {
    var type = e.layerType, layer = e.layer;
    var drawnJSONObject = layer.toGeoJSON();
    var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

    if (type === 'polyline') {
      $('#geom_polyline').val(objectGeometry);
      $('#createpolylineModal').modal('show');
    } else if (type === 'polygon' || type === 'rectangle') {
      $('#geom_polygon').val(objectGeometry);
      $('#createpolygonModal').modal('show');
    } else if (type === 'marker') {
      $('#geom_point').val(objectGeometry);
      $('#createpointModal').modal('show');
    }
    drawnItems.addLayer(layer);
  });

  // Modal hidden event
  $('.modal').on('hidden.bs.modal', function() {
    drawnItems.clearLayers();
  });

  /* --- 5. Data GeoJSON dengan Tombol Edit & Delete --- */

  // GeoJSON Point
  var point = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
      var editUrl = "{{ route('point.edit', ':id') }}".replace(':id', feature.properties.id);
      var deleteUrl = "{{ route('point.destroy', ':id') }}".replace(':id', feature.properties.id);

      var imageHtml = feature.properties.image_path ? "<div class='mt-2'><img src='" + storageUrl + "/" + feature.properties.image_path + "' class='img-fluid rounded' style='max-width:100%;height:auto;'></div>" : "";

      var popupContent = "<table class='table table-sm'>" +
          "<tr><th>Name</th><td>:</td><td>" + feature.properties.name + "</td></tr>" +
          "<tr><th>Description</th><td>:</td><td>" + feature.properties.description + "</td></tr>" +
        "</table>" + imageHtml +
        "<div class='d-flex flex-row'>" +
        "<a href='" + editUrl + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='" + deleteUrl + "' method='Post'>" +
        '{{ csrf_field() }}' + '{{ method_field("DELETE") }}' +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form></div>";

      layer.on({
        click: function(e) { layer.bindPopup(popupContent).openPopup(); },
        mouseover: function(e) { layer.bindTooltip(feature.properties.name); },
      });
    },
  });
  $.getJSON("{{ route('geojson.points') }}", function(data) { point.addData(data); map.addLayer(point); });

  // GeoJSON Polyline
  var polyline = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
      var editUrl = "{{ route('polyline.edit', ':id') }}".replace(':id', feature.properties.id);
      var deleteUrl = "{{ route('polyline.destroy', ':id') }}".replace(':id', feature.properties.id);

      var imageHtml = feature.properties.image_path ? "<div class='mt-2'><img src='" + storageUrl + "/" + feature.properties.image_path + "' class='img-fluid rounded' style='max-width:100%;height:auto;'></div>" : "";

      var length = Number(feature.properties.length) || 0;

      var popupContent = "<table class='table table-sm'>" +
          "<tr><th>Name</th><td>:</td><td>" + feature.properties.name + "</td></tr>" +
          "<tr><th>Length</th><td>:</td><td>" + length.toFixed(2) + " m</td></tr>" +
        "</table>" + imageHtml +
        "<div class='d-flex flex-row'>" +
        "<a href='" + editUrl + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='" + deleteUrl + "' method='Post'>" +
        '{{ csrf_field() }}' + '{{ method_field("DELETE") }}' +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form></div>";

      layer.on({
        click: function(e) { layer.bindPopup(popupContent).openPopup(); },
        mouseover: function(e) { layer.bindTooltip(feature.properties.name); },
      });
    },
  });
  $.getJSON("{{ route('geojson.polylines') }}", function(data) { polyline.addData(data); map.addLayer(polyline); });

  // GeoJSON Polygon
  var polygon = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
      var editUrl = "{{ route('polygon.edit', ':id') }}".replace(':id', feature.properties.id);
      var deleteUrl = "{{ route('polygon.destroy', ':id') }}".replace(':id', feature.properties.id);

      var imageHtml = feature.properties.image_path ? "<div class='mt-2'><img src='" + storageUrl + "/" + feature.properties.image_path + "' class='img-fluid rounded' style='max-width:100%;height:auto;'></div>" : "";

      var popupContent = "<table class='table table-sm'>" +
          "<tr><th>Name</th><td>:</td><td>" + feature.properties.name + "</td></tr>" +
          "<tr><th>Area</th><td>:</td><td>" + feature.properties.area.toFixed(2) + " m<sup>2</sup></td></tr>" +
        "</table>" + imageHtml +
        "<div class='d-flex flex-row'>" +
        "<a href='" + editUrl + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='" + deleteUrl + "' method='Post'>" +
        '{{ csrf_field() }}' + '{{ method_field("DELETE") }}' +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form></div>";

      layer.on({
        click: function(e) { layer.bindPopup(popupContent).openPopup(); },
        mouseover: function(e) { layer.bindTooltip(feature.properties.name); },
      });
    },
  });
  $.getJSON("{{ route('geojson.polygons') }}", function(data) { polygon.addData(data); map.addLayer(polygon); });

  /* --- 6. Kontrol Layer --- */
  var baseMaps = {
    "Peta Terang": lightMap,
    "Peta Gelap": darkMap,
    "Satelit": satelliteMap,
    "Google Maps": googleStreets
  };

  var overlayMaps = {
    "Point": point,
    "Polyline": polyline,
    "Polygon": polygon,
  };

  L.control.layers(baseMaps, overlayMaps, {collapsed: false}).addTo(map);
</script>
@endsection