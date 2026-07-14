// ===== TIMEZONE WATCHES — SHARED JS =====

// Cart State
const Cart = {
  items: JSON.parse(localStorage.getItem('tz_cart') || '[]'),

  save() {
    localStorage.setItem('tz_cart', JSON.stringify(this.items));
    this.updateBadge();
  },

  add(id, name, price, image, brand) {
    const existing = this.items.find(i => i.id === id);
    if (existing) {
      existing.qty += 1;
    } else {
      this.items.push({ id, name, price, image, brand, qty: 1 });
    }
    this.save();
    showToast(`${name} added to cart`);
  },

  remove(id) {
    this.items = this.items.filter(i => i.id !== id);
    this.save();
  },

  updateQty(id, qty) {
    const item = this.items.find(i => i.id === id);
    if (item) {
      if (qty <= 0) this.remove(id);
      else item.qty = qty;
      this.save();
    }
  },

  total() {
    return this.items.reduce((sum, i) => sum + (i.price * i.qty), 0);
  },

  count() {
    return this.items.reduce((sum, i) => sum + i.qty, 0);
  },

  clear() {
    this.items = [];
    this.save();
  },

  updateBadge() {
    const badge = document.querySelector('.cart-count');
    if (badge) {
      const count = this.count();
      badge.textContent = count;
      badge.style.display = count > 0 ? 'flex' : 'none';
    }
  }
};

// Toast Notification
function showToast(message, icon = '✓') {
  let toast = document.querySelector('.toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<div class="toast-icon"></div><span class="toast-msg"></span>`;
    document.body.appendChild(toast);
  }
  toast.querySelector('.toast-icon').textContent = icon;
  toast.querySelector('.toast-msg').textContent = message;
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 3000);
}

// Navbar Scroll Effect
function initNavbar() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 50);
  });
  // Set active link
  const path = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a').forEach(a => {
    const href = a.getAttribute('href');
    if (href === path) a.classList.add('active');
  });
}

// Scroll Reveal Animations
function initScrollReveal() {
  const els = document.querySelectorAll('.reveal, .reveal-left');
  if (!els.length) return;
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        const delay = entry.target.dataset.delay || 0;
        setTimeout(() => entry.target.classList.add('visible'), parseInt(delay));
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });
  els.forEach(el => observer.observe(el));
}

// Nav Search (redirect to products page)
function initNavSearch() {
  const input = document.querySelector('.nav-search input');
  if (!input) return;
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && input.value.trim()) {
      window.location.href = `products.html?search=${encodeURIComponent(input.value.trim())}`;
    }
  });
}

