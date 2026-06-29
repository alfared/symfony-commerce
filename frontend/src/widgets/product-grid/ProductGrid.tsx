import { useEffect, useState } from "react";
import { fetchProducts } from "@/entities/product/api/product.api";
import type { Product } from "@/entities/product/model/product";

export function ProductGrid() {
  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    fetchProducts().then(setProducts);
  }, []);

  return (
    <section id="products" className="mx-auto max-w-7x1 px-6 py-10">
      <div className="mb-6">
        <h2 className="text-2xl font-bold">Featured products</h2>
        <p className="text-sm text-slate-400">
          Products loaded from Symfony API
        </p>
      </div>

      <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        {products.map((product) => (
          <article
            key={product.id}
            className="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900"
          >
            <div className="flex h-44 items-center justify-center bg-slate-900">
              <div className="h-24 w-24 rounded-2xl bg-slate-700" />
            </div>

            <div className="p-5">
              <p className="text-xs uppercase tracking-wide text-slate-500">
                {product.code}
              </p>
              <h3 className="mt-1 font-semibold">{product.name}</h3>
              <p className="mt-2 line-clamp-2 text-sm text-slate-400">
                {product.description}
              </p>

              <button className="mt-5 w-full rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-950">
                View product
              </button>
            </div>
          </article>
        ))}
      </div>
    </section>
  );
}
