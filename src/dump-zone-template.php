<?php use DumpZone\DumpZone; ?>

<style>
    .dz-overflow-hidden {
        overflow: hidden;
    }

    .dz-output {
        background-color: #18171B;
        bottom: 1rem;
        display: none;
        left: 1rem;
        min-height: calc(100% - 2rem);
        overflow: scroll;
        padding-left: 1rem;
        padding-right: 1rem;
        position: fixed;
        right: 1rem;
        top: 1rem;
    }

    .dz-active .dz-output {
        display: block;
    }

    .dz-toggle {
        bottom: 1rem;
        position: fixed;
        right: 1rem;
        z-index: 999999;
    }
</style>

<script>
    (function() {
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.dz-dump-zone');
            const toggle = document.querySelector('.dz-toggle');
            const output = document.querySelector('.dz-output');

            toggle.addEventListener('click', () => {
                container.classList.toggle('dz-active');
                document.body.classList.toggle('dz-overflow-hidden');

                if (container.classList.contains('dz-active')) {
                    toggle.textContent = toggle.textContent.replace('Show', 'Hide');
                } else {
                    toggle.textContent = toggle.textContent.replace('Hide', 'Show');
                }
            });
        });
    })();
</script>

<div class="dz-dump-zone">
    <button class="dz-toggle">
        Show Dumps (<?= DumpZone::getDumpCount(); ?>)
    </button>

    <div class="dz-output">
        <?php \do_action(DumpZone::class); ?>
    </div>
</div>
