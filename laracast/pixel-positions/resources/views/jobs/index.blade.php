<x-layout>
    <div class="space-y-10">

        <section class="flex flex-col pt-6 pb-10 items-center justify-center gap-6 text-center">
            <h1 class="font-bold text-4xl">Let's Find Your Next Job</h1>

            <x-forms.form action="/search" class="w-full">
                <x-forms.input :label="false" name="q" placeholder="Web Developer..." />
            </x-forms.form>
        </section>

        <section>
            <x-section-heading>Features Jobs</x-section-heading>

            <div class="mt-6 grid lg:grid-cols-3 gap-8">
                @foreach ($featured_jobs as $job)
                    <x-job-card :$job />
                @endforeach
            </div>
        </section>

        <section>
            <x-section-heading>Tags</x-section-heading>

            <div class="mt-6 flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                    <x-tag :tag="$tag" />
                @endforeach
            </div>
        </section>

        <section>
            <x-section-heading>Recent Jobs</x-section-heading>

            <div class="mt-6 space-y-6">
                @foreach ($jobs as $job)
                    <x-job-card-wide :$job />
                @endforeach
            </div>
        </section>
    </div>
</x-layout>
