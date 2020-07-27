process.stdin.setEncoding('utf8');
let domInline = '';

process.stdin.on('readable', () => { //We will see later how Symfony communicates on this input
    let chunk;

    // Use a loop to make sure we read all available data.
    while ((chunk = process.stdin.read()) !== null) {
        domInline += chunk;
    }
});

const nodeRenderer = require('vue-server-renderer').createRenderer()



process.stdin.on('end', () => {
    const JSDOM = require('jsdom').JSDOM
    const virtualDom = new JSDOM(domInline.toString())

    global.document = virtualDom.window.document

    const Vue = require('vue');
    const app = new Vue({
        template: virtualDom.window.document.getElementById('vue').outerHTML
    })


    nodeRenderer.renderToString(app, (err, renderedHTML) => {
        const appEL = document.getElementById("vue");

        appEL.parentElement.innerHTML = renderedHTML

        process.stdout.write(document.documentElement.outerHTML);
    });
})