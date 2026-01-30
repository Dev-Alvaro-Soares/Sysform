(function () {
    function padNumber(value, length) {
        return String(value).padStart(length, '0');
    }

    function nextSequence(key) {
        var stored = localStorage.getItem(key);
        var current = parseInt(stored || '0', 10);
        var next = Number.isFinite(current) ? current + 1 : 1;
        localStorage.setItem(key, String(next));
        return next;
    }

    function buildProtocol(keyBase) {
        var year = new Date().getFullYear();
        var key = keyBase + '_' + year;
        var seq = nextSequence(key);
        return String(year) + padNumber(seq, 6);
    }

    function attachProtocol(form) {
        var keyBase = form.getAttribute('data-protocolo-key');
        if (!keyBase) {
            return;
        }

        form.addEventListener('submit', function () {
            var input = form.querySelector('input[name="numero_protocolo"]');
            if (!input) {
                return;
            }
            if (input.value) {
                return;
            }
            input.value = buildProtocol('sysform_protocolo_' + keyBase);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var forms = document.querySelectorAll('form[data-protocolo-key]');
        forms.forEach(attachProtocol);
    });
})();
