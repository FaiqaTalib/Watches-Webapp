// Shared navbar - injected into every page
function injectNavbar() {
  const nav = `
  <nav class="navbar">
    <a href="index.html" class="nav-logo">
      <div class="logo-icon">TZ</div>
      <div class="logo-text">Time<span>Zone</span></div>
    </a>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="products.php">Collection</a></li>
      <li><a href="my_orders.php">Orders</a></li>
      <li><a href="contact.php">Contact Us</a></li>
    </ul>
    <div class="nav-actions">
      <a href="cart.php" class="nav-cart-btn" title="Cart">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <span class="cart-count" style="display:none">0</span>
      </a>
      <a href="login.php" class="nav-user-btn">Login</a>
    </div>
  </nav>`;
  document.body.insertAdjacentHTML('afterbegin', nav);
}

function injectFooter() {
  const footer = `
  <footer class="footer">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">Time<span>Zone</span></div>
        <p>Curating the world's finest timepieces since 1995. Every watch is a story of precision, heritage, and enduring elegance.</p>
      </div>
      <div class="footer-col">
        <h4>Collection</h4>
        <ul>
          <li><a href="products.php?cat=luxury">Luxury Watches</a></li>
          <li><a href="products.php?cat=sport">Sport Watches</a></li>
          <li><a href="products.php?cat=fashion">Fashion Watches</a></li>
          <li><a href="products.php?badge=new">New Arrivals</a></li>
          <li><a href="products.php?badge=sale">Sale</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Account</h4>
        <ul>
          <li><a href="profile.php">My Profile</a></li>
          <li><a href="orders.php">My Orders</a></li>
          <li><a href="cart.php">Shopping Cart</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="about.php">About Us</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Shipping Info</a></li>
          <li><a href="#">Returns</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 <span>TimeZone Watches</span>. All rights reserved.</p>
      <p>Crafted with precision &amp; passion</p>
    </div>
  </footer>`;
  document.body.insertAdjacentHTML('beforeend', footer);
}

document.addEventListener('DOMContentLoaded', () => {
  injectNavbar();
  injectFooter();
});
