export type ProductVariantDto = {
  '@id': string;
  '@type': string;
  product: string;
  code: string;
  sku: string;
  price: number;
  stock: number;
  enabled: boolean;
};

export type ProductVariantsCollectionDto = {
    member?: ProductVariantDto[];
    'hydra:member'?: ProductVariantDto[];
};

export type CreateProductVariantPayload = {
    productId: number;
    code: string;
    sku: string;
    price: number;
    stock: number;
    enabled: boolean;
};