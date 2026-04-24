<div>
    <!-- Hero Section -->
  <section class="relative min-h-[50vh] flex items-center justify-center bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-400 pt-32 pb-16">
    <div class="text-center max-w-3xl mx-auto px-4 text-white">
      <h1 class="font-bold font-serif mb-6 text-5xl leading-tight">Get in Touch</h1>
      <p class="text-xl opacity-95 leading-loose">Have questions about listing your property or need assistance? We're here to help you every step of the way.</p>
    </div>
  </section>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 gap-12">
      <!-- Contact Information -->
      <div class="flex flex-col gap-6">
        <!-- Phone -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
              <i class="ri-phone-line text-xl text-emerald-600"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-xl">Phone</h3>
          </div>
          <p class="text-gray-500 mb-1">Call us directly</p>
          <a href="tel:+2348067042140" class="text-emerald-500 font-medium hover:text-emerald-600 transition">08067042140</a>
          <p class="text-gray-400 mt-2 text-sm">Mon-Sat, 8AM-6PM</p>
        </div>

        <!-- Email -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
              <i class="ri-mail-line text-xl text-emerald-600"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-xl">Email</h3>
          </div>
          <p class="text-gray-500 mb-1">Send us an email</p>
          <a href="mailto:louis670421@gmail.com" class="text-emerald-500 font-medium hover:text-emerald-600 transition">louis670421@gmail.com</a>
          <p class="text-gray-400 mt-2 text-sm">24/7 support</p>
        </div>

        <!-- WhatsApp -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
              <i class="ri-whatsapp-line text-xl text-emerald-600"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-xl">WhatsApp</h3>
          </div>
          <p class="text-gray-500 mb-1">Chat with us on WhatsApp</p>
          <a href="https://wa.me/2348067042140" target="_blank" rel="noopener noreferrer" class="text-emerald-500 font-medium hover:text-emerald-600 transition">Start Chat</a>
          <p class="text-gray-400 mt-2 text-sm">Quick response</p>
        </div>

        <!-- Office Address -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
              <i class="ri-map-pin-line text-xl text-emerald-600"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-xl">Office Address</h3>
          </div>
          <p class="text-gray-500 mb-1">Visit our office</p>
          <p class="text-gray-500">94 Off Alashe Junction, Opposite Police Barracks, Igbogbo Road, Ikorodu, Lagos</p>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="bg-white rounded-2xl p-10 shadow-2xl">
        <h2 class="font-bold font-serif text-gray-900 mb-2 text-4xl leading-tight">Send us a Message</h2>
        <p class="text-gray-500 mb-8">Fill out the form below and we'll get back to you as soon as possible.</p>
        
        <form id="contact-form" class="space-y-6">
          <div>
            <label for="name" class="block font-semibold text-gray-700 mb-2 text-sm">Full Name *</label>
            <input type="text" id="name" name="name" required placeholder="Enter your full name" class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-base" />
          </div>
          <div>
            <label for="email" class="block font-semibold text-gray-700 mb-2 text-sm">Email Address *</label>
            <input type="email" id="email" name="email" required placeholder="your.email@example.com" class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-base" />
          </div>
          <div>
            <label for="phone" class="block font-semibold text-gray-700 mb-2 text-sm">Phone Number *</label>
            <input type="tel" id="phone" name="phone" required placeholder="08012345678" class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-base" />
          </div>
          <div>
            <label for="subject" class="block font-semibold text-gray-700 mb-2 text-sm">Subject *</label>
            <select id="subject" name="subject" required class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition appearance-none bg-white text-base">
              <option value="">Select a subject</option>
              <option value="List Property">List a Property</option>
              <option value="Property Inquiry">Property Inquiry</option>
              <option value="Technical Support">Technical Support</option>
              <option value="Payment Issue">Payment Issue</option>
              <option value="General Question">General Question</option>
            </select>
          </div>
          <div>
            <label for="message" class="block font-semibold text-gray-700 mb-2 text-sm">Message *</label>
            <textarea id="message" name="message" required maxlength="500" placeholder="Tell us how we can help you..." class="w-full px-4 py-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none min-h-[120px] text-base"></textarea>
            <p class="text-gray-400 text-right mt-1 text-xs">0/500 characters</p>
          </div>
          <button type="submit" class="w-full py-4 text-white font-semibold rounded-lg transition-all hover:-translate-y-1 flex items-center justify-center gap-2 bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-400 hover:from-emerald-700 hover:via-emerald-600 hover:to-emerald-500 shadow-md hover:shadow-lg text-base">
            <i class="ri-send-plane-line text-lg"></i>
            Send Message
          </button>
        </form>
      </div>
    </div>

    <!-- Map Section -->
    <section class="mt-16">
      <h2 class="font-bold font-serif text-gray-900 text-center mb-6 text-4xl leading-tight">Find Us</h2>
      <div class="bg-white rounded-2xl overflow-hidden shadow-2xl h-[400px]">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.952912260219!2d3.5062!3d6.6137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b9245d66d3b9f%3A0x5e27e6e8e8e8e8e8!2sIkorodu%2C%20Lagos%2C%20Nigeria!5e0!3m2!1sen!2sng!4v1234567890" class="w-full h-full" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="mt-16">
      <h2 class="font-bold font-serif text-gray-900 text-center mb-6 text-4xl leading-tight">Frequently Asked Questions</h2>
      <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="font-bold text-gray-900 mb-3 text-lg">How do I list my property?</h3>
          <p class="text-gray-500 text-[0.95rem] leading-relaxed">Simply create an account, click on "List Property," fill in the details about your property, upload photos, and pay the one-time listing fee of ₦5,000. Your property will be live within 24 hours after approval.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="font-bold text-gray-900 mb-3 text-lg">What payment methods do you accept?</h3>
          <p class="text-gray-500 text-[0.95rem] leading-relaxed">We accept payments through Paystack, which supports debit/credit cards, bank transfers, and USSD payments. All transactions are secure and encrypted.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="font-bold text-gray-900 mb-3 text-lg">How do I contact a property owner?</h3>
          <p class="text-gray-500 text-[0.95rem] leading-relaxed">Each property listing displays the owner's phone number and WhatsApp contact. You can call, WhatsApp, or email them directly without any intermediaries.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="font-bold text-gray-900 mb-3 text-lg">Is there a commission on sales?</h3>
          <p class="text-gray-500 text-[0.95rem] leading-relaxed">No, JustProperties does not charge any commission on property sales or rentals. We only charge a one-time listing fee of ₦5,000 to property owners.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="font-bold text-gray-900 mb-3 text-lg">How long does it take to get my property listed?</h3>
          <p class="text-gray-500 text-[0.95rem] leading-relaxed">After submitting your property details and payment, our team reviews the listing within 24 hours. Once approved, your property will be visible to thousands of potential buyers and renters.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="font-bold text-gray-900 mb-3 text-lg">Can I boost my property listing?</h3>
          <p class="text-gray-500 text-[0.95rem] leading-relaxed">Yes, you can boost your listing for increased visibility. Boosted properties appear at the top of search results and receive more views. Contact us for boost pricing options.</p>
        </div>
      </div>
    </section>
  </main>

</div>