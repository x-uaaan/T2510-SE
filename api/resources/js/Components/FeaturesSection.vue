<template>
  <section class="py-16 px-8 bg-blue-50">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl font-bold text-blue-900 text-center mb-12">Core Features</h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        <div>
          <img src="/image/icon-events.svg" class="mx-auto mb-4 h-12" alt="">
          <h3 class="font-bold text-lg mb-2">Events</h3>
          <p class="text-gray-600">Find and join campus events that match your interests.</p>
        </div>
        <div>
          <img src="/image/icon-forum.svg" class="mx-auto mb-4 h-12" alt="">
          <h3 class="font-bold text-lg mb-2">Forums</h3>
          <p class="text-gray-600">Participate in discussions and share your ideas.</p>
        </div>
        <div>
          <img src="/image/icon-network.svg" class="mx-auto mb-4 h-12" alt="">
          <h3 class="font-bold text-lg mb-2">Networking</h3>
          <p class="text-gray-600">Connect with peers, faculty, and campus groups.</p>
        </div>
        <div>
          <img src="/image/icon-notify.svg" class="mx-auto mb-4 h-12" alt="">
          <h3 class="font-bold text-lg mb-2">Notifications</h3>
          <p class="text-gray-600">Stay informed with real-time updates and alerts.</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'FeaturesSection',
}
</script> 