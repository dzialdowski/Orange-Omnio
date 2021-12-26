$(document).ready(function () {
  let modalPickup = new boosted.Modal(document.getElementById("myModal"));
  function getTerminal() {
    let terminal = new Array();
    terminal.producer = document.getElementById("Producer").value;
    terminal.offerType = document.getElementById("offerType").value;
    terminal.category = document.getElementById("category").value;
    terminal.search = document.getElementById("search").value;
    terminal.piecgie = document.getElementById("5G").checked;
    terminal.esim = document.getElementById("eSIM").checked;
    terminal.outlet = document.getElementById("Outlet").checked;
    terminal.preorder = document.getElementById("preorder").checked;
    terminal.priceFilter = document.getElementById("priceFilter").checked;
    terminal.priceFrom = document.getElementById("priceFrom").value;
    terminal.priceTo = document.getElementById("priceTo").value;

    onlyAvailable = document.getElementById("onlyAvailable").checked;
    checkPickup = document.getElementById("checkPickup").checked;
    var response = $.ajax({
      url: `api/getTerminals.php?producer="${terminal.producer}"&offer="${terminal.offerType}"&search="${terminal.search}"&category="${terminal.category}"&piecgie=${terminal.piecgie}"&esim="${terminal.esim}&lojalka=24&outlet=${terminal.outlet}&priceFilter=${terminal.priceFilter}&priceFrom=${terminal.priceFrom}&priceTo=${terminal.priceTo}&onlyAvailable=${terminal.onlyAvailable}&preorder=${terminal.preorder}`,
      dataType: "json",
      async: false,
    });
    document.getElementById("dzejson").innerHTML = "";
    if (response.responseText == null) {
      document.getElementById("dzejson").innerHTML = "Pobranie danych nieudane";
    } else {
      json = JSON.parse(response.responseText);
      if (document.getElementById("checkPickup").checked) {
        if (json.data.length > 100) {
          document.getElementById("requestCount").innerHTML = json.data.length;
          modalPickup.show();
        } else getTerminals();
      } else getTerminals();
    }
  }

  $("#search").on("keyup", function (e) {
    if (e.key === "Enter" || e.keyCode === 13) {
      getTerminal();
    }
  });

  $("#getTerminalsButton").click(function () {
    getTerminal();
  });

  function getTerminals() {
    document.getElementById("dzejson").innerHTML += device(
      json.data,
      checkPickup
    );
  }

  function device(devices, checkPickup) {
    var html = "";
    devices.forEach((element) => {
      var cards = "";
      if (
        document.getElementById("offerType").value ==
        "DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"
      ) {
        // Jeżeli SIMFREE
        html += `<div class="deviceInfo">
        <strong>${element.name}</strong></br>
        Cena netto: ${element.priceNet}</br>
        Cena brutto: ${element.priceGross}</br>`;
        if (checkPickup) {
          html += `<div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox"  id="disabledFieldsetCheck" disabled ${POSPickup(
                element.productId
              )}>
              <label class="custom-control-label" for="disabledFieldsetCheck">
                Odbiór w salonie
            </label>
            </div>
          </div></br>`;
        }
        cards = createCards(element.variantList).innerHTML;
      } else {
        html += `<div class="deviceInfo">
        <strong>${element.name}</strong></br>
        Opłata na start netto: ${element.inOffer.price.convergent.oneTimePaymentNet}</br>
        Opłata na start brutto: ${element.inOffer.price.convergent.oneTimePayment}</br>`;
        element.inOffer.price.convergent.devicePayments.forEach((payment) => {
          html += `Opłata od ${payment.monthFrom} do ${payment.monthTo} miesiąca: ${payment.priceNet} zł netto</br>`;
          html += `Opłata od ${payment.monthFrom} do ${payment.monthTo} miesiąca: ${payment.priceGross} zł brutto</br>`;
        });
        html += `Łączna cena terminala netto: ${
          element.deviceTotalPriceNet
        } zł</br>
        Łączna cena terminala brutto: ${element.deviceTotalPrice} zł</br>
        Łączna cena terminala brutto: ${
          element.deviceTotalPrice / 70000000
        } Sasinów</br>`;
        if (checkPickup)
          html += `<div class="form-group"> 
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="disabledFieldsetCheck" disabled ${POSPickup(
                element.productId
              )}>
              <label class="custom-control-label" for="disabledFieldsetCheck">
                  Odbiór w salonie
              </label>
            </div>
            </div></br>`;
        cards = createCards(element.variantList).innerHTML;
      }

      if (cards == null) return "";
      html += cards;
      html +=
        '<div class="w-100"><hr class="bg-primary" height:3px></div></div>';
    });
    return html;
  }

  function POSPickup(deviceID) {
    var response = $.ajax({
      url: `api/pickup.php?productBaseCode=${deviceID}`,
      dataType: "json",
      async: false,
    });
    try {
      json = JSON.parse(response.responseText);
    } catch (error) {
      return "";
    }
    if (json.length > 2) return "checked";
    else return "";
  }

  function createCards(variantList) {
    var html = '<div class="row row-cols-1 row-cols-md-3 g-4">';
    var counter = 0;
    variantList.forEach((variant) => {
      counter++;
      html += `
        <div class="col">
          <div class="card" style="max-width: 300px;">
            <img src=https://orange.pl${variant.imageUrl} class="card-img-top">
            <div class="card-body">
              <h5 class="card-title">${getColours(variant.colorDefinition)}</h5>
              <p class="card-text">W magazynie: ${variant.stockLevel}</p>
              <a href="https://orange.pl/sklep${
                variant.productUrl
              }" class="btn btn-primary">Na stronę Orange</a>
            </div>
          </div>
        </div>`;
    });
    html += "</div>";
    if (counter == 0) return;
    return createElementFromHTML(html);
  }
  function createElementFromHTML(htmlString) {
    var div = document.createElement("div");
    div.innerHTML = htmlString.trim();

    // Change this to div.childNodes to support multiple top-level nodes
    //return div.firstChild;
    return div;
  }
  function getColours(colorDefinition) {
    if (colorDefinition.length == 1) return colorDefinition[0].name;
    return colorDefinition[0].name + " i " + colorDefinition[1].name;
  }

  if ("serviceWorker" in navigator) {
    caches.keys().then(function (cacheNames) {
      cacheNames.forEach(function (cacheName) {
        caches.delete(cacheName);
      });
    });
  }
});
