(function () {
    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    function insertAfter(reference, node) {
        reference.parentNode.insertBefore(node, reference.nextSibling);
    }

    function firstCardBody(root) {
        var bodies = root.querySelectorAll('.card-body');
        var i;
        var body;

        for (i = 0; i < bodies.length; i++) {
            body = bodies[i];

            if (!body.closest('[data-creatorcodes-box]')) {
                return body;
            }
        }

        return null;
    }

    function wrapAsCard(box) {
        var card = document.createElement('div');
        var header = document.createElement('div');
        var inner = document.createElement('div');
        var title = box.querySelector('.fw-bold');

        card.className = 'card mb-4';
        header.className = 'card-header';
        inner.className = 'card-body';

        if (title) {
            header.textContent = title.textContent;
            title.remove();
        }

        box.classList.remove('creatorcodes-inline', 'mb-4', 'pb-4');
        inner.appendChild(box);
        card.appendChild(header);
        card.appendChild(inner);

        return card;
    }

    function mount(box) {
        var deluxeCat = document.querySelector('#shop .shop-nav-cat');
        var deluxeCard = deluxeCat && deluxeCat.closest('.card');

        if (deluxeCard && deluxeCard.parentNode) {
            insertAfter(deluxeCard, wrapAsCard(box));
            return;
        }

        var content = document.querySelector('#shop')
            || document.querySelector('.container.content')
            || document.querySelector('main .container')
            || document.querySelector('.container')
            || document.querySelector('main')
            || document.body;

        var cardBody = firstCardBody(content);

        if (cardBody) {
            cardBody.insertBefore(box, cardBody.firstChild);
            return;
        }

        content.insertBefore(wrapAsCard(box), content.firstChild);
    }

    ready(function () {
        var placeholder = document.getElementById('creatorcodes-mount');

        if (!placeholder) {
            return;
        }

        var alreadyMounted = Array.prototype.slice
            .call(document.querySelectorAll('[data-creatorcodes-box]'))
            .some(function (el) {
                return !placeholder.contains(el);
            });

        if (alreadyMounted) {
            placeholder.remove();
            return;
        }

        var box = placeholder.querySelector('[data-creatorcodes-box]');

        if (!box) {
            placeholder.remove();
            return;
        }

        mount(box);
        placeholder.remove();
    });
})();
