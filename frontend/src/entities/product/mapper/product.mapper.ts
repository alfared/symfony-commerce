import type { ProductDto } from '../model/product.dto';
import type { Product } from '../model/product';

export function toProduct(dto: ProductDto): Product {
  return {
    id: Number(dto['@id'].split('/').pop()),
    iri: dto['@id'],
    code: dto.code,
    name: dto.name,
    slug: dto.slug,
    description: dto.description ?? null,
    enabled: dto.enabled,
  };
}