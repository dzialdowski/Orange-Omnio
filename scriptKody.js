$(document).ready(function () {
  let cityID = "";
  let cityName = "";
  let streetID = "";
  let streetName = "";

  $("#getCityButton").click(function () {
    let city = document.getElementById("cityInput").value;
    var response = $.ajax({
      url: `api/kody.php?type=city&city=${city}`,
      dataType: "json",
      async: false,
    });
    json = JSON.parse(response.responseText);
    cityTable = document.getElementById("cityTableContent");
    let html = "";
    json.forEach((cityObj) => {
      html += `
        <tr>
          <td>${cityObj["fullName"]}</td>
          <td>${cityObj["description"]}</td>
          <td>
            <button title=${cityObj["id"]} slot='${cityObj["fullName"]}' class='btn biere btn-block btn-primary'>
              Wybieram
            </button>
          </td>
        </tr>`;
    });
    cityTable.innerHTML = html;

    $(".biere").click(function () {
      cityID = this.title;
      cityName = this.slot;
      document.getElementById("chosenCity").innerHTML = this.slot;
    });
  });

  $("#getStreetButton").click(function () {
    if (!cityID) return;
    let street = document.getElementById("streetInput").value;
    var response = $.ajax({
      url: `api/kody.php?type=street&city_id=${cityID}&street=${street}`,
      dataType: "json",
      async: false,
    });
    json = JSON.parse(response.responseText);
    streetTable = document.getElementById("streetTableContent");
    let html = "";
    json.forEach((streetObj) => {
      html +=`
        <tr>
          <td>${streetObj["fullName"]}</td>
          <td>
            <button title=${streetObj["id"]} slot='${streetObj["fullName"]}' class='btn biere btn-block btn-primary'>
              Wybieram
            </button>
          </td>
        </tr>`;
    });
    streetTable.innerHTML = html;

    $(".biere").click(function () {
      streetID = this.title;
      streetName = this.slot;
      document.getElementById("chosenStreet").innerHTML = this.slot;
    });
  });

  $("#getZipCodeButton").click(function () {
    if (!cityID || !streetID) return;
    let streetNumber = document.getElementById("numberInput").value;
    var response = $.ajax({
      url: `
        api/kody.php?type=zipCode&city_id=${cityID}&street_id=${streetID}&street_number=${streetNumber}`,
      dataType: "json",
      async: false,
    });
    json = JSON.parse(response.responseText);
    if (json.length == 0) {
      zipCodePlace.innerHTML = "Brak adresu w bazie";
      return;
    }
    let html = "";
    json.forEach((zip) => {
      html += zip["value"] + "<br>";
    });
    zipCodePlace.innerHTML = html;
  });

  $("#getOffersButton").click(function () {
    document.getElementById("addressInfo").innerHTML =
      `<div class="d-flex align-items-center">
        <strong>Pobieram dane...</strong>
        <div class="spinner-border ml-auto text-primary" role="status" aria-hidden="true"></div>
      </div>`;
    document.getElementById("offerTableContent").innerHTML = "";
    if (!cityID || !streetID) return;
    let streetNumber = document.getElementById("numberInput").value;
    let lokalNumber = document.getElementById("lokalInput").value;
    var response = $.ajax({
      url: `
        api/kody.php?type=offers&city_name=${cityName}&street_name=${streetName}&street_number=${streetNumber}&appartment_number=${lokalNumber}&street_id=${streetID}&city_id=${cityID}`,
      dataType: "json",
      async: false,
    });
    json = JSON.parse(response.responseText);
    let html = "";
    json["offers"].forEach((oferta) => {
      html +=`
        <tr>
          <td>${oferta["offerType"]}</td>
          <td>${oferta["mainServices"][0]["features"]["config"][0]["value"]["Name"]}</td>
        </tr>`;
    });
    document.getElementById("offerTableContent").innerHTML = html;
    let addressData = json["attributes"]["addressData"];
    let html2 = "";
    if (addressData["isDereg"]) html2 += "Obszar deregulowany<br>";
    if (addressData["sfh"]) html2 += "Domek jednorodzinny<br>";
    if (addressData["isPopc"]) html2 += "Obszar objęty POPC<br>";

    document.getElementById("addressInfo").innerHTML = html2;
  });
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
