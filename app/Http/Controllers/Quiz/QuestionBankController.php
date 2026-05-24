<?php

namespace App\Http\Controllers\Quiz;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class QuestionBankController extends Controller
{
    public function index()
    {
        $questions = [
            [
                'id' => 1,
                'title' => 'Monthly Revenue Calculation',
                'difficulty' => 'MEDIUM',
                'tags' => ['Aggregations', 'GROUP BY', 'DATE functions'],
            ],
            [
                'id' => 2,
                'title' => 'Find Orphaned Records',
                'difficulty' => 'HARD',
                'tags' => ['Joins', 'LEFT JOIN', 'NULL check'],
            ],
            [
                'id' => 3,
                'title' => 'Basic User Table Setup',
                'difficulty' => 'EASY',
                'tags' => ['DDL', 'CREATE TABLE'],
            ],
            [
                'id' => 4,
                'title' => 'Running Total by Category',
                'difficulty' => 'HARD',
                'tags' => ['Window Functions', 'OVER', 'PARTITION BY'],
            ],
            [
                'id' => 5,
                'title' => 'Filter Active Customers',
                'difficulty' => 'EASY',
                'tags' => ['WHERE', 'SELECT'],
            ],
            [
                'id' => 6,
                'title' => 'Top 5 Products by Sales',
                'difficulty' => 'MEDIUM',
                'tags' => ['ORDER BY', 'LIMIT', 'Aggregations'],
            ],
            [
                'id' => 7,
                'title' => 'Employees Above Department Average',
                'difficulty' => 'HARD',
                'tags' => ['Subqueries', 'AVG', 'Correlated'],
            ],
            [
                'id' => 8,
                'title' => 'Count Orders Per Customer',
                'difficulty' => 'EASY',
                'tags' => ['GROUP BY', 'COUNT', 'Aggregations'],
            ],
        ];

        return Inertia::render('Quiz/QuestionBank', [
            'questions' => $questions,
        ]);
    }
}
