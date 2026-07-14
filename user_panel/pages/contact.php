

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>
<style>
/* HERO */
.contact-hero {
  position: relative; height: 420px;
  display: flex; align-items: center; overflow: hidden;
}
.contact-hero-bg {
  position: absolute; inset: 0;
  background: url('https://images.unsplash.com/photo-1614164185128-e4ec99c436d7?w=1600&h=600&fit=crop') center/cover;
  filter: brightness(0.3);
}
.contact-hero-content {
  position: relative; z-index: 2; padding: 0 60px; max-width: 640px;
}
.contact-hero-content h1 {
  font-family: var(--font-display);
  font-size: clamp(44px, 5vw, 70px);
  font-weight: 300; color: var(--white);
  line-height: 1.05; letter-spacing: 2px; margin-bottom: 18px;
}
.contact-hero-content h1 em { color: var(--gold); font-style: italic; }
.contact-hero-content p {
  font-size: 14px; color: var(--gray-light); line-height: 1.9;
}

/* INFO CARDS ROW */
.info-cards {
  max-width: 1200px; margin: 0 auto;
  padding: 70px 60px 0;
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 2px;
}
.info-card {
  background: var(--dark-2); border: 1px solid var(--border);
  padding: 34px 28px; transition: var(--transition);
  text-align: center;
}
.info-card:hover {
  border-color: var(--border-gold);
  transform: translateY(-4px);
}
.info-card-icon {
  width: 54px; height: 54px; border-radius: 50%;
  border: 1.5px solid var(--border-gold);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; color: var(--gold);
  margin: 0 auto 18px;
}
.info-card-label {
  font-size: 9px; font-weight: 700; letter-spacing: 3px;
  text-transform: uppercase; color: var(--gold); margin-bottom: 10px;
}
.info-card-val {
  font-family: var(--font-display); font-size: 16px;
  color: var(--white); line-height: 1.6;
}
.info-card-sub {
  font-size: 11px; color: var(--gray); margin-top: 6px; line-height: 1.7;
}

/* MAIN LAYOUT */
.contact-main {
  max-width: 1200px; margin: 0 auto;
  padding: 70px 60px 90px;
  display: grid; grid-template-columns: 1fr 420px; gap: 50px;
}

/* FORM SIDE */
.contact-form-wrap {}
.cf-title {
  font-family: var(--font-display); font-size: 38px; font-weight: 300;
  color: var(--white); line-height: 1.1; margin-bottom: 8px;
}
.cf-title em { color: var(--gold); font-style: italic; }
.cf-sub {
  font-size: 13px; color: var(--gray); margin-bottom: 36px; line-height: 1.8;
}

.form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }

.subject-chips {
  display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 6px;
}
.chip {
  padding: 7px 16px; border-radius: 1px;
  border: 1px solid var(--border); background: var(--dark-2);
  font-size: 11px; font-weight: 500; letter-spacing: 1px;
  color: var(--gray-light); cursor: pointer; transition: var(--transition);
}
.chip:hover { border-color: var(--border-gold); color: var(--gold); }
.chip.active { background: rgba(201,168,76,0.1); border-color: var(--gold); color: var(--gold); }

.form-textarea {
  width: 100%; padding: 14px 16px;
  background: var(--dark-2); color: var(--white);
  border: 1px solid var(--border); border-radius: 2px;
  font-size: 13px; letter-spacing: 0.5px; line-height: 1.7;
  resize: vertical; min-height: 140px;
  transition: var(--transition); font-family: var(--font-body);
}
.form-textarea:focus { border-color: var(--border-gold); background: var(--dark-3); outline: none; }
.form-textarea::placeholder { color: var(--gray); }

.char-count {
  font-size: 11px; color: var(--gray); text-align: right; margin-top: 6px;
}

.form-bottom {
  display: flex; align-items: center; gap: 20px; margin-top: 8px; flex-wrap: wrap;
}
.privacy-note {
  font-size: 11px; color: var(--gray); line-height: 1.6; flex: 1;
}
.privacy-note a { color: var(--gold); }

/* SUCCESS STATE */
.form-success {
  display: none; text-align: center; padding: 50px 20px;
}
.form-success.show { display: block; }
.success-circle {
  width: 70px; height: 70px; border-radius: 50%;
  border: 2px solid var(--gold); color: var(--gold);
  font-size: 28px; display: flex; align-items: center; justify-content: center;
  margin: 0 auto 22px;
}
.success-title {
  font-family: var(--font-display); font-size: 32px; font-weight: 300;
  color: var(--white); margin-bottom: 12px;
}
.success-msg { font-size: 13px; color: var(--gray); line-height: 1.9; margin-bottom: 28px; }