// Format currency
function formatPrice(num) {
  return '$' + num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// User state (simple local storage)
const User = {
  get() {
    return JSON.parse(localStorage.getItem('tz_user') || 'null');
  },
  set(data) {
    localStorage.setItem('tz_user', JSON.stringify(data));
  },
  logout() {
    localStorage.removeItem('tz_user');
    window.location.href = 'index.html';
  },
  isLoggedIn() {
    return !!this.get();
  }
};

// Update nav user button based on auth
function updateNavUser() {
  const btn = document.querySelector('.nav-user-btn');
  if (!btn) return;
  if (User.isLoggedIn()) {
    const u = User.get();
    btn.textContent = u.name ? u.name.split(' ')[0] : 'Profile';
    btn.href = 'profile.php';
  } else {
    btn.textContent = 'Login';
    btn.href = 'login.html';
  }
}

// Watch data (shared demo data)
// const WATCHES = [
//   { id: 1, name: 'Seamaster Professional', brand: 'Omega', price: 5890, oldPrice: null, image: 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop', badge: 'new', category: 'luxury', rating: 5, desc: 'A professional diver\'s watch with a helium escape valve and 300m water resistance. Features a co-axial master chronometer movement.' },
//   { id: 2, name: 'Submariner Date', brand: 'Rolex', price: 10500, oldPrice: null, image: 'https://images.unsplash.com/photo-1547996160-81dfa63595aa?w=400&h=400&fit=crop', badge: 'limited', category: 'luxury', rating: 5, desc: 'Iconic Rolex diver watch with a unidirectional rotatable bezel and waterproof Oyster case.' },
//   { id: 3, name: 'Speedmaster Moonwatch', brand: 'Omega', price: 6300, oldPrice: null, image: 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop', badge: null, category: 'sport', rating: 5, desc: 'The legendary watch worn on the Moon. Manual-winding chronograph with hesalite crystal.' },
//   { id: 4, name: 'Calatrava Ref. 5196', brand: 'Patek Philippe', price: 22000, oldPrice: null, image: 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=400&h=400&fit=crop', badge: null, category: 'luxury', rating: 5, desc: 'The quintessential dress watch. Sleek round case in white gold with a clean white dial.' },
//   { id: 5, name: 'Royal Oak 15500ST', brand: 'Audemars Piguet', price: 28500, oldPrice: null, image: 'https://images.unsplash.com/photo-1508057198894-247b23fe5ade?w=400&h=400&fit=crop', badge: null, category: 'luxury', rating: 5, desc: 'The original luxury sports watch with iconic octagonal bezel and tapisserie dial.' },
//   { id: 6, name: 'Navitimer B01', brand: 'Breitling', price: 7900, oldPrice: 8500, image: 'https://images.unsplash.com/photo-1614164185128-e4ec99c436d7?w=400&h=400&fit=crop', badge: 'sale', category: 'sport', rating: 4, desc: 'Aviator chronograph with circular slide rule for navigation calculations. COSC-certified movement.' },
//   { id: 7, name: 'Big Pilot 43', brand: 'IWC', price: 8200, oldPrice: null, image: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=400&h=400&fit=crop', badge: null, category: 'sport', rating: 4, desc: 'Pilot watch with a large, legible dial, oversized crown and soft iron inner case for antimagnetic protection.' },
//   { id: 8, name: 'Tank Must', brand: 'Cartier', price: 3200, oldPrice: 3600, image: 'https://images.unsplash.com/photo-1493051433-8e08a6b1d2b3?w=400&h=400&fit=crop', badge: 'sale', category: 'fashion', rating: 4, desc: 'A timeless icon. Rectangular case with sapphire cabochon crown and silver Roman numeral dial.' },
//   { id: 9, name: 'Portugieser Chrono', brand: 'IWC', price: 9600, oldPrice: null, image: 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=400&h=400&fit=crop', badge: null, category: 'luxury', rating: 5, desc: 'Elegant large-diameter chronograph with a clean dial architecture and flyback function.' },
//   { id: 10, name: 'Reverso Classic', brand: 'Jaeger-LeCoultre', price: 6800, oldPrice: null, image: 'https://images.unsplash.com/photo-1434056886845-dac89ffe9b56?w=400&h=400&fit=crop', badge: 'new', category: 'fashion', rating: 4, desc: 'Art Deco icon with a reversible case, originally designed for polo players to protect the dial.' },
//   { id: 11, name: 'Aquanaut 5168G', brand: 'Patek Philippe', price: 31000, oldPrice: null, image: 'https://images.unsplash.com/photo-1599707367072-cd6ada2bc375?w=400&h=400&fit=crop', badge: 'limited', category: 'sport', rating: 5, desc: 'Sporty yet sophisticated with a rounded octagonal bezel and embossed black composite dial.' },
//   { id: 12, name: 'Datejust 41', brand: 'Rolex', price: 8900, oldPrice: null, image: 'https://images.unsplash.com/photo-1619134778706-7015533a6150?w=400&h=400&fit=crop', badge: null, category: 'luxury', rating: 5, desc: 'The quintessential Rolex dress watch with the iconic date window magnified by a Cyclops lens.' },
// ];

// Render a watch card
// function renderWatchCard(watch) {
//   const badgeHtml = watch.badge
//     ? `<span class="watch-card-badge badge-${watch.badge}">${watch.badge}</span>` : '';
//   const stars = '★'.repeat(watch.rating) + '☆'.repeat(5 - watch.rating);
//   const oldPrice = watch.oldPrice ? `<span class="watch-price-old">${formatPrice(watch.oldPrice)}</span>` : '';
//   return `
//     <div class="watch-card reveal" data-id="${watch.id}">
//       <div class="watch-card-image">
//         <img src="${watch.image}" alt="${watch.name}" loading="lazy">
//         ${badgeHtml}
//         <div class="watch-card-actions">
//           <button class="btn-add-cart" onclick="Cart.add(${watch.id}, '${watch.name}', ${watch.price}, '${watch.image}', '${watch.brand}'); event.stopPropagation();">Add to Cart</button>
//           <button class="btn-view-detail" onclick="window.location.href='product-details.html?id=${watch.id}'">View</button>
//         </div>
//       </div>
//       <div class="watch-card-info">
//         <div class="watch-brand">${watch.brand}</div>
//         <div class="watch-name">${watch.name}</div>
//         <div class="watch-price-row">
//           <div>
//             <span class="watch-price">${formatPrice(watch.price)}</span>
//             ${oldPrice}
//           </div>
//           <div class="watch-rating">${stars}</div>
//         </div>
//       </div>
//     </div>`;
// }

// Init on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initScrollReveal();
  initNavSearch();
  Cart.updateBadge();
  updateNavUser();
});
