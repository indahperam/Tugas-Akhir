<template lang="">
    <button
        class="btn select-none"
        @click="notifikasi('success', 'pesan sukses')"
    >
        Sukses
    </button>
    <button
        class="btn select-none"
        @click="notifikasi('warning', 'pesan warning')"
    >
        warning
    </button>
    <button class="btn select-none" @click="notifikasi('error', 'pesan error')">
        error
    </button>
</template>
<script>
import LayoutMain from "@/Layouts/LayoutMain.vue";
export default {
    layout: LayoutMain,
    beforeMount() {},
};
</script>
<style lang=""></style>
