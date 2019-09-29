<template>
  <layout title="Dashboard">
    <h1 class="mb-4 font-bold text-3xl">Dashboard</h1>
    <p class="mb-2 leading-normal">Hey there! Welcome to ProTracker, a demo app designed to help illustrate how <a class="text-indigo underline hover:text-orange-dark" href="https://github.com/inertiajs">Inertia.js</a> works.</p>
    <div class="w-full flex items-center">
        <button class="bg-indigo-700 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded" @click="showModal = !showModal">
            New Task
        </button>
        <p class="ml-5">Tasks: <span v-html="$page.auth.user.tasks.length"></span></p>
    </div>
    <div class="w-full">
        <transition name="fade">
            <div v-if="showModal" class="fixed top-0 left-0 w-full h-full justify-center flex bg-indigo-700 items-center">
                <form class="my-4 align-middle container" @submit.prevent="newTask">
                    <div class="w-100 flex justify-between">
                        <p class="text-white text-3xl">New Task</p>
                        <p class="text-white text-3xl cursor-pointer px-5" @click="showModal = !showModal">X</p>
                    </div>

                    <div class="my-5 p-5 rounded bg-white">
                        <text-input :errors="$page.errors.name" v-model="form.name" label="Name" class="mb-3" type="text" autofocus autocapitalize="off"/>
                        <TextareaInput :errors="$page.errors.description"  v-model="form.description" label="Description" class="mb-3" type="text" autofocus autocapitalize="off"/>
                        <select-input :errors="$page.errors.status " v-model="form.status" label="Status">
                            <option disabled selected value="">Status</option>
                            <option value="0">To do</option>
                            <option value="1">Doing</option>
                            <option value="2">Done</option>
                            <option value="3">Aborted</option>
                        </select-input>
                        <div class="pt-4 bg-grey-lightest flex justify-end items-end">
                            <loading-button :loading="sending" class="btn-indigo" type="submit">Save</loading-button>
                        </div>
                    </div>

                </form>
            </div>

        </transition>
    </div>
    <div>
        <task v-for="task in $page.auth.user.tasks" :key="task.id" :task="task" ></task>
    </div>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '../../Shared/TextInput'
import LoadingButton from '../../Shared/LoadingButton'
import SelectInput from '../../Shared/SelectInput'
import TextareaInput from '../../Shared/TextareaInput'
import Task from '../../Shared/Task'
export default {
  components: {
    SelectInput,
    LoadingButton,
    TextInput,
    Layout,
    TextareaInput,
    Task
  },
  data: () => ({
    showModal: false,
    sending: false,
    form: {
      name: null,
      description: null,
      status: null,
    },
  }),
  updated() {
    if(this.$page.errors.name || this.$page.errors.description || this.$page.errors.status) {
      this.showModal = true
    }
  },
  methods: {
    newTask() {
      this.sending = true
      this.$inertia.post(this.route('tasks.add'), {
        name: this.form.name,
        description: this.form.description,
        status: this.form.status,
      }).then(() =>
      {
        this.sending = false
        this.showModal = false
      })
    },
  }
}
</script>
<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s, background-color .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
