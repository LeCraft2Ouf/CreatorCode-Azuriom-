<style>
    .alert-success {
        background: #163528 !important;
        color: #c6f6d5 !important;
        border-color: #2f6f4e !important;
    }
    .alert-danger {
        background: #3a1c1c !important;
        color: #fecaca !important;
    }
    .creatorcodes-box {
        width: 100%;
        margin: 1.25rem 0 0;
        padding: 0;
    }
    .creatorcodes-box .input-group {
        max-width: 100% !important;
    }
</style>
<div id="creatorcodes-mount" hidden>
    @include('creatorcodes::shop.box')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var mount = document.getElementById('creatorcodes-mount');
        if (!mount) {
            return;
        }

        var alreadyInPage = Array.prototype.slice.call(document.querySelectorAll('[data-creatorcodes-box]'))
            .some(function (el) {
                return !mount.contains(el);
            });

        if (alreadyInPage) {
            mount.remove();
            return;
        }

        var box = mount.querySelector('[data-creatorcodes-box]');
        if (!box) {
            mount.remove();
            return;
        }

        function shopSidebar() {
            var shop = document.getElementById('shop');
            if (!shop) {
                return null;
            }

            var children = shop.children;
            for (var i = 0; i < children.length; i++) {
                if (!children[i].classList.contains('shop-content')) {
                    return children[i];
                }
            }

            return shop.querySelector('aside, nav') || shop.firstElementChild;
        }

        function goalBlock(sidebar) {
            var progress = sidebar.querySelector('.progress');
            if (!progress) {
                var headings = sidebar.querySelectorAll('h6, h5, .fw-bold');
                for (var i = 0; i < headings.length; i++) {
                    var text = (headings[i].textContent || '').toLowerCase();
                    if (text.indexOf('objectif') !== -1 || text.indexOf('goal') !== -1) {
                        progress = headings[i];
                        break;
                    }
                }
            }

            if (!progress) {
                return sidebar.querySelector('.mt-auto');
            }

            var el = progress;
            while (el.parentElement && el.parentElement !== sidebar) {
                var parent = el.parentElement;
                var parentText = parent.textContent || '';
                if (/cat[eé]gorie/i.test(parentText) && parent.querySelector('.progress')) {
                    return el;
                }
                el = parent;
            }

            return el;
        }

        var sidebar = shopSidebar();
        var placed = false;

        if (sidebar) {
            var goal = goalBlock(sidebar);
            if (goal && goal.parentNode) {
                goal.parentNode.insertBefore(box, goal);
                placed = true;
            } else {
                sidebar.appendChild(box);
                placed = true;
            }
        }

        if (!placed) {
            var fallback = document.querySelector('.card-body') || document.body;
            fallback.appendChild(box);
        }

        mount.remove();
    });
</script>
