/**
 * Interações do módulo público:
 * - gaveta de filtros (mobile)
 * - bottom sheet do formulário de interesse (mobile)
 * - galeria de miniaturas na página de detalhes
 * - pré-preenchimento do formulário via localStorage, com consentimento (RF06, RNF09)
 */
(function () {
    'use strict';

    var CHAVE_DADOS = 'adote.solicitante';

    /* ---------- Gaveta de filtros ---------- */
    var drawer = document.getElementById('drawer-filtros');
    var drawerFundo = document.querySelector('.drawer-fundo');

    function abrirDrawer() {
        if (!drawer) return;
        drawer.classList.add('aberta');
        if (drawerFundo) drawerFundo.hidden = false;
    }

    function fecharDrawer() {
        if (!drawer) return;
        drawer.classList.remove('aberta');
        if (drawerFundo) drawerFundo.hidden = true;
    }

    /* ---------- Bottom sheet do formulário ---------- */
    var sheet = document.getElementById('sheet-form');
    var sheetFundo = document.querySelector('.sheet-fundo');
    var ehDesktop = window.matchMedia('(min-width: 900px)');

    function abrirSheet() {
        if (!sheet) return;
        if (ehDesktop.matches) {
            sheet.scrollIntoView({ behavior: 'smooth', block: 'start' });
            return;
        }
        sheet.classList.add('aberta');
        if (sheetFundo) sheetFundo.hidden = false;
    }

    function fecharSheet() {
        if (!sheet) return;
        sheet.classList.remove('aberta');
        if (sheetFundo) sheetFundo.hidden = true;
    }

    document.addEventListener('click', function (evento) {
        var alvo = evento.target.closest('[data-abrir-drawer], [data-fechar-drawer], [data-abrir-sheet], [data-fechar-sheet], .miniatura');
        if (!alvo) return;

        if (alvo.hasAttribute('data-abrir-drawer')) abrirDrawer();
        if (alvo.hasAttribute('data-fechar-drawer')) fecharDrawer();
        if (alvo.hasAttribute('data-abrir-sheet')) abrirSheet();
        if (alvo.hasAttribute('data-fechar-sheet')) fecharSheet();

        /* ---------- Galeria ---------- */
        if (alvo.classList.contains('miniatura')) {
            var principal = document.getElementById('foto-principal');
            if (principal) principal.src = alvo.getAttribute('data-foto');
        }
    });

    document.addEventListener('keydown', function (evento) {
        if (evento.key === 'Escape') {
            fecharDrawer();
            fecharSheet();
        }
    });

    /* ---------- localStorage com consentimento ---------- */
    var form = document.getElementById('form-interesse');
    if (!form) return;

    var consentimento = document.getElementById('salvar-dados');
    var campos = ['nome', 'email', 'telefone', 'cidade'];

    // Pré-preenche apenas campos vazios (não sobrescreve old() após erro de validação).
    try {
        var salvos = JSON.parse(localStorage.getItem(CHAVE_DADOS) || 'null');
        if (salvos) {
            campos.forEach(function (nome) {
                var campo = form.elements[nome];
                if (campo && !campo.value && salvos[nome]) campo.value = salvos[nome];
            });
            if (consentimento) consentimento.checked = true;
        }
    } catch (erro) {
        localStorage.removeItem(CHAVE_DADOS);
    }

    form.addEventListener('submit', function () {
        if (consentimento && consentimento.checked) {
            var dados = {};
            campos.forEach(function (nome) {
                var campo = form.elements[nome];
                if (campo) dados[nome] = campo.value;
            });
            localStorage.setItem(CHAVE_DADOS, JSON.stringify(dados));
        } else {
            localStorage.removeItem(CHAVE_DADOS);
        }
    });
})();
