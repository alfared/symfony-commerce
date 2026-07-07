export type CreateBrandPayload = {
    code: string;
    name: string;
    slug: string;
    description?: string | null;
    enabled?: boolean;
};