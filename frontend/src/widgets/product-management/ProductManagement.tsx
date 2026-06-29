import { useEffect, useState } from 'react';
import { fetchProducts } from '@/entities/product/api/product.api'
import type { Product } from '@/entities/product/model/product';
import { ProductList } from '@/entities/product/ui/ProductList';
import { CreateProductForm } from '@/features/product/create/CreateProductForm';
import { CreateProductVariantForm } from '@/features/product-variant/create/CreateProductVariantForm';

export function ProductManagement() {
  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    fetchProducts().then(setProducts);
  }, []);

  return (
    <div className="grid gap-6">
      <div className="grid gap-6 lg:grid-cols-2">
        <CreateProductForm onCreated={(product) => setProducts((current) => [product, ...current])} />
        <CreateProductVariantForm products={products} />
      </div>

      <ProductList products={products} />
    </div>
  );
}