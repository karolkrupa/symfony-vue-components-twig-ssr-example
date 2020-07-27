import Vue from 'vue'
import TestComponent from "./TestComponent";

 let vm = new Vue({
     template: "<div id=\"vue-app\">\n" +
         "    <div class=\"example-wrapper\" id=\"vue\">\n" +
         "        <test-component></test-component>\n" +
         "        <h1>Hello DefaultController! ✅</h1>\n" +
         "\n" +
         "        This friendly message is coming from:\n" +
         "    </div>\n" +
         "</div>",
     components: {
         TestComponent
     }
})

vm.$mount('#vue-app')

