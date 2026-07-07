import type { Category } from "../model/category";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

type Props = {
  categories: Category[];
};

export function CategoryList({ categories }: Props) {
  return (
    <Card className="border-slate-800 bg-slate-900 text-slate-50">
      <CardHeader>
        <CardTitle>Categories</CardTitle>
      </CardHeader>

      <CardContent>
        <div className="grid gap-3">
          {categories.map((category) => (
            <div
              key={category.id}
              className="rounded-xl border border-slate-800 bg-slate-950 p-4"
            >
              <div className="flex items-center justify-between gap-4">
                <div>
                    <h3 className="font-semibold">{category.name}</h3>
                    <p className="text-sm text-slate-400">{category.code}</p>
                    <p className="text-sm text-slate-500">/{category.slug}</p>
                </div>

                <Badge variant={category.enabled ? 'default' : 'secondary'}>
                    {category.enabled ? 'Enabled' : 'Disabled'}
                </Badge>
              </div>

              {category.description && (
                <p className="mt-3 text-sm text-slate-400">{category.description}</p>
              )}
            </div>
          ))}
        </div>
      </CardContent>
    </Card>
  );
}