/* RIGHT SIDE */
.contact-right {}

/* MAP PLACEHOLDER */
.map-box {
  background: var(--dark-2); border: 1px solid var(--border);
  border-radius: 2px; overflow: hidden; margin-bottom: 24px;
  position: relative; height: 240px;
}
.map-placeholder {
  width: 100%; height: 100%; object-fit: cover;
  filter: brightness(0.6) saturate(0);
}
.map-pin {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  background: var(--gold); color: var(--black);
  font-size: 10px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; padding: 10px 18px; border-radius: 1px;
  white-space: nowrap;
}

/* HOURS TABLE */
.hours-card {
  background: var(--dark-2); border: 1px solid var(--border);
  border-radius: 2px; padding: 26px 28px; margin-bottom: 24px;
}
.hc-title {
  font-size: 10px; font-weight: 700; letter-spacing: 3px;
  text-transform: uppercase; color: var(--gold); margin-bottom: 18px;
}
.hours-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 10px 0; border-bottom: 1px solid var(--border);
  font-size: 13px;
}
.hours-row:last-child { border-bottom: none; }
.hours-day { color: var(--gray-light); }
.hours-time { color: var(--white); font-weight: 500; }
.hours-row.today .hours-day { color: var(--gold); font-weight: 600; }
.hours-row.today .hours-time { color: var(--gold); }
.today-badge {
  font-size: 8px; font-weight: 700; letter-spacing: 1.5px;
  text-transform: uppercase; background: rgba(201,168,76,0.15);
  border: 1px solid var(--border-gold); color: var(--gold);
  padding: 2px 7px; border-radius: 1px; margin-left: 8px;
}

/* SOCIAL */
.social-card {
  background: var(--dark-2); border: 1px solid var(--border);
  border-radius: 2px; padding: 26px 28px;
}
.sc-title {
  font-size: 10px; font-weight: 700; letter-spacing: 3px;
  text-transform: uppercase; color: var(--gold); margin-bottom: 18px;
}
.social-links { display: flex; gap: 10px; }
.social-link {
  flex: 1; padding: 12px 8px; text-align: center;
  background: var(--dark); border: 1px solid var(--border);
  border-radius: 1px; font-size: 11px; font-weight: 600;
  letter-spacing: 1px; color: var(--gray-light);
  transition: var(--transition); cursor: pointer;
}
.social-link:hover { border-color: var(--border-gold); color: var(--gold); }

/* FAQ STRIP */
.faq-section {
  background: var(--dark-2); border-top: 1px solid var(--border);
}
.faq-inner {
  max-width: 1200px; margin: 0 auto; padding: 70px 60px;
}
.faq-grid {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 2px;
  margin-top: 48px;
}
.faq-item {
  background: var(--dark); border: 1px solid var(--border);
  padding: 28px 30px; cursor: pointer; transition: var(--transition);
}
.faq-item:hover { border-color: var(--border-gold); }
.faq-item.open { border-color: var(--border-gold); }
.faq-q {
  display: flex; align-items: center; justify-content: space-between; gap: 16px;
  font-family: var(--font-display); font-size: 18px; font-weight: 400;
  color: var(--white); line-height: 1.3;
}
.faq-icon {
  color: var(--gold); font-size: 20px; flex-shrink: 0;
  transition: transform 0.3s ease;
}
.faq-item.open .faq-icon { transform: rotate(45deg); }
.faq-a {
  font-size: 13px; color: var(--gray); line-height: 1.9;
  max-height: 0; overflow: hidden;
  transition: max-height 0.4s ease, padding 0.3s ease;
}
.faq-item.open .faq-a { max-height: 200px; padding-top: 16px; }

@media (max-width: 1024px) {
  .info-cards { grid-template-columns: repeat(2, 1fr); padding: 50px 30px 0; }
  .contact-main { grid-template-columns: 1fr; padding: 50px 30px 60px; }
  .faq-inner { padding: 50px 30px; }
  .contact-hero-content { padding: 0 30px; }
}
@media (max-width: 600px) {
  .info-cards { grid-template-columns: 1fr; padding: 30px 20px 0; }
  .contact-main { padding: 30px 20px 50px; }
  .faq-inner { padding: 30px 20px; }
  .faq-grid { grid-template-columns: 1fr; }
  .form-row-2 { grid-template-columns: 1fr; }
  .contact-hero-content { padding: 0 20px; }
  .form-bottom { flex-direction: column; align-items: flex-start; }
}
</style>
</head>
<body>

<!-- HERO -->
<section class="contact-hero">
  <div class="contact-hero-bg"></div>
  <div class="contact-hero-content">
    <div class="section-label" style="margin-bottom:14px;">We'd Love to Hear From You</div>
    <h1>Get In <em>Touch</em></h1>
    <p>Whether you're searching for a specific timepiece, need expert advice, or require servicing — our team of horologists is here to help.</p>
  </div>
