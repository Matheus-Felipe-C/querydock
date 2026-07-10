import { Question } from "./question";

export interface Quiz {
    title: string,
    timeLimit: number,
    instructions: string,
    status: string,
    questions: Question,
}