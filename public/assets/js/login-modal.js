$(document).ready(function () {
  $("body").on("click", "#login--btn", function () {
    $("#login--modal").show();
  });

  $("body").on("click", "#close", function () {
    $("#login--modal").hide();
  });
});
