<nav class="navbar navbar-expand-lg fixed-top navbar-modern">
  <div class="container">
    <a class="navbar-brand" href="#">
      <span class="logo-icon"><i class="bi bi-geo-fill"></i></span> 
      Geo<span class="fw-light">Space</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <i class="bi bi-list"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Explorer API
          </a>
          <ul class="dropdown-menu shadow-sm">
            <li><a class="dropdown-item" href="{{ url('api/geojson-points') }}">Points</a></li>
            <li><a class="dropdown-item" href="{{ url('api/geojson-polylines') }}">Polylines</a></li>
            <li><a class="dropdown-item" href="{{ url('api/geojson-polygons') }}">Polygons</a></li>
          </ul>
        </li>
        <li class="nav-item ms-lg-3">
          <a class="nav-link btn-info-modern" href="#" data-bs-toggle="modal" data-bs-target="#infoModal">
            About Project
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');

  :root {
    --bg-cream: #fdfaf5;
    --accent-coffee: #4e342e;
    --soft-tan: #e7d8c9;
    --text-main: #2c2420;
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .navbar-modern {
    background: rgba(253, 250, 245, 0.85) !important;
    backdrop-filter: blur(15px); /* Efek kaca modern */
    padding: 3px 0;
    border-bottom: 1px solid rgba(78, 52, 46, 0.1);
  }

  .navbar-brand {
    font-weight: 800;
    color: var(--accent-coffee) !important;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .logo-icon {
    background: var(--accent-coffee);
    color: white;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1.1rem;
  }

  .nav-link {
    color: var(--text-main) !important;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.5rem 1rem !important;
  }

  .nav-link:hover {
    color: var(--accent-coffee) !important;
    opacity: 0.7;
  }

  /* Dropdown Modern */
  .dropdown-menu {
    border: 1px solid var(--soft-tan);
    background-color: var(--bg-cream);
    border-radius: 12px;
    padding: 8px;
    margin-top: 15px !important;
  }

  .dropdown-item {
    border-radius: 8px;
    padding: 10px 15px;
    color: var(--text-main);
    font-weight: 500;
  }

  .dropdown-item:hover {
    background-color: var(--soft-tan);
    color: var(--accent-coffee);
  }

  /* Button Modern */
  .btn-info-modern {
    background-color: var(--accent-coffee);
    color: white !important;
    border-radius: 50px; /* Pill style */
    padding: 8px 25px !important;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(78, 52, 46, 0.2);
  }

  .btn-info-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(78, 52, 46, 0.3);
  }

  .navbar-toggler {
    border: none;
    color: var(--accent-coffee);
    font-size: 1.5rem;
  }
</style>