document.getElementById("searchInput").addEventListener("keyup", function () {
  var filter = this.value.toLowerCase();
  var items = document.getElementsByClassName("medication-item");

  Array.from(items).forEach(function (item) {
    var title = item.querySelector(".card-title").textContent.toLowerCase();
    if (title.includes(filter)) {
      item.style.display = "";
    } else {
      item.style.display = "none";
    }
  });
});
