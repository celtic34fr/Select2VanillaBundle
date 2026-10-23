// select2-vanilla-init.js — Initialisation automatique des champs Select2Type
// à partir des attributs data-* rendus par le thème Twig.

(function () {
    function initSelect2VanillaFields() {
        if (typeof window.Select2Vanilla !== 'function') {
            return;
        }

        document.querySelectorAll('select.js-select2-vanilla').forEach(function (select) {
            // Turbo rejoue les événements de chargement : on n'initialise
            // chaque champ qu'une seule fois.
            if (select.dataset.select2Initialized === '1') {
                return;
            }
            select.dataset.select2Initialized = '1';

            new window.Select2Vanilla(select, {
                multiple: select.multiple,
                placeholder: select.dataset.placeholder || 'Choisir ou saisir',
                removeIconHtml: select.dataset.removeIconHtml || '×'
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSelect2VanillaFields);
    } else {
        initSelect2VanillaFields();
    }

    // Navigation Turbo : le DOM est remplacé sans recharger la page.
    document.addEventListener('turbo:load', initSelect2VanillaFields);
})();
