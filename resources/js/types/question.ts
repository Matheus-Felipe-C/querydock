export interface Question {
    id: number,
    title: string,
    difficulty: 'EASY' | 'MEDIUM' | 'HARD',
    tags: string[],
}