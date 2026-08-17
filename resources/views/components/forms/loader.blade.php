@props([
   'active' => false,
])
<div {{ $attributes->class(['wrapper_loader',  'active' => $active,]) }}>
    <span class="loader"></span>
</div>
