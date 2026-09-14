export interface Dataset {
    id: number,
    name: string,
    description: string | null,
    sql_script?: string,
    created_at?: string,
    updated_at?: string,
}