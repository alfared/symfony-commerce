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

export interface CreateAttributeOptionDto {
  code: string;
  name: string;
  sortOrder: number;
}

export interface CreateAttributeOptionResponse {
  id: string;
}

export interface CreateAttributeOptionVariables {
  attributeId: string;
  payload: CreateAttributeOptionDto;
}
