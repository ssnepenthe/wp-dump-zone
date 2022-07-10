<?php use DumpZone\DumpZone; ?>

<style>
    .dz-overflow-hidden {
        overflow: hidden;
    }

    .dz-dump-zone {
        background-color: #18171B;
        bottom: 0;
        height: 70%;
        position: fixed;
        transform: translateY(100%);
        transition: transform 0.2s;
        width: 100%;
        z-index: 9991; /* Ensures we are in front of #adminmenuwrap */
    }

    .dz-active {
        transform: translateY(0);
    }

    .dz-toggle {
        background-color: #18171B;
        border: none;
        border-radius: 0.4rem 0.4rem 0 0;
        color: white;
        display: block;
        margin-left: auto;
        padding: 1rem;
        position: fixed;
        right: 1rem;
        transform: translateY(-100%);
    }

    .dz-output {
        height: 100%;
        overflow: scroll;
    }

    .dz-dump-zone svg {
        height: 1rem;
        width: 1rem;
        vertical-align: middle;
        margin-right: 0.4rem;
        transition: transform 0.2s;
    }

    .dz-active svg {
        transform: rotate(180deg);
    }
</style>

<script>
    (function() {
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.dz-dump-zone');
            const toggle = document.querySelector('.dz-toggle');

            toggle.addEventListener('click', () => {
                container.classList.toggle('dz-active');
                document.body.classList.toggle('dz-overflow-hidden');
            });
        });
    })();
</script>

<div class="dz-dump-zone">
    <button class="dz-toggle">
        <svg viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="icon-shape">
                    <path fill="white" d="M10,0 C4.4771525,-3.55271368e-15 3.55271368e-15,4.4771525 0,10 C0,15.5228475 4.4771525,20 10,20 C15.5228475,20 20,15.5228475 20,10 C20,4.4771525 15.5228475,0 10,0 L10,0 Z M10,2 C5.581722,2 2,5.581722 2,10 C2,14.418278 5.581722,18 10,18 C14.418278,18 18,14.418278 18,10 C18,5.581722 14.418278,2 10,2 L10,2 Z M12,10 L8,10 L8,15 L12,15 L12,10 L12,10 Z M10,5 L5,10 L15,10 L10,5 L10,5 Z"></path>
                </g>
            </g>
        </svg>

        <span class="dz-toggle-label">
            Toggle Dump Zone (<?= DumpZone::getDumpCount(); ?>)
        </span>
    </button>

    <div class="dz-output">
        <?php DumpZone::renderDumps(); ?>
    </div>
</div>
