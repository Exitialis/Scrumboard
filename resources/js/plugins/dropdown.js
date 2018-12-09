export function install(Vue) {
  Vue.directive("dropdown", function (el) {
    el.onclick = function (event) {
      event.preventDefault();
      let childs = el.children;
      for (let i = 0; childs.item(i) !== null; i++) {
        let item = childs.item(i);
        if (item.classList.contains('dropdown-menu')) {
          item.classList.toggle('show');
        }
      }
    };
  });
}
