import React, { type FormEvent, useState } from "react";

import type {
  Attribute,
  AttributeType,
} from "@/entities/attribute/model/attribute";

import type { UpdateAttributeDto } from "@/entities/attribute/model/attribute.dto";

interface EditAttributeFormProps {
  attribute: Attribute;
  isPending: boolean;
  error?: Error | null;
  onSubmit: (payload: UpdateAttributeDto) => Promise<void>;
  onCancel: () => void;
}

const attributeTypes: AttributeType[] = [
  "text",
  "textarea",
  "boolean",
  "integer",
  "decimal",
  "date",
  "select",
  "multi_select",
];

export function EditAttributeForm({
  attribute,
  isPending,
  error,
  onSubmit,
  onCancel,
}: EditAttributeFormProps) {
  const [name, setName] = useState(attribute.name);
  const [type, setType] = useState<AttributeType>(attribute.type);
  const [required, setRequired] = useState(attribute.required);
  const [filterable, setFilterable] = useState(attribute.filterable);
  const [searchable, setSearchable] = useState(attribute.searchable);
  const [variantAxis, setVariantAxis] = useState(attribute.variantAxis);
  const [enabled, setEnabled] = useState(attribute.enabled);

  const supportsOptions = type === "select" || type === "multi_select";

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    await onSubmit({
      name: name.trim(),
      type,
      required,
      filterable,
      searchable,
      variantAxis: supportsOptions ? variantAxis : false,
      enabled,
    });
  }

  function handleTypeChange(nextType: AttributeType) {
    setType(nextType);

    if (nextType !== "select" && nextType !== "multi_select") {
      setVariantAxis(false);
    }
  }

  return (
    <form
      onSubmit={handleSubmit}
      className="space-y-6 rounded-lg border bg-white p-6 shadow-sm"
    >
      <div className="grid gap-6 md:grid-cols-2">
        <FormField label="Code">
          <input
            value={attribute.code}
            disabled
            className="w-full cursor-not-allowed rounded-md border bg-gray-100 px-3 py-2 text-gray-600"
          />
          <p className="mt-1 text-xs text-gray-500">
            Code is a stable identifier and cannot be changed.
          </p>
        </FormField>

        <FormField label="Name">
          <input
            value={name}
            onChange={(event) => setName(event.target.value)}
            required
            maxLength={255}
            disabled={isPending}
            className="w-full rounded-md border px-3 py-2 text-slate-900"
          />
        </FormField>

        <FormField label="Type">
          <select
            value={type}
            onChange={(event) =>
              handleTypeChange(event.target.value as AttributeType)
            }
            disabled={isPending}
            className="w-full rounded-md border px-3 py-2 text-slate-900"
          >
            {attributeTypes.map((attributeType) => (
              <option key={attributeType} value={attributeType}>
                {formatType(attributeType)}
              </option>
            ))}
          </select>
        </FormField>
      </div>

      <div className="grid gap-4 sm:grid-cols-2 text-slate-900">
        <Checkbox
          label="Required"
          checked={required}
          disabled={isPending}
          onChange={setRequired}
        />

        <Checkbox
          label="Filterable"
          checked={filterable}
          disabled={isPending}
          onChange={setFilterable}
        />

        <Checkbox
          label="Searchable"
          checked={searchable}
          disabled={isPending}
          onChange={setSearchable}
        />

        <Checkbox
          label="Variant axis"
          checked={variantAxis}
          disabled={isPending || !supportsOptions}
          onChange={setVariantAxis}
        />

        <Checkbox
          label="Enabled"
          checked={enabled}
          disabled={isPending}
          onChange={setEnabled}
        />
      </div>

      {!supportsOptions && (
        <p className="rounded-md bg-amber-50 px-4 py-3 text-sm text-amber-800">
          Only select and multi-select attributes can be used as variant axes.
        </p>
      )}

      {error && (
        <p className="rounded-md bg-red-50 px-4 py-3 text-sm text-red-700">
          {error.message}
        </p>
      )}

      <div className="flex justify-end gap-3">
        <button
          type="button"
          onClick={onCancel}
          disabled={isPending}
          className="rounded-md border px-4 py-2 text-sm font-medium hover:bg-gray-50 disabled:opacity-50 text-slate-900"
        >
          Cancel
        </button>

        <button
          type="submit"
          disabled={isPending || name.trim().length === 0}
          className="rounded-md bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-50"
        >
          {isPending ? "Saving..." : "Save changes"}
        </button>
      </div>
    </form>
  );
}
interface FormFieldProps {
  label: string;
  children: React.ReactNode;
}

function FormField({ label, children }: FormFieldProps) {
  return (
    <label className="block">
      <span className="mb-1 block text-sm font-medium text-gray-700">
        {label}
      </span>

      {children}
    </label>
  );
}

interface CheckboxProps {
  label: string;
  checked: boolean;
  disabled?: boolean;
  onChange: (checked: boolean) => void;
}

function Checkbox({
  label,
  checked,
  disabled = false,
  onChange,
}: CheckboxProps) {
  return (
    <label
      className={[
        "flex items-center gap-3 rounded-md border px-4 py-3",
        disabled
          ? "cursor-not-allowed bg-gray-50 opacity-60"
          : "cursor-pointer",
      ].join(" ")}
    >
      <input
        type="checkbox"
        checked={checked}
        disabled={disabled}
        onChange={(event) => onChange(event.target.checked)}
      />

      <span className="text-sm font-medium">{label}</span>
    </label>
  );
}

function formatType(type: AttributeType): string {
  return type
    .split("_")
    .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
    .join(" ");
}
