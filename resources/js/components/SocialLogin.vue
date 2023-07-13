<template>
  <div>
    <!-- Social login buttons -->
    <a
      class="mb-3 flex w-full items-center justify-center rounded bg-red-500 px-7 pb-2.5 pt-3 text-center text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-red-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-red-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-red-600 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
      role="button"
      data-te-ripple-init
      data-te-ripple-color="light"
      @click="toGoogleLoginPage"
    >
      <!-- Google -->
      <i class="fa-brands fa-google mr-2"></i>
      グーグルで登録する
    </a>
  </div>
</template>

<script>
import { useRouter } from "vue-router";
export default {
  setup() {
    const router = useRouter();

    // Googleログインページに遷移
    const toGoogleLoginPage = () => {
      // api.webにてroute指定しているため「api/」が必要
      axios
        .get(`${import.meta.env.VITE_APP_API_LOGIN_URL}/google`)
        .then((res) => {
          // tokenなどがランダムなため直接指定で遷移
          window.location.href = res.data.redirectUrl;
        })
        .catch((err) => {
          router.push("/login");
        });
    };

    return { toGoogleLoginPage };
  },
};
</script>

<style></style>
