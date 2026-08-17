import { Link, useNavigate, useParams } from "react-router-dom";

import {
  useAttribute,
  useUpdateAttribute,
} from "@/entities/attribute/api/useAttributes";

import type { UpdateAttributeDto } from "@/entities/attribute/model/attribute.dto";
import { EditAttributeForm } from "@/features/attribute/edit/EditAttributeForm";
import { AddAttributeOptionForm } from "@/features/attribute-option/create/AddAttributeOptionForm";
import { AttributeOptionList } from "@/entities/attribute/ui/AttributeOptionList";

export function EditAttributePage() {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();

  const attributeQuery = useAttribute(id);
  const updateAttribute = useUpdateAttribute();

  async function handleSubmit(payload: UpdateAttributeDto) {
    if (!id) {
      return;
    }

    await updateAttribute.mutateAsync({
      id,
      payload,
    });

    navigate("/admin/attributes");
  }

  if (!id) {
    return (
      <PageMessage
        title="Invalid attribute"
        message="The attribute identifier is missing from the URL."
      />
    );
  }

  if (attributeQuery.isLoading) {
    return (
      <div className="rounded-lg border bg-white p-6">Loading attribute...</div>
    );
  }

  if (attributeQuery.isError) {
    return (
      <PageMessage
        title="Failed to load attribute"
        message={
          attributeQuery.error instanceof Error
            ? attributeQuery.error.message
            : "Unknown error"
        }
        onRetry={() => void attributeQuery.refetch()}
      />
    );
  }

  if (!attributeQuery.data) {
    return (
      <PageMessage
        title="Attribute not found"
        message="The requested attribute does not exist."
      />
    );
  }

  return (
    <section className="mx-auto max-w-4xl space-y-6">
      <div>
        <Link
          to="/admin/attributes"
          className="text-sm font-medium text-blue-700 hover:underline"
        >
          ← Back to attributes
        </Link>

        <h1 className="mt-3 text-3xl font-bold text-gray-900">
          Edit attribute
        </h1>

        <p className="mt-1 text-gray-600">
          Update configuration for{" "}
          <span className="font-medium">{attributeQuery.data.name}</span>.
        </p>
      </div>

      <EditAttributeForm
        key={attributeQuery.data.id}
        attribute={attributeQuery.data}
        isPending={updateAttribute.isPending}
        error={
          updateAttribute.error instanceof Error ? updateAttribute.error : null
        }
        onSubmit={handleSubmit}
        onCancel={() => navigate("/admin/attributes")}
      />

      {attributeQuery.data.type === "select" ||
      attributeQuery.data.type === "multi_select" ? (
        <section className="space-y-4">
          <div>
            <h2 className="text-2xl font-semibold">Attribute options</h2>

            <p className="text-slate-400">
              Manage selectable values for this attribute.
            </p>
          </div>

          <AddAttributeOptionForm attributeId={attributeQuery.data.id} />

          <AttributeOptionList attributeId={attributeQuery.data.id} />
        </section>
      ) : null}
    </section>
  );
}

interface PageMessageProps {
  title: string;
  message: string;
  onRetry?: () => void;
}

function PageMessage({ title, message, onRetry }: PageMessageProps) {
  return (
    <section className="mx-auto max-w-3xl rounded-lg border bg-white p-6">
      <h1 className="text-xl font-semibold text-gray-900">{title}</h1>

      <p className="mt-2 text-gray-600">{message}</p>

      <div className="mt-5 flex gap-3">
        {onRetry && (
          <button
            type="button"
            onClick={onRetry}
            className="rounded-md bg-blue-700 px-4 py-2 text-sm font-medium text-white"
          >
            Try again
          </button>
        )}

        <Link
          to="/admin/attributes"
          className="rounded-md border px-4 py-2 text-sm font-medium"
        >
          Back to attributes
        </Link>
      </div>
    </section>
  );
}
