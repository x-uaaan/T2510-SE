<template>
  <div class="forum-card">
    <div class="forum-content" @click="$emit('click')">
      <div class="forum-title">{{ forum.forumTitle }}</div>
      <div class="forum-meta-row">
        <span class="forum-icon-label categories">
          <span class="icon-svg" v-html="interestSvg"></span>
          <span class="categories-text">{{ forum.Categories }}</span>
        </span>
        <span class="forum-icon-label">
          <span class="icon-svg" v-html="postSvg"></span>
          <span>{{ forum.posts_count || 0 }} Posts</span>
        </span>
      </div>
      <div class="forum-desc no-wrap">{{ forum.forumDesc }}</div>
    </div>
  </div>
</template>

<script setup>
import MenuPopover from '@/Components/MenuPopover.vue'

const props = defineProps(['forum'])
const emit = defineEmits(['click', 'updated'])

const postSvg = `<svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><rect x='3' y='5' width='18' height='14' rx='2' stroke='#fff' stroke-width='1.5'/><path d='M7 9H17' stroke='#fff' stroke-width='1.5' stroke-linecap='round'/><path d='M7 13H13' stroke='#fff' stroke-width='1.5' stroke-linecap='round'/></svg>`
const interestSvg = `<svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><circle cx='12' cy='12' r='10' stroke='#fff' stroke-width='1.5'/><circle cx='12' cy='12' r='4' stroke='#fff' stroke-width='1.5'/></svg>`
</script>

<style scoped>
.forum-card {
  background: #232323;
  color: #fff;
  border-radius: 32px;
  padding: 24px 32px;
  margin: 18px 0;
  height: 100px;
  width: 450px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  transition: box-shadow 0.2s, background 0.2s;
  box-shadow: 0 4px 16px #0002;
}
.forum-card:hover {
  background: #343434;
  box-shadow: 0 4px 16px #0004;
}
.forum-content {
  display: flex;
  flex-direction: column;
  align-items: left;
  gap: 8px;
  width: 100%;
  cursor: pointer;
}
.forum-title {
  font-size: 1.3em;
  font-weight: bold;
  margin-bottom: 2px;
  text-align: left;
}
.forum-meta-row {
  display: flex;
  align-items: center;
  gap: 24px;
  margin-bottom: 4px;
  width: 100%;
  padding-right: 50px;
}
.forum-icon-label {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #fff;
  font-size: 0.9em;
}
.categories {
  width: 300px;
  justify-content: flex-start;
  margin-left: -3px;
}
.categories-text {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: inline-block;
  max-width: 300px;
}
.icon-svg {
  width: 24px;
  height: 24px;
}
.forum-desc.no-wrap {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  width: 100%;
  text-align: left;
  color: #b0b0b0;
  font-size: 0.9em;
}
</style> 