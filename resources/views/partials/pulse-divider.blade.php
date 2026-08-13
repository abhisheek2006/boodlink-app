@php
    $id = 'pulse-' . uniqid();
@endphp

<div class="bl-pulse-divider" aria-hidden="true">
    <svg
        id="{{ $id }}"
        viewBox="0 0 600 28"
        preserveAspectRatio="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M0 14 H220
               L235 14
               L245 4
               L255 24
               L265 14
               H600"
            fill="none"
            stroke="#EF233C"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </svg>
</div>

<style>
    .bl-pulse-divider {
        width: 100%;
        height: 28px;
        margin: 20px 0;
        overflow: hidden;
        opacity: .85;
    }

    .bl-pulse-divider svg {
        display: block;
        width: 100%;
        height: 100%;
    }

    .bl-pulse-divider path {
        stroke-dasharray: 620;
        stroke-dashoffset: 620;
        animation:
            bl-draw-pulse 1.5s cubic-bezier(.4, 0, .2, 1) forwards,
            bl-pulse-glow 2.5s ease-in-out 1.5s infinite;
    }

    @keyframes bl-draw-pulse {
        from {
            stroke-dashoffset: 620;
        }

        to {
            stroke-dashoffset: 0;
        }
    }

    @keyframes bl-pulse-glow {
        0%,
        100% {
            opacity: .65;
        }

        50% {
            opacity: 1;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .bl-pulse-divider path {
            animation: none !important;
            stroke-dashoffset: 0 !important;
        }
    }
</style>