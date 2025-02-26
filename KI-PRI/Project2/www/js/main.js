function scrollToId(id) {
  let anchor = document.querySelector(`body > main #${id}`);
  anchor?.scrollIntoView({ behavior: "smooth" });
}
