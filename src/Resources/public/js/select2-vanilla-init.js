// select2-vanilla-init.js — Initialisation automatique des champs Select2Type
// à partir des attributs data-* rendus par le thème Twig.

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-select2-vanilla').forEach(function (select) {
        const multiple = select.dataset.multiple === 'true';
        const placeholder = select.dataset.placeholder || 'Choisir ou saisir';
        const removeIconHtml = select.dataset.removeIconHtml || '×';

        new Select2Vanilla(select, {
            multiple: multiple,
            placeholder: placeholder,
            removeIconHtml: removeIconHtml
        });
    });
});
