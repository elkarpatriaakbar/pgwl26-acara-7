<!-- Modal Info -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="infoModalLabel"><i class="bi bi-info-circle-fill"></i> Info</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col">
            <h5 class="mb-3">Peta Dora</h5>

            <p>Repository: <a href="hhttps://github.com/elkarpatriaakbar/pgwl26" target="_blank"
                rel="noopener noreferrer">https://github.com/elkarpatriaakbar/pgwl26</a> </p>
            <p class="mb-0">Library:</p>
            <ul>
              <li><a href="https://leafletjs.com" target="_blank" rel="noopener noreferrer">Leaflet JS</a></li>
              <li><a href="https://leaflet.github.io/Leaflet.draw/docs/leaflet-draw-latest.html" target="_blank"
                  rel="noopener noreferrer">Leaflet Draw</a></li>
              <li><a href="https://github.com/terraformer-js/terraformer" target="_blank"
                  rel="noopener noreferrer">Terraformer JS</a></li>
              <li><a href="https://jquery.com/download/" target="_blank" rel="noopener noreferrer">jQuery</a></li>
              <li><a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer">Bootstrap 5</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <small><a href="elkar21.com" target="_blank"
            class="text-decoration-none text-secondary">Elkar Patria Akbar</a></small>
        <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@if ($page === 'map')
  <!-- Modal Create Point -->
  <div class="modal fade" id="createpointModal" tabindex="-1" aria-labelledby="createpointModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createpointModalLabel"><i class="bi bi-geo-alt-fill"></i> Create Point</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('point.store') }}" method="Post">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Fill in the name"
                required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="description" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="geom_point" class="form-label">Geometry WKT</label>
              <textarea class="form-control" id="geom_point" name="geom_point" rows="3" readonly></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
              class="bi bi-x-circle-fill"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Create Polyline -->
  <div class="modal fade" id="createpolylineModal" tabindex="-1" aria-labelledby="createpolylineModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createpolylineModalLabel"><i class="bi bi-slash-lg"></i> Create Polyline
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('polyline.store') }}" method="Post">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name"
                placeholder="Fill in the name" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="description" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="geom_polyline" class="form-label">Geometry WKT</label>
              <textarea class="form-control" id="geom_polyline" name="geom_polyline" rows="3" readonly></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
              class="bi bi-x-circle-fill"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Create Polygon -->
  <div class="modal fade" id="createpolygonModal" tabindex="-1" aria-labelledby="createpolygonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createpolygonModalLabel"><i class="bi bi-pentagon-fill"></i> Create
            Polygon</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('polygon.store') }}" method="Post">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name"
                placeholder="Fill in the name" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="description" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="geom_polygon" class="form-label">Geometry WKT</label>
              <textarea class="form-control" id="geom_polygon" name="geom_polygon" rows="3" readonly></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
              class="bi bi-x-circle-fill"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif

@if ($page === 'edit-point')
  <!-- Modal Edit Point -->
  <div class="modal fade" id="editpointModal" tabindex="-1" aria-labelledby="editpointModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editpointModalLabel"><i class="bi bi-geo-alt-fill"></i> Edit Point</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('point.update', $id) }}" method="Post" id="form-update-point">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name"
                placeholder="Fill in the name" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="description" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="geom" class="form-label">Geometry WKT</label>
              <textarea class="form-control" id="geom" name="geom" rows="3" readonly></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
              class="bi bi-x-circle-fill"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif

@if ($page === 'edit-polyline')
  <!-- Modal Edit Polyline -->
  <div class="modal fade" id="editpolylineModal" tabindex="-1" aria-labelledby="editpolylineModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editpolylineModalLabel"><i class="bi bi-geo-alt-fill"></i> Edit Polyline
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('polyline.update', $id) }}" method="Post" id="form-update-polyline">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name"
                placeholder="Fill in the name" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="description" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="geom" class="form-label">Geometry WKT</label>
              <textarea class="form-control" id="geom" name="geom" rows="3" readonly></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
              class="bi bi-x-circle-fill"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif

@if ($page === 'edit-polygon')
  <!-- Modal Edit Polygon -->
  <div class="modal fade" id="editpolygonModal" tabindex="-1" aria-labelledby="editpolygonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editpolygonModalLabel"><i class="bi bi-geo-alt-fill"></i> Edit Polygon
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('polygon.update', $id) }}" method="Post" id="form-update-polygon">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name"
                placeholder="Fill in the name" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="description" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="geom" class="form-label">Geometry WKT</label>
              <textarea class="form-control" id="geom" name="geom" rows="3" readonly></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
              class="bi bi-x-circle-fill"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif
