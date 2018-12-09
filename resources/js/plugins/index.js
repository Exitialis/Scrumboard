import Vue from 'vue';

const files = require.context("./", false, /\.js$/);

files.keys().forEach(key => {
  if (key === "./index.js") return;
  let plugin = {
    name: key.replace(/^\.\//, "").replace(/\.js$/, ""),
    install: files(key).install
  };
  if (plugin.hasOwnProperty("init")) plugin.init();
  if (plugin.install) {
    Vue.use(plugin);
  }
});

export default {};
