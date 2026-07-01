import { ProductGrid } from "@/widgets/product-grid/ProductGrid";

export function CatalogPage() {
  return (
    <main className="mx-auto max-w-7xl px-6 py-10">
      <div className="mb-8">
        <p className="text-sm font-semibold uppercase tracking-wide text-slate-400">
          Catalog
        </p>
        <h1 className="mt-2 text-4xl font-bold">All products</h1>
        <p className="mt-3 text-slate-400">
          Browse products loaded from Symfony API.
        </p>
      </div>

      <ProductGrid />
    </main>
  );
}
