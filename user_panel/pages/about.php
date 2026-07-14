<?php include('../config/db.php'); ?> 
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>


</head>


<?php
if(isset($_POST['submit'])){
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $mess = trim($_POST['mess']);
  $review = trim($_POST['review']);

  // if($name == "" || $email == "" || $phone == "" || $mess == "" || $review == ""){
  //   echo "<script>alert('All fields are required');</script>";
  // } else {

    $query = "INSERT INTO feedback (name, email, phone, mess, review) 
              VALUES ('$name', '$email', '$phone', '$mess', '$review')";
    
    $res = mysqli_query($admin, $query);

    if($res){
      header("Location: ".$_SERVER['PHP_SELF']."?success=1");
      exit();
    }
  // }
}
?>








<body>

<!-- HERO -->
<section class="about-hero">
  <div class="about-hero-bg"></div>
  <div class="about-hero-content">
    <div class="section-label">Our Story</div>
    <h1>Thirty Years of <em>Horological Excellence</em></h1>
    <p>Since 1995, TimeZone Watches has been the trusted destination for the world's most discerning watch collectors and enthusiasts.</p>
  </div>
</section>

<!-- STORY -->
<section>
  <div class="about-story">
    <div class="story-text reveal-left">
      <div class="section-label">Who We Are</div>
      <h2 class="section-title" style="margin-bottom:28px;">Curators of <em>Time</em></h2>
      <p>TimeZone Watches was founded in 1995 by horologist Marcus Reynolds in the heart of New York City. What began as a small boutique specializing in vintage Swiss timepieces has grown into one of the world's most respected luxury watch retailers.</p>
      <p>Our philosophy is simple: every watch tells a story. Each timepiece in our collection has been hand-selected by our team of certified horologists, ensuring that only the most exceptional examples reach our clients.</p>
      <p>Today, we serve collectors and connoisseurs across 45 countries, offering an unparalleled selection of new, pre-owned, and vintage timepieces from every major manufacture.</p>
      <div class="story-quote">
        <blockquote>"A watch is not merely an instrument for measuring time — it is a testament to human ingenuity, artistry, and the relentless pursuit of perfection."</blockquote>
        <cite>— Marcus Reynolds, Founder</cite>
      </div>
    </div>
    <div class="story-image reveal">
      <img src="../assets/images/aboutpic.png" alt="Our Story">
    </div>
  </div>
</section>

<!-- NUMBERS -->
<section class="about-numbers">
  <div class="numbers-grid">
    <div class="number-card reveal">
      <div class="number-val">30<span class="number-unit">+</span></div>
      <div class="number-label">Years of Heritage</div>
    </div>
    <div class="number-card reveal" data-delay="100">
      <div class="number-val">500<span class="number-unit">+</span></div>
      <div class="number-label">Timepieces</div>
    </div>
    <div class="number-card reveal" data-delay="200">
      <div class="number-val">45</div>
      <div class="number-label">Countries Served</div>
    </div>
    <div class="number-card reveal" data-delay="300">
      <div class="number-val">28</div>
      <div class="number-label">Luxury Brands</div>
    </div>
  </div>
</section>

<!-- TEAM -->
<section>
  <div class="about-team">
    <div class="section-label">The Experts</div>
    <h2 class="section-title">Meet Our <em>Team</em></h2>
    <div class="team-grid">
      <div class="team-card reveal">
        <div class="team-img"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=350&fit=crop" alt="Marcus Reynolds"></div>
        <div class="team-info">
          <div class="team-role">Founder & Head Horologist</div>
          <div class="team-name">Marcus Reynolds</div>
          <div class="team-bio">30 years of expertise in Swiss horology. Certified by the British Horological Institute and the WOSTEP school in Neuchâtel.</div>
        </div>
      </div>
      <div class="team-card reveal" data-delay="150">
        <div class="team-img"><img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=350&fit=crop" alt="Sofia Marchetti"></div>
        <div class="team-info">
          <div class="team-role">Curator & Acquisitions Director</div>
          <div class="team-name">Sofia Marchetti</div>
          <div class="team-bio">Former auction specialist at Christie's Geneva. Expert in vintage Patek Philippe and rare complications.</div>
        </div>
      </div>
      <div class="team-card reveal" data-delay="300">
        <div class="team-img"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=350&fit=crop" alt="James Harlow"></div>
        <div class="team-info">
          <div class="team-role">Senior Watch Technician</div>
          <div class="team-name">James Harlow</div>
          <div class="team-bio">Master watchmaker with 20 years of service experience. Specializes in movement restoration and servicing.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- VALUES -->
