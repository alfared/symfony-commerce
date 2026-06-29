import { useEffect, useState } from "react";
import {
  createProduct,
  fetchProducts,
} from "@/entities/product/api/product.api";
import { fetchProductVariants } from "@/entities/product-variant/api/product-variant.api";
import type { Product } from "@/entities/product/model/product";
import type { ProductVariant } from "@/entities/product-variant/model/product-variant";
import { ProductList } from "@/entities/product/ui/ProductList";
import { CreateProductForm } from "@/features/product/create/CreateProductForm";
import type { CreateProductPayload } from "@/entities/product/model/product.dto";

export function ProductManagement() {
  const [products, setProducts] = useState<Product[]>([]);
  const [variants, setVariants] = useState<ProductVariant[]>([]);

  useEffect(() => {
    Promise.all([fetchProducts(), fetchProductVariants()]).then(
      ([products, variants]) => {
        setProducts(products);
        setVariants(variants);
      },
    );
  }, []);

  const handleCreateProduct = async (payload: CreateProductPayload) => {
    const product = await createProduct(payload);
    setProducts((current) => [product, ...current]);
  };

  return (
    <div className="grid gap-6">
      <div className="grid gap-6 lg:grid-cols-2">
        <CreateProductForm onSubmit={handleCreateProduct} />
      </div>

      <ProductList products={products} variants={variants} />
    </div>
  );
}