<template>
    <div>
        <h1 class="mb-8 font-bold text-4xl">Dashboard</h1>
        <div class="w-full flex items-center flex-wrap">
            <button class="bg-indigo-700 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded"
                    @click="showModal = !showModal"
            >
                New Task
            </button>
            <p class="ml-5">Tasks: <span v-html="$page.auth.user.tasks.length"/></p>
            <div v-if="$page.auth.user.is_admin" class="w-full md:w-auto md:ml-5 mt-3 md:mt-0">
                <label for="viewAll">View all tasks</label>
                <input type="checkbox" v-model="viewAll" id="viewAll" class="ml-1"/>
            </div>

        </div>
        <div class="w-full">
            <transition name="fade">
                <div v-if="showModal"
                     class="fixed top-0 left-0 w-full h-full justify-center flex bg-indigo-700 items-center"
                >
                    <form class="my-4 align-middle container lg:mx-48 xl:mx-56" @submit.prevent="newTask">
                        <div class="w-100 flex justify-between items-center">
                            <p class="text-white text-3xl">New Task</p>
                            <p class="text-white text-3xl cursor-pointer pl-1 py-1 hover:text-gray-300"
                               @click="showModal = !showModal"
                            >
                                &times;
                            </p>
                        </div>

                        <div class="my-3 p-5 rounded bg-white flex flex-wrap -mx-2">
                            <text-input v-model="form.name" :errors="$page.errors.name" label="Name"
                                        class="mb-3 w-full lg:w-1/2 px-2" type="text" autofocus autocapitalize="off"
                            />
                            <select-input v-model="form.status" :errors="$page.errors.status " label="Status"
                                          class="w-full lg:w-1/2 px-2"
                            >
                                <option disabled selected value="">Status</option>
                                <option value="0">To do</option>
                                <option value="1">Doing</option>
                                <option value="2">Done</option>
                                <option value="3">Aborted</option>
                            </select-input>
                            <TextareaInput v-model="form.description" :errors="$page.errors.description"
                                           label="Description" class="mt-3 px-2 w-full" type="text" autofocus
                                           autocapitalize="off"
                            />
                            <div class="pt-4 bg-grey-lightest flex justify-end items-end px-2 w-full">
                                <loading-button :loading="sending" class="btn-indigo" type="submit">
                                    Save
                                </loading-button>
                            </div>
                        </div>
                    </form>
                </div>
            </transition>
        </div>
        <div class="mt-5">
            <task v-if="!viewAll" v-for="task in $page.auth.user.tasks" :key="task.id" :task="task"
                  :view-all="viewAll"/>
            <task v-else v-for="task in $page.tasks" :key="task.id" :task="task" :view-all="viewAll"/>
        </div>
    </div>
</template>

<script>
  import Layout from '@/Shared/Layout'
  import TextInput from '../../Shared/TextInput'
  import LoadingButton from '../../Shared/LoadingButton'
  import SelectInput from '../../Shared/SelectInput'
  import TextareaInput from '../../Shared/TextareaInput'
  import Task from '../../Shared/Task'

  export default {
    metaInfo: {title: 'Dashboard'},
    layout: (h, page) => h(Layout, [page]),
    components: {
      SelectInput,
      LoadingButton,
      TextInput,
      TextareaInput,
      Task,
    },
    data: () => ({
      showModal: false,
      sending: false,
      viewAll: false,
      form: {
        name: null,
        description: null,
        status: null,
      },
    }),
    updated() {
      if (this.$page.errors.name || this.$page.errors.description || this.$page.errors.status) {
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
        }).then(() => {
          this.sending = false
          this.showModal = false
        })
      },
    },
  }
</script>
<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s, background-color .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }
</style>
