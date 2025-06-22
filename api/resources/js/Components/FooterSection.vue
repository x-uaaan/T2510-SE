<template>
  <footer class="footer-section">
    <div class="footer-content">
      <a href="@/views/app.blade.php">© 2025 Campus Pulse. All rights reserved.</a>
      <a href="mailto:support@campuspulse.com">Contact Us</a>
      <a href="mailto:support@campuspulse.com">Feedback</a>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'FooterSection',
}
</script>

<style scoped>
.footer-section {
  position: relative;
  left: 0;
  bottom: 0;
  width: 100vw;
  height: 50px;
  background: #232323; /* blue-900 */
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 5;
}
.footer-content {
  display: flex;
  gap: 2rem;
  align-items: center;
}
a {
  text-decoration: none;
  color: white;
}

a:hover {
  color: #d3cece;
  transition: color 0.3s ease;
}
</style>