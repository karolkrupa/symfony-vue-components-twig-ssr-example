import Vue from 'vue'
import TestComponent from "./TestComponent.vue";

let vm = new Vue({
    template: PHP.html,

    components: {
        TestComponent
    }
})

renderVueComponentToString(vm, (err, res) => {
    print(res)
})