<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Details — TimeZone Watches</title> 
<link rel="stylesheet" href="../assets/css/style.css"/>

<?php 
session_start();
if($_SESSION['role']!='user'){
  header("location: login.php");
  exit();
}
?>
<?php
$pd_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
include('../config/db.php');
$query = "SELECT p.p_id, p.p_name, p.p_desc, p.p_price, p.p_stock, p.p_status, p.p_image, c.c_name 
          FROM products p 
          JOIN category c ON p.p_cid = c.c_id 
          WHERE p.p_id = $pd_id";
$result = mysqli_query($admin, $query);
$p_data = mysqli_fetch_assoc($result);
?>

<style>
/* ====== PRODUCT DETAIL PAGE (FIXED ACCORDING TO MOTHER CSS) ====== */

.price-cart-box {
  background: var(--dark-2);
  border: 1px solid var(--border);
  border-radius: 2px;
  padding: 28px;
  margin: 24px 0;
  color: var(--white);
  box-shadow: var(--shadow);
  transition: var(--transition);
}

.price-cart-box:hover {
  border-color: var(--border-gold);
}

/* Price Row */
.price-row {
  display: flex;
  align-items: baseline;
  gap: 12px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

.price-main {
  font-size: 2.2rem;
  font-weight: 600;
  color: var(--gold);
  letter-spacing: 0.5px;
  font-family: var(--font-display);
}

.price-label {
  font-size: 10px;
  color: var(--gray);
  text-transform: uppercase;
  letter-spacing: 2px;
}

/* Stock */
.stock-status {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  color: var(--gold);
  margin-bottom: 20px;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.stock-status::before {
  content: '';
  width: 6px;
  height: 6px;
  background: var(--gold);
  border-radius: 50%;
}

/* Quantity */
.qty-section {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid var(--border);
}

.qty-label {
  font-size: 11px;
  color: var(--gray);
  letter-spacing: 2px;
  text-transform: uppercase;
}

.qty-selector {
  display: flex;
  align-items: center;
  background: var(--dark-3);
  border-radius: 2px;
  overflow: hidden;
  border: 1px solid var(--border);
}

.qty-btn {
  width: 40px;
  height: 40px;
  background: var(--dark-2);
  color: var(--white);
  font-size: 16px;
  cursor: pointer;
  transition: var(--transition);
  display: flex;
  align-items: center;
  justify-content: center;
}

.qty-btn:hover {
  color: var(--gold);
}

.qty-num {
  width: 50px;
  text-align: center;
  font-size: 13px;
  font-weight: 600;
  color: var(--white);
  border-left: 1px solid var(--border);
  border-right: 1px solid var(--border);
  padding: 10px 0;
  background: var(--dark);
}

/* Add to Cart (match system) */
.btn-add-cart {
  width: 100%;
  padding: 14px 24px;
  background: var(--gold);
  color: var(--black);
  border-radius: 1px;
  font-size: 11px;
  font-weight: 700;
  cursor: pointer;
  transition: var(--transition);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.btn-add-cart:hover {
  background: var(--gold-light);
  transform: translateY(-1px);
  box-shadow: var(--shadow-gold);
}

/* Secondary */
.secondary-actions {
  display: flex;
  gap: 12px;
  margin-top: 16px;
}

.btn-wishlist-detail {
  flex: 1;
  padding: 12px;
  background: transparent;
  border: 1px solid var(--border);
  color: var(--white);
  border-radius: 1px;
  cursor: pointer;
  font-size: 11px;
  letter-spacing: 1px;
  transition: var(--transition);
}

.btn-wishlist-detail:hover {
  border-color: var(--gold);
  color: var(--gold);
}

/* Trust */
.trust-badges-inline {
  display: flex;
  gap: 16px;
  margin-top: 20px;
  flex-wrap: wrap;
}

.trust-badge {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  color: var(--gray);
  letter-spacing: 1px;
}

.trust-badge::before {
  content: '✓';
  color: var(--gold);
  font-weight: bold;
}

/* Header Cart FIX */
.header-cart {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: var(--gray-light);
  font-weight: 500;
  padding: 8px 14px;
  border-radius: 2px;
  transition: var(--transition);
  border: 1px solid var(--border);
}

.header-cart:hover {
  border-color: var(--border-gold);
  color: var(--gold);
}

.cart-count {
  position: absolute;
  top: -6px;
  right: -6px;
  background: var(--gold);
  color: var(--black);
  width: 18px;
  height: 18px;
  border-radius: 50%;
  font-size: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
  .price-main { font-size: 1.6rem; }
  .price-cart-box { padding: 20px; }
  .qty-section { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>

</head>
<body>

<div class="page-header">
  <div class="page-header-inner">
    <div class="page-badge"></div>
    <h1 class="page-title" id="pageTitle">Product Detail<em></em></h1>
    <div class="breadcrumb">
      <a href="index.html">Home</a><span>/</span>
      <a href="products.html">Collection</a><span>/</span>
      <span id="bcrumb">Watch</span>
    </div>
  </div>
</div>

<div class="detail-wrap">
  <div class="detail-grid" id="detailContent">
    <div class="detail-images reveal-left">
      <div class="main-image">
        <img src="../../admin panel/assets/images/<?php echo $p_data['p_image'] ?>" alt="<?php echo $p_data['p_name'] ?>" id="mainImg">
      </div>
      <div class="thumb-row">
       <img src="../../admin panel/assets/images/<?php echo $p_data['p_image'] ?>" alt="<?php echo $p_data['p_name'] ?>" style="width: 100px;">
      </div>
    </div>
    
    <div class="detail-info reveal">
      <div class="detail-brand"><?php echo $p_data['c_name'] ?></div>
      <h2 class="detail-name"><?php echo $p_data['p_name'] ?></h2>
      
      <div class="detail-rating">
        <span class="stars">⭐⭐⭐⭐⭐</span>
      </div>
      
      <!-- ===== PRICE + QTY + ADD TO CART (Professional Box) ===== -->
      <div class="price-cart-box">
        <div class="price-row">
          <span class="price-main">$<?php echo number_format($p_data['p_price'], 2); ?></span>
          <span class="price-label">USD</span>
        </div>
        
        <div class="stock-status">In Stock</div>
        
        <div class="qty-section">
          <span class="qty-label">Quantity</span>
          <div class="qty-selector">
            <button class="qty-btn" id="minus">−</button>
            <span class="qty-num" id="qty">1</span>
            <button class="qty-btn" id="plus">+</button>
          </div>
        </div>
        
        <button class="btn-add-cart" data-id="<?php echo $pd_id ?>" id="add-to-cart">
          Add to Cart
        </button>
        
        <div class="secondary-actions">
          <button class="btn-wishlist-detail">♡ Add to Wishlist</button>
        </div>
        
        <div class="trust-badges-inline">
          <span class="trust-badge">Free Shipping</span>
          <span class="trust-badge">2-Year Warranty</span>
          <span class="trust-badge">Authentic</span>
        </div>
      </div>
      <!-- ===== END ===== -->
      
      <p class="detail-desc"><?php echo $p_data['p_desc'] ?></p>
      
      <div class="detail-specs">
        <div class="spec-item">
          <div class="spec-label">Movement</div>
          <div class="spec-val">Automatic</div>
        </div>
        <div class="spec-item">
          <div class="spec-label">Case Material</div>
          <div class="spec-val">Stainless Steel</div>
        </div>
        <div class="spec-item">
          <div class="spec-label">Water Resistance</div>
          <div class="spec-val">100m</div>
        </div>
        <div class="spec-item">
          <div class="spec-label">Case Diameter</div>
          <div class="spec-val">40mm</div>
        </div>
        <div class="spec-item">
          <div class="spec-label">Crystal</div>
          <div class="spec-val">Sapphire</div>
        </div>
        <div class="spec-item">
          <div class="spec-label">Power Reserve</div>
          <div class="spec-val">48 Hours</div>
        </div>
      </div>
      
      <div class="detail-badges">
        <span class="d-badge">Certified Authentic</span>
        <span class="d-badge">Free Insured Shipping</span>
        <span class="d-badge">2-Year Warranty</span>
      </div>
    </div>
  </div>

  <div class="related">
    <div class="section-label">You May Also Like</div>
    <h2 class="section-title">Related <em>Timepieces</em></h2>
    <div class="related-grid" id="relatedGrid"></div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../assets/js/layout.js"></script>
<script src="../assets/js/app.js"></script> 

<script>
document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const id = parseInt(params.get('id')) || 1;
  const watch = WATCHES.find(w => w.id === id) || WATCHES[0];

  document.title = `${watch.name} — TimeZone Watches`;
  document.getElementById('pageTitle').innerHTML = `${watch.name} <em>${watch.brand}</em>`;
  document.getElementById('bcrumb').textContent = watch.name;

  const altImages = WATCHES.filter(w => w.id !== id).slice(0, 3).map(w => w.image);
  const thumbsHtml = [watch.image, ...altImages].map((img, i) =>
    `<div class="thumb ${i === 0 ? 'active' : ''}" onclick="changeImg('${img}', this)">
      <img src="${img}" alt="View ${i+1}">
    </div>`).join('');

  const related = WATCHES.filter(w => w.id !== id && w.category === watch.category).slice(0, 4);
  const relGrid = document.getElementById('relatedGrid');
  related.forEach((w, i) => {
    const div = document.createElement('div');
    div.innerHTML = renderWatchCard(w);
    const card = div.firstElementChild;
    card.dataset.delay = i * 100;
    relGrid.appendChild(card);
  });

  initScrollReveal();
});

function changeImg(src, el) {
  document.getElementById('mainImg').src = src;
  document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}

window.changeImg = changeImg;

// ===== jQuery: Add to Cart =====
$(document).ready(function() {
    let qty = 1;

    $("#plus").click(function() {
        qty++;
        $("#qty").text(qty);
    });

    $("#minus").click(function() {
        if (qty > 1) {
            qty--;
            $("#qty").text(qty);
        }
    });

    $("#add-to-cart").click(function() {
        const productId = $(this).data('id');
        const currentQty = parseInt($("#qty").text());

        if (!productId || productId === 0) {
            alert('Invalid product!');
            return;
        }

        $.ajax({
            url: 'handle_cart.php',
            method: 'POST',
            data: { p_id: productId, p_qty: currentQty },
            success: function() {
                alert("Added to cart");
            },
            error: function() {
                alert('Error adding to cart!');
            }
        });
    });
});
</script>
</body>
</html>