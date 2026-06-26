import { apiClient } from '@/shared/api/client';
import { toProduct } from '../mapper/product.mapper';
import type { Product } from '../model/product';
import type { CreateProductPayload, ProductsCollectionDto } from '../model/product.dto';

export async function fetchProducts(): Promise<Product[]> {
    const response = await apiClient.get<ProductsCollectionDto>('/products');
    const items = response.data.member ?? response.data['hydra:member'] ?? [];

    return items.map(toProduct);
}

export async function createProduct(payload: CreateProductPayload): Promise<Product> {
    const response = await apiClient.post('/products', payload);

    return toProduct(response.data);
}