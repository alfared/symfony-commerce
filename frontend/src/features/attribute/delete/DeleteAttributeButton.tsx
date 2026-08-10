import { useState } from "react";

import { useDeleteAttribute } from "@/entities/attribute/api/useAttributes";

interface DeleteAttributeButtonProps {
  attributeId: string;
  attributeName: string;
}

export function DeleteAttributeButton({
  attributeId,
  attributeName,
}: DeleteAttributeButtonProps) {
  const [isConfirming, setIsConfirming] = useState(false);
  const deleteAttribute = useDeleteAttribute();

  async function handleDelete() {
    try {
      await deleteAttribute.mutateAsync(attributeId);
      setIsConfirming(false);
    } catch {
      // Error is rendered below.
    }
  }

  if (!isConfirming) {
    return (
      <button
        type="button"
        onClick={() => setIsConfirming(true)}
        disabled={deleteAttribute.isPending}
        className="font-medium text-red-700 hover:underline disabled:opacity-50"
      >
        Delete
      </button>
    );
  }

  return (
    <div className="min-w-64 rounded-md border border-red-200 bg-red-50 p-3">
      <p className="text-sm text-red-900">
        Delete <strong>{attributeName}</strong>?
      </p>

      <p className="mt-1 text-xs text-red-700">This action cannot be undone.</p>

      {deleteAttribute.isError && (
        <p className="mt-2 text-sm text-red-700">
          {deleteAttribute.error instanceof Error
            ? deleteAttribute.error.message
            : "Failed to delete attribute."}
        </p>
      )}

      <div className="mt-3 flex gap-2">
        <button
          type="button"
          onClick={() => void handleDelete()}
          disabled={deleteAttribute.isPending}
          className="rounded-md bg-red-700 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-800 disabled:opacity-50"
        >
          {deleteAttribute.isPending ? "Deleting..." : "Confirm"}
        </button>
        <button
          type="button"
          onClick={() => {
            deleteAttribute.reset();
            setIsConfirming(false);
          }}
          disabled={deleteAttribute.isPending}
          className="rounded-md border bg-white px-3 py-1.5 text-sm font-medium hover:bg-gray-50 disabled:opacity-50"
        >
          Cancel
        </button>
      </div>
    </div>
  );
}