</section>

<!-- INFO CARDS -->
<div class="info-cards">
  <div class="info-card reveal">
    <div class="info-card-icon">◎</div>
    <div class="info-card-label">Visit Us</div>
    <div class="info-card-val">387 Fifth Avenue<br>New York, NY 10016</div>
    <div class="info-card-sub">Suite 12, Midtown Manhattan</div>
  </div>
  <div class="info-card reveal" data-delay="100">
    <div class="info-card-icon">◇</div>
    <div class="info-card-label">Call Us</div>
    <div class="info-card-val">+1 (800) 603-6035</div>
    <div class="info-card-sub">Mon–Sat, 10am – 7pm EST</div>
  </div>
  <div class="info-card reveal" data-delay="200">
    <div class="info-card-icon">◈</div>
    <div class="info-card-label">Email Us</div>
    <div class="info-card-val">hello@timezone<br>watches.com</div>
    <div class="info-card-sub">We reply within 24 hours</div>
  </div>
  <div class="info-card reveal" data-delay="300">
    <div class="info-card-icon">◉</div>
    <div class="info-card-label">WhatsApp</div>
    <div class="info-card-val">+1 (646) 555-0199</div>
    <div class="info-card-sub">Quick replies, 7 days a week</div>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="contact-main">

  <!-- FORM -->
  <div class="contact-form-wrap">
    <div class="section-label" style="margin-bottom:10px;">Send a Message</div>
    <h2 class="cf-title">How Can We <em>Help?</em></h2>
    <p class="cf-sub">Fill in the form below and one of our watch specialists will get back to you within 24 hours.</p>

    <div id="contactForm">
      <div class="form-row-2">
        <div class="form-group">
          <label class="form-label">First Name</label>
          <input type="text" class="form-input" id="cfFname" placeholder="John">
        </div>
        <div class="form-group">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-input" id="cfLname" placeholder="Doe">
        </div>
      </div>
      <div class="form-row-2">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" class="form-input" id="cfEmail" placeholder="your@email.com">
        </div>
        <div class="form-group">
          <label class="form-label">Phone (Optional)</label>
          <input type="tel" class="form-input" placeholder="+1 (555) 000-0000">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Subject</label>
        <div class="subject-chips" id="subjectChips">
          <div class="chip active" onclick="selectChip(this)">General Inquiry</div>
          <div class="chip" onclick="selectChip(this)">Watch Purchase</div>
          <div class="chip" onclick="selectChip(this)">Watch Servicing</div>
          <div class="chip" onclick="selectChip(this)">Authentication</div>
          <div class="chip" onclick="selectChip(this)">Sell My Watch</div>
          <div class="chip" onclick="selectChip(this)">Other</div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Message</label>
        <textarea class="form-textarea" id="cfMsg" placeholder="Tell us how we can help you..." oninput="updateCount(this)" maxlength="800"></textarea>
        <div class="char-count"><span id="charNum">0</span> / 800</div>
      </div>

      <div class="form-bottom">
        <div class="privacy-note">
          By submitting this form you agree to our <a href="#">Privacy Policy</a>. Your information is kept confidential and never shared with third parties.
        </div>
        <button class="btn-primary" onclick="submitForm()" style="white-space:nowrap;">Send Message →</button>
      </div>
    </div>

    <!-- SUCCESS STATE -->
    <div class="form-success" id="formSuccess">
      <div class="success-circle">✓</div>
      <div class="success-title">Message Sent!</div>
      <div class="success-msg">Thank you for reaching out. One of our watch specialists will contact you within 24 hours. We look forward to assisting you.</div>
      <button class="btn-gold-outline" onclick="resetForm()">Send Another Message</button>
    </div>
  </div>

  <!-- RIGHT COLUMN -->
  <div class="contact-right">

    <!-- MAP -->
    <div class="map-box reveal">
      <img class="map-placeholder" src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=600&h=300&fit=crop" alt="New York City">
      <div class="map-pin">◎ TimeZone — 5th Ave, NYC</div>
    </div>

    <!-- HOURS -->
    <div class="hours-card reveal">
      <div class="hc-title">Store Hours</div>
      <div class="hours-row today">
        <span class="hours-day">Friday <span class="today-badge">Today</span></span>
        <span class="hours-time">10:00am – 7:00pm</span>
      </div>
      <div class="hours-row">
        <span class="hours-day">Saturday</span>
        <span class="hours-time">10:00am – 7:00pm</span>
      </div>
      <div class="hours-row">
        <span class="hours-day">Sunday</span>
        <span class="hours-time">By Appointment</span>
      </div>
      <div class="hours-row">
        <span class="hours-day">Monday – Thursday</span>
        <span class="hours-time">10:00am – 7:00pm</span>
      </div>
    </div>

    <!-- SOCIAL -->
    <div class="social-card reveal">
      <div class="sc-title">Follow Us</div>
      <div class="social-links">
        <div class="social-link">Instagram</div>
        <div class="social-link">Facebook</div>
        <div class="social-link">Twitter</div>
        <div class="social-link">YouTube</div>
      </div>
    </div>

  </div>
