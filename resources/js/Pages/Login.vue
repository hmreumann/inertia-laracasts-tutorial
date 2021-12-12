<template>
  <Head title="Login" />

  <main class="grid place-items-center min-h-screen">
      <section class="bg-white max-w-md p-8 mx-auto border">
          <h1 class="text-3xl">Login</h1>
          <form @submit.prevent="submit" >
            <div class="mt-6">
              <label
                class="block mb-2 uppercase font-bold text-xs text-gray-700"
                for="email"
              >
                Email
              </label>
              <input v-model="form.email"
                class="border border-gray-400 p-2 w-full"
                type="email"
                name="email"
                id="email"
              />
              <div v-if="form.errors.email" v-text="form.errors.email" class="text-sm text-red-500 mt-1"></div>
            </div>
            <div class="mt-6">
              <label
                class="block mb-2 uppercase font-bold text-xs text-gray-700"
                for="password"
              >
                Password
              </label>
              <input v-model="form.password"
                class="border border-gray-400 p-2 w-full"
                type="password"
                name="password"
                id="password"
              />
              <div v-if="form.errors.password" v-text="form.errors.password" class="text-sm text-red-500 mt-1"></div>
            </div>
            <div class="mt-6">
              <button
                type="submit"
                class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                :disabled="form.processing"
              >
                Login
              </button>
            </div>
          </form>
      </section>
  </main>

</template>
<script>
export default {
    layout: null
};
</script>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';

defineProps({
    errors: Object,
});

let form = useForm({
  email: "",
  password: "",
});

function submit() {
    form.post('/login');
}
</script>
