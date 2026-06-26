import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { createProduct, fetchProducts } from '@/entities/product/api/product.api';
import { ProductList } from '@/entities/product/ui/ProductList';
import {
  createProductVariant,
  fetchProductVariants,
} from '@/entities/product-variant/api/product-variant.api';
import { CreateProductForm } from '../../features/product/create/CreateProductForm';
import { CreateProductVariantForm } from '../../features/product-variant/create/CreateProductVariantForm';

export function ProductsPage() {

  const queryClient = useQueryClient();

  const { data: products = [] } = useQuery({
    queryKey: ['products'],
    queryFn: fetchProducts,
  });

  const { data: variants = [] } = useQuery({
    queryKey: ['product-variants'],
    queryFn: fetchProductVariants,
  });


  const createProductMutation = useMutation({
    mutationFn: createProduct,
    onSuccess: () => queryClient.invalidateQueries({ queryKey: ['products'] }),
  });

  const createVariantMutation = useMutation({
     mutationFn: createProductVariant,
  });

  return (
    <main className="min-h-screen bg-slate-950 text-slate-50">
        <div className="mx-auto max-w-6xl px-6 py-10">
            <header className="mb-10">
                <h1 className="mt-2 text-4xl font-bold tracking-tight">
                    Product Catalog
                </h1>
                <p className="mt-3 max-w-2xl text-slate-400">
                    Manage products and product variants using Symfony API Platform + React.
                </p>
            </header>

            <div className="grid gap-6 lg:grid-cols-2">
                <CreateProductForm onSubmit={createProductMutation.mutate} />

                <CreateProductVariantForm 
                    products={products}
                    onSubmit={createVariantMutation.mutate}
                />

                <div className="lg:col-span-2">
                    <ProductList products={products} variants={variants} />
                </div>
            </div>
        </div>
    </main>
  );
  
}