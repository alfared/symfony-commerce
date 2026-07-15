import { apiClient } from '@/shared/api/client';
import type { Attribute } from '../model/attribute';
import type { CreateAttributePayload } from '../model/attribute.dto';

export async function getAttributes(): Promise<Attribute[]> {
    const response = await apiClient.get<Attribute[]>('/attributes');

    return response.data;
}

export async function createAttribute(
  payload: CreateAttributePayload,
): Promise<Attribute> {
    const response = await apiClient.post<Attribute>('/attributes', payload);

    return response.data;
}