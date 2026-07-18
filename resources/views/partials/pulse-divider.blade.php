@php $id = 'pulse-' . uniqid(); @endphp
<svg class="pulse-divider" viewBox="0 0 600 28" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path d="M0 14 H220 L235 2 L252 26 L268 14 H600"
          fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          style="stroke-dasharray: 620; stroke-dashoffset: 620; animation: draw-divider 1.4s ease-out forwards;" />
</svg>
<style>
@keyframes draw-divider { to { stroke-dashoffset: 0; } }
@media (prefers-reduced-motion: reduce) {
    .pulse-divider path { animation: none !important; stroke-dashoffset: 0 !important; }
}
</style>
