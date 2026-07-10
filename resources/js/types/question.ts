export interface Question {
    id: number,
    title: string,
    description: string,
    difficulty: 'EASY' | 'MEDIUM' | 'HARD',
    topics: string[],
    expected_answer: string,
}

export interface PaginateQuestions {
    data: Question[],
    current_page: number;
    last_page: number;
    links: any[];
}