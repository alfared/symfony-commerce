import { FormEvent, useState } from 'react';
import type { Product } from '@/entities/product/model/product';
import type { CreateProductVariantPayload } from '@/entities/product-variant/model/product-variant.dto';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

type Props = {
  products: Product[];
  onSubmit: (payload: CreateProductVariantPayload) => void;
};

export function CreateProductVariantForm({ products, onSubmit }: Props) {
  const [form, setForm] = useState({
    productId: '',
    code: '',
    sku: '',
    price: '',
    stock: '',
    enabled: true,
  });

  function submit(event: FormEvent) {
    event.preventDefault();

    onSubmit({
      productId: Number(form.productId),
      code: form.code,
      sku: form.sku,
      price: Number(form.price),
      stock: Number(form.stock),
      enabled: form.enabled,
    });
  }

  return (
    <Card className="border-slate-800 bg-slate-900 text-slate-50">
      <CardHeader>
        <CardTitle>Create Variant</CardTitle>
        <CardDescription>
          Variant contains SKU, price and stock like in Sylius.
        </CardDescription>
      </CardHeader>

      <CardContent>
        <form className="grid gap-4" onSubmit={submit}>
          <div className="grid gap-2">
            <Label>Product</Label>
            <select
              className="h-10 rounded-md border border-slate-700 bg-slate-950 px-3 text-sm"
              value={form.productId}
              onChange={(e) => setForm({ ...form, productId: e.target.value })}
            >
              <option value="">Select product</option>
              {products.map((product) => (
                <option key={product.id} value={product.id}>
                  {product.name}
                </option>
              ))}
            </select>
          </div>

          <div className="grid gap-2">
            <Label>Code</Label>
            <Input value={form.code} onChange={(e) => setForm({ ...form, code: e.target.value })} placeholder="IPHONE_15_128_BLACK" />
          </div>

          <div className="grid gap-2">
            <Label>SKU</Label>
            <Input value={form.sku} onChange={(e) => setForm({ ...form, sku: e.target.value })} placeholder="IPHONE15-128-BLACK" />
          </div>

          <div className="grid gap-2">
            <Label>Price in cents</Label>
            <Input value={form.price} onChange={(e) => setForm({ ...form, price: e.target.value })} placeholder="89900" />
          </div>

          <div className="grid gap-2">
            <Label>Stock</Label>
            <Input value={form.stock} onChange={(e) => setForm({ ...form, stock: e.target.value })} placeholder="10" />
          </div>

          <Button type="submit">Create Variant</Button>
        </form>
      </CardContent>
    </Card>
  );
}