<?php $message = session('success') ?? session('errors') ?>

@if ($message)
    <div class="alert alert-{{ (session('success')) ? 'success' : 'danger' }}" role="alert">
        @if (is_array($message))
            <ul>
                @foreach ($message as $m)
                    <li>{{ $m }}</li>
                @endforeach
            </ul>
        @else
            {{ $message }}
        @endif
    </div>
@endif