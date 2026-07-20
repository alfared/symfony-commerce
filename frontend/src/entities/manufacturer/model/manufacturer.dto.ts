export type CreateManufacturerPayload = {
    code: string;
    name: string;
    slug: string;
    description?: string | null;
    enabled?: boolean;
};