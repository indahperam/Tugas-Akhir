<template lang="">
    <div class="form-control">
        <label class="label" v-if="title">
            <span class="label-text">{{ title }}</span>
        </label>
        <input
            type="password"
            class="input input-bordered input-sm"
            :value="inputValue"
            @input="$emit('update:inputValue', $event.target.value)"
            :placeholder="`Masukkan ${title}`"
        />
        <transition name="list">
            <label class="label" v-if="error">
                <span class="label-text-alt text-error">{{ error }}</span>
            </label>
        </transition>
    </div>
</template>
<script>
export default {
    props: ["inputValue", "error", "title"],
};
</script>
<style lang=""></style>
