<template lang="">
    <div class="flex flex-col gap-2">
        <div class="flex justify-between gap-2 items-center">
            <div class="flex">
                <input
                    type="text"
                    class="input input-sm input-bordered shadow-md"
                    placeholder="Cari"
                    :value="inputSearch"
                    @input="$emit('update:inputSearch', $event.target.value),loading_state()"
                />
            </div>
            <div class="flex gap-7 items-center">
                <div class="">Total Item : {{ dataTotal }}</div>
                <div class="flex gap-2 items-center">
                    <div>Tampilkan</div>
                    <select
                        class="select select-sm select-bordered w-max"
                        v-model="showPage"
                        @change="$emit('update:inputShow', $event.target.value)"
                    >
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
        </div>
        <slot name="content"></slot>
        <div class="flex justify-center p-4">
            <div class="btn-group shadow-lg">
                <template v-for="(item, index) in dataPage" :key="index">
                    <Link
                        :href="item.url"
                        class="btn btn-sm no-animation"
                        :class="{
                            'btn-active': item.active,
                            'btn-disabled': item.url == null,
                        }"
                        v-html="item.label"
                    ></Link>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        dataPage: Array,
        dataTotal: Number,
        inputSearch: String,
        inputShow: Number,
    },
    data() {
        return {
            showPage: this.inputShow,
        };
    },
};
</script>
<style lang=""></style>
