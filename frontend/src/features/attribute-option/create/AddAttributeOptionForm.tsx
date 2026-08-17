import { useState, type FormEvent } from "react";

import { useCreateAttributeOption } from "@/entities/attribute/api/useAttributes";

interface AddAttributeOptionFormProps {
  attributeId: string;
}

export function AddAttributeOptionForm({
  attributeId,
}: AddAttributeOptionFormProps) {
  const createOption = useCreateAttributeOption();

  const [code, setCode] = useState("");
  const [name, setName] = useState("");
  const [sortOrder, setSortOrder] = useState(0);

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    await createOption.mutateAsync({
      attributeId,
      payload: {
        code: code.trim(),
        name: name.trim(),
        sortOrder,
      },
    });

    setCode("");
    setName("");
    setSortOrder(0);
  }

  return (
    <form
      onSubmit={handleSubmit}
      className="grid gap-4 rounded-lg border bg-slate-900 p-4 md:grid-cols-4"
    >
      <input
        value={code}
        onChange={(event) => setCode(event.target.value)}
        placeholder="black"
        required
        className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2"
      />

      <input
        value={name}
        onChange={(event) => setName(event.target.value)}
        placeholder="Black"
        required
        className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2"
      />

      <input
        type="number"
        min={0}
        value={sortOrder}
        onChange={(event) => setSortOrder(Number(event.target.value))}
        className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2"
      />

      <button
        type="submit"
        disabled={createOption.isPending}
        className="rounded-md bg-blue-600 px-4 py-2 font-medium text-white disabled:opacity-50"
      >
        {createOption.isPending ? "Adding..." : "Add option"}
      </button>

      {createOption.error && (
        <p className="md:col-span-4 text-sm text-red-400">
          {createOption.error instanceof Error
            ? createOption.error.message
            : "Failed to add option."}
        </p>
      )}
    </form>
  );
}
