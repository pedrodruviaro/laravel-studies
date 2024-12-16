<x-layout>
    <x-page-heading>Results for "{{ $q }}"</x-page-heading>

    <section>
        <div class="space-y-6">
            @if (count($jobs) !== 0)
                @foreach ($jobs as $job)
                    <x-job-card-wide :$job />
                @endforeach
            @else
                <p class="font-bold text-center text-xl">No jobs here...</p>
            @endif
        </div>
    </section>
</x-layout>