<section class="about-values">
  <div class="values-inner">
    <div class="section-label">Our Principles</div>
    <h2 class="section-title">What We <em>Stand For</em></h2>
    <div class="values-grid">
      <div class="value-card reveal">
        <div class="value-num">01</div>
        <div class="value-title">Authenticity</div>
        <div class="value-text">Every timepiece is thoroughly authenticated by our team of horologists before it enters our collection. We guarantee the provenance and condition of every watch we sell.</div>
      </div>
      <div class="value-card reveal" data-delay="150">
        <div class="value-num">02</div>
        <div class="value-title">Expertise</div>
        <div class="value-text">Our team combines over 80 years of combined horological expertise. We are passionate students of the craft, continuously deepening our knowledge.</div>
      </div>
      <div class="value-card reveal" data-delay="300">
        <div class="value-num">03</div>
        <div class="value-title">Service</div>
        <div class="value-text">The purchase of a luxury timepiece is the beginning of a lifelong relationship. We provide full after-sale support, servicing, and consultation to every client.</div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<div class="tz-fb-wrap">
  <div id="tzFbForm">
    <div class="tz-top">
      <div class="tz-gold-line"></div>
      <div class="tz-title">Share Your <em>Feedback</em></div>
    </div>
    <form method="post">
    <div class="tz-row">
      <div>
        <label class="tz-label ">Full Name</label>
        <input class="tz-input" name="name" id="tzFn" placeholder="John">
      </div>
      <div>
        <label class="tz-label">Phone</label>
        <input type="number" class="tz-input" id="tzLn" name="number" placeholder="03xxxxxxxxxx">
      </div>
      <div>
        <label class="tz-label">Email Address</label>
        <input class="tz-input" type="email" name="email" id="tzEm" placeholder="your@email.com">
        <div class="tz-err" id="tzEmErr">Valid email required.</div>
      </div>
    </div>
    <div>
      <label class="tz-label">Your Feedback</label>
      <textarea class="tz-textarea" id="tzMsg" name="mess" placeholder="Tell us about your experience..."></textarea>
      <div class="tz-err" id="tzMsgErr">Please write your feedback.</div>
    </div>
    <div class="tz-bottom">
      <div>
        <label class="tz-label">Rating</label>
        <div class="tz-stars">
          <select name="review" class="form-select">
                    <option value="⭐">⭐</option>
                    <option value="⭐⭐">⭐⭐</option>
                    <option value="⭐⭐⭐">⭐⭐⭐</option>
                    <option value="⭐⭐⭐⭐">⭐⭐⭐⭐</option>
                    <option value="⭐⭐⭐⭐⭐">⭐⭐⭐⭐⭐</option>
                </select>
        </div>
        <div class="tz-hint" id="tzHint">Tap to rate</div>
        <div class="tz-err" id="tzStarErr">Please rate us.</div>
      </div>
      <br>
      <input   class="tz-btn" id="tzSubmit" type="submit" value="Submit →" name="submit">
      
    </div>
    </form>
  </div>

  <div class="tz-success" id="tzFbSuccess">
    <div class="tz-check">✓</div>
    <div class="tz-s-title">Thank You for Your <em>Review</em></div>
    <p class="tz-s-msg">Your feedback has been received. We truly appreciate you taking the time.</p>
    <button class="tz-reset" id="tzReset">Submit Another</button>
  </div>
</div>


<script src="../assets/js/layout.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
