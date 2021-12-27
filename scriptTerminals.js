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
        /** @typedef {object} Terminals
         * @property {object[]} data
         * @property {number} data.deviceTotalPriceNet
         * @property {string} data.productId
         * @property {null} data.sidChannelsInB2B
         * @property {object[]} data.variantList
         * @property {boolean} data.variantList.isInstalmentAvailable
         * @property {string} data.variantList.stockLevelDate
         * @property {string} data.variantList.productId
         * @property {number} data.variantList.stockLevel
         * @property {null|string} data.variantList.manufacturer
         * @property {null} data.variantList.defaultChoice
         * @property {number} data.variantList.pdpStockLevel
         * @property {object[]} data.variantList.colorDefinition
         * @property {string} data.variantList.colorDefinition.code
         * @property {string} data.variantList.colorDefinition.name
         * @property {string} data.variantList.colorDefinition.cssCode
         * @property {null|string} data.variantList.skuNumber
         * @property {string} data.variantList.imageUrl
         * @property {boolean} data.variantList.shouldStockLevelBeVisible
         * @property {string} data.variantList.name
         * @property {boolean} data.variantList.shouldStockLevelBeSorted
         * @property {null} data.variantList.imageMiniThumbnail
         * @property {string} data.variantList.productUrl
         * @property {object} data.variantList.stockLevelStatus
         * @property {string} data.variantList.stockLevelStatus.code
         * @property {string} data.variantList.stockLevelStatus.type
         * @property {null|object} data.sticker
         * @property {number} data.loyaltyLength
         * @property {number} data.priceNet
         * @property {number} data.priceGross
         * @property {string} data.canonicalLink
         * @property {object} data.offer
         * @property {number} data.offer.price
         * @property {number} data.price
         * @property {string} data.name
         * @property {number} data.deviceTotalPrice
         * @property {number} data.deviceTotalPriceGross
         * @property {null} data.sidChannelsInB2C
         * @property {string|null} data.productCardUrl
         * @property {null} data.selectedVariant
         * @property {string} data.bundleTemplateName
         * @property {object} data.inOffer
         * @property {object} data.inOffer.price
         * @property {object} data.inOffer.price.convergent
         * @property {number} data.inOffer.price.convergent.payNowPayment
         * @property {number} data.inOffer.price.convergent.oneTimePaymentNet
         * @property {object[]} data.inOffer.price.convergent.combinedTariffAndDevicePayments
         * @property {number} data.inOffer.price.convergent.combinedTariffAndDevicePayments.price
         * @property {number} data.inOffer.price.convergent.combinedTariffAndDevicePayments.monthFrom
         * @property {number} data.inOffer.price.convergent.combinedTariffAndDevicePayments.priceNet
         * @property {number} data.inOffer.price.convergent.combinedTariffAndDevicePayments.priceGross
         * @property {number} data.inOffer.price.convergent.combinedTariffAndDevicePayments.monthTo
         * @property {number} data.inOffer.price.convergent.payNowPaymentGross
         * @property {number} data.inOffer.price.convergent.oneTimePayment
         * @property {number} data.inOffer.price.convergent.summaryPayment
         * @property {number} data.inOffer.price.convergent.summaryPaymentGross
         * @property {object[]} data.inOffer.price.convergent.tariffPayments
         * @property {number} data.inOffer.price.convergent.tariffPayments.price
         * @property {number} data.inOffer.price.convergent.tariffPayments.monthFrom
         * @property {number} data.inOffer.price.convergent.tariffPayments.priceNet
         * @property {number} data.inOffer.price.convergent.tariffPayments.priceGross
         * @property {number} data.inOffer.price.convergent.tariffPayments.monthTo
         * @property {number} data.inOffer.price.convergent.oneTimePaymentGross
         * @property {number} data.inOffer.price.convergent.payNowPaymentNet
         * @property {object[]} data.inOffer.price.convergent.devicePayments
         * @property {number} data.inOffer.price.convergent.devicePayments.price
         * @property {number} data.inOffer.price.convergent.devicePayments.monthFrom
         * @property {number} data.inOffer.price.convergent.devicePayments.priceNet
         * @property {number} data.inOffer.price.convergent.devicePayments.priceGross
         * @property {number} data.inOffer.price.convergent.devicePayments.monthTo
         * @property {number} data.inOffer.price.convergent.summaryPaymentNet
         * @property {object} data.inOffer.price.base
         * @property {number} data.inOffer.price.base.payNowPayment
         * @property {number} data.inOffer.price.base.oneTimePaymentNet
         * @property {object[]} data.inOffer.price.base.combinedTariffAndDevicePayments
         * @property {number} data.inOffer.price.base.combinedTariffAndDevicePayments.price
         * @property {number} data.inOffer.price.base.combinedTariffAndDevicePayments.monthFrom
         * @property {number} data.inOffer.price.base.combinedTariffAndDevicePayments.priceNet
         * @property {number} data.inOffer.price.base.combinedTariffAndDevicePayments.priceGross
         * @property {number} data.inOffer.price.base.combinedTariffAndDevicePayments.monthTo
         * @property {number} data.inOffer.price.base.payNowPaymentGross
         * @property {number} data.inOffer.price.base.oneTimePayment
         * @property {number} data.inOffer.price.base.summaryPayment
         * @property {number} data.inOffer.price.base.summaryPaymentGross
         * @property {object[]} data.inOffer.price.base.tariffPayments
         * @property {number} data.inOffer.price.base.tariffPayments.price
         * @property {number} data.inOffer.price.base.tariffPayments.monthFrom
         * @property {number} data.inOffer.price.base.tariffPayments.priceNet
         * @property {number} data.inOffer.price.base.tariffPayments.priceGross
         * @property {number} data.inOffer.price.base.tariffPayments.monthTo
         * @property {number} data.inOffer.price.base.oneTimePaymentGross
         * @property {number} data.inOffer.price.base.payNowPaymentNet
         * @property {object[]} data.inOffer.price.base.devicePayments
         * @property {number} data.inOffer.price.base.devicePayments.price
         * @property {number} data.inOffer.price.base.devicePayments.monthFrom
         * @property {number} data.inOffer.price.base.devicePayments.priceNet
         * @property {number} data.inOffer.price.base.devicePayments.priceGross
         * @property {number} data.inOffer.price.base.devicePayments.monthTo
         * @property {number} data.inOffer.price.base.summaryPaymentNet
         * @property {number} data.inOffer.loyalty
         * @property {string} data.sidChannel
         * @property {string[]} data.sticker.availableProcesses
         * @property {string} data.sticker.code
         * @property {string} data.sticker.textSize
         * @property {null|boolean} data.sticker.visible
         * @property {string} data.sticker.color
         * @property {number} data.sticker.endDate
         * @property {string} data.sticker.align
         * @property {string} data.sticker.textColor
         * @property {} data.sticker.propositionItems
         * @property {string[]} data.sticker.products
         * @property {string} data.sticker.name
         * @property {string} data.sticker.cuteName
         * @property {number} data.sticker.startDate
         * @property {number} pagesCount
         * @property {string} mainCategory
         * @property {number} currentPage
         * @property {null} sortedValue
         * @property {null} numberOfResults
     */

      /** @type {Terminals} */
      const json = JSON.parse(response.responseText);
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
  /**
   * 
   * @param {Terminals} devices 
   * @param {boolean} checkPickup 
   * @returns 
   */
  function device(devices, checkPickup) {
    var html = "";
    
    devices.forEach(
      /** 
       * @param {Terminals.data} element 
       */
      (element) => {
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
        html += `Łączna cena terminala netto: ${element.deviceTotalPriceNet
          } zł</br>
        Łączna cena terminala brutto: ${element.deviceTotalPrice} zł</br>
        Łączna cena terminala brutto: ${element.deviceTotalPrice / 70000000
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
              <a href="https://orange.pl/sklep${variant.productUrl
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
