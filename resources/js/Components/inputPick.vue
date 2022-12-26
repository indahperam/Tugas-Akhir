<template lang="">
    <div class="relative">
        <input
            type="text"
            placeholder="cari.."
            class="input input-sm shadow-md max-w-[20rem] z-0"
            v-model="cari"
        />
        <div
            v-if="show_data"
            class="absolute z-10 bg-base-300 h-max p-1 max-h-[14rem] scrollbar-thin scrollbar-track-base-300 scrollbar-thumb-primary overflow-y-auto w-[40rem] shadow-md mt-2"
        >
            <transition-group
                name="listv2"
                tag="ul"
                class="menu bg-base-100 w-full menu-compact z-10"
            >
                <li
                    v-for="(item, index) in data_filter"
                    :key="item.kode"
                    @click="change_pick(item)"
                >
                    <a class="flex justify-between" v-if="member">
                        <div class="">{{ item.kode }}</div>
                        <div class="">{{ item.nama }}</div>
                        <div class="">{{ item.kontak }}</div>
                    </a>
                    <a
                        class="flex justify-between"
                        :class="item.stok < 1 ? 'bg-base-300 opacity-50' : null"
                        v-else
                    >
                        <div class="">{{ item.kode }}</div>
                        <div>{{ item.nama }}</div>
                        <div class="">
                            {{ rupiah(supplier?item.harga_beli:item.harga_jual) }} /
                            {{ item.satuan.nama }}
                        </div>
                        <div class="">Stok : {{ item.stok }}</div>
                    </a>
                </li>
            </transition-group>
        </div>
    </div>
</template>
<script>
export default {
    props: ["dataPick", "dataSelect", "member", 'supplier'],
    data() {
        return {
            cari: "",
            show_data: false,
            pick_data: null,
        };
    },
    watch: {
        cari(data) {
            data.length >= 1
                ? (this.show_data = true)
                : (this.show_data = false);
        },
        pick_data(baru, lama) {
            this.$emit("update:dataSelect", baru);
            this.pick_data = null;
            this.cari = "";
        },
    },
    computed: {
        data_filter() {
            var data_filter = this.dataPick.filter((items) => {
                var data = JSON.stringify(items).toLowerCase();
                return data.includes(this.cari.toLowerCase());
            });
            return data_filter.slice(0, 10);
        },
    },
    methods: {
        change_pick(data) {
            if (this.member) {
                this.pick_data = data;
            } else {
                if (data.stok > 0) {
                    this.pick_data = data;
                }
            }
        },
    },
};
</script>
<style lang=""></style>
