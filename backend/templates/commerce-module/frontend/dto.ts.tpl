export type Create{{ Entity }}Payload = {
    code: string;
    name: string;
    slug: string;
    description?: string | null;
    enabled?: boolean;
};