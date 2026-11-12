
<script>
(function () {
    var EYE = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
    var EYE_OFF = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>';

    function pasang(input) {
        if (input.dataset.mata) return;
        input.dataset.mata = '1';

        var wrap = document.createElement('div');
        wrap.style.position = 'relative';
        wrap.style.display = input.classList.contains('w-full') ? 'block' : 'inline-block';
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);
        input.style.paddingRight = '2.75rem';

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.setAttribute('aria-label', 'Lihat password');
        btn.innerHTML = EYE;
        btn.style.cssText = 'position:absolute;top:0;bottom:0;right:0;width:2.75rem;display:flex;align-items:center;justify-content:center;color:#6b7280;background:none;border:0;cursor:pointer;';
        btn.onmouseenter = function () { btn.style.color = '#2563eb'; };
        btn.onmouseleave = function () { btn.style.color = '#6b7280'; };
        btn.onclick = function () {
            var tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            btn.innerHTML = tampil ? EYE_OFF : EYE;
            btn.setAttribute('aria-label', tampil ? 'Sembunyikan password' : 'Lihat password');
        };
        wrap.appendChild(btn);
    }

    document.querySelectorAll('input[type="password"]').forEach(pasang);
})();
</script><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\resources\views/partials/toggle-password.blade.php ENDPATH**/ ?>