import { useEffect, useState } from 'react';
import { createAttribute, getAttributes } from '@/entities/attribute/api/attributeApi';
import type { Attribute } from '@/entities/attribute/model/attribute';
import type { CreateAttributePayload } from '@/entities/attribute/model/attribute.dto';
import { AttributeList } from '@/entities/attribute/ui/AttributeList';
import { CreateAttributeForm } from '@/features/attribute/create/CreateAttributeForm';

export function AttributeManagement() {
  const [items, setItems] = useState<Attribute[]>([]);

  useEffect(() => {
    getAttributes().then(setItems);
  }, []);

  async function handleCreate(payload: CreateAttributePayload) {
    const item = await createAttribute(payload);
    setItems((current) => [item, ...current]);
  }

  return (
    <section className="grid gap-6">
      <CreateAttributeForm onSubmit={handleCreate} />
      <AttributeList items={items} />
    </section>
  );
}