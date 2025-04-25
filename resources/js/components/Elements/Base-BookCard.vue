<script setup>
import { RouterLink } from 'vue-router';

const props = defineProps({
  book: {
    type: Object,
    required: true,
  }
});
</script>

<template>
  <RouterLink :to="`/book/${book.id}`" class="block">
    <div class="p-4 rounded-xl bg-card-bg flex gap-4 w-full transition-all duration-200 hover:shadow-md">
      <!-- Book Cover Image -->
      <div class="w-20 h-28 rounded-lg overflow-hidden flex-shrink-0">
        <img :src="book.coverUrl" :alt="book.title" class="w-full h-full object-cover" />
      </div>
      
      <!-- Book Details -->
      <div class="flex flex-col justify-between flex-grow">
        <div>
          <h3 class="font-medium text-lg text-text-default">{{ book.title }}</h3>
          <p class="text-sub-text-lighter text-sm">{{ book.author }}</p>
        </div>
        
        <!-- Status Badge -->
        <div class="mt-2">
          <span 
            class="px-3 py-1 rounded-full text-sm inline-block" 
            :class="{
              'bg-green-100 text-green-700': book.status === 'Read',
              'bg-badge-bg text-badge-text': book.status === 'Pending',
              'bg-rose-200 text-rose-600': book.status === 'To-read'
            }"
          >
            {{ book.status }}
          </span>
        </div>
      </div>
      
      <!-- Bookmark icon placeholder - removed as per instructions -->
    </div>
  </RouterLink>
</template>

<style scoped>
/* Using CSS variables from the root to support dark and light mode */
.bg-card-bg {
  background-color: var(--card-bg);
}

.text-text-default {
  color: var(--text-default);
}

.text-sub-text-lighter {
  color: var(--sub-text-lighter);
}

/* Status badge styles */
.bg-badge-bg {
  background-color: var(--badge-bg);
}

.text-badge-text {
  color: var(--badge-text);
}
</style>