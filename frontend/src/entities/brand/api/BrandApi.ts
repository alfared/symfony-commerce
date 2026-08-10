import { apiClient } from "@/shared/api/client";
import type { Brand } from "../model/brand";
import type { CreateBrandPayload } from "../model/brand.dto";

export async function getBrands(): Promise<Brand[]> {
  const response = await apiClient.get<Brand[]>("/brands");

  return response.data;
}

export async function createBrand(payload: CreateBrandPayload): Promise<Brand> {
  const response = await apiClient.post<Brand>("/brands", payload);

  return response.data;
}
