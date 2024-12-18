<x-main-layout pageTitle="Game">

    <div class="container">
        <x-question :country="$country" :currentQuestion="$current_question" :totalQuestions="$total_questions" />

        <div class="row">
            @foreach ($answers as $answer)
                <x-answer :capital="$answer" />
            @endforeach
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('start_game') }}" class="btn btn-outline-danger mt-3 px-5">CANCELAR JOGO</a>
    </div>
</x-main-layout>
