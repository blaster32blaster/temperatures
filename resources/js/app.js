require('./bootstrap');

let select = document.getElementById('country-select');
select.addEventListener('change', function(){
    if (!select.value || select.value === 'undefined' || select.value === 'Select a Country') {
        setCityToDefault();
        return;
    }
    let value = JSON.parse(select.value);
    setCities(value.cities);
}, false);

/**
 * if there are cities, set them
 *
 * @param {Array} cities
 * @returns
 */
function setCities (cities) {
    let cityList = document.getElementById('city-select');
    if (!cities || cities === 'undefined' || !cities.length) {
        clearCurrentOptions();
        setForNoCities(cityList);
        return;
    }

    clearCurrentOptions();
    cities.forEach(element => {
        newOption = document.createElement('option');
        newOption.value = element.id;
        if (element.name !== 'undefined') {
            newOption.innerText = element.name;
            cityList.appendChild(newOption);
        }
    });
}

/**
 * if there are no cities for the selected country, mark as none available
 *
 * @param {Array} cityList
 */
function setForNoCities (cityList) {
    newOption = document.createElement('option');
    newOption.value = null;
    newOption.innerText = 'No Cities Available';
    cityList.appendChild(newOption);
}

/**
 * clear current city options
 */
function clearCurrentOptions () {
    var select = document.getElementById("city-select");
    var length = select.options.length;
    for (i = length-1; i >= 0; i--) {
        select.options[i] = null;
    }
}

/**
 * set to default if default country value is selected
 */
function setCityToDefault () {
    clearCurrentOptions();
    let cityList = document.getElementById('city-select');
    newOption = document.createElement('option');
    newOption.value = null;
    newOption.innerText = 'Select a Country';
    cityList.appendChild(newOption);
}
