import type { ProductVariantDto } from '../model/product-variant.dto';
import type { ProductVariant } from '../model/product-variant';

function extractIdFromIri(iri: string): number {
  return Number(iri.split('/').pop());
}

export function toProductVariant(dto: ProductVariantDto): ProductVariant {
    return {
        id: extractIdFromIri(dto['@id']),
        iri: dto['@id'],
        productIri: dto.product,
        productId: extractIdFromIri(dto.product),
        code: dto.code,
        sku: dto.sku,
        price: dto.price,
        stock: dto.stock,
        enabled: dto.enabled,
    }
}