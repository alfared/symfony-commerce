import { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import { getProducts } from "@/entities/product/api/product.api";
import type { Product } from "@/entities/product/model/product";

export function ProductPage() {
  const { slug } = useParams();
  const [product, setProduct] = useState<Product | null>(null);

  useEffect(() => {
    getProducts().then((products) => {
      setProduct(products.find((item) => item.slug === slug) ?? null);
    });
  }, [slug]);

  if (!product) {
    return (
      <main className="mx-auto grid max-w-7xl gap-10 px-6 py-10 lg:grid-cols-2">
        <p className="text-slate-400">Product not found.</p>
        <Link to="/catalog" className="mt-4 inline-block text-white underline">
          Back to catalog
        </Link>
      </main>
    );
  }

  return (
    <main className="mx-auto grid max-w-7xl gap-10 px-6 py-10 lg:grid-cols-2">
      <div className="flex min-h-[420px] items-center justify-center rounded-3xl bg-slate-900">
        <div className="h-56 w-56 rounded-3xl bg-slate-800" />
      </div>
    </main>
  );
}
