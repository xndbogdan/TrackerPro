<template>
  <div>
<!--    <div class="mb-4">-->
<!--      <inertia-link class="block px-6 py-2 hover:bg-indigo hover:text-white" :href="route('users.edit', $page.auth.user.id)">My Profile</inertia-link>-->
<!--    </div>-->
<!--    <div class="mb-4">-->
<!--      <inertia-link class="block px-6 py-2 hover:bg-indigo hover:text-white" :href="route('users')">Manage Users</inertia-link>-->
<!--    </div>-->
    <div class="mb-0">
      <inertia-link class="block px-6 py-2 hover:bg-indigo-700 hover:text-white" :href="route('logout')" method="post">Logout</inertia-link>
    </div>
  </div>
</template>

<script>

export default {
  components: {

  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return location.pathname.substr(1) === ''
      }

      return urls.filter(url => location.pathname.substr(1).startsWith(url)).length
    },
  },
}
</script>
