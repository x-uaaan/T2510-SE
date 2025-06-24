<template>
    <div class="min-h-screen flex flex-col">
        <slot></slot>
        <FooterSection />
    </div>
</template>

<script>
import FooterSection from '@/Components/FooterSection.vue'

export default {
    components: {
        FooterSection
    }
}
</script> 