export type AttributeType =
  | "text"
  | "textarea"
  | "boolean"
  | "integer"
  | "decimal"
  | "date"
  | "select"
  | "multi_select";

export interface AttributeOption {
  id: string;
  code: string;
  name: string;
  sortOrder: number;
  enabled: boolean;
}

export interface Attribute {
  id: string;
  code: string;
  name: string;
  type: AttributeType;
  required: boolean;
  filterable: boolean;
  searchable: boolean;
  variantAxis: boolean;
  enabled: boolean;
  options: AttributeOption[];
  createdAt: string;
  updatedAt: string;
}
