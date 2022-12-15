<template lang="">
    <div class="flex flex-col gap-2">
        <div class="flex justify-between gap-2 items-center">
            <div class="flex">
                <input
                    type="text"
                    class="input input-sm input-bordered shadow-md"
                    placeholder="Cari"
                    :value="inputSearch"
                    @input="
                        $emit('update:inputSearch', $event.target.value),
                            loading_state()
                    "
                />
            </div>
            <div class="flex justify-center gap-4" v-if="inputDate">
                <div class="flex gap-2 items-center">
                    <label class="label">Dari</label>
                    <input
                        :value="dateStart"
                        type="date"
                        class="input input-bordered input-sm"
                        @change="$emit('update:dateStart', $event.target.value)"
                    />
                </div>
                <div class="flex gap-2 items-center">
                    <label class="label">Sampai</label>
                    <input
                        :value="dateEnd"
                        type="date"
                        class="input input-bordered input-sm"
                        @change="$emit('update:dateEnd', $event.target.value)"
                    />
                </div>
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
        <div class="flex justify-center" v-if="dataTotal == 0">
            Tidak Ada Data
        </div>
        <div class="flex justify-center p-4">
            <div class="btn-group shadow-lg">
                <template
                    v-for="(item, index) in dataPage"
                    :key="index"
                    v-if="dataTotal > inputShow"
                >
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
        inputDate: Boolean,
        dateStart: String,
        dateEnd: String,
    },
    data() {
        return {
            showPage: this.inputShow,
        };
    },
};
</script>
<style lang=""></style>
