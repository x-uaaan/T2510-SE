<template>
  <AppLayout>
    <div class="min-h-screen bg-[#18191A] text-white font-['Inter'] py-16 px-4">
      <div class="max-w-3xl mx-auto space-y-16">
        <!-- About Us -->
        <section>
          <h1 class="text-4xl font-extrabold mb-4">About Campus Pulse</h1>
          <p class="text-lg text-gray-300">
            Campus Pulse is a modern alumni management system designed to help university communities connect, collaborate, and stay engaged. Our platform offers forums, event management, and a vibrant network for alumni and students.
          </p>
        </section>

        <!-- Issue Reporting -->
        <section>
          <h2 class="text-2xl font-bold mb-2">Report an Issue</h2>
          <p class="text-gray-300 mb-2">If you encounter any bugs or issues, please let us know so we can improve your experience.</p>
          <a href="mailto:support@campuspulse.com" class="text-blue-400 underline">Email support@campuspulse.com</a>
        </section>

        <!-- Terms & Conditions -->
        <section>
          <h2 class="text-2xl font-bold mb-2">Terms & Conditions</h2>
          <p class="text-gray-300">
            By using Campus Pulse, you agree to use the platform respectfully and abide by all university and community guidelines. Misuse of the system may result in account suspension.
          </p>
        </section>

        <!-- Privacy Policy -->
        <section>
          <h2 class="text-2xl font-bold mb-2">Privacy Policy</h2>
          <p class="text-gray-300">
            We value your privacy. Your personal information is securely stored and will never be shared with third parties without your consent. For more details, contact our support team.
          </p>
        </section>

        <!-- FAQ -->
        <section>
          <h2 class="text-2xl font-bold mb-4">Frequently Asked Questions</h2>
          <div class="space-y-4">
            <div>
              <h3 class="font-semibold">How do I join Campus Pulse?</h3>
              <p class="text-gray-300">Click the Sign Up button at the top right and fill in your details to create an account.</p>
            </div>
            <div>
              <h3 class="font-semibold">Is my data safe?</h3>
              <p class="text-gray-300">Yes, we use industry-standard security practices to protect your data.</p>
            </div>
            <div>
              <h3 class="font-semibold">How can I participate in events?</h3>
              <p class="text-gray-300">Browse the Events section and register for any event that interests you.</p>
            </div>
            <div>
              <h3 class="font-semibold">Who can I contact for help?</h3>
              <p class="text-gray-300">You can email our support team at <a href="mailto:support@campuspulse.com" class="text-blue-400 underline">support@campuspulse.com</a>.</p>
            </div>
          </div>
        </section>

        <!-- Contact Section -->
        <section>
          <h2 class="text-2xl font-bold mb-2">Contact Us</h2>
          <p class="text-gray-300">For any inquiries, suggestions, or feedback, please reach out to us at <a href="mailto:info@campuspulse.com" class="text-blue-400 underline">info@campuspulse.com</a>.</p>
        </section>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script> 