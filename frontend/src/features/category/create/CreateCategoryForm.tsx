import { useState } from 'react';
import type { FormEvent } from 'react';
import { createCategory } from '@/entities/category/api/categoryApi';
import type { Category } from '@/entities/category/model/category';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

type Props = {
  onCreated: (category: Category) => void;
};

export function CreateCategoryForm({ onCreated }: Props) {
  const [code, setCode] = useState('');
  const [name, setName] = useState('');
  const [slug, setSlug] = useState('');
  const [description, setDescription] = useState('');
  const [enabled, setEnabled] = useState(true);
  const [loading, setLoading] = useState(false);

  async function handleSubmit(event: FormEvent) {
    event.preventDefault();

    setLoading(true);

    try {
      const category = await createCategory({
        code,
        name,
        slug,
        description: description || null,
        enabled,
      });

      onCreated(category);

      setCode('');
      setName('');
      setSlug('');
      setDescription('');
      setEnabled(true);
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={handleSubmit} className="grid gap-3">
      <Input placeholder="Code" value={code} onChange={(event) => setCode(event.target.value)} />
      <Input placeholder="Name" value={name} onChange={(event) => setName(event.target.value)} />
      <Input placeholder="Slug" value={slug} onChange={(event) => setSlug(event.target.value)} />
      <Input placeholder="Description" value={description} onChange={(event) => setDescription(event.target.value)} />

      <label className="flex items-center gap-2 text-sm">
        <input type="checkbox" checked={enabled} onChange={(event) => setEnabled(event.target.checked)} />
        Enabled
      </label>

      <Button type="submit" disabled={loading}>
        {loading ? 'Creating...' : 'Create category'}
      </Button>
    </form>
  );
}