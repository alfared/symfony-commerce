import { apiClient } from '@/shared/api/client';
import { toProductVariant } from '../mapper/product-variant.mapper';
import type { ProductVariant } from '../model/product-variant';
import type {
  CreateProductVariantPayload,
  ProductVariantsCollectionDto,
} from '../model/product-variant.dto';

export async function fetchProductVariants(): Promise<ProductVariant[]> {
    const response = await apiClient.get<ProductVariantsCollectionDto>('/product-variants');
    const items = response.data.member ?? response.data['hydra:member'] ?? [];

    return items.map(toProductVariant);
}

export async function createProductVariant(
    payload: CreateProductVariantPayload,
): Promise<ProductVariant> {
    const response = await apiClient.post('/product-variants', payload);

    return toProductVariant(response.data);
}