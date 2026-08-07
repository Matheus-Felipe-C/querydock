import { Question } from "./question";

export interface Quiz {
    id: number,
    title: string,
    timeLimit: number,
    instructions: string,
    status: string,
    questions: Question,
    questions_count: number;
}