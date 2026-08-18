import { useEffect, useState } from 'react';
import { createBrand, getBrands } from '@/entities/brand/api/brandApi';
import type { Brand } from '@/entities/brand/model/brand';
import type { CreateBrandPayload } from '@/entities/brand/model/brand.dto';
import { BrandList } from '@/entities/brand/ui/BrandList';
import { CreateBrandForm } from '@/features/brand/create/CreateBrandForm';

export function BrandManagement() {
  const [items, setItems] = useState<Brand[]>([]);

  useEffect(() => {
    getBrands().then(setItems);
  }, []);

  async function handleCreate(payload: CreateBrandPayload) {
    const item = await createBrand(payload);
    setItems((current) => [item, ...current]);
  }

  return (
    <section className="grid gap-6">
      <CreateBrandForm onSubmit={handleCreate} />
      <BrandList items={items} />
    </section>
  );
}