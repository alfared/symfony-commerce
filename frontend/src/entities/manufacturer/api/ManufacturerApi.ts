import { apiClient } from "@/shared/api/client";
import type { Manufacturer } from "../model/manufacturer";
import type { CreateManufacturerPayload } from "../model/manufacturer.dto";

export async function getManufacturers(): Promise<Manufacturer[]> {
  const response = await apiClient.get<Manufacturer[]>("/manufacturers");

  return response.data;
}

export async function createManufacturer(
  payload: CreateManufacturerPayload,
): Promise<Manufacturer> {
  const response = await apiClient.post<Manufacturer>(
    "/manufacturers",
    payload,
  );

  return response.data;
}
