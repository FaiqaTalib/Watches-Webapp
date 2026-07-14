<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Collection — TimeZone Watches</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>


<?php 
//  include('update.php');
include('../config/db.php');

$query="SELECT p.p_id , p.p_name , p.p_desc, p.p_price, p.p_stock, p.p_status ,p.p_image , c.c_name from products p join category c on p.p_cid = c.c_id";
$result=mysqli_query($admin,$query);
 ?>




<body>

  <div class="page-header">
    <div class="page-header-inner">
      <div class="page-badge">Explore</div>
      <h1 class="page-title">Our <em>Collection</em></h1>
      <div class="breadcrumb">
        <a href="index.html">Home</a>
        <span>/</span>
        <span>Collection</span>
      </div>
    </div>
  </div>

  <div class="products-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="filter-section">
        <div class="filter-title">Category</div>
        <label class="filter-option"><input type="checkbox" value="luxury" onchange="applyFilters()"> Luxury</label>
        <label class="filter-option"><input type="checkbox" value="sport" onchange="applyFilters()"> Sport</label>
        <label class="filter-option"><input type="checkbox" value="fashion" onchange="applyFilters()"> Fashion</label>
      </div>

      <div class="filter-section">
        <div class="filter-title">Max Price</div>
        <div class="price-range-wrap">
          <input type="range" class="price-range" id="priceRange" min="1000" max="35000" step="500" value="35000"
            oninput="updatePrice(this)">
          <div class="price-labels">
            <span>$1,000</span>
            <span id="priceVal">$35,000</span>
          </div>
        </div>
      </div>
      <div class="filter-title">Brand</div>
      <div id="brandFilters"></div>
      <div class="filter-reset" onclick="resetFilters()">✕ Reset All Filters</div>
    </aside>

    <!-- MAIN -->
    <div class="products-main">
      <div class="search-bar-full">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"
          stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8" />
          <path d="m21 21-4.35-4.35" />
        </svg>
        <input type="text" id="searchInput" placeholder="Search by name, brand, or keyword..." oninput="applyFilters()">
      </div>

      <div class="active-filters" id="activeTags"></div>

      <div class="products-toolbar">
        <div class="products-count">Showing <span id="countNum"></span> timepieces</div>
        <div class="toolbar-right">
          <select class="sort-select" id="sortSelect" onchange="applyFilters()">
            <option value="default">Featured</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="rating">Top Rated</option>
            <option value="name">Name A–Z</option>
          </select>
        </div>
      </div>
<div class="watch-container">

  <div class="grid-3">
<?php foreach($result as $data){ ?>
    <!-- Card 1 -->
    <div class="watch-card reveal" data-id="<?php echo $data['p_id'] ?>">
      <div class="watch-card-image">
        <img src="../../admin panel/assets/images/<?php echo $data['p_image'] ?>" alt="Rolex Submariner" loading="lazy">

        <span class="watch-card-badge badge-new">New</span>

        <div class="watch-card-actions">
          
          <!-- <button class="btn-add-cart" onclick="window.location.href='cart.php?id=<?php echo $data['p_id'] ?>'">Add to Cart</button> -->
          <button class="btn-view-detail" onclick="window.location.href='product-details.php?id=<?php echo $data['p_id'] ?>'">View</button>
        </div>
      </div>

      <div class="watch-card-info">
        <div class="watch-brand"><?php echo $data['p_id'] ?></div>
        <div class="watch-name"><?php echo $data['p_name'] ?></div>

        <div class="watch-price-row">
          <div>
            <span class="watch-price"><?php echo '$'.$data['p_price'] ?></span>
            <!-- <span class="watch-price-old">Rs 30,000</span> -->
          </div>

          <div class="watch-rating">★★★★☆</div>
        </div>
      </div>
    </div>

   <?php } ?>

  </div>

