<template>
    <div class="min-h-screen flex flex-col">
        <NavBar v-if="showNavBar" />
        <main class="flex-grow">
            <slot></slot>
        </main>
        <FooterSection />
    </div>
</template>

<script>
import NavBar from '@/Components/NavBar.vue'
import FooterSection from '@/Components/FooterSection.vue'

export default {
    components: {
        NavBar,
        FooterSection
    },
    props: {
        showNavBar: {
            type: Boolean,
            default: true
        }
    }
}
</script> 