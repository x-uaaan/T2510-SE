<template>
  <div class="calendar-fixed" @click="handleCalendarClick">
    <div class="search-menu-row">
      <SearchBar :class="{ 'search-bar-full-width': userType !== 'Lecturer' && userType !== 'Admin' }" />
      <a href="/events/create" v-if="userType === 'Lecturer' || userType === 'Admin'">
        <button class="menu-btn create-btn">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 4V20M4 12H20" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          <span>Create</span>
        </button>
      </a>
    </div>
    <VDatePicker
      ref="calendarRef"
      :key="calendarKey"
      is-dark
      :min-view="'month'"
      :max-view="'month'"
      :show-caps="false"
      :show-weeknumbers="false"
      :show-header="true"
      :show-nav="true"
      :show-title="true"
      :show-weekdays="true"
      :show-overlay="false"
      :show-edge-dates="true"
      :first-day-of-week="0"
      :attributes="attributes"
      :title-position="'left'"
      :select-attribute="null"
      :drag-attribute="null"
      v-model="displayedDate"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import 'v-calendar/style.css'
import SearchBar from '@/Components/SearchBar.vue'
import axios from 'axios'

const userType = ref('')

onMounted(async () => {
  try {
    const response = await axios.get('/user', { withCredentials: true });
    userType.value = response.data.userType;
  } catch (error) {
    console.error('Error fetching user type:', error);
  }
  window.addEventListener('scroll', handleScroll)
})

const searchQuery = ref('')
const showLogo = ref(true)
let lastScrollY = window.scrollY

function handleScroll() {
  const currentY = window.scrollY
  if (currentY < 100) {
    showLogo.value = true
  } else if (currentY > lastScrollY) {
    // scrolling down
    showLogo.value = false
  } else {
    // scrolling up
    showLogo.value = true
  }
  lastScrollY = currentY
}

// Get today's date and set as default month
const today = new Date()
const defaultMonth = {
  month: today.getMonth() + 1,
  year: today.getFullYear()
}

const displayedDate = ref(defaultMonth)
const calendarRef = ref(null)
const calendarKey = ref(0)

const attributes = ref([
  {
    key: 'today',
    highlight: {
      color: 'blue',
      fillMode: 'solid'
    },
    dates: new Date() // This will always be today's date
  }
])

function attachTitleClickListener(retryCount = 0) {
  console.log('Attaching title click listener, retry:', retryCount)
  
  const titleElement = document.querySelector('.vc-title')
  console.log('Title element found for listener attachment:', titleElement)
  
  if (titleElement) {
    console.log('Adding click listener to title element')
    titleElement.style.cursor = 'pointer'
    titleElement.addEventListener('click', (e) => {
      console.log('Title click handler triggered')
      e.preventDefault()
      e.stopPropagation()
      goToDefaultMonth()
    })
  } else if (retryCount < 10) {
    // Retry up to 10 times with increasing delays
    const delay = 100 + (retryCount * 100) // 100ms, 200ms, 300ms, etc.
    console.log(`Title element not found, retrying in ${delay}ms...`)
    setTimeout(() => {
      attachTitleClickListener(retryCount + 1)
    }, delay)
  } else {
    console.log('Max retries reached, title element not found')
  }
}

function goToDefaultMonth() {
  console.log('goToDefaultMonth called')
  // Always get the current date when function is called
  const currentDate = new Date()
  const currentMonth = {
    month: currentDate.getMonth() + 1,
    year: currentDate.getFullYear()
  }
  console.log('Current month calculated:', currentMonth)
  console.log('Previous displayed date:', displayedDate.value)
  
  // Update the today highlight to current date
  attributes.value = [
    {
      key: 'today',
      highlight: {
        color: 'blue',
        fillMode: 'solid'
      },
      dates: new Date() // Always current date
    }
  ]
  
  // Force reactivity by creating a completely new object
  displayedDate.value = { ...currentMonth }
  
  console.log('New displayed date:', displayedDate.value)
  console.log('Updated attributes for today:', attributes.value)
  
  // Force the calendar to update using multiple approaches
  nextTick(() => {
    if (calendarRef.value) {
      // Try to force the calendar to move to the new date
      calendarRef.value.move(currentMonth)
      console.log('Calendar move called with:', currentMonth)
    }
    
    // Also force re-render by updating the key
    calendarKey.value++
    console.log('Calendar key updated to:', calendarKey.value)
    
    // Re-attach the title click listener after re-render with longer delay
    setTimeout(() => {
      attachTitleClickListener(0)
    }, 500) // Increased delay to 500ms
  })
}

function handleCalendarClick(event) {
  console.log('Calendar clicked:', event.target)
  console.log('Clicked element classes:', event.target.className)
  // Check if the clicked element is the title or inside the title
  const titleElement = event.target.closest('.vc-title')
  console.log('Title element found:', titleElement)
  if (titleElement) {
    console.log('Title clicked! Preventing default and calling goToDefaultMonth')
    event.preventDefault()
    event.stopPropagation()
    goToDefaultMonth()
  }
}

