function today(language) {

    var dayNames = {
        'en' : ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        'fr' : ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        'sl' : ["Nedelja", "Ponedeljek", "Torek", "Sreda", "Četrtek", "Petek", "Sobota"],

    };

    var monthNames = {
        'en' : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        'fr' : ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembr", "Octobre", "Novembre", "Décembre"],
        'sl' : ["Januar", "Februar", "Marec", "April", "Maj", "Junij", "Julij", "Avgust", "September", "Oktober", "November", "December"],

    };

    var lang = (undefined === dayNames[language] || undefined === monthNames[language]) ? 'en' : language;

    var now = new Date();

    document.write(dayNames[lang][now.getDay()] + ", " + now.getDate() + " " + monthNames[lang][now.getMonth()] + "  " + now.getFullYear());

}
