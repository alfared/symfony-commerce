import { useEffect, useState } from 'react';
import { createManufacturer, getManufacturers } from '@/entities/manufacturer/api/manufacturerApi';
import type { Manufacturer } from '@/entities/manufacturer/model/manufacturer';
import type { CreateManufacturerPayload } from '@/entities/manufacturer/model/manufacturer.dto';
import { ManufacturerList } from '@/entities/manufacturer/ui/ManufacturerList';
import { CreateManufacturerForm } from '@/features/manufacturer/create/CreateManufacturerForm';

export function ManufacturerManagement() {
  const [items, setItems] = useState<Manufacturer[]>([]);

  useEffect(() => {
    getManufacturers().then(setItems);
  }, []);

  async function handleCreate(payload: CreateManufacturerPayload) {
    const item = await createManufacturer(payload);
    setItems((current) => [item, ...current]);
  }

  return (
    <section className="grid gap-6">
      <CreateManufacturerForm onSubmit={handleCreate} />
      <ManufacturerList items={items} />
    </section>
  );
}