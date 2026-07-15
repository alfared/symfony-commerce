import { useState } from 'react';
import type { FormEvent } from 'react';
import type { CreateAttributePayload } from '@/entities/attribute/model/attribute.dto';

type Props = {
    onSubmit: (payload: CreateAttributePayload) => void;
};

export function CreateAttributeForm({ onSubmit }: Props) {
    const [form, setForm] = useState<CreateAttributePayload>({
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
        <form onSubmit={submit} className="grid gap-3 rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <h2 className="text-x1 font-semibold text-slate-50">Create Attribute</h2>

            <input 
                className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50"
                placeholder="Code"
                value={form.code}
                onChange={(event) => setForm({...form, code: event.target.value })}
            />

            <input
                className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50"
                placeholder="Name"
                value={form.name}
                onChange={(event) => setForm({...form, code: event.target.value })}
            />

              <input
                className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50"
                placeholder="Slug"
                value={form.slug}
                onChange={(event) => setForm({ ...form, slug: event.target.value })}
            />

            <input
                className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50"
                placeholder="Description"
                value={form.description ?? ''}
                onChange={(event) => setForm({ ...form, description: event.target.value })}
            />

            <button className="rounded-md bg-white px-4 py-2 font-semibold text-slate-950">
                Create 
            </button>
        </form>
    );
}