</div>

<!-- FAQ -->
<section class="faq-section">
  <div class="faq-inner">
    <div class="section-label">Quick Answers</div>
    <h2 class="section-title">Frequently Asked <em>Questions</em></h2>
    <div class="faq-grid">
      <div class="faq-item reveal" onclick="toggleFaq(this)">
        <div class="faq-q">
          How do I verify a watch is authentic?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Every watch in our collection undergoes a rigorous multi-point authentication process conducted by our certified horologists. We verify serial numbers, movement specifications, case markings, and provenance documents before any timepiece is listed.</div>
      </div>
      <div class="faq-item reveal" data-delay="100" onclick="toggleFaq(this)">
        <div class="faq-q">
          Do you offer watch servicing?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Yes — our in-house master watchmaker James Harlow offers full movement servicing, restoration, and repair for most major Swiss brands. All watches purchased from us include a complimentary 2-year service warranty.</div>
      </div>
      <div class="faq-item reveal" data-delay="100" onclick="toggleFaq(this)">
        <div class="faq-q">
          Can I sell or trade in my watch?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Absolutely. We offer competitive buy-back and trade-in programs for luxury timepieces. Simply contact us with photos and details of your watch, and our acquisitions team will provide a free valuation within 48 hours.</div>
      </div>
      <div class="faq-item reveal" data-delay="200" onclick="toggleFaq(this)">
        <div class="faq-q">
          What shipping options are available?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">We offer complimentary fully insured shipping on all orders over $500. All packages are shipped via secure courier with real-time tracking, discreet packaging, and require a signature upon delivery.</div>
      </div>
      <div class="faq-item reveal" data-delay="200" onclick="toggleFaq(this)">
        <div class="faq-q">
          What is your return policy?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">We offer a 14-day hassle-free return policy on all purchases. The watch must be returned in its original condition with all documentation. Contact our team to initiate a return and we'll arrange a secure collection.</div>
      </div>
      <div class="faq-item reveal" data-delay="300" onclick="toggleFaq(this)">
        <div class="faq-q">
          Do you ship internationally?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Yes — we ship to over 45 countries worldwide. International shipments are fully insured and handled by specialist luxury couriers. Import duties and taxes are the responsibility of the recipient and vary by destination.</div>
      </div>
    </div>
  </div>
</section>

<script src="../assets/js/layout.js"></script>
<script src="../assets/js/app.js"></script>
<script>
function selectChip(el) {
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
}

function updateCount(el) {
  document.getElementById('charNum').textContent = el.value.length;
}

function submitForm() {
  const fname = document.getElementById('cfFname').value.trim();
  const email = document.getElementById('cfEmail').value.trim();
  const msg = document.getElementById('cfMsg').value.trim();

  if (!fname) { showToast('Please enter your first name.', '!'); return; }
  if (!email || !email.includes('@')) { showToast('Please enter a valid email.', '!'); return; }
  if (!msg) { showToast('Please write a message.', '!'); return; }

  document.getElementById('contactForm').style.display = 'none';
  document.getElementById('formSuccess').classList.add('show');
}

function resetForm() {
  document.getElementById('contactForm').style.display = 'block';
  document.getElementById('formSuccess').classList.remove('show');
  document.getElementById('cfFname').value = '';
  document.getElementById('cfLname').value = '';
  document.getElementById('cfEmail').value = '';
  document.getElementById('cfMsg').value = '';
  document.getElementById('charNum').textContent = '0';
  document.querySelectorAll('.chip').forEach((c, i) => {
    c.classList.toggle('active', i === 0);
  });
}

function toggleFaq(el) {
  const isOpen = el.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(f => f.classList.remove('open'));
  if (!isOpen) el.classList.add('open');
}

// Set today highlight based on actual day
(function() {
  const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
  const today = days[new Date().getDay()];
  document.querySelectorAll('.hours-day').forEach(el => {
    if (el.textContent.startsWith(today)) {
      el.closest('.hours-row').classList.add('today');
    } else {
      el.closest('.hours-row').classList.remove('today');
    }
  });
})();
</script>
</body>
</html>