function debounce(func, delay) {
    let debounceTimer;
    return function() {
      const context = this;
      const args = arguments;
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
  }
  
document.addEventListener("DOMContentLoaded", function () {
  var modal = document.getElementById("searchModal");
  var btn = document.getElementById("searchButton"); // Assume you have this button
  var span = document.getElementsByClassName("close-btn")[0];

  // Open the modal
  btn.onclick = function () {
    modal.style.display = "block";
  };

  // Close the modal
  span.onclick = function () {
    modal.style.display = "none";
  };

  // Close if outside click
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

 // Handle search input with debounce
 var input = document.getElementById("search-input");
 var results = document.getElementById("search-results");
 
 // Debounce the input event
 input.addEventListener("input", debounce(function () {
   var query = this.value;
   if (query.length >= 3) {
     fetch(`/search/${encodeURIComponent(query)}`)
       .then((response) => response.text())
       .then((html) => {
         results.innerHTML = html;
       })
       .catch((error) => {
         console.error("Search error:", error);
         results.innerHTML = `<p>Error during search: ${error.message}</p>`;
       });
   } else {
     results.innerHTML = "";
   }
 }, 300)); // 300 milliseconds delay
});