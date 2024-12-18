<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class MainController extends Controller
{
    private $app_data;

    public function __construct()
    {
        // load app_data file from app folder
        $this->app_data = require(app_path('app_data.php'));
    }

    public function start_game(): View
    {
        return view('home');
    }

    public function prepare_game(Request $request)
    {

        $request->validate(
            [
                'total_questions' => ['required', 'integer', 'min:3', 'max:30']
            ],
            [
                'total_questions.required' => 'O número de questões é obrigatório',
                'total_questions.integer' => 'O número de questões deve ser um inteiro',
                'total_questions.min' => 'O número mínimo de questões deve ser igual ou maior que 3',
                'total_questions.max' => 'O número de questões deve ser menor ou igual a 30',
            ]
        );

        // get total questions
        $total_questions = intval($request->total_questions);

        // prepare all quiz structure
        $quiz = $this->prepare_quiz($total_questions);

        // store the quiz in session
        session()->put([
            'quiz' => $quiz,
            'total_questions' => $total_questions,
            'current_question' => 1,
            'correct_answers' => 0,
            'wrong_answers' => 0,
        ]);

        return redirect()->route('game');
    }

    public function game(): View
    {
        $quiz = session('quiz');
        $total_questions = session('total_questions');
        $current_question = session('current_question') - 1;

        // prepare answers to show in view
        $answers = $quiz[$current_question]['wrong_answers'];
        $answers[] = $quiz[$current_question]['correct_answer'];
        shuffle($answers);

        return view('game', [
            'country' => $quiz[$current_question]['country'],
            'total_questions' => $total_questions,
            'current_question' => $current_question,
            'answers' => $answers
        ]);
    }

    public function answer(string $encAnswer): View
    {
        try {
            $answer = Crypt::decryptString($encAnswer);
        } catch (Exception $e) {
            return redirect()->route('start_game');
        }

        // game logic
        $quiz = session('quiz');
        $currentQuestion = session('current_question') - 1;
        $correctAnswer = $quiz[$currentQuestion]['correct_answer'];
        $correctAnswers = session('correct_answers');
        $wrongAnswers = session('wrong_answers');

        if ($answer == $correctAnswer) {
            $correctAnswers++;
            $quiz[$currentQuestion]['correct'] = true;
        } else {
            $wrongAnswers++;
            $quiz[$currentQuestion]['correct'] = false;
        }

        // update session
        session()->put([
            'quiz' => $quiz,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
        ]);

        return view('answer_result', [
            'country' => $quiz[$currentQuestion]['country'],
            'correct_answer' => $correctAnswer,
            'chose_answer' => $answer,
            'current_question' => $currentQuestion,
            'total_questions' => session('total_questions')
        ]);
    }

    public function next_question()
    {
        $currentQuestion = session('current_question');
        $totalQuestions = session('total_questions');

        // check if the game is over
        if ($currentQuestion < $totalQuestions) {
            $currentQuestion++;
            session()->put('current_question', $currentQuestion);
            return redirect()->route('game');
        }

        // game over
        return redirect()->route('show_results');
    }

    public function show_results(): View
    {
        $correctAnswers = session('correct_answers');
        $totalQuestions = session('total_questions');

        return view('show_results', [
            'totalQuestions' => $totalQuestions,
            'correctAnswers' => $correctAnswers,
            'wrongAnswers' => session('wrong_answers'),
            'finalScore' => round($correctAnswers / $totalQuestions * 100, 2)
        ]);
    }

    private function prepare_quiz(int $total_questions)
    {
        $questions = [];
        $total_countries = count($this->app_data);

        // create countries index for unique questions
        $indexes = range(0, $total_countries - 1);
        shuffle($indexes);
        $indexes = array_slice($indexes, 0, $total_questions);

        // create array of questions
        $question_number = 1;
        foreach ($indexes as $index) {
            $question['question_number'] = $question_number++;
            $question['country'] = $this->app_data[$index]['country'];
            $question['correct_answer'] = $this->app_data[$index]['capital'];

            // wrong answers
            $other_capitals = array_column($this->app_data, 'capital');

            // remove correct answer from list
            $other_capitals = array_diff($other_capitals, [$question['correct_answer']]);
            shuffle($other_capitals);

            $question['wrong_answers'] = array_slice($other_capitals, 0, 3);

            // store answer result
            $question['correct'] = null;

            $questions[] = $question;
        }

        return $questions;
    }
}
