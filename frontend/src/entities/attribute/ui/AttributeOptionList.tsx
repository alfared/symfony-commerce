import { useState } from "react";
import {
  useAttributeOptions,
  useDeleteAttributeOption,
  useUpdateAttributeOption,
} from "../api/useAttributes";

interface AttributeOptionListProps {
  attributeId: string;
}

export function AttributeOptionList({ attributeId }: AttributeOptionListProps) {
  const optionsQuery = useAttributeOptions(attributeId);
  const updateOption = useUpdateAttributeOption();
  const deleteOption = useDeleteAttributeOption();

  const [editingId, setEditingId] = useState<string | null>(null);
  const [name, setName] = useState("");
  const [sortOrder, setSortOrder] = useState(0);
  const [enabled, setEnabled] = useState(true);

  if (optionsQuery.isLoading) {
    return <p>Loading options...</p>;
  }

  if (optionsQuery.isError) {
    return (
      <p className="text-red-400">
        {optionsQuery.error instanceof Error
          ? optionsQuery.error.message
          : "Failed to load options."}
      </p>
    );
  }

  const options = optionsQuery.data ?? [];

  function startEdit(option: (typeof options)[number]) {
    setEditingId(option.id);
    setName(option.name);
    setSortOrder(option.sortOrder);
    setEnabled(option.enabled);
  }

  async function save(optionId: string) {
    await updateOption.mutateAsync({
      attributeId,
      optionId,
      payload: {
        name,
        sortOrder,
        enabled,
      },
    });

    setEditingId(null);
  }

  async function remove(optionId: string) {
    if (!window.confirm("Delete this option?")) {
      return;
    }

    await deleteOption.mutateAsync({
      attributeId,
      optionId,
    });
  }

  if (options.length === 0) {
    return (
      <div className="rounded-lg border border-slate-800 p-4 text-slate-400">
        No options yet.
      </div>
    );
  }

  return (
    <div className="overflow-hidden rounded-lg border border-slate-800">
      <table className="w-full text-left text-sm">
        <thead className="bg-slate-900">
          <tr>
            <th className="px-4 py-3">Name</th>
            <th className="px-4 py-3">Code</th>
            <th className="px-4 py-3">Sort order</th>
            <th className="px-4 py-3">Status</th>
          </tr>
        </thead>

        <tbody>
          {options.map((option) => {
            const isEditing = editingId === option.id;

            return (
              <tr key={option.id} className="border-t border-slate-800">
                <td className="px-4 py-3">
                  {isEditing ? (
                    <input
                      value={name}
                      onChange={(e) => setName(e.target.value)}
                      className="rounded border px-2 py-1 text-black"
                    />
                  ) : (
                    option.name
                  )}
                </td>
                <td className="px-4 py-3 font-mono">{option.code}</td>
                <td className="px-4 py-3">
                  {isEditing ? (
                    <input
                      type="number"
                      value={sortOrder}
                      onChange={(e) => setSortOrder(Number(e.target.value))}
                      className="w-20 rounded border px-2 py-1 text-black"
                    />
                  ) : (
                    option.sortOrder
                  )}
                </td>
                <td className="px-4 py-3">
                  {isEditing ? (
                    <input
                      type="checkbox"
                      checked={enabled}
                      onChange={(e) => setEnabled(e.target.checked)}
                    />
                  ) : option.enabled ? (
                    "Enabled"
                  ) : (
                    "Disabled"
                  )}
                </td>
                <td className="px-4 py-3">
                  <div className="flex gap-3">
                    {isEditing ? (
                      <>
                        <button
                          type="button"
                          onClick={() => void save(option.id)}
                          disabled={updateOption.isPending}
                          className="text-blue-400"
                        >
                          Save
                        </button>
                        <button
                          type="button"
                          onClick={() => setEditingId(null)}
                          className="text-slate-400"
                        >
                          Cancel
                        </button>
                      </>
                    ) : (
                      <>
                        <button
                          type="button"
                          onClick={() => startEdit(option)}
                          className="text-blue-400"
                        >
                          Edit
                        </button>

                        <button
                          type="button"
                          onClick={() => void remove(option.id)}
                          disabled={deleteOption.isPending}
                          className="text-red-400"
                        >
                          Delete
                        </button>
                      </>
                    )}
                  </div>
                </td>
              </tr>
            );
          })}
        </tbody>
      </table>
    </div>
  );
}
