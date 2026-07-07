import { useEffect, useState } from "react";
import { getCategories } from "@/entities/category/api/categoryApi";
import type { Category } from "@/entities/category/model/category";

export function CategoryStrip() {
  const [categories, setCategories] = useState<Category[]>([]);

  useEffect(() => {
    getCategories().then(setCategories);
  }, []);

  return (
    <section id="categories" className="mx-auto max-w-7xl px-6 py-6">
      <div className="mb-5 flex items-end justify-between">
        <div>
          <h2 className="text-2x1 font-bold">Shop by category</h2>
          <p className="text-sm text-slate-400">
            Browse popular catalog sections
          </p>
        </div>
      </div>

      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        {categories.slice(0, 10).map((category) => (
          <div
            key={category.id}
            className="rounded-2xl border border-slate-800 bg-slate-900 p-5 transition hover:-translate-y-1 hover:border-slate-600"
          >
            <div className="mb-4 h-12 w-12 rounded-xl bg-slate-800" />
            <h3 className="font-semibold">{category.name}</h3>
            <p className="mt-1 text-sm text-slate-400">{category.description}</p>
          </div>
        ))}
      </div>
    </section>
  );
}
