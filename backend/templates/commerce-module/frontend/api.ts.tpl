import { apiClient } from '@/shared/api/client';
import type { {{ Entity }} } from '../model/{{ entityKebab }}';
import type { Create{{ Entity }}Payload } from '../model/{{ entityKebab }}.dto';

export async function get{{ Entity }}s(): Promise<{{ Entity }}[]> {
    const response = await apiClient.get<{{ Entity }}[]>('/{{ entities }}');

    return response.data;
}

export async function create{{ Entity }}(
  payload: Create{{ Entity }}Payload,
): Promise<{{ Entity }}> {
    const response = await apiClient.post<{{ Entity }}>('/{{ entities }}', payload);

    return response.data;
}