import { apiClient } from '@/shared/api/client';
import type { Category } from '../model/category';

export type CreateCategoryPayload = {
    code: string;
    name: string;
    slug: string;
    description?: string | null;
    enabled?: boolean;
};

export type UpdateCategoryPayload = Partial<CreateCategoryPayload>;

export async function getCategories(): Promise<Category[]>{
    const response = await apiClient.get<Category[]>('/categories');
    return response.data;
}

export async function getCategoryByCode(code: string): Promise<Category> {
    const response = await apiClient.get<Category>(`/categories/by-code/${code}`);

    return response.data;
}

export async function createCategory(payload: CreateCategoryPayload): Promise<Category> {
    const response = await apiClient.post<Category>('/categories', payload);

    return response.data;
}

export async function updateCategory(id: number, payload: UpdateCategoryPayload): Promise<Category> {
  const response = await apiClient.put<Category>(`/categories/${id}`, payload);

  return response.data;
}