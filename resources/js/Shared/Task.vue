<template>
    <div :id="id" class="bg-indigo-700 text-white my-2 p-3 rounded">
        <div class="flex justify-between">
            <p class="text-2xl">{{task.name}}</p>
            <div class="flex">
                <button @click="showModal=!showModal" class="mr-4">Edit</button>
                <button @click="removeTask">Remove</button>
            </div>
        </div>

        <div class="container">
            <p class="mt-4" v-html="task.description" style="white-space: pre-wrap;"></p>
            <div class="flex flex-row justify-between">
                <p class="mt-4">Status: {{task.state}}</p>
                <p class="mt-4" v-if="viewAll">Belongs to: {{task.username}}</p>
            </div>

        </div>

        <transition name="fade">
            <div v-if="showModal" class="fixed top-0 left-0 w-full h-full justify-center flex bg-indigo-700 items-center">
                <form class="my-4 align-middle container lg:mx-48 xl:mx-56" @submit.prevent="editTask">
                    <div class="w-100 flex justify-between items-center">
                        <p class="text-white text-3xl">Edit Task</p>
                        <p class="text-white text-3xl cursor-pointer pl-1 py-1 hover:text-gray-300" @click="showModal = !showModal">&times;</p>
                    </div>

                    <div class="my-3 p-5 rounded bg-white flex flex-wrap -mx-2">
                        <text-input :errors="$page.errors.name" v-model="form.name" label="Name" class="mb-3 w-full lg:w-1/2 px-2" type="text" autofocus autocapitalize="off"/>
                        <select-input :errors="$page.errors.status " v-model="form.status" class="w-full lg:w-1/2 px-2" label="Status">
                            <option disabled selected value="">Status</option>
                            <option value="0">To do</option>
                            <option value="1">Doing</option>
                            <option value="2">Done</option>
                            <option value="3">Aborted</option>
                        </select-input>
                        <TextareaInput :errors="$page.errors.description"  v-model="form.description" label="Description" class="px-2 mt-3 w-full" type="text" autofocus autocapitalize="off"/>
                        <div class="px-2 pt-4 bg-grey-lightest flex justify-end items-end w-full">
                            <loading-button :loading="sending" class="btn-indigo" type="submit">Save</loading-button>
                        </div>
                    </div>

                </form>
            </div>
        </transition>

    </div>
</template>

<script>
import TextInput from './TextInput'
import LoadingButton from './LoadingButton'
import SelectInput from './SelectInput'
import TextareaInput from './TextareaInput'

export default {
  components: {
    SelectInput,
    LoadingButton,
    TextInput,
    TextareaInput
  },
  inheritAttrs: false,
  data: () => ({
    showModal: false,
    sending: false,
    form: {
      name: null,
      description: null,
      status: null,
    },
  }),
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
    },
    viewAll: Boolean
  },
  mounted() {
    this.form.name = this.task.name
    this.form.description = this.task.description
    this.form.status = this.task.status
    this.form.id = this.task.id
  },
  methods: {
    editTask() {
      this.sending = true
      this.$inertia.post(this.route('tasks.edit'), {
        id: this.form.id,
        name: this.form.name,
        description: this.form.description,
        status: this.form.status,
      }).then(() =>
      {
        this.sending = false
        this.showModal = false
        let message = this.$page.toast
        if(message) {
          this.$toasted.show(this.$page.toast, {
            theme: 'toasted-primary',
            position: 'top-right',
            icon : 'ballot',
            duration : 5000
          })
        }
      })
    },
    removeTask() {
      this.$inertia.post(this.route('tasks.delete'), {
        id:this.task.id
      }).then(() => {
        let message = this.$page.toast
        if(message) {
          this.$toasted.show(this.$page.toast, {
            theme: 'toasted-primary',
            position: 'top-right',
            icon : 'adjust',
            duration : 5000
          })
        }
      })
    },
  },
}
</script>

<style scoped>

</style>
