import { useState, type FormEvent } from "react";
import { useCreateAttribute } from "../../../entities/attribute/api/useAttributes";
import type { AttributeType } from "../../../entities/attribute/model/attribute";

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

export function CreateAttributeForm() {
  const createAttribute = useCreateAttribute();

  const [code, setCode] = useState("");
  const [name, setName] = useState("");
  const [type, setType] = useState<AttributeType>("text");
  const [required, setRequired] = useState(false);
  const [filterable, setFilterable] = useState(false);
  const [searchable, setSearchable] = useState(false);
  const [variantAxis, setVariantAxis] = useState(false);

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    await createAttribute.mutateAsync({
      code,
      name,
      type,
      required,
      filterable,
      searchable,
      variantAxis,
    });

    setCode("");
    setName("");
    setType("text");
    setRequired(false);
    setFilterable(false);
    setSearchable(false);
    setVariantAxis(false);
  }
  const supportsOptions = type === "select" || type === "multi_select";

  return (
    <form
      onSubmit={handleSubmit}
      className="space-y-4 rounded-xl border bg-white p-6"
    >
      <h2 className="text-xl font-semibold text-slate-900">Create attribute</h2>

      <div className="grid gap-4 md:grid-cols-2">
        <div className="grid gap-4 md:grid-cols-2">
          <label className="space-y-1">
            <span className="text-sm font-medium text-slate-900">Code</span>
            <input
              value={code}
              onChange={(event) => setCode(event.target.value)}
              placeholder="color"
              required
              className="w-full rounded-md border px-3 py-2 text-slate-900"
            />
          </label>

          <label className="space-y-1">
            <span className="text-sm font-medium text-slate-900">Name</span>
            <input
              value={name}
              onChange={(event) => setName(event.target.value)}
              placeholder="Color"
              required
              className="w-full rounded-md border px-3 py-2 text-slate-900"
            />
          </label>
          <label className="block space-y-1">
            <span className="text-sm font-medium text-slate-900">Type</span>
            <select
              value={type}
              onChange={(event) => setType(event.target.value as AttributeType)}
              className="w-full rounded-md border px-3 py-2 text-slate-900"
            >
              {attributeTypes.map((item) => (
                <option key={item} value={item}>
                  {item}
                </option>
              ))}
            </select>
          </label>
        </div>
      </div>
      <div className="grid gap-3 sm:grid-cols-2 text-slate-900">
        <Checkbox label="Required" checked={required} onChange={setRequired} />
        <Checkbox
          label="Filterable"
          checked={filterable}
          onChange={setFilterable}
        />
        <Checkbox
          label="Searchable"
          checked={searchable}
          onChange={setSearchable}
        />
        <Checkbox
          label="Variant axis"
          checked={variantAxis}
          onChange={setVariantAxis}
          disabled={!supportsOptions}
        />
      </div>

      {createAttribute.error && (
        <p className="text-sm text-red-600"> {createAttribute.error.message}</p>
      )}

      <button
        type="submit"
        disabled={createAttribute.isPending}
        className="rounded-md bg-black px-4 py-2 text-white disabled:opacity-50"
      >
        {createAttribute.isPending ? "Creating..." : "Create attribute"}
      </button>
    </form>
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
    <label className="flex items-center gap-2">
      <input
        type="checkbox"
        checked={checked}
        disabled={disabled}
        onChange={(event) => onChange(event.target.checked)}
      />
      <span>{label}</span>
    </label>
  );
}
