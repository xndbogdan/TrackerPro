<template>
    <div class="p-6 bg-indigo-900 min-h-screen flex justify-center items-center">
        <div class="w-full max-w-sm">
            <div class="flex justify-center">
                <logo/>
            </div>

            <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
                <div class="px-10 py-12">
                    <h1 class="text-center font-bold text-3xl">Join us!</h1>
                    <div class="mx-auto my-3 w-24 border-b-2"/>
                    <p class="text-gray-600">It's easy to create an account. Just enter the details below, and you're ready to go!</p>
                    <text-input v-model="form.email" :errors="$page.errors.email" class="mt-5" label="Email"
                                type="email" autofocus autocapitalize="off"/>
                    <text-input v-model="form.fname" :errors="$page.errors.fname" class="mt-5" label="First Name"
                                type="text" autofocus autocapitalize="off"/>
                    <text-input v-model="form.lname" :errors="$page.errors.lname" class="mt-5" label="Last Name"
                                type="text" autofocus autocapitalize="off"/>
                    <text-input v-model="form.password" :errors="$page.errors.password" class="mt-5" label="Password" type="password"/>
                    <text-input v-model="form.confirm_pass" :errors="$page.errors.confirm_pass" class="mt-5" label="Confirm password" type="password"/>
                </div>
                <div class="px-10 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-center items-center">
                    <loading-button :loading="sending" class="btn-indigo" type="submit">Register</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import LoadingButton from '@/Shared/LoadingButton'
  import Logo from '@/Shared/Logo'
  import TextInput from '@/Shared/TextInput'

  export default {
    components: {
      LoadingButton,
      Logo,
      TextInput,
    },
    props: {
      errors: Object,
    },
    data() {
      return {
        sending: false,
        form: {
          email: null,
          password: null,
          remember: null,
          fname: null,
          lname:null,
          confirm_pass:null
        },
      }
    },
    mounted() {
      document.title = 'Register | TrackerPro'
    },
    methods: {
      submit() {
        this.sending = true
        this.$inertia.post(this.route('register.attempt'), {
          email: this.form.email,
          first_name: this.form.fname,
          last_name: this.form.lname,
          password: this.form.password,
          password_confirm: this.form.confirm_pass
        }).then(() => this.sending = false)
      },
    },
  }
</script>
