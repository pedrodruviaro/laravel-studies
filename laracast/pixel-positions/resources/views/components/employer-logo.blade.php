@props(['employer', 'width' => 90])

<img src="{{ asset($employer->logo) }}" width="{{ $width }}" alt="" class="rounded-xl">
