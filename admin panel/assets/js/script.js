/* ===========================
   Luxrio Admin Panel - script.js
   =========================== */

// ---- Modal ----
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
function closeModalOnBackdrop(e, id) {
    if (e.target === document.getElementById(id)) closeModal(id);
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-backdrop.open').forEach(function(m) {
            m.classList.remove('open');
            document.body.style.overflow = '';
        });
    }
});

// ---- Toast ----
function showToast(msg, type) {
    var t = document.createElement('div');
    t.className = 'toast ' + (type === 'error' ? 'toast-error' : 'toast-success');
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(function() { t.remove(); }, 3000);
}

// ---- Form submit (no backend - just close modal + toast) ----
function handleFormSubmit(e, modalId, successMsg) {
    e.preventDefault();
    closeModal(modalId);
    showToast(successMsg || 'Saved successfully!');
}

// ---- Qty controls ----
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('qty-btn')) {
        var input = e.target.parentElement.querySelector('.qty-input');
        if (!input) return;
        var val = parseInt(input.value) || 0;
        if (e.target.dataset.action === 'increase') val++;
        else if (e.target.dataset.action === 'decrease' && val > 0) val--;
        input.value = val;
    }
});

// ---- Active nav link ----
document.addEventListener('DOMContentLoaded', function() {
    var page = window.location.pathname.split('/').pop();
    document.querySelectorAll('.nav-link[href]').forEach(function(link) {
        var href = link.getAttribute('href').split('/').pop();
        if (href === page) link.classList.add('active');
    });
});

// ---- Edit helpers ----
function openEditProduct(id, sku, name, cat, price, stock, desc, brand, status) {
    document.getElementById('edit-pid').value = id;
    document.getElementById('edit-sku').value = sku;
    document.getElementById('edit-pname').value = name;
    document.getElementById('edit-cat').value = cat;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-stock').value = stock;
    document.getElementById('edit-desc').value = desc;
    document.getElementById('edit-brand').value = brand;
    document.getElementById('edit-pstatus').value = status;
    openModal('edit-product-modal');
}

function openEditEmployee(id, name, email, phone, role, dept, status) {
    document.getElementById('eemp-id').value = id;
    document.getElementById('eemp-name').value = name;
    document.getElementById('eemp-email').value = email;
    document.getElementById('eemp-phone').value = phone;
    document.getElementById('eemp-role').value = role;
    document.getElementById('eemp-dept').value = dept;
    document.getElementById('eemp-status').value = status;
    openModal('edit-employee-modal');
}

function openEditCategory() {
// id, name, description, status
    // document.getElementById('ecat-id').value = id;
    // document.getElementById('ecat-name').value = name;

    // document.querySelector('[name="c_description"]').value = description;

    // document.getElementById('ecat-status').value = status;

    openModal('edit-category-modal');
}

function openAdjustStock(id, name, qty) {
    document.getElementById('adj-pid').value = id;
    document.getElementById('adj-pname').value = name;
    document.getElementById('adj-current').value = qty + ' units';
    openModal('adjust-stock-modal');
}

function openDeleteModal(id, type) {
    document.getElementById('del-id').value = id;
    document.getElementById('del-type').value = type;
    openModal('delete-confirm-modal');
}
