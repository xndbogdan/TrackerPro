<template>
  <div>
    <portal-target name="dropdown" slim />
    <div class="flex flex-col">
      <div class="min-h-screen flex flex-col" @click="hideDropdownMenus">
        <div class="bg-indigo-900 flex border-b justify-between items-center">
          <div class="w-full md:flex-no-shrink md:w-56 px-6 py-4 flex items-center justify-between md:justify-center">
            <inertia-link href="/">
              <logo/>
            </inertia-link>
            <dropdown class="md:hidden" placement="bottom-end">
              <svg class="fill-current text-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
              <div slot="dropdown" class="mt-2 px-8 py-4 shadow-lg bg-indigo-darker rounded">
                <main-menu />
              </div>
            </dropdown>
          </div>
          <div class="hidden md:block text-white p-4 md:py-0 md:px-12 text-sm md:text-base flex justify-between items-center">
            <div class="mr-4">{{ $page.auth.user.name }}</div>
            <dropdown placement="bottom-end">
              <div class="flex items-center cursor-pointer select-none group">
                <div class="text-grey-darkest group-hover:text-indigo-dark focus:text-indigo-dark mr-1 whitespace-no-wrap">
                  <span>{{ $page.auth.user.first_name }}</span>
                  <span class="hidden md:inline">{{ $page.auth.user.last_name }}</span>
                </div>
                <icon class="w-5 h-5 text-white fill-current " name="cheveron-down" />
              </div>
              <div slot="dropdown" class="mt-2 py-2 shadow-lg bg-white rounded text-sm">
<!--                <inertia-link class="block px-6 py-2 hover:bg-indigo-700 hover:text-white" :href="route('users.edit', $page.auth.user.id)">My Profile</inertia-link>-->
<!--                <inertia-link class="block px-6 py-2 hover:bg-indigo-700 hover:text-white" :href="route('users')">Manage Users</inertia-link>-->
                <inertia-link class="block px-6 py-2 hover:bg-indigo-700 hover:text-white" :href="route('logout')" method="post">Logout</inertia-link>
              </div>
            </dropdown>
          </div>
        </div>
        <div class="flex flex-grow">
          <div class="w-full overflow-hidden px-4 py-8 md:p-12">
<!--                <flash-messages />-->
              <div class="container mx-auto">
                  <slot/>
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown'
import FlashMessages from '@/Shared/FlashMessages'
import Icon from '@/Shared/Icon'
import Logo from '@/Shared/Logo'
import MainMenu from '@/Shared/MainMenu'

export default {
  components: {
    Dropdown,
    FlashMessages,
    Icon,
    Logo,
    MainMenu,
  },
  props: {
    title: String,
  },
  data() {
    return {
      showUserMenu: false,
      accounts: null,
    }
  },
  watch: {
    title: {
      immediate: true,
      handler(title) {
        document.title = title ? `${title} | TrackerPro` : 'TrackerPro'
      },
    },
  },
  updated() {
  },
  methods: {
    hideDropdownMenus() {
      this.showUserMenu = false
    },
  },
}
</script>
