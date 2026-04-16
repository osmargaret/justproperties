<div>
  <section class="hero">
    <div class="hero-content">
      <h1>Get in Touch</h1>
      <p>Have questions about listing your property or need assistance? We're here to help you every step of the way.</p>
    </div>
  </section>

  <main class="main-content">
    <div class="contact-grid">
      <!-- Contact Information -->
      <div class="contact-info">
        <div class="contact-card">
          <div class="contact-card-header">
            <div class="contact-icon">
              <i class="ri-phone-line"></i>
            </div>
            <h3>Phone</h3>
          </div>
          <p>Call us directly</p>
          <a href="tel:+2348067042140">08067042140</a>
          <p class="hours">Mon-Sat, 8AM-6PM</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-header">
            <div class="contact-icon">
              <i class="ri-mail-line"></i>
            </div>
            <h3>Email</h3>
          </div>
          <p>Send us an email</p>
          <a href="mailto:louis670421@gmail.com">louis670421@gmail.com</a>
          <p class="hours">24/7 support</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-header">
            <div class="contact-icon">
              <i class="ri-whatsapp-line"></i>
            </div>
            <h3>WhatsApp</h3>
          </div>
          <p>Chat with us on WhatsApp</p>
          <a href="https://wa.me/2348067042140" target="_blank" rel="noopener noreferrer">Start Chat</a>
          <p class="hours">Quick response</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-header">
            <div class="contact-icon">
              <i class="ri-map-pin-line"></i>
            </div>
            <h3>Office Address</h3>
          </div>
          <p>Visit our office</p>
          <p>94 Off Alashe Junction, Opposite Police Barracks, Igbogbo Road, Ikorodu, Lagos</p>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="contact-form-container">
        <h2>Send us a Message</h2>
        <p>Fill out the form below and we'll get back to you as soon as possible.</p>
        <form id="contact-form" class="contact-form">
          <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" required placeholder="Enter your full name" />
          </div>
          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required placeholder="your.email@example.com" />
          </div>
          <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" name="phone" required placeholder="08012345678" />
          </div>
          <div class="form-group">
            <label for="subject">Subject *</label>
            <select id="subject" name="subject" required>
              <option value="">Select a subject</option>
              <option value="List Property">List a Property</option>
              <option value="Property Inquiry">Property Inquiry</option>
              <option value="Technical Support">Technical Support</option>
              <option value="Payment Issue">Payment Issue</option>
              <option value="General Question">General Question</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required maxlength="500" placeholder="Tell us how we can help you..."></textarea>
            <p class="char-count">0/500 characters</p>
          </div>
          <button type="submit" class="submit-btn">
            <i class="ri-send-plane-line"></i>
            Send Message
          </button>
        </form>
      </div>
    </div>

    <!-- Map Section -->
    <section class="map-section">
      <h2>Find Us</h2>
      <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.952912260219!2d3.5062!3d6.6137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b9245d66d3b9f%3A0x5e27e6e8e8e8e8e8!2sIkorodu%2C%20Lagos%2C%20Nigeria!5e0!3m2!1sen!2sng!4v1234567890" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <h2>Frequently Asked Questions</h2>
      <div class="faq-grid">
        <div class="faq-item">
          <h3>How do I list my property?</h3>
          <p>Simply create an account, click on "List Property," fill in the details about your property, upload photos, and pay the one-time listing fee of ₦5,000. Your property will be live within 24 hours after approval.</p>
        </div>
        <div class="faq-item">
          <h3>What payment methods do you accept?</h3>
          <p>We accept payments through Paystack, which supports debit/credit cards, bank transfers, and USSD payments. All transactions are secure and encrypted.</p>
        </div>
        <div class="faq-item">
          <h3>How do I contact a property owner?</h3>
          <p>Each property listing displays the owner's phone number and WhatsApp contact. You can call, WhatsApp, or email them directly without any intermediaries.</p>
        </div>
        <div class="faq-item">
          <h3>Is there a commission on sales?</h3>
          <p>No, JustProperties does not charge any commission on property sales or rentals. We only charge a one-time listing fee of ₦5,000 to property owners.</p>
        </div>
        <div class="faq-item">
          <h3>How long does it take to get my property listed?</h3>
          <p>After submitting your property details and payment, our team reviews the listing within 24 hours. Once approved, your property will be visible to thousands of potential buyers and renters.</p>
        </div>
        <div class="faq-item">
          <h3>Can I boost my property listing?</h3>
          <p>Yes, you can boost your listing for increased visibility. Boosted properties appear at the top of search results and receive more views. Contact us for boost pricing options.</p>
        </div>
      </div>
    </section>
  </main>
</div>
@push('styles')
  <style>
    body{
      background-color: #f9fafb;
    }
    
  </style>
<script>