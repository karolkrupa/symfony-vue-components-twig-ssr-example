# Symfony Twig + Vue components SSR (V8js/node) example

This is example of implementation server side rendering vue components in
twig based on V8js (rendering in V8js is much faster than rendering in node.
v8js renders the content within 30 ms, when the node taking about 300+ ms)

## Usage

```bash
# build server side bundle
$ npx webpack --config ssr.webpack.js --target node

# build client side bundle
$ yarn encore dev
```

#### Client side bundle

The most important thing is we have to update template string in client 
side script before building `assets/vue/vue.js`

A good solution would be to insert the template in the html script tag as global
javascript variable. We must remember that the template should be 
passed to the client-side script after rendering in javascript it must be 
identical to the template inserted on the server to avoid warning 
about vue template mismatch