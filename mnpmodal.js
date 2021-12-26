$(document).ready(function () {
    let modalMNP = new boosted.Modal(document.getElementById("kalkulatorMNPModal"));
    $("#calculateMNPbutton").click(function () {
        const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
        var today = new Date();
        var newCycleDay = document.getElementById("MNPday").value;
        today.setHours(0);
        today.setMinutes(0);
        today.setSeconds(0);
        var MNPday = new Date(today.getTime());
        MNPday.setDate(newCycleDay);
        diff = MNPday.getDate() - today.getDate();
        if (diff <= 0) {
        //Cykl już się zresetował w tym miesiącu
        MNPday.setMonth(MNPday.getMonth() + 1);
        }
        diffDays = Math.round(Math.abs((MNPday - today) / oneDay));
        if (diffDays > 20) {
        //Do końca cyklu zostało więcej niż 20 dni
        MNPday.setMonth(MNPday.getMonth() + 1); //Plus miesiąc
        } else {
        MNPday.setMonth(MNPday.getMonth() + 2); //Plus 2 miechy
        }
        document.getElementById(
        "MNPdate"
        ).innerHTML = `Przeniesiemy klienta dnia: ${MNPday.toLocaleDateString()}`;
        $("#showMNPinfo").collapse("show");
    });
    
    $("#showMNPbutton").click(function () {
        modalMNP.show();
    });
});