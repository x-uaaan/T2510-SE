<template>
  <div class="post-card-single">
    <div class="post-header-row">
      <div class="post-title-container">
        <div class="post-title">{{ post.postTitle }}</div>
        <div class="post-desc">{{ post.postDesc }}</div>
      </div>
      <div class="right-side">
        <MenuPopover class="menu-popover-margin" />
        <div class="post-meta">
          By <a :href="`/profile/${post.authorId}`" class="author-link">{{ post.author }}</a>
        </div>
      </div>
    </div>
    <hr class="divider" style="margin-top: 20px; margin-bottom: 20px;" />
    <div class="comments-section">
      <ul class="comments-list">
        <li v-for="(comment, idx) in post.comments" :key="idx" class="comment-item">
          <div class="comment-text">{{ comment }}</div>
        </li>
      </ul>
    </div>
    </div>
    <form class="add-comment-row" @submit.prevent>
    <input
        v-model="newComment"
        type="text"
        class="add-comment-input"
        placeholder="Add a comment..."
    />
    <button class="add-comment-btn outline" type="submit">Post</button>
    </form>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import MenuPopover from '@/Components/MenuPopover.vue';
const props = defineProps({
  post: Object
});
const newComment = ref('');
</script>

<style scoped>
.post-card-single {
  background: #232323;
  color: #fff;
  border-radius: 32px;
  padding: 32px 40px;
  margin-bottom: 32px;
  margin-top: 35px;
  width: 850px;
  box-shadow: 0 4px 16px #0002;
  display: flex;
  flex-direction: column;
  gap: 0px;
}
.post-header-row {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 100%;
  align-items: top;
}
.post-title {
  font-size: 2em;
  font-weight: bold;
  margin-bottom: 0;
}
.right-side {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-end;
  width: auto;
}
.post-meta {
  color: #b0b0b0;
  font-size: 0.8em;
  white-space: nowrap;
  margin-top: 10px;
}
.author-link {
  color: #b0b0b0;
  text-decoration: none;
  cursor: pointer;
  transition: color 0.2s;
}
.author-link:hover {
  color: #3b82f6;
}
.post-desc {
  font-size: 1em;
  color: #b0b0b0;
  margin-bottom: 0;
}
.divider {
  border: none;
  border-top: 1.5px solid #444;
  margin: 10px 0 10px 0;
}
.comments-section {
  width: 100%;
}
.comments-list {
  list-style: none;
  padding: 0;
  margin: 0;
}
.comment-item {
  background: #292929;
  border-radius: 16px;
  padding: 10px 18px;
  margin-bottom: 15px;
  color: #fff;
  font-size: 0.9em;
}
.comment-item:hover {
  background: #343434;
  transition: background 0.3s;
}
.comment-text {
  color: #fff;
}
.add-comment-row {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 10px;
  margin-top: 18px;
  width: 780px;
  position: fixed;
  bottom: 80px;
}
.add-comment-input {
  flex: 1;
  background: #18191a;
  border: 1px solid #444;
  border-radius: 12px;
  padding: 10px 16px;
  color: #fff;
  font-size: 1em;
  outline: none;
  transition: border-color 0.2s;
}
.add-comment-input:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 2px #3b82f688 !important;
  border: 0.5px solid #3b82f6 !important;
  border-radius: 12px !important;
  transition: border-color 0.2s;
  background: #18191A !important;
  color: #fff !important;
  outline: none !important;
}
.add-comment-btn {
  width: 90px;
  background: #18191a;
  color: #fff;
  border: 0.5px solid #444;
  border-radius: 14px;
  padding: 10px 18px;
  font-size: 1em;
  cursor: pointer;
  outline: none;
}
.add-comment-btn:hover {
  background: #232323;
  color: #fff;
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px #3b82f688 !important;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}

@media (max-width: 1250px) {
  .post-card-single {
    max-width: 600px !important;
    margin-left: 0;
    margin-right: auto;
  }
  .add-comment-row {
    width: 500px !important;
    left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;
    align-items: center;

  }
}
</style> 