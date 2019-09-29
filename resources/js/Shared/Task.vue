<template>
    <div :id="id" class="bg-indigo-700 text-white my-2 p-3 rounded">
        <div class="flex justify-between">
            <p class="text-2xl">{{task.name}}</p>
            <div class="flex">
                <button class="mr-4">Edit</button>
                <button>Remove</button>
            </div>
        </div>

        <div class="container">
            <p class="mt-4">{{task.description}}</p>
            <p class="mt-4">Status: {{task.state}}</p>
        </div>
    </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `task-${this._uid}`
      },
    },
    task: Object,
    errors: {
      type: Array,
      default: () => [],
    }
  },
}
</script>

<style scoped>

</style>
