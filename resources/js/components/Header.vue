<template>
  <div class="bg-gray-500 h-12 md:h-16">
    <header class="container mx-auto text-white relative z-10">
      <div
        class="flex justify-between items-center fixed w-full bg-gray-500 px-2 h-12 md:h-16"
      >
        <h1 class="text-2xl font-semibold md:text-4xl" @click="toHome">HR</h1>
        <div>
          <button @click="isOpen = !isOpen" class="focus:outline-none md:hidden">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
              <path
                v-show="!isOpen"
                d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"
              />
              <path
                v-show="isOpen"
                d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"
              />
            </svg>
          </button>
        </div>
        <!-- ハンバーガーメニューの開閉(app.css) -->
        <div :class="isOpen ? 'show-toggleMenu' : 'hidden-toggleMenu'">
          <ul
            class="md:flex md:justify-between md:items-center md:mr-1 md: m-auto lg:mr-0"
          >
            <li class="border-b md:mr-auto md:border-none">
              <router-link to="/" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded"
                >HRとは</router-link
              >
            </li>
            <li v-if="isLogined" class="border-b md:border-none">
              <a
                class="block px-8 py-2 my-4 hover:bg-gray-600 rounded cursor-pointer"
                @click.native="logout"
                >ログアウト</a
              >
            </li>
            <li v-else class="border-b md:border-none">
              <router-link
                to="/login"
                class="block px-8 py-2 my-4 hover:bg-gray-600 rounded"
                >ログイン</router-link
              >
            </li>
            <li class="border-b md:border-none">
              <router-link to="/" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded"
                >料金プラン</router-link
              >
            </li>
            <li class="border-b md:border-none">
              <router-link to="/" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded"
                >お知らせ</router-link
              >
            </li>
            <li>
              <div class="my-8 text-center md:my-4">
                <router-link
                  to="/"
                  class="px-6 py-2 bg-orange-500 hover:bg-orange-400 rounded-full"
                  >お問い合わせ</router-link
                >
              </div>
            </li>
          </ul>
        </div>
      </div>
    </header>
  </div>
</template>
<script>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
export default {
  setup() {
    const router = useRouter();
    const store = useStore();

    const isOpen = ref(false);
    const user = ref([]);

    // ログイン状態をVuexより取得
    const isLogined = computed(() => store.state.isLogined);

    // ハンバーガーメニューの表示/非表示
    const toggleNav = () => (isOpen.value = !isOpen.value);

    // ホーム画面へ遷移
    const toHome = () => router.push("/");

    // ログアウト処理
    const logout = async () => {
      await axios
        .post("/api/logout", {})
        .then((res) => {
          if ((res.data.status_code = 200)) {
            router.push("/");
            // ログイン状態を変更するためVuexより呼び出し
            store.dispatch("loginState");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    };

    return { isOpen, isLogined, user, toggleNav, toHome, logout };
  },
};
</script>

<style></style>
