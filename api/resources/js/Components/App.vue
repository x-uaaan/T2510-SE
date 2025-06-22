<template>
  <div>
    <NavBar />
    <HeroSection />
    <AboutSection />
    <FeaturesSection />
    <FooterSection />
  </div>
</template>

<script>
import NavBar from './Components/NavBar.vue'
import HeroSection from './Components/HeroSection.vue'
import AboutSection from './Components/AboutSection.vue'
import FeaturesSection from './Components/FeaturesSection.vue'
import FooterSection from './Components/FooterSection.vue'

export default {
  components: { NavBar, HeroSection, AboutSection, FeaturesSection, FooterSection }
}
</script>
