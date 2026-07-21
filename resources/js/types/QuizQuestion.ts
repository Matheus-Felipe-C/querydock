import { Question } from "./question";

export interface QuizQuestion {
    question: Question;
    weight: number;
    position: number;
    is_bonus: boolean;
    is_optional: boolean;
}