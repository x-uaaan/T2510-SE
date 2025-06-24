<template>
  <AppLayout>
    <div class="min-h-screen bg-black text-white font-['Inter']">
      <!-- Hero Section -->
      <section class="relative py-24 px-4 bg-gradient-to-br from-black via-gray-900 to-black">
        <div class="max-w-4xl mx-auto text-center">
          <div class="inline-block bg-gradient-to-r from-blue-500/20 to-blue-600/20 px-4 py-2 rounded-full border border-blue-500/30 mb-8">
            <span class="text-blue-400 font-medium">About Us</span>
          </div>
          <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
            About 
            <span class="bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Campus Pulse</span>
          </h1>
          <p class="text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed">
            Campus Pulse is a modern alumni management system designed to help university communities connect, collaborate, and stay engaged. Our platform offers forums, event management, and a vibrant network for alumni and students.
          </p>
        </div>
      </section>

      <!-- Main Content -->
      <section class="py-16 px-4 bg-gray-900">
        <div class="max-w-6xl mx-auto">
          <div class="grid lg:grid-cols-2 gap-16">
            <!-- Left Column -->
            <div class="space-y-12">
              <!-- Issue Reporting -->
              <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700 hover:border-red-500/50 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                  </div>
                  <h2 class="text-2xl font-bold text-white">Report an Issue</h2>
                </div>
                <p class="text-gray-400 mb-4">If you encounter any bugs or issues, please let us know so we can improve your experience.</p>
                <a href="mailto:support@campuspulse.com" class="inline-flex items-center gap-2 text-red-400 hover:text-red-300 font-medium transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                  support@campuspulse.com
                </a>
              </div>

              <!-- Terms & Conditions -->
              <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700 hover:border-yellow-500/50 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <h2 class="text-2xl font-bold text-white">Terms & Conditions</h2>
                </div>
                <p class="text-gray-400">
                  By using Campus Pulse, you agree to use the platform respectfully and abide by all university and community guidelines. Misuse of the system may result in account suspension.
                </p>
              </div>

              <!-- Privacy Policy -->
              <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700 hover:border-green-500/50 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                  </div>
                  <h2 class="text-2xl font-bold text-white">Privacy Policy</h2>
                </div>
                <p class="text-gray-400">
                  We value your privacy. Your personal information is securely stored and will never be shared with third parties without your consent. For more details, contact our support team.
                </p>
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-12">
              <!-- FAQ -->
              <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700">
                <div class="flex items-center gap-4 mb-8">
                  <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <h2 class="text-2xl font-bold text-white">Frequently Asked Questions</h2>
                </div>
                <div class="space-y-6">
                  <div class="border-b border-gray-700 pb-4">
                    <h3 class="font-semibold text-white mb-2">How do I join Campus Pulse?</h3>
                    <p class="text-gray-400">Click the Sign Up button at the top right and fill in your details to create an account.</p>
                  </div>
                  <div class="border-b border-gray-700 pb-4">
                    <h3 class="font-semibold text-white mb-2">Is my data safe?</h3>
                    <p class="text-gray-400">Yes, we use industry-standard security practices to protect your data.</p>
                  </div>
                  <div class="border-b border-gray-700 pb-4">
                    <h3 class="font-semibold text-white mb-2">How can I participate in events?</h3>
                    <p class="text-gray-400">Browse the Events section and register for any event that interests you.</p>
                  </div>
                  <div class="pb-4">
                    <h3 class="font-semibold text-white mb-2">Who can I contact for help?</h3>
                    <p class="text-gray-400">You can email our support team at <a href="mailto:support@campuspulse.com" class="text-blue-400 hover:text-blue-300 underline">support@campuspulse.com</a>.</p>
                  </div>
                </div>
              </div>

              <!-- Contact Section -->
              <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700 hover:border-purple-500/50 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                  </div>
                  <h2 class="text-2xl font-bold text-white">Contact Us</h2>
                </div>
                <p class="text-gray-400 mb-4">For any inquiries, suggestions, or feedback, please reach out to us.</p>
                <div class="space-y-3">
                  <a href="mailto:info@campuspulse.com" class="inline-flex items-center gap-2 text-purple-400 hover:text-purple-300 font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    info@campuspulse.com
                  </a>
                  <a href="mailto:support@campuspulse.com" class="inline-flex items-center gap-2 text-purple-400 hover:text-purple-300 font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                    </svg>
                    support@campuspulse.com
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Call to Action -->
      <section class="py-16 px-4 text-center bg-gradient-to-br from-black via-gray-900 to-black">
        <div class="max-w-4xl mx-auto">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Get Started?</h2>
          <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
            Join the Campus Pulse community and start connecting with fellow alumni today.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/auth/microsoft" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl shadow-2xl hover:shadow-blue-500/25 font-semibold transition-all duration-300 transform hover:scale-105">
              Sign Up Now
            </a>
            <a href="/" class="text-gray-400 hover:text-white px-8 py-4 rounded-xl border border-gray-600 hover:border-gray-400 font-medium transition-all duration-300">
              Back to Home
            </a>
          </div>
        </div>
      </section>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #1f2937;
}

::-webkit-scrollbar-thumb {
  background: #4b5563;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #6b7280;
}
</style> 