<template>
  <Head>
      <title>My App</title>
  </Head>
  <section class="p-8 bg-gray-200">
    <header class="flex justify-between">
      <div class="flex items-center">
        <h1 class="text-2xl font-bold">My App</h1>
        <p class="text-sm ml-6">Welcome back, {{ username ?? 'Guest' }}!</p>
      </div>

      <Nav />
    </header>
  </section>
  <section class="p-8">
    <div class="max-w-3xl mx-auto">
      <slot />
    </div>
  </section>
</template>

<script>
import Nav from "../Shared/Nav";

export default {
  components: { Nav },

  computed: {
    username() {
        if (this.$page.props.auth != null) {
            return this.$page.props.auth.user.username;
        } else {
            return 'Guest';
        }
    },
  },
};
</script>
