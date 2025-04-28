<script setup>
import { computed } from 'vue';

const props = defineProps({
  status: {
    type: String,
    default: 'pending',
    validator: (value) => ['pending', 'to-read', 'read'].includes(value)
  }
});

const badgeText = computed(() => {
  if (props.status === 'read') return 'Read';
  if (props.status === 'to-read') return 'To-read';
  return 'Pending';
});

const badgeClasses = computed(() => {
  if (props.status === 'read') return 'bg-green-200 text-green-800';
  if (props.status === 'to-read') return 'bg-red-200 text-red-800';
  return 'bg-blue-200 text-blue-800';
});
</script>

<template>
  <div 
    class="inline-block text-sm font-medium rounded-full px-4 py-1.5"
    :class="badgeClasses"
  >
    {{ badgeText }}
  </div>
</template>