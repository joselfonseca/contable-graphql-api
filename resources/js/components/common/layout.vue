<template>
  <div class="bg-gray-100">
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </div>
    </header>
    <main class="container mx-auto h-full">
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <slot name="content"></slot>
      </div>
    </main>
  </div>
</template>
<script>
export default {
  name: 'layout'
}
</script>
