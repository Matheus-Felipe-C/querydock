import { Question } from "./question";

export interface Quiz {
    id: number,
    title: string,
    time_limit: number | null,
    instructions: string | null,
    status: string,
    questions: Question[],
    questions_count: number;
    created_at: string;
    updated_at: string;
}