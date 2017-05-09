<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\View;
use Auth;
use Mail;

use App\Models\ShopOrder;
use Illuminate\Support\Facades\Request;
use \App\Models\Country;

use Illuminate\Support\Facades\Session;
use App\Models\QuizResult;


class PagesController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function home() {

//        $user = User::find(1);
//
//        Auth::login($user);

        return view('pages.home', [

        ]);

    }
    public function dashboard() {

        $user = Auth::user();
        $companies = $user->companies;



        return view('pages.dashboard', [
            'user' => $user,
            'companies' => $companies
        ]);

    }
//
//    public function intro() {
//        $currentQuizId = config('quiz.active_quiz');
//        $quiz = Quiz::find($currentQuizId);
//
//        $questions = QuizQuestion::where('active', '=', '1')->get();
//        return View::make('quiz.intro', [
//                    'quiz' => $quiz,
//                    'questions' => $questions
//        ]);
//    }
//
//    public function questionPage() {
//
//        $currentQuizId = config('quiz.active_quiz');
//        $quiz = Quiz::find($currentQuizId);
//
//        return View::make('quiz.questions', [
//                    'quiz' => $quiz,
//                    'noHeaderMobile' => true
//        ]);
//    }
//
//    public function result($resultCId) {
//        $quizUser = QuizUser::find(CryptId::unCryptHashToId($resultCId));
//        if (!$quizUser) {
//            return redirect(route('quiz_home'));
//        }
//
//        $comment = QuizResult::getComment($quizUser->quiz_id, $quizUser->score);
//
//        return View::make('quiz.result', [
//                    'pageTitle' => 'Le CaroloQuiz de ' . $quizUser->user->firstname,
//                    'og_image' => 'http://carolofornie.be/site_elements/layout/quiz/caroloquiz.png',
//                    'og_url' => $_SERVER['SCRIPT_URI'],
//                    'og_description' => 'Un score de ' . $quizUser->score . ' / ' . $quizUser->quiz->nbr_questions . ' ' . $comment->comment,
//                    'og_type' => 'article',
//                    'quizUser' => $quizUser,
//                    'user' => $quizUser->user,
//                    'comment' => $comment,
//        ]);
//    }
//
//    public function questions($encode_json = true) {
//
//        $arrayReturn = [];
//
//        $currentQuizId = config('quiz.active_quiz');
//
//        $quiz = Quiz::find($currentQuizId);
//
////        $user = Auth::user();
//        $user = Auth::user();
//        // -- testing if a quiz is already  begun
//        // -- (a quiz is a groupe of questions)
//        $quizUser = QuizUser::retrieveOrCreate($user->id, $currentQuizId);
//        $arrayReturn['quiz_user_cid'] = CryptId::cryptIdToHash($quizUser->id);
//
//        // -- nbr answer for this quiz user
//        $userAnswersCount = count($quizUser->quizUserAnswers);
//
//        // -- test if we have to show question or redirect :
//        // -- the condition is the nbr of answered and number of questionon quiz
//        if ($userAnswersCount >= $quiz->nbr_questions) {
//            // -- Stop this quizuser
//            // -- set curent quiz as finished
//            $quizUser->is_finished = date('Y-m-d H:i:s');
//            $quizUser->save();
//
//            $arrayReturn['success'] = false;
//            $arrayReturn['reason'] = 'quiz_finished';
//            $arrayReturn['quiz_result'] = [];
//            $arrayReturn['quiz_result']['cid'] = CryptId::cryptIdToHash($quizUser->id);
//            $arrayReturn['quiz_result']['facebook_id'] = $quizUser->user->facebook_id;
//            $arrayReturn['quiz_result']['score'] = $quizUser->score;
//            $arrayReturn['quiz_result']['total_questions'] = $quizUser->quiz->nbr_questions;
//            $arrayReturn['quiz_result']['comment'] = QuizResult::getComment($quizUser->quiz_id, $quizUser->score)->comment;
//            $arrayReturn['quiz_result']['link_result'] = route('quiz_question_result', ['resultCId' => CryptId::cryptIdToHash($quizUser->id)]);
//
//
//            if ($encode_json) {
//                $arrayReturn = json_encode($arrayReturn);
//            }
//            return $arrayReturn;
//        }
//        // -- todo : check if userhave not answered to a question pending
//        $userAnswer = QuizUserAnswer::existsPendingQuestion($quizUser->id);
//        if ($userAnswer) {
//            // -- taking pending question not answered
//            $question = QuizQuestion::find($userAnswer->question_id);
//        } else {
//            // -- looking for a random question but need to know whichs are already answred
//            $alreadyAnswered = $quizUser->quizUserAnswers;
//            $question = QuizQuestion::getQuestionRandomlyFromQuiz($currentQuizId, $alreadyAnswered);
//            if (!$question) {
//
//                $arrayReturn['success'] = false;
//                $arrayReturn['reason'] = 'no_more_question';
//                if ($encode_json) {
//                    $arrayReturn = json_encode($arrayReturn);
//                }
//                return $arrayReturn;
//            }
//            $userAnswer = QuizUserAnswer::createUserAnswer($quizUser->id, $question->id);
//        }
//
//        $answers = $question->answersRandom;
//
//        $arrayReturn['success'] = true;
//
//
//        $arrayReturn['question'] = [];
//        $arrayReturn['question']['title'] = $question->question;
//        $arrayReturn['question']['questions_total'] = $quiz->nbr_questions;
//        $arrayReturn['question']['score'] = $quizUser->score;
//        $arrayReturn['question']['user'] = [];
////        $arrayReturn['question']['user']['firstname'] = $question->user->firstname;
////        $arrayReturn['question']['user']['lastname'] = $question->user->lastname;
//
//        $arrayReturn['score'] = $quizUser->score;
//
//        $arrayReturn['answers'] = [];
//        foreach ($answers as $answer) {
//            $arrayAnswer = [];
//            $arrayAnswer['title'] = $answer->answer;
//            $arrayAnswer['cid'] = CryptId::cryptIdToHash($answer->id);
//
//            $arrayReturn['answers'][] = $arrayAnswer;
//        }
//
//        if ($encode_json) {
//            $arrayReturn = json_encode($arrayReturn);
//        }
//        return $arrayReturn;
//    }
//
//    public function answer() {
//        $arrayReturn = [];
//        $arrayReturn['success'] = false;
//
//
//
//        $currentQuizId = config('quiz.active_quiz');
//        $quiz = Quiz::find($currentQuizId);
//
//        $user = Auth::user();
//        // -- testing if a quiz is already  begun
//        // -- (a quiz is a groupe of questions)
//        $quizUser = QuizUser::userIsPlaying($user->id, $currentQuizId);
//        // -- no pending queston
//        if ($quizUser === false) {
//            $arrayReturn['reason'] = 'no_active_quiz';
//            return json_encode($arrayReturn);
//        }
//        // -- Looking for pending question for this quiz
//        $pendingQuestion = QuizUserAnswer::existsPendingQuestion($quizUser->id);
//        if ($pendingQuestion === false) {
//            $arrayReturn['reason'] = 'no_pending_question';
//            return json_encode($arrayReturn);
//        }
//        // -- define as no correctanswer by default
//        $arrayReturn['is_correct'] = false;
//
//        $inputAnswerCid = Request::input('acid');
//
//
//
//
//        // -- test if the time given to answer is ok
//        $asnwerBeginDate = strtotime($pendingQuestion->time_start);
//        $nowTimeMinusTimeByQuestion = strtotime(date('Y-m-d H:i:s')) - $quiz->time_by_questions;
//
//        // -- IF -1 OUTOF TIME answer
//        if ($inputAnswerCid === -1) {
//            $arrayReturn['answer_given_cid'] = -1;
//            // -- Check server side if question is answered in time
//        } else if ($nowTimeMinusTimeByQuestion >= $asnwerBeginDate) {
//            $arrayReturn['answer_given_cid'] = -1;
//        } else {
//            //
//            $answerId = CryptId::unCryptHashToId($inputAnswerCid);
//            $answer = QuizAnswer::find($answerId);
//
//            // -- CHECK IF ANSWER IF FOR THIS QUESTION
//            if ($pendingQuestion->question_id != $answer->question_id) {
//                $arrayReturn['reason'] = 'answer_not_for_pending_question';
//
//                return json_encode($arrayReturn);
//            }
//
//
//            // -- Answer question
//            if ($answer->is_correct_answer) {
//                $pendingQuestion->is_correct = 1;
//                $quizUser->score = $quizUser->score + 1;
//                $quizUser->save();
//                // -- return it 's the good answer
//                $arrayReturn['is_correct'] = true;
//            }
//            // -- define answered question
//            $pendingQuestion->answer_id = $answer->id;
//
//
//            $arrayReturn['answer_given_cid'] = CryptId::cryptIdToHash($answerId);
//        }
//
//        if (Request::has('isMobile')) {
//            $pendingQuestion->is_mobile = 1;
//        }
//
//        $pendingQuestion->time_answering = date('Y-m-d H:i:s');
//        $pendingQuestion->save();
//
//        // -- Correct answer
//        $currentQuestion = QuizQuestion::find($pendingQuestion->question_id);
//        $correctAnswer = $currentQuestion->correctAnswer();
//        $arrayReturn['correct_answer'] = [];
//        $arrayReturn['correct_answer']['cid'] = CryptId::cryptIdToHash($correctAnswer->id);
//
//        $arrayReturn['score'] = $quizUser->score;
//        ;
//
//        $arrayReturn['success'] = true;
//        //$arrayReturn['question_new'] = $this->questions(false);
////        if ($arrayReturn['question_new']['success']) {
////            $arrayReturn['success'] = true;
////        } else {
////            $arrayReturn['success'] = false;
////            $arrayReturn['reason'] = $arrayReturn['question_new']['reason'];
////        }
//
//        return json_encode($arrayReturn);
//    }
//
//    public function suggest() {
//
//        $currentQuizId = config('quiz.active_quiz');
//        $quiz = Quiz::find($currentQuizId);
//        $user = Auth::user();
//
//        $userQuestions = QuizQuestion::questionSuggestedByUser($user->id);
//
//        return View::make('quiz.suggest', [
//                    'quiz' => $quiz,
//                    'user' => $user,
//                    'userQuestions' => $userQuestions,
//        ]);
//    }
//
//    public function suggestDo(QuizSuggestQuestionRequest $request) {
//
//        $currentQuizId = config('quiz.active_quiz');
//        $quiz = Quiz::find($currentQuizId);
//        $user = Auth::user();
//
//        $question = new QuizQuestion;
//        $question->question = $request['question'];
//        $question->quiz_id = $currentQuizId;
//        $question->suggested_by_user_id = $user->id;
//        $question->comment_from_user = trim($request['comment']);
//
//        $question->save();
//
//        // -- answer
//        for ($i = 0; $i < 4; $i++) {
//            $answer = new QuizAnswer;
//            $answer->question_id = $question->id;
//            $answer->is_correct_answer = $i == 0 ? 1 : 0;
//            $answer->answer = trim($request['answer_' . $i]);
//            $answer->save();
//        }
//
//        $totalAnswer = $question->answers;
//
//        Mail::send('emails.quiz_suggestion', ['question' => $question, 'user' => $user, 'answers' => $totalAnswer], function ($m) {
//            $m->to('bri@fatcha.be', 'brieuc')->subject('[Carolofornie] Nouvelle question suggerée');
//        });
//
//        return redirect(route('quiz_suggest'));
//    }
//
//    public function contributors() {
//        $questionsUserDistinc = QuizQuestion::distinct()->select('suggested_by_user_id')->get();
//        return View::make('quiz.contributors', [
//                    'contributors' => $questionsUserDistinc,
//                    'pageTitle' => 'Les contributeurs du CaroloQuiz',
//                    'og_image' => 'http://carolofornie.be/site_elements/layout/quiz/caroloquiz.png',
//                    'og_url' => $_SERVER['SCRIPT_URI'],
//                    'og_description' => "C'est grâce à eux, que vous êtes frustrés :). Mais vous aussi vous pouvez rendre dingue les joueurs en proposant vos questions",
//                    'og_type' => 'article'
//        ]);
//    }

}
