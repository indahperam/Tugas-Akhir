<template lang="">
    <!-- The button to open modal -->
    <label
        :for="id"
        class="btn btn-sm btn-primary"
        :class="{ 'btn-success': type == 'success', 'btn-disabled': disabled }"
        v-if="title"
        >{{ title }}</label
    >
    <label
        :for="id"
        class="btn btn-sm btn-primary"
        :class="{ 'btn-disabled': disabled }"
        v-else
        ><i class="fa-solid fa-keyboard"></i
    ></label>

    <teleport :to="location ? location : 'body'">
        <input type="checkbox" :id="id" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box p-8">
                <div class="card shadow-lg">
                    <div class="card-body items-center">
                        <div class="card-title text-2xl" v-if="harga">
                            {{ rupiah(input ? input : 0) }}
                        </div>
                        <div class="card-title text-2xl" v-else>
                            {{ input ? input : 0 }}
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2 mt-9">
                    <button
                        class="btn btn-ghost text-lg shadow-md"
                        v-for="item in 9"
                        @click="button(item)"
                    >
                        {{ item }}
                    </button>
                    <button
                        class="btn btn-ghost text-lg shadow-md"
                        @click="button('clear')"
                    >
                        clear
                    </button>
                    <button
                        class="btn btn-ghost text-lg shadow-md"
                        @click="button(0)"
                    >
                        0
                    </button>
                    <button
                        class="btn btn-ghost text-lg shadow-md"
                        @click="button('delete')"
                    >
                        delete
                    </button>
                </div>
                <div class="modal-action">
                    <label :for="id" class="btn btn-primary" @click="simpan"
                        >simpan</label
                    >
                    <label :for="id" class="btn">close</label>
                </div>
            </div>
        </div>
    </teleport>
</template>
<script>
export default {
    props: [
        "keypadValue",
        "id",
        "harga",
        "min",
        "max",
        "title",
        "type",
        "location",
        "disabled",
    ],
    data() {
        return {
            input: this.keypadValue,
        };
    },
    watch: {
        input(baru) {
            if (this.min >= 0 && this.max >= 0) {
                if (baru < this.min) {
                    this.input = this.min;
                } else if (baru > this.max) {
                    this.input = this.max;
                }
            }
        },
    },
    methods: {
        button(data) {
            var input = this.input ? this.input : 0;
            if (data == "delete") {
                if (String(input).length < 2) {
                    input = 0;
                } else {
                    input = parseInt(String(input).slice(0, -1));
                }
            } else if (data == "clear") {
                input = 0;
            } else {
                if (input == 0) {
                    input = data;
                } else {
                    input = parseInt(String(input) + String(data));
                }
            }
            this.input = input;
        },
        simpan() {
            this.$emit("update:keypadValue", this.input);
        },
    },
};
</script>
<style lang=""></style>
