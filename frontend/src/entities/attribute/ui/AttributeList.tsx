import { useAttributes } from "../api/useAttributes";
import { Link } from "react-router-dom";

export function AttributeList() {
  const {
    data: attributes = [],
    isLoading,
    isError,
    error,
    refetch,
    isFetching,
  } = useAttributes();

  if (isLoading) {
    return (
      <div className="rounded-xl border bg-white p-6">
        Loading attributes...
      </div>
    );
  }

  if (isError) {
    return (
      <div className="rounded-xl border border-red-200 bg-red-50 p-6">
        <p className="font-medium text-red-700">Failed to load attributes</p>

        <p className="mt-1 text-sm text-red-600">
          {error instanceof Error ? error.message : "Unknown error"}
        </p>

        <button
          type="button"
          onClick={() => void refetch()}
          className="mt-4 rounded-md bg-red-700 px-4 py-2 text-sm text-white"
        >
          Try again
        </button>
      </div>
    );
  }

  if (attributes.length === 0) {
    return (
      <div className="rounded-xl border bg-white p-6 text-slate-600">
        No attributes created yet.
      </div>
    );
  }

  return (
    <div className="overflow-hidden rounded-xl border bg-white">
      <div className="flex items-center justify-between border-b px-5 py-4">
        <div>
          <h2 className="font-semibold text-slate-900">Attribute list</h2>
          <p className="text-sm text-slate-500">
            {attributes.length}{" "}
            {attributes.length === 1 ? "attribute" : "attributes"}
          </p>
        </div>

        {isFetching && (
          <span className="text-sm text-slate-500">Refreshing...</span>
        )}
      </div>

      <div className="overflow-x-auto">
        <table className="w-full text-left text-sm">
          <thead className="bg-slate-50 text-slate-600">
            <tr>
              <th className="px-5 py-3 font-medium">Name</th>
              <th className="px-5 py-3 font-medium">Code</th>
              <th className="px-5 py-3 font-medium">Type</th>
              <th className="px-5 py-3 font-medium">Configuration</th>
              <th className="px-5 py-3 font-medium">Status</th>
              <th className="px-4 py-3 text-left">Actions</th>
            </tr>
          </thead>

          <tbody>
            {attributes.map((attribute) => {
              const flags = [
                attribute.required && "Required",
                attribute.filterable && "Filterable",
                attribute.searchable && "Searchable",
                attribute.variantAxis && "Variant axis",
              ].filter(Boolean);

              return (
                <tr key={attribute.id} className="border-t">
                  <td className="px-5 py-4 font-medium text-slate-900">
                    {attribute.name}
                  </td>

                  <td className="px-5 py-4 font-mono text-slate-600">
                    {attribute.code}
                  </td>

                  <td className="px-5 py-4">
                    <span className="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-900">
                      {attribute.type}
                    </span>
                  </td>

                  <td className="px-5 py-4 text-slate-600">
                    {flags.length > 0 ? flags.join(", ") : "—"}
                  </td>

                  <td className="px-5 py-4">
                    <span
                      className={
                        attribute.enabled
                          ? "text-emerald-700"
                          : "text-slate-500"
                      }
                    >
                      {attribute.enabled ? "Enabled" : "Disabled"}
                    </span>
                  </td>
                  <td className="px-4 py-3">
                    <Link
                      to={`/admin/attributes/${attribute.id}/edit`}
                      className="font-medium text-blue-700 hover:underline"
                    >
                      Edit
                    </Link>
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>
    </div>
  );
}
