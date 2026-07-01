import { CategoryManagement } from "@/widgets/category-management/CategoryManagement";
import { ProductManagement } from "@/widgets/product-management/ProductManagement";

export function AdminPage() {
  return (
    <div className="min-h-screen bg-slate-950 p-6 text-slate-50">
      <h1 className="text-3x1 font-bold">Product Catalog Admin</h1>
      <p className="mt-2 text-slate-400">
        Manage products, variants and categories.
      </p>

      <div className="mt-10 grid gap-8">
        <ProductManagement />
        <CategoryManagement />
      </div>
    </div>
  );
}
