import { FormEvent, useState } from 'react';
import type { CreateProductPayload } from '@/entities/product/model/product.dto';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

type Props = {
  onSubmit: (payload: CreateProductPayload) => void;
};

export function CreateProductForm({ onSubmit }: Props) {
  const [form, setForm] = useState({
    code: '',
    name: '',
    slug: '',
    description: '',
    enabled: true,
  });

  function submit(event: FormEvent) {
    event.preventDefault();
    onSubmit(form);
  }

  return (
    <Card className="border-slate-800 bg-slate-900 text-slate-50">
      <CardHeader>
        <CardTitle>Create Product</CardTitle>
        <CardDescription>
          Product is the main catalog item. Price and stock live in variants.
        </CardDescription>
      </CardHeader>

      <CardContent>
        <form className="grid gap-4" onSubmit={submit}>
          <div className="grid gap-2">
            <Label>Code</Label>
            <Input value={form.code} onChange={(e) => setForm({ ...form, code: e.target.value })} placeholder="IPHONE_15" />
          </div>

          <div className="grid gap-2">
            <Label>Name</Label>
            <Input value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} placeholder="iPhone 15" />
          </div>

          <div className="grid gap-2">
            <Label>Slug</Label>
            <Input value={form.slug} onChange={(e) => setForm({ ...form, slug: e.target.value })} placeholder="iphone-15" />
          </div>

          <div className="grid gap-2">
            <Label>Description</Label>
            <Input value={form.description} onChange={(e) => setForm({ ...form, description: e.target.value })} placeholder="Apple smartphone" />
          </div>

          <Button type="submit">Create Product</Button>
        </form>
      </CardContent>
    </Card>
  );
}