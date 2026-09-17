import {Quiz} from "@/types/quiz.ts";

export interface DashboardSummary {
    quiz_count: number,
    submission_count: number,
    avg_score: number,
    active_quiz_count: number,
}

export interface QuizSummary extends Pick<Quiz, 'id' | 'title' | 'questions_count' | 'updated_at' | 'updated_at_human'>{
    submissions_count: number,
    avg_score: number,
}
