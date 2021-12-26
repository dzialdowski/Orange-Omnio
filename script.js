$(document).ready(function () {
  let modalGetCoupon = new boosted.Modal(document.getElementById("myModal"));
  let noCoupon = new boosted.Modal(document.getElementById("noCoupon"));
  function getMOTD() {
    let response = $.ajax({
      url: "api/motd.php?requestType=GET",
      dataType: "json",
      async: false,
    });
    if (response.responseText == "") return 0;
    let MOTD = JSON.parse(response.responseText);
    setMOTDonDOM(MOTD);
  }
  getMOTD();
  function setMOTDonDOM(MOTD) {
    if (MOTD.additionalContentCheck) {
      document.getElementById(
        "MOTD_content"
      ).innerHTML = `<div class="alert ${MOTD.type}" role="alert">
          <span class="alert-icon"></span>
          <div>
            <h4 class="alert-heading">${MOTD.content}</h4>
            <p>${MOTD.additionalContent}</p>
          </div>
        </div>`;
    } else {
      document.getElementById(
        "MOTD_content"
      ).innerHTML = `<div class="alert ${MOTD.type}" role="alert">
          <span class="alert-icon"></span>
          <p>${MOTD.content}</p>
        </div>`;
    }
  }

  var odliczanko;
  if (localStorage.getItem("username") == null) {
    var username = prompt("Podaj swój login z intranetu:", "imie.nazwisko");
    if (
      username == null ||
      username == "" ||
      username == "imie.nazwisko" ||
      username == "null"
    ) {
      alert("Musisz podać swój login!");
      window.location.reload(true);
    } else {
      localStorage.setItem("username", username);
    }
  }
  var couponTypes = $.ajax({
    url: "api/getCouponTypes.php",
    dataType: "json",
    async: false,
  });
  document.getElementById("typy").innerHTML = "";
  json1 = JSON.parse(couponTypes.responseText);
  var html1 = `<table class='table'>
      <thead>
        <tr>
          <th scope=col>Kupon</th>
          <th scope=col>Opis</th>
        </tr>
      </thead>`;
  json1["success"].forEach((row) => {
    html1 += `<tr>
        <td>${row["CouponType"]}</td>
        <td>${row["CouponDesc"]}</td>
      </tr>`;
  });
  html1 += "</table>";
  document.getElementById("typy").innerHTML = html1;
  if (localStorage.getItem("lastCoupon") == null) {
    $("#getLastCoupon").prop("disabled", true);
  }

  $("#getLastCoupon").click(function () {
    document.getElementById("couponPlace").innerHTML =
      localStorage.getItem("lastCoupon");
    document.getElementById("myModalLabel2").innerHTML = "Twój zapisany kupon:";
    modalGetCoupon.show();
  });

  $("#zwrot-button").click(function () {
    var kupon = $("#couponCodeToReturn").val();
    var response = $.ajax({
      url: `api/returnToDatabase.php?codeVal=${kupon}&username=${localStorage.getItem(
        "username"
      )}`,
      dataType: "json",
      async: false,
      statusCode: {
        406: function () {},
      },
    });
    alert(response.responseText);
    $("#couponCodeToReturn").val("");
  });

  

  function getCoupons() {
    document.getElementById("refreshCountdown").innerHTML = 9;
    clearInterval(odliczanko);
    odliczanie();
    var response = $.ajax({
      url: "api/getCouponsCount.php",
      dataType: "json",
      async: false,
    });
    document.getElementById("couponList").innerHTML = "";
    json = JSON.parse(response.responseText);
    var html = `<table class='shadow-lg table'>
        <thead>
          <tr>
            <th scope=col>Kupon</th>
            <th scope=col>Ilość</th>
            <th scope=col>Rezerwuj</th>
          </tr></thead>`;
    if (json["success"] == null) {
      html = `<div class="alert alert-warning" role="alert">
          <span class="alert-icon">
          </span>
          <p>Kupony się skończyły :c</p>
        </div>`;
      document.getElementById("couponList").innerHTML = html;
    } else {
      json["success"].forEach((row) => {
        html += `<tr>
            <td>${row["Kupon"]}</td>
            <td>${row["Ilosc"]}</td>
            <td>
              <button title="${row["Kupon"]}" class='btn biere btn-block btn-primary'>
                BIORĘ!
              </button>
            </td>
          </tr>`;
      });
      html += "</table>";
      document.getElementById("couponList").innerHTML = html;
    }

    $(".biere").click(function () {
      var kupon = this.title;
      var response = $.ajax({
        url: `api/getCoupon.php?kuponType=${kupon}&username=${localStorage.getItem(
          "username"
        )}`,
        dataType: "json",
        async: false,
      });
      json = JSON.parse(response.responseText);
      if (json["success"] == null) {
        noCoupon.show();
      } else {
        if (json["success"][0]["coupon"] == "Błędny login") {
          document.getElementById("myModalLabel2").innerHTML = "Nie kombinuj";
          document.getElementById(
            "couponText"
          ).innerHTML = `Twój login jest błędny, aby zresetować usuń ciasteczka i odśwież stronę<br>
            <button type="button" onclick="localStorage.removeItem('username') class="btn btn-primary btn-block">Usuń ciasteczka</button>`;
            modalGetCoupon.show();
          } else {
          localStorage.setItem("lastCoupon", json["success"][0]["coupon"]);
          document.getElementById("myModalLabel2").innerHTML =
            "Twój kupon został zarezerwowany i oznaczony jako zużyty!";
          $("#getLastCoupon").prop("disabled", false);
          document.getElementById("couponPlace").innerHTML =
            json["success"][0]["coupon"]; //Show coupon in it's place
            modalGetCoupon.show();
        }
      }
    });
  }

  $("#getCouponsButton").click(function () {
    getCoupons();
  });

  function odliczanie() {
    //odliczanko
    var timeleft = 9;
    odliczanko = setInterval(function () {
      if (timeleft <= 0) {
        clearInterval(odliczanko);
        getCoupons();
      }
      document.getElementById("refreshCountdown").innerHTML = timeleft;
      timeleft -= 1;
    }, 1000);
  }

  getCoupons();
});

if ("serviceWorker" in navigator) {
  window.addEventListener("load", function () {
    navigator.serviceWorker
      .register("/serviceWorker.js")
      .then((res) => console.log("service worker registered"))
      .catch((err) => console.log("service worker not registered", err));
  });
}

if ("serviceWorker" in navigator) {
  caches.keys().then(function (cacheNames) {
    cacheNames.forEach(function (cacheName) {
      caches.delete(cacheName);
    });
  });
}

window.addEventListener("beforeinstallprompt", (e) => {
  // Prevent the mini-infobar from appearing on mobile
  // Stash the event so it can be triggered later.
  // Optionally, send analytics event that PWA install promo was shown.
  console.log(`'beforeinstallprompt' event was fired.`);
});