// Alternative: Try direct title click handler
onMounted(() => {
  console.log('Component mounted, setting up title click handlers')
  
  // Initial attachment
  attachTitleClickListener()
  
  // Also add a mutation observer to handle dynamic title changes
  const observer = new MutationObserver(() => {
    console.log('Mutation observed, checking for title element')
    attachTitleClickListener()
  })
  
  // Observe changes in the calendar container
  setTimeout(() => {
    const calendarContainer = document.querySelector('.vc-container')
    console.log('Calendar container found:', calendarContainer)
    if (calendarContainer) {
      observer.observe(calendarContainer, { childList: true, subtree: true })
      console.log('Mutation observer set up')
    }
  }, 500)
})
</script>

<style scoped>
.calendar-fixed {
  position: fixed;
  top: 85px;
  right: 70px;
  z-index: 20;
  margin-right: 50px;
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
}

@media screen and (max-width: 1200px) {
  .calendar-fixed {
    display: none;
  }
}
.search-menu-row {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  gap: 0.5rem;
  margin-bottom: 30px;
}

.search-bar {
  width: 150px;
}

.search-bar-full-width {
  width: 270px !important;
}

.create-btn-margin {
  margin-left: 0.5rem;
}
.create-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.68rem 1rem;
  padding-bottom: 0.56rem;
  background: #23242a;
  border: 1px solid #3d3e46;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background 0.2s;
}
.create-btn:hover {
  background: #2d2e35;
}
.create-btn svg {
  width: 20px;
  height: 20px;
}
a {
  text-decoration: none !important;
}
span {
  font-size: 1.1rem;
  color: #727171;

}

:deep(.vc-container) {
  background: #18191a !important;
  color: #fff !important;
  font-family: inherit;
  border-radius: 15px;
  padding: 5px 12px;
  box-shadow: 0 2px 8px #0002;
  border: 1px solid #3d3e46 !important;
  margin-bottom: 10px;
  width: 300px;
  height: 310px;
}

/* Title styling - clickable to go to today */
:deep(.vc-title) {
  color: #fff !important;
  font-size: 1em;
  font-family: inherit;
  background: none !important;
  border-radius: 30px;
  margin: 0 36px;
  text-align: center;
  padding: 2px 20px;
  letter-spacing: 0.02em;
  border: none !important;
  cursor: pointer !important;
  user-select: none; /* Prevent text selection */
}

:deep(.vc-title):active {
  background: #1a1b20 !important;
  transform: scale(0.98);
}

/* Arrow styling */
:deep(.vc-arrows) {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  margin: 0;
  padding: 0 12px;
}

:deep(.vc-arrow) {
  background: none !important;
  border: none !important;
  color: #fff !important;
  font-size: 1.5em !important;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s;
  outline: none !important;
}

:deep(.vc-arrow:disabled) {
  color: #888 !important;
  background: none !important;
}

:deep(.vc-arrow:hover:not(:disabled)) {
  background: #23242a !important;
}

:deep(.vc-arrow:focus) {
  outline: none !important;
  box-shadow: none !important;
  border: none !important;
}

:deep(.vc-arrow:active) {
  outline: none !important;
  box-shadow: none !important;
  border: none !important;
}

/* Weekdays */
:deep(.vc-weekdays) {
  color: #7ecfff !important;
  font-size: 1em;
  background: none !important;
  margin: 2px -1px;
  letter-spacing: 0.05em;
}

/* Date styling - hoverable but not selectable */
:deep(.vc-day) {
  cursor: default !important;
  pointer-events: auto !important;
}

:deep(.vc-day-content) {
  color: #fff !important;
  font-size: 1.1em;
  border-radius: 50% !important;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  transition: background 0.2s, color 0.2s;
  cursor: default !important;
  pointer-events: none !important;
}

:deep(.vc-day-content.vc-highlight-content) {
  background: #7ecfff !important;
  color: #fff !important;
  border-radius: 50% !important;
}

:deep(.vc-day:hover .vc-day-content) {
  background: #23242a !important;
  color: #fff !important;
}

/* Disable selection styling */
:deep(.vc-day.is-selected) {
  background: none !important;
}

:deep(.vc-day.is-selected .vc-day-content) {
  background: none !important;
  color: #fff !important;
}

:deep(.vc-day.is-selected .vc-day-content.vc-highlight-content) {
  background: #7ecfff !important;
  color: #fff !important;
}

/* Hide popover completely */
:deep(.vc-popover-content) {
  display: none !important;
  pointer-events: none !important;
  opacity: 0 !important;
  visibility: hidden !important;
}

.calendar-logo-container {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 18px;
  margin-top: 0;
  height: 100px;
}
.calendar-logo-img {
  height: 100px;
  width: auto;
  object-fit: contain;
  transition: opacity 0.3s, transform 0.3s;
}
.fade-slide-enter-active, .fade-slide-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}
.fade-slide-enter-from, .fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
.fade-slide-enter-to, .fade-slide-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>