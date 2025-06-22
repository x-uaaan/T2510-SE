<template>
  <div class="post-card" @click="$emit('click')">
    <div class="post-content">
      <div class="post-title">{{ post.postTitle }}</div>
      <div class="post-desc no-wrap">{{ post.postDesc }}</div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(['post'])

const userSvg = `<svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><circle cx='12' cy='7.25' r='5.73' stroke='#fff' stroke-width='1.5'/><path d='M1.5,23.48l.37-2.05A10.3,10.3,0,0,1,12,13h0a10.3,10.3,0,0,1,10.13,8.45l.37,2.05' stroke='#fff' stroke-width='1.5'/></svg>`
const timeSvg = `<svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><circle cx='12' cy='12' r='9' stroke='#fff' stroke-width='1.5'/><path d='M12 7V12L15 15' stroke='#fff' stroke-width='1.5' stroke-linecap='round'/></svg>`

function formatDate(timestamp) {
  const date = new Date(timestamp)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>

<style scoped>
.post-card {
  background: #232323;
  color: #fff;
  border-radius: 32px;
  padding: 24px 32px;
  margin: 18px 0;
  height: 100px;
  width: 500px;
  display: flex;
  align-items: center;
  cursor: pointer;
  transition: box-shadow 0.2s, background 0.2s;
  box-shadow: 0 4px 16px #0002;
  margin-bottom: 0px;
}
.post-card:hover {
  background: #343434;
  box-shadow: 0 4px 16px #0004;
}
.post-content {
  display: flex;
  flex-direction: column;
  align-items: left;
  gap: 8px;
  width: 100%;
}
.post-title {
  font-size: 1.3em;
  font-weight: bold;
  margin-bottom: 2px;
  text-align: left;
}
.post-meta-row {
  display: flex;
  align-items: center;
  gap: 24px;
  margin-bottom: 4px;
  width: 100%;
  padding-right: 50px;
}
.post-icon-label {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #fff;
  font-size: 0.9em;
}
.icon-svg {
  width: 24px;
  height: 24px;
}
.post-desc.no-wrap {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  width: 100%;
  text-align: left;
  color: #b0b0b0;
  font-size: 0.9em;
}
</style> 