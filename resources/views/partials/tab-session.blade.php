<script>
    (function () {
        const key = 'sievent_tab_id';
        const params = new URLSearchParams(window.location.search);
        let tabId = sessionStorage.getItem(key);

        function generateTabId() {
            return 'tab_' + Date.now().toString(36) + Math.random().toString(36).slice(2, 10);
        }

        if (!tabId) {
            const incomingTabId = params.get('_tab');
            const isNewBrowserTab = window.opener && window.opener !== window;

            if (incomingTabId && isNewBrowserTab) {
                tabId = generateTabId();
                params.set('_tab', tabId);
                window.history.replaceState({}, '', window.location.pathname + '?' + params.toString() + window.location.hash);
            } else {
                tabId = incomingTabId || generateTabId();
            }

            sessionStorage.setItem(key, tabId);
        }

        function addTabToUrl(value) {
            if (!value || value.startsWith('#') || value.startsWith('mailto:') || value.startsWith('tel:') || value.startsWith('javascript:')) {
                return value;
            }

            const url = new URL(value, window.location.href);

            if (url.origin !== window.location.origin) {
                return value;
            }

            url.searchParams.set('_tab', tabId);

            return url.pathname + url.search + url.hash;
        }

        function addHiddenTabInput(form) {
            let input = form.querySelector('input[name="_tab"]');

            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_tab';
                form.appendChild(input);
            }

            input.value = tabId;
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a[href]').forEach(function (link) {
                if (link.target && link.target !== '_self') {
                    return;
                }

                link.setAttribute('href', addTabToUrl(link.getAttribute('href')));
            });

            document.querySelectorAll('form').forEach(function (form) {
                addHiddenTabInput(form);

                if (form.action) {
                    form.action = addTabToUrl(form.action);
                }
            });
        });
    })();
</script>
