<template lang="">
    <teleport :to="location ? location : 'body'">
        <input type="checkbox" :id="id" class="modal-toggle" />
        <div class="modal z-40">
            <div
                class="modal-box scrollbar-thin scrollbar-thumb-primary scrollbar-track-gray-100 w-screen max-w-5xl"
            >
                <h3 class="font-bold text-lg capitalize">
                    <slot name="title"></slot>
                </h3>
                <div class="py-4">
                    <slot name="content"></slot>
                </div>
                <div class="modal-action">
                    <slot name="action"></slot>
                    <label :for="id" class="btn">close</label>
                </div>
            </div>
        </div>
    </teleport>
</template>
<script>
export default {
    props: {
        id: String,
        location: String,
    },
};
</script>
<style lang=""></style>
