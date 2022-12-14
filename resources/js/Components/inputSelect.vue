<template lang="">
    <div class="form-control">
        <label class="label" v-if="title">
            <span class="label-text">{{ title }}</span>
        </label>
        <select
            class="select select-bordered w-full select-sm"
            :value="inputValue"
            @input="$emit('update:inputValue', $event.target.value)"
            :placeholder="`Masukkan ${title}`"
        >
            <option v-for="item in dataSelect" :value="item.id">
                {{ item.nama }}
            </option>
        </select>
        <transition name="list">
            <label class="label" v-if="error">
                <span class="label-text-alt text-error">{{ error }}</span>
            </label>
        </transition>
    </div>
</template>
<script>
export default {
    props: ["inputValue", "error", "title", "dataSelect"],
};
</script>
<style lang=""></style>
