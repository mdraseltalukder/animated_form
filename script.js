let verified = false;

function recaptchaverify(token) {
  verified = true;
  const iframe = document.querySelector("#recaptcha iframe");
  if (iframe) {
    iframe.style.border = "";
  }
}

var onloadCallback = function () {
  grecaptcha.render("recaptcha", {
    sitekey: "6Lf7JV8rAAAAAO-NV0ghPCqq8Is5DDsbukhc-ykJ", // ✅ Replace with your site key
    callback: recaptchaverify,
  });
};

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("signin-form")
    .addEventListener("submit", function (e) {
      if (!verified) {
        e.preventDefault();
        const iframe = document.querySelector("#recaptcha iframe");
        if (iframe) {
          iframe.style.border = "2px solid red";
        }
      }
    });
});
