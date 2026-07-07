import { apiClient } from '@/shared/api/client';
import { toProduct } from '../mapper/product.mapper';
import type { Product } from '../model/product';
import type { CreateProductPayload } from '../model/product.dto';


export async function getProducts(): Promise<Product[]> {
    const response = await apiClient.get<Product[]>('/products');
    return response.data
}

export async function createProduct(payload: CreateProductPayload): Promise<Product> {
    const response = await apiClient.post('/products', payload);

    return toProduct(response.data);
}