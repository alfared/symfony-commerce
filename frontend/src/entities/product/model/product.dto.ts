export type ProductDto = {
  '@id': string;
  '@type': string;
  code: string;
  name: string;
  slug: string;
  description?: string | null;
  enabled: boolean;
}

export type ProductsCollectionDto = {
    member?: ProductDto[];
   'hydra:member'?: ProductDto[];
};

export type CreateProductPayload = {
    code: string;
    name: string;
    slug: string;
    description?: string;
    enabled: boolean;
};