</div>
  </div>
  </div>


  <script src="../assets/js/layout.js"></script>
  <script src="../assets/js/app.js"></script>
  <script>
    let maxPrice = 35000;

    // Build brand filters
    function buildBrandFilters() {
      const brands = [...new Set(WATCHES.map(w => w.brand))];
      const container = document.getElementById('brandFilters');
      brands.forEach(b => {
        container.innerHTML += `<label class="filter-option"><input type="checkbox" value="${b}" class="brand-cb" onchange="applyFilters()"> ${b}</label>`;
      });
    }

    function updatePrice(input) {
      maxPrice = parseInt(input.value);
      document.getElementById('priceVal').textContent = '$' + maxPrice.toLocaleString();
      applyFilters();
    }

    function applyFilters() {
      const search = document.getElementById('searchInput').value.toLowerCase();
      const catCbs = [...document.querySelectorAll('.filter-section input[type=checkbox][value=luxury], .filter-section input[type=checkbox][value=sport], .filter-section input[type=checkbox][value=fashion]')];
      const statusCbs = [...document.querySelectorAll('input[value=new], input[value=sale], input[value=limited]')];
      const brandCbs = [...document.querySelectorAll('.brand-cb')];
      const sort = document.getElementById('sortSelect').value;

      const selectedCats = catCbs.filter(c => c.checked).map(c => c.value);
      const selectedStatus = statusCbs.filter(c => c.checked).map(c => c.value);
      const selectedBrands = brandCbs.filter(c => c.checked).map(c => c.value);

      let filtered = WATCHES.filter(w => {
        const matchSearch = !search || w.name.toLowerCase().includes(search) || w.brand.toLowerCase().includes(search);
        const matchCat = !selectedCats.length || selectedCats.includes(w.category);
        const matchStatus = !selectedStatus.length || (w.badge && selectedStatus.includes(w.badge));
        const matchBrand = !selectedBrands.length || selectedBrands.includes(w.brand);
        const matchPrice = w.price <= maxPrice;
        return matchSearch && matchCat && matchStatus && matchBrand && matchPrice;
      });

      // Sort
      if (sort === 'price-asc') filtered.sort((a, b) => a.price - b.price);
      else if (sort === 'price-desc') filtered.sort((a, b) => b.price - a.price);
      else if (sort === 'rating') filtered.sort((a, b) => b.rating - a.rating);
      else if (sort === 'name') filtered.sort((a, b) => a.name.localeCompare(b.name));

      renderProducts(filtered);
      updateActiveTags(selectedCats, selectedStatus, selectedBrands);
    }

    function renderProducts(list) {
      const grid = document.getElementById('productsGrid');
      document.getElementById('countNum').textContent = list.length;
      if (!list.length) {
        grid.innerHTML = `<div class="no-results"><h3>No watches found</h3><p>Try adjusting your filters or search term.</p></div>`;
        return;
      }
      grid.innerHTML = '';
      list.forEach((w, i) => {
        const tmp = document.createElement('div');
        tmp.innerHTML = renderWatchCard(w);
        const card = tmp.firstElementChild;
        card.dataset.delay = i * 60;
        grid.appendChild(card);
      });
      initScrollReveal();
    }

    function updateActiveTags(cats, status, brands) {
      const container = document.getElementById('activeTags');
      const all = [...cats, ...status, ...brands];
      container.innerHTML = all.map(t => `<div class="filter-tag">${t} ✕</div>`).join('');
    }

    function resetFilters() {
      document.querySelectorAll('.sidebar input[type=checkbox]').forEach(c => c.checked = false);
      document.getElementById('priceRange').value = 35000;
      maxPrice = 35000;
      document.getElementById('priceVal').textContent = '$35,000';
      document.getElementById('searchInput').value = '';
      document.getElementById('sortSelect').value = 'default';
      applyFilters();
    }

    // Handle URL params
    function handleUrlParams() {
      const params = new URLSearchParams(window.location.search);
      const cat = params.get('cat');
      const badge = params.get('badge');
      const search = params.get('search');
      if (cat) {
        const cb = document.querySelector(`input[value="${cat}"]`);
        if (cb) cb.checked = true;
      }
      if (badge) {
        const cb = document.querySelector(`input[value="${badge}"]`);
        if (cb) cb.checked = true;
      }
      if (search) {
        document.getElementById('searchInput').value = search;
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      buildBrandFilters();
      handleUrlParams();
      applyFilters();
    });
  </script>
</body>

</html>