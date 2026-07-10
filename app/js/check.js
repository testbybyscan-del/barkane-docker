function toggleCheckbox(checkboxName, checkboxValue) {
    const checkForKids = document.querySelector('input[name="for_kids"]');
    const checkHasAlcohol = document.querySelector('input[name="has_alcohol"]');

    if (checkboxValue === 'for_kids' && checkForKids.checked) {
        checkHasAlcohol.checked = false;
    }
    if (checkboxValue === 'has_alcohol' && checkHasAlcohol.checked) {
        checkForKids.checked = false;
    }
}
