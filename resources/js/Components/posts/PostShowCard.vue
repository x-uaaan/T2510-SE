<template>
  <div class="post-card-single">
    <div class="post-header-row">
      <div class="post-title-container">
        <div class="post-title">{{ post.postTitle }}</div>
        <div class="post-desc">{{ post.postDesc }}</div>
      </div>
      <div class="right-side">
        <MenuPopoverPost v-if="canManagePost" class="menu-popover-margin" :post="post" />
        <div class="post-meta">
          <a :href="`/profile/${post.authorId}`" class="author-link">{{ post.author }}</a>
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
    <form class="add-comment-row" @submit.prevent="addComment">
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
import { defineProps, ref, onMounted, computed } from 'vue';
import MenuPopoverPost from '@/Components/posts/MenuPopoverPost.vue';
const props = defineProps({
  post: Object
});
const newComment = ref('');
const currentUser = ref(null);

const canManagePost = computed(() => {
  if (!currentUser.value || !props.post) {
    return false;
  }
  return currentUser.value.userType === 'Admin' || currentUser.value.userID === props.post.authorId;
});

onMounted(() => {
  fetchCurrentUser();
});

async function fetchCurrentUser() {
  try {
    const response = await fetch('/api/user', { credentials: 'include' });
    if (response.ok) {
      currentUser.value = await response.json();
    } else {
      currentUser.value = null;
    }
  } catch (error) {
    console.error('Failed to fetch current user:', error);
    currentUser.value = null;
  }
}

async function addComment() {
  if (!newComment.value.trim()) return;

  try {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const response = await fetch(`/api/posts/${props.post.postID}/comments`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ comment: newComment.value }),
    });

    if (response.ok) {
      const data = await response.json();
      props.post.comments = data.comments;
      newComment.value = '';
    } else {
      console.error('Failed to add comment');
    }
  } catch (error) {
    console.error('An error occurred:', error);
  }
}
</script>

<style scoped>
.post-card-single {
  color: #fff;
  border-radius: 32px;
  margin-bottom: 32px;
  margin-top: 35px;
  width: 1000px;
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
  font-size: 0.9em;
  white-space: nowrap;
  margin-top: 10px;
}
.author-link {
  color: #fff;
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