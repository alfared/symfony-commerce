import type { AttributeType } from "./attribute";

export interface CreateAttributeDto {
  code: string;
  name: string;
  type: AttributeType;
  required: boolean;
  filterable: boolean;
  searchable: boolean;
  variantAxis: boolean;
}

export interface CreateAttributeResponse {
  id: string;
}

export interface UpdateAttributeDto {
  name: string;
  type: AttributeType;
  required: boolean;
  filterable: boolean;
  searchable: boolean;
  variantAxis: boolean;
  enabled: boolean;
}
