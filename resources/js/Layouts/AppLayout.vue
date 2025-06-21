<template>
    <div class="bg-slate-900">
        <NavigationDrawer />
        <div class="flex flex-col flex-1 md:ml-[80px]">
            <NavBar />
            <main class="flex-grow">
                <slot></slot>
            </main>
        </div>
        <FooterSection />
    </div>
</template>

<script>
import NavigationDrawer from '@/Components/NavigationDrawer.vue';
import NavBar from '@/Components/NavBar.vue';
import FooterSection from '@/Components/FooterSection.vue';

export default {
    components: {
        NavigationDrawer,
        NavBar,
        FooterSection,
    },
}
</script> 