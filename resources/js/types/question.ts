export interface Question {
    id: number,
    title: string,
    description: string,
    difficulty: 'EASY' | 'MEDIUM' | 'HARD',
    topics: string[],
    expected_answer: string,
}