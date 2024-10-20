@props(['field'])
@if ($errors->has($field))
    <div class="text-danger mt-1">{{ $errors->first($field) }}</div>
@